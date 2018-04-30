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
	
    function __construct($idBase=false,$idTrace=false){    	
    	    	
    		parent::__construct($idBase,$idTrace);
		$this->pathPaiement = ROOT_PATH."/data/editions/modeles/royalty.odt";		
    		
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
	
		$this->bTrace = false;
		$this->temps_debut = microtime(true);
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
		$this->odf->setVars('roy_periode', $periode);
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
		$this->odf->setVars('livre_titre', $data["titre_fr"]." - ".$data["titre_en"]);
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
		$newfile = ROOT_PATH."/data/editions/".$nomFic;
		//copy($this->odf->tmpfile, $newfile);

		$this->odf->saveToDisk($newfile);
		$this->trace("//enregistre le fichier ".$newfile);
		
		//enregistrement du rapport
		$idRapport = $this->dbRapport->ajouter(array("url"=>WEB_ROOT."/data/editions/".$nomFic,"id_importfic"=>$mod["id_importfic"]
			, "data"=>json_encode($data), "obj_type"=>"auteur_livre", "obj_id"=>$data["id_auteur"]."_".$data["id_livre"]));		
			
		//mise à jour de la date d'éditions
		$this->dbRoyalty->edit(false,array("id_rapport"=>$idRapport,"date_edition"=>new Zend_Db_Expr('NOW()')),$data["idsRoyalty"]);

		$this->trace("FIN");		
		
		return $idRapport;
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
		$newfile = ROOT_PATH."/data/editions/".$nomFic;
		//copy($this->odf->tmpfile, $newfile);

		$this->odf->saveToDisk($newfile);
		$this->trace("//enregistre le fichier ".$newfile);
		
		//enregistrement du rapport
		$rsRapport = $this->dbRapport->ajouter(array("url"=>WEB_ROOT."/data/editions/".$nomFic,"id_importfic"=>$mod["id_importfic"]
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
  	
}	
