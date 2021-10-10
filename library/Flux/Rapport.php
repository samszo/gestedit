<?php
/**
* Class pour gérer les rapport automatique
*
*
* @author     Samuel Szoniecky <samuel.szoniecky@univ-paris8.fr>
* @license    CC0 1.0 Universal (CC0 1.0) Public Domain Dedication http://creativecommons.org/publicdomain/zero/1.0/ 
*/
class Flux_Rapport extends Flux_Site{

	var $odf;
	var $dbRapport;
	var $dbRoyalty;
	var $dbDevise;
	var $dbImportfic;
	var $dbSerie;
	
    function __construct($idBase=false,$bTrace=false){    	
    	    	
    	parent::__construct($idBase,$bTrace);
		$this->pathPaiement = ROOT_PATH."/data/".RAPPORT_PATH."/modeles/royalty.odt";		
		$this->temps_debut = microtime(true);
    		
    }
	
	
	/**
	 * récupère la liste des rapports
	 *
	 * @param int 		$idObj
	 * @param string 	$typeObj
	 *
	 * @return array
	 */
	public function getRapportFait($idObj, $typeObj){
		
		$dbR = new Model_DbTable_Iste_rapport();
		return $dbR->findByObj($idObj, $typeObj);
		
	}	
    	
	/**
	 * création d'un paiement
	 *
	 * @param array 		$data
	 *
	 * @return array
	 */
	public function creaPaiement($data){
	
		$this->trace("creaPaiement",$data);
		
		//initialisation des objets	
		if(!$this->dbRapport) $this->dbRapport = new Model_DbTable_Iste_rapport();
		if(!$this->dbRoyalty) $this->dbRoyalty = new Model_DbTable_Iste_royalty();
		//if(!$this->dbDevise) $this->dbDevise = new Model_DbTable_Iste_devise();
		if(!$this->dbImportfic) $this->dbImportfic = new Model_DbTable_Iste_importfic();
		
		//$tauxPeriode = $this->dbDevise->getTauxPeriode($data['minDateVente'],$data['maxDateVente']);
		
		$rsRoyalty = $this->dbRoyalty->getDetails($data["idsRoyalty"]);		
		
		$date = new DateTime();
		$refRapport = substr($data["prenom"],0,2)."_".$data["autNom"]."_"
			.substr($data["titre_en"], 0,12)."_".substr($data["titre_fr"], 0,12)
			."_".$data["base_contrat"]."_".$data["annee"];
		$refRapport = $this->dbImportfic->valideChaine($refRapport);
		
		//charge le modèle
		$mod = $this->dbImportfic->findByType("paiement royalties ".$data["base_contrat"]);
		$this->trace("//charge le modèle ".$mod["url"]);
		$config = array(
		    	'ZIP_PROXY' => 'PhpZipProxy',
		    	'DELIMITER_LEFT' => '{',
		    	'DELIMITER_RIGHT' => '}',
				'PATH_TO_TMP' => ROOT_PATH.'/tmp'
		   		);
		$this->odf = new odf(ROOT_PATH.$mod["url"], $config);		
		/*dégugage du contenu xml
		header("Content-Type:text/xml");
		echo $this->odf->getContentXml();
		return;
		*/
		
		//ajout des infos de référence
		$this->odf->setVars('roy_date_edition', $date->format('l d F Y'));
		$this->odf->setVars('roy_reference', $data["isbns"]);
		$periode = $data["date_taux"]." - ".$data["date_taux_fin"];
		//pas dans la version de prod $this->odf->setVars('roy_periode', $periode);
		$this->odf->setVars('livre_roy_pc', $data["pc_papier"]." %");
		
		//ajout des infos d'auteur
		$this->odf->setVars('aut_civilite', $data["civilite"]);
		$this->odf->setVars('aut_nom', $data["autNom"]);
		$this->odf->setVars('aut_prenom', $data["prenom"]);
		$this->odf->setVars('aut_adresse1', $data["adresse_1"]);
		$this->odf->setVars('aut_adresse2', $data["adresse_2"]);
		$this->odf->setVars('aut_cp', $data["code_postal"]);
		$this->odf->setVars('aut_ville', $data["ville"]);
		$this->odf->setVars('aut_pays', $data["pays"]);
		
		//ajout des infos du livre
		$this->odf->setVars('livre_titre', $data["titre_fr"]." - ".$data["titre_en"]." - ".$data["titre_es"]);
		$this->odf->setVars('livre_parution', $data["parution"]);
		/*
		$this->odf->setVars('livre_prix', $data["vMtLivre"]/$data["vNb"]);
		$this->odf->setVars('livre_pcpaper', $data["pc_papier"]." %");
		$this->odf->setVars('livre_pcebook', $data["pc_ebook"]." %");
		*/
				
		//ajout des infos de royalty		
		$roys = $this->odf->setSegment('roys');	
		$due = 0;
		$revTot = 0;
		foreach ($rsRoyalty as $r) {
			$this->trace("détail royalties",$r);
			
			if($r["typeVente"]=="N")$r["typeVente"]="Book digital";
			if($r["typeVente"]=="P")$r["typeVente"]="Book paper";
			if($r["typeVente"]=="Licence num")$r["typeVente"]="E-Licence";
			
			$roys->setVars('roy_type', $r["typeVente"]." ".$r["typeIsbn"]." ".$r["typeContrat"]);
			$roys->setVars('roy_unit', $r["unit"]);
			$roys->setVars('roy_rev', $r["rMtVente"]);
			$revTot += $r["rMtVente"];
			$roys->setVars('roy_pc', $r["pc"]);
			$roys->setVars('roy_livre', $r["rMtRoy"]);
			$due += $r["rMtRoy"];
		}
		$roys->merge();
		$this->odf->mergeSegment($roys);
	
		//ajout les totaux
		$this->odf->setVars('roy_rev_tot', $revTot);
		$this->odf->setVars('roy_balance_due', $due);
		$this->odf->setVars('roy_tax_deduc_pc', $r["deduction"]);
		$deduc = $due*$r["deduction"]/100;
		$this->odf->setVars('roy_tax_deduc', $deduc);
		$this->odf->setVars('roy_net_due_livre', $due-$deduc);

		$this->odf->setVars('roy_devise_date', $periode);
		$this->odf->setVars('roy_devise_pc', $data["taux_livre_euro"]);
		$this->odf->setVars('roy_net_due_euro', ($due-$deduc)*$data["taux_livre_euro"]);
		
				
		//on enregistre le fichier
		$nomFic = utf8_encode($refRapport).".odt";
		//copie le fichier dans le répertoire data
		$newfile = ROOT_PATH."/data/".RAPPORT_PATH."/".$nomFic;
		//copy($this->odf->tmpfile, $newfile);

		$this->odf->saveToDisk($newfile);
		$this->trace("//enregistre le fichier ".$newfile);
		
		//enregistrement du rapport
		$idRapport = $this->dbRapport->ajouter(array("url"=>WEB_ROOT."/data/".RAPPORT_PATH."/".$nomFic,"id_importfic"=>$mod["id_importfic"]
			, "data"=>json_encode($data), "obj_type"=>"auteur_livre", "obj_id"=>$data["id_auteur"]."_".$data["id_livre"]));		
			
		//mise à jour de la date d'éditions
		$this->dbRoyalty->edit(false,array("id_rapport"=>$idRapport,"date_edition"=>new Zend_Db_Expr('NOW()')),$data["idsRoyalty"]);

		$this->trace("FIN");		
		
		return $idRapport;
	}

	/**
	 * création d'un paiement pour les livres d'un auteur
	 *
	 * @param array 		$data
	 * @param string 		$type
	 * @param number 		$taux_reduction
	 * @param int 			$ordreGen -- pour gérer trop de génération
	 *
	 * @return array
	 */
	public function creaPaiementFic($data, $type="livre", $taux_reduction=0, $ordreGen=0){
	
		$this->trace(__METHOD__,$data);
		
		//initialisation des objets	
		if(!$this->dbRapport) $this->dbRapport = new Model_DbTable_Iste_rapport();
		if(!$this->dbRoyalty) $this->dbRoyalty = new Model_DbTable_Iste_royalty();
		if(!$this->dbDevise) $this->dbDevise = new Model_DbTable_Iste_devise();
		if(!$this->dbImportfic) $this->dbImportfic = new Model_DbTable_Iste_importfic();
		if(!$this->dbContrat) $this->dbContrat = new Model_DbTable_Iste_contrat();
		
		//$tauxPeriode = $this->dbDevise->getTauxPeriode($data['minDateVente'],$data['maxDateVente']);
				
		$date = new DateTime();
		/*
		$refRapport = $data["autNom"].".".substr($data["prenom"],0,2)
			.".".$type.".".$data["idsFicImport"]
			.".".$data["minDateVente"].".".$data["maxDateVente"];
		*/
		$refRapport = $data["autNom"]."_".substr($data["prenom"],0,2)."_".$type."_".uniqid()."_".$date->format('Y-m-d');
		$refRapport = $this->dbImportfic->valideChaine($refRapport);

		
		//charge le modèle
		//$mod = $this->dbImportfic->findByType("paiement droit ".$data["base_contrat"]);
		$mod = $this->dbImportfic->findByType("paiement droits FR");
		$this->trace("//charge le modèle ".$mod["url"]);
		$config = array(
		    	'ZIP_PROXY' => 'PhpZipProxy',
		    	'DELIMITER_LEFT' => '{',
		    	'DELIMITER_RIGHT' => '}',
				'PATH_TO_TMP' => ROOT_PATH.'/tmp'
		   		);
		$this->odf = new odf(ROOT_PATH.$mod["url"], $config);		
		/*dégugage du contenu xml
		header("Content-Type:text/xml");
		echo $this->odf->getContentXml();
		return;
		*/
		
		//ajout des infos de référence
		$this->odf->setVars('roy_date_edition', $date->format('l d F Y'));
		$this->odf->setVars('roy_reference', $refRapport);
		//les périodes sont différentes suivant les contrats on affiche à la fin
		$periode = $data["minDateVente"]." -> ".$data["maxDateVente"];
		//pas dans la version de prod $this->odf->setVars('roy_periode', $periode);
		//$this->odf->setVars('livre_roy_pc', $data["pc_papier"]." %");
				
		//ajout des infos d'auteur
		$this->odf->setVars('aut_civilite', $data["civilite"]);
		$this->odf->setVars('aut_nom', $data["autNom"]);
		$this->odf->setVars('aut_prenom', $data["prenom"]);
		$this->odf->setVars('aut_adresse1', $data["adresse_1"]);
		$this->odf->setVars('aut_adresse2', $data["adresse_2"]);
		$this->odf->setVars('aut_cp', $data["code_postal"]);
		$this->odf->setVars('aut_ville', $data["ville"]);
		$this->odf->setVars('aut_pays', $data["pays"]);
		
		//somme global des droits
		$due = 0;
		$revTot = 0;
		$deduction = 0;
		$perDeb = mktime(0, 0, 0, date("m"),   date("d"),   date("Y"));;
		$perFin = 0;
		$taux_livre_euro = 0;
		$nbRoy = 0;
	
		//récupère les royalties suivant le type
		if($type=="livre"){
			$rsRoyalty = $this->dbRoyalty->getDetailsLivre($data["idsRoyalty"]);
			$royTitre = "Author Royalty";
		}
		if($type=="serie"){
			$rsRoyalty = $this->dbRoyalty->getDetailsSerie($data["idsRoyalty"]);
			$royTitre = "Droits série";
		}
		if($type=="editoriaux"){
			$rsRoyalty = $this->dbRoyalty->getDetailsEditoriaux($data["idsRoyalty"]);
			$royTitre = "Editor Royalty";
		}
		//pour différencier les royalties globales de celles liées au type de rapport
		//et associer le bon rapport à la bonne royalty
		$cumulIdRoy = "-1";
		if(count($rsRoyalty)){

			$this->odf->setVars('roy_titre', $royTitre);
				
			//ajout des infos de royalty		
			$roys = $this->odf->setSegment('roys');	
			$oPeriode = "";
			$oTitre = "";
			foreach ($rsRoyalty as $r) {
				$this->trace("détail royalties Livre",$r);
				$cumulIdRoy .= ",".$r['idRD'];

				/*période
				$contrats = $this->dbContrat->getPeriodes($r["annee"],$r["id_contrat"]);
				//if($perDeb > $this->contrats[$r["id_contrat"]][$r["base_contrat"]]["deb"])
				$perDeb = $contrats[$r["id_contrat"]][$r["base_contrat"]]["deb"];
				//if($perFin < $this->contrats[$r["id_contrat"]][$r["base_contrat"]]["fin"])
				$perFin = $contrats[$r["id_contrat"]][$r["base_contrat"]]["fin"];
				$periode = "Contrats ".$r["base_contrat"]." pour la période : ".strftime("%d %b %Y", $perDeb)." -> ".strftime("%d %b %Y", $perFin);
				if($oPeriode!=$periode){
					$roys->setVars('roy_periode', $periode);
					$oPeriode = $periode;
				} else
					$roys->setVars('roy_periode', "-");
				*/
				$titre = $r["titre_en"]." - ".$r["titre_fr"]." - ".$r["titre_es"];
				if($oTitre!=$titre){
					if($oTitre!=""){
						$roys->merge();
					}
					$oTitre=$titre;	
					$roys->setVars('roy_item', $r["titre_en"]." - ".$r["titre_fr"]." - ".$r["titre_es"]);
					if($type=="livre"){
						$roys->setVars('roy_role', $r["typeContrat"]);
						$roys->setVars('roy_isbn', "");
					}else{
						$roys->setVars('roy_role', $r["typeContrat"]);
						$roys->setVars('roy_isbn', "");
					}
				}
				$isbn = "ISBN : ".$r["num"]." (".$r["typeISBN"].")";
				if($r["typeVente"]=="ebook")$typeVente="Book digital   ";//.$isbn;
				if($r["typeVente"]=="papier")$typeVente="Book paper    ".$isbn;
				if($r["typeVente"]=="Licence num")$typeVente="E-Licence    ".$isbn;
				//si pas de vente 
				if($r["rMtVente"]==0){
					//on force le type de vente
					//$typeVente="Book paper    ".$isbn;
					//on met les quantité à zéro
					$r["unit"]=0;
				}
				$roys->details->setVars('roy_type', $typeVente);
				

				if($typeVente=="Book digital   ")
					$roys->details->setVars('roy_unit', " ");
				else
					$roys->details->setVars('roy_unit', $r["unit"]);

				$roys->details->setVars('roy_rev', sprintf("%01.2f", $r["rMtVente"]));
				$revTot += $r["rMtVente"];
				$roys->details->setVars('roy_pc', sprintf("%01.2f", $r["pc"]));
				$roys->details->setVars('roy_livre', sprintf("%01.2f", $r["rMtRoy"]));
				$due += $r["rMtRoy"];
				$taux_livre_euro += $r["taux_livre_euro"];
				$nbRoy += $r["nbRoy"];
				$roys->details->merge();
				
			}
			$roys->merge();
			$this->odf->mergeSegment($roys);
		}else{
			//pas de données donc pas de rapport
			return false;
		}		
		
		//ajout les totaux
		$this->odf->setVars('roy_rev_tot', sprintf("%01.2f", $revTot));
		$this->odf->setVars('roy_balance_due', sprintf("%01.2f", $due));
		$dueHT = $due;
		if($data['taxe_uk']=='oui'){
			$this->odf->setVars('roy_tax_deduc_pc', sprintf("%01.2f", $taux_reduction));
			$deduc = $due*$taux_reduction;
			$this->odf->setVars('roy_tax_deduc', sprintf("%01.2f", $deduc));
			$due -= $deduc; 
		}else{
			$this->odf->setVars('roy_tax_deduc_pc', 'no');
			$this->odf->setVars('roy_tax_deduc', '0');
		}
		
		$this->odf->setVars('roy_net_due_livre', sprintf("%01.2f", $due));
		if($data['paiement_euro']=='oui'){
			$moyenneTaux = round($taux_livre_euro/$nbRoy,2);
			$this->odf->setVars('roy_devise_date', $periode);
			$this->odf->setVars('roy_devise_pc', sprintf("%01.2f", $moyenneTaux));
			$montantEuro = round($due*$moyenneTaux,2);
			$this->odf->setVars('roy_net_due_euro', sprintf("%01.2f", $montantEuro));
		}else{
			$this->odf->setVars('roy_devise_date', 'no');
			$this->odf->setVars('roy_devise_pc', 'no');
			$this->odf->setVars('roy_net_due_euro', 'no');
			$montantEuro = "";
		}
		
				
		//on enregistre le fichier
		$nomFic = $ordreGen."_".$refRapport;
		//copie le fichier dans le répertoire data
		$newfile = ROOT_PATH."/data/".RAPPORT_PATH."/tmp/".$nomFic.".odt";
		//copy($this->odf->tmpfile, $newfile);

		$this->odf->saveToDisk($newfile);
		$this->trace("//enregistre le fichier ".$newfile);
		
		//ATTENTION  très gourmant d'ouvrir et de fermet libre office
		//la création des pdf se fait globalement 
		//$this->convertOdtToPdf($newfile, ROOT_PATH."/data/".RAPPORT_PATH."");
		//$this->trace("//enregistre le pdf ".$newfile);

		//enregistrement du rapport
		$idRapport = $this->dbRapport->ajouter(array("url"=>WEB_ROOT."/data/".RAPPORT_PATH."/".$nomFic.".pdf"
			,"id_importfic"=>$mod["id_importfic"], "periode_deb"=>$data["minDateVente"], "periode_fin"=>$data["maxDateVente"]
			, 'montant'=>$due, 'montant_ht'=>$dueHT, 'montant_euro'=>$montantEuro
			, "data"=>json_encode($data),"type"=>$type, "obj_type"=>"auteur_ficimport", "obj_id"=>$data["id_auteur"]."_".$data["idsFicImport"]));		
					
		//mise à jour de la date d'éditions
		$this->dbRoyalty->edit(false,array("id_rapport"=>$idRapport,"date_edition"=>new Zend_Db_Expr('NOW()')),$cumulIdRoy);

		$this->trace("FIN");		
		
		return array($idRapport,$newfile);
	}	

	/**
	 * création de pdf à partir d'un odt ou de plusieurs *.odt
	 *
	 * @param string 	$odtPath
	 * @param string 	$pdfPath
	 *
	 * @return string
	 */
	public function convertOdtToPdf($odtPath, $pdfPath){

		if(!$odtPath)return;
		//pour localhot 
		if(WEB_ROOT=="http://localhost/gestedit" || WEB_ROOT=="http://gapai.univ-paris8.fr/gestedit"){
			$cmd = "export HOME=/tmp; ".LIBREOFFICE_PATH.' --headless ';
			$cmd .= '--convert-to pdf --outdir '.$pdfPath.' '.$odtPath;
			$result = exec($cmd);	
		}else{
			//pour prod
			$cmd .= LIBREOFFICE_PATH.' -env:UserInstallation=file:///$HOME/.libreoffice-headless/ --headless ';
			$cmd .= '--convert-to pdf --outdir '.$pdfPath.' '.$odtPath;
			$connection = ssh2_connect(SSH2_PATH);
			ssh2_auth_password($connection, SSH2_USER, SSH2_MDP);		
			$result = ssh2_exec($connection, $cmd);
			//export HOME=/tmp; soffice --headless --convert-to pdf --outdir /home/clients/680a35fe32961faf6d197a8c38f2570a/web/data/".RAPPORT_PATH." /home/clients/680a35fe32961faf6d197a8c38f2570a/web/data/".RAPPORT_PATH."/tmp/*.odt	
		}
		$this->trace($cmd);
		$this->trace("result=".$result);
		return $result;
		
	}

	/**
	 * création d'un etat de série
	 *
	 * @param array 		$data
	 *
	 * @return array
	 */
	public function creaEtatSeries($data){
	
		$this->bTrace = false;
		$this->temps_debut = microtime(true);
				
		//initialisation des objets	
		if(!$this->dbRapport) $this->dbRapport = new Model_DbTable_Iste_rapport();
		if(!$this->dbSerie) $this->dbSerie = new Model_DbTable_Iste_serie();
		if(!$this->dbImportfic) $this->dbImportfic = new Model_DbTable_Iste_importfic();
		
		$date = new DateTime();
		$refRapport = "EtatSeries_".uniqid()."_".$date->format('Y-m-d');

		
		//charge le modèle
		$mod = $this->dbImportfic->findByType("etatSerie");
		$this->trace("//charge le modèle ".$mod["url"]);
		$config = array(
		    	'ZIP_PROXY' => 'PclZipProxy',
		    	'DELIMITER_LEFT' => '{',
		    	'DELIMITER_RIGHT' => '}',
				'PATH_TO_TMP' => ROOT_PATH.'/tmp'
		   		);
		$this->odf = new odf(ROOT_PATH.$mod["url"], $config);		
		/*dégugage du contenu xml
		header("Content-Type:text/xml");
		echo $this->odf->getContentXml();
		return;
		*/
		$titreRecap = "Série éditée";
		if(count($data)>1)$titreRecap = "Séries éditées";
		$this->odf->setVars('titre_recap',$titreRecap);	
		
		//ajout des infos		
		$series = $this->odf->setSegment('series');	
		$recap = $this->odf->setSegment('recap');	
		
		foreach ($data as $idSerie) {
			$rsSerie = $this->dbSerie->getDetails($idSerie);
			$first=true;
			foreach ($rsSerie as $s) {
				if($first){
					$first=false;
					$series->setVars('date_jour', $date->format('d m Y'));
					$series->setVars('serie_titre_en', $s['serie_titre_en']);
					$series->setVars('serie_titre_fr', $s['serie_titre_fr']);
					$recap->setVars('recap_fr', $s['serie_titre_fr']);
					$recap->setVars('recap_en', $s['serie_titre_en']);
					$series->setVars('coordinateur', $s['coordinateur']);
				};
				$series->livres->titre_fr($s['titre_fr']);
				$series->livres->titre_en($s['titre_en']);
				$series->livres->auteurs($s['auteurs']);
				//ajout du planning
				if($s["pFin"])$series->livres->proposal("reçu : ".$s["pFin"]);
				else $series->livres->proposal("prévu : ".$s["pPrev"]);
				if($s["cFin"])$series->livres->contrat("signé : ".$s["cFin"]);
				else $series->livres->contrat("prévu : ".$s["cPrev"]);
				if($s["mFin"])$series->livres->manuscrit("reçu : ".$s["mFin"]);
				else $series->livres->manuscrit("prévu : ".$s["mPrev"]);
				//ajout des commentaires
				$com = $s["commentaire"];
				if($s["pCom"])$com .= "\nProposal:\n".$s["pCom"]; 
				if($s["cCom"])$com .= "\nContrat:\n".$s["cCom"]; 
				if($s["mCom"])$com .= "\nManuscrit:\n".$s["mCom"]; 
				$series->livres->commentaire($com);
				$series->livres->merge();
			}		
			$series->merge();
			$recap->merge();
		}
		$this->odf->mergeSegment($series);
		$this->odf->mergeSegment($recap);
		
		//on enregistre le fichier
		$nomFic = $refRapport.".odt";
		//copie le fichier dans le répertoire data
		$newfile = ROOT_PATH."/data/".RAPPORT_PATH."/".$nomFic;
		//copy($this->odf->tmpfile, $newfile);

		$this->odf->saveToDisk($newfile);
		$this->trace("//enregistre le fichier ".$newfile);
		
		//enregistrement du rapport
		$rsRapport = $this->dbRapport->ajouter(array("url"=>WEB_ROOT."/data/".RAPPORT_PATH."/".$nomFic,"id_importfic"=>$mod["id_importfic"]
			, "data"=>json_encode($data), "obj_type"=>"serie", "obj_id"=>implode(",", $data)),true,true);		
			
		$this->trace("FIN");		
		
		return $rsRapport;
	}
	
	/**
	 * ajoute une image au modèle
	 *
	 * @param string $balise
	 * @param array $arrDocs
	 *
	 */
	public function setImage($oOdf, $balise, $arrDocs){
	
		if(isset($arrDocs[0])){
			$doc = $arrDocs[0];
			if($doc["content_type"]=='image/gif' || $doc["content_type"]=='image/jpeg' || $doc["content_type"]=='image/png'){
				//récupère la taille de l'image
				if($this->pathDebug)$path = str_replace("/home/gevu/www/data/lieux",$this->pathDebug."/data/lieux", $doc['path_source']);
				else $path = $doc['path_source'];
				/*
				$size = getimagesize($doc['url']);
				if($size[0] > $size[1])
					$oOdf->setImage($balise, $path, 0, 9);						
				else
				*/
				$oOdf->setImage($balise, $path, 9, 0);
				$this->trace("setImage : ".$path);
			}
		}else{
			//sans image on en met une par defaut
			$oOdf->setImage($balise, '../images/check_no.png');
			$this->trace("setImage : NO");
		}
		
		return $oOdf;
	}   
		
	/**
	 * supprime les rapports des royalties obsoletes
	 * 
	 * @param int	$idsAuteur
	 *
	 *
	 */
	function supprimeObsoletes($idsAuteur){

		$dbR = new Model_DbTable_Iste_rapport();
		$rs = $dbR->findObsoleteByIdsAuteur($idsAuteur); 
		foreach ($rs as $r) {
			$dbR->remove($r['id_rapport']); 
		} 
	 
		

	}
	
	
	
	function delTree($dir) { 
		$files = array_diff(scandir($dir), array('.','..')); 
		 foreach ($files as $file) { 
		   (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file"); 
		 } 
		 return rmdir($dir); 
	} 

	/**
	 * création de tous les rapports
	 * 
	 * @param int	$idAuteur
	 *
	 *
	 */
	public function setAll($idAuteur=false){
		set_time_limit(3600);

		$dbRoy = new Model_DbTable_Iste_royalty();
		$dbRap = new Model_DbTable_Iste_rapport();
		$dbDev = new Model_DbTable_Iste_devise();

		//on supprime le répertoire tmp
		if(!$idAuteur)$this->delTree(ROOT_PATH."/data/".RAPPORT_PATH."/tmp");
		//on le recrée
		if(!$idAuteur)mkdir(ROOT_PATH."/data/".RAPPORT_PATH."/tmp", 0775);
		//récupère le taux actuel
		$taux_reduction = floatval($dbDev->findByAnnee(date('Y'))["taxe_deduction"]);
		//on récupère les paiements
		$rs = $dbRoy->paiementAuteurFic($idAuteur);		
		$i = 0;
		foreach ($rs as $r) {
			$verifAuteur = $idAuteur ? $idAuteur : $r['id_auteur'];
			if($r['id_auteur'] && $r['id_auteur'] == $verifAuteur){
				//supprime les anciens rapports
				$this->supprimeObsoletes($r['id_auteur']);
				//calcule les odt
				$fic = $this->creaPaiementFic($r,"livre",$taux_reduction,($i % 9));
				if($idAuteur)$this->convertOdtToPdf($fic[1], ROOT_PATH."/data/".RAPPORT_PATH);
				$fic = $this->creaPaiementFic($r,"editoriaux",$taux_reduction,($i % 9));  
				if($idAuteur)$this->convertOdtToPdf($fic[1], ROOT_PATH."/data/".RAPPORT_PATH);
				$i++;
			}
		}
		//pour gérer la génération d'un grand nombre de pdf
		if(!$idAuteur){
			for ($i=0; $i < 10; $i++) { 
				$this->convertOdtToPdf(ROOT_PATH."/data/".RAPPORT_PATH."/tmp/".$i."_*.odt", ROOT_PATH."/data/".RAPPORT_PATH);
			}	
		}
	}

}	
