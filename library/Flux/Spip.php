<?php
/**
* Class pour gérer les flux de données SPIP
*
*
* @author     Samuel Szoniecky <samuel.szoniecky@univ-paris8.fr>
* @license    CC0 1.0 Universal (CC0 1.0) Public Domain Dedication http://creativecommons.org/publicdomain/zero/1.0/ 
*/
class Flux_Spip extends Flux_Site{
        
	var $statueDocument = "publie";
	var $statueArticle = "publie";
	var $statueAuteur = "1comite";	
	var $extImg = array("jpg", "png", "gif", "jpeg");	
    function __construct($idBase=false,$idTrace=false){    	
    	    	
    		parent::__construct($idBase,$idTrace);
    	    
    		$this->arrRub = array("en"=>array("Liste"=>15,"Comite"=>16,"Catalog"=>18),"fr"=>array("Liste"=>27,"Comite"=>28,"Catalog"=>23));
		$this->arrMC = array("serie"=>1,"comite"=>2, "role"=>3);
    		$this->arrLangue = array("en","fr");
    		
		//initialisation des objets		
		$this->dbAut = new Model_DbTable_Iste_auteur();
		$this->dbLivre = new Model_DbTable_Iste_livre();
		$this->dbSpip = new Model_DbTable_Iste_spip();
		$this->dbComite = new Model_DbTable_Iste_comite();
		$this->dbSerie = new Model_DbTable_Iste_serie();
		$this->dbImpFic = new Model_DbTable_Iste_importfic();
		
		$this->dbArt = new Model_DbTable_Spip_articles($this->db);
		$this->dbAutS = new Model_DbTable_Spip_auteurs($this->db);
		$this->dbR = new Model_DbTable_Spip_rubriques($this->db);
		$this->dbM = new Model_DbTable_Spip_mots($this->db);
		$this->dbAutL = new Model_DbTable_Spip_auteursliens($this->db);
		$this->dbML = new Model_DbTable_Spip_motsliens($this->db);
		$this->dbD = new Model_DbTable_Spip_documents($this->db);
		$this->dbDL = new Model_DbTable_Spip_documentsliens($this->db);
		
		
    }

	/**
	 * création automatique des rubrique et article d'auteur
	 * 
	 * @param	array	$arrAuteur
	 * 
	 * @return array
	 */
	public function creaAuteurFromIste($arrAuteur) {
				
		$this->trace("DEBUT ".__METHOD__);		
		$this->trace("auteur ".$arrAuteur["id_auteur"]." ".$arrAuteur["prenom"]." ".$arrAuteur["nom"]);		
						
			//construction du numéro d'ordre
			$num = "";//$i."00. ";

			//vérifie si la rubrique de l'auteur existe
			$titreArtAuteur = $num.$arrAuteur["prenom"]." ".$arrAuteur["nom"];

			//création de l'auteur
			$idAutS = $this->dbAutS->ajouter(array("nom"=>$arrAuteur["prenom"]." ".$arrAuteur["nom"],"statut"=>$this->statueAuteur,"source"=>"flux"));			
			$this->dbSpip->ajouter(array("id_spip"=>$idAutS,"id_iste"=>$arrAuteur["id_auteur"],"obj_spip"=>"auteurs","obj_iste"=>"auteur"));
			
			//création des articles de l'auteur
			$arrIds = $this->creaArticleMultilingue(array("texte"=>"A compléter...", "titre"=>$titreArtAuteur
				,"statut"=>"prepa"), $arrAuteur["id_auteur"], $idAutS, "Liste");

			//création des mots clefs
			$infoAut = $this->dbAut->findInfos($arrAuteur["id_auteur"]);
			//création des comités de l'auteur
			if($infoAut[0]["comites"]){
				$comites = explode(":",$infoAut[0]["comites"]);
				foreach ($comites as $sC) {
					//ajout du lien vers l'auteur
					$this->creaMCFromIste(explode(",", $sC), "comite", "auteur", $idAutS);
					//ajout des liens vers les articles de l'auteur
					foreach ($arrIds as $idA) {
						$this->creaMCFromIste(explode(",", $sC), "comite", "article", $idA);
					}
				}
			}
			//création des séries de l'auteur
			if($infoAut[0]["series"]){
				$series = explode(":",$infoAut[0]["series"]);
				foreach ($series as $sS) {
					$this->creaMCFromIste(explode(",", $sS), "serie", "auteur", $idAutS);
					//ajout des liens vers les articles de l'auteur
					foreach ($arrIds as $idA) {
						$this->creaMCFromIste(explode(",", $sS), "serie", "article", $idA);
					}
				}
			}
			//création des livres de l'auteur
			if($infoAut[0]["livres"]){
				$livres = explode(",",$infoAut[0]["livres"]);
				foreach ($livres as $l) {
					$idArtFr = false;
					$idArtEn = false;
					//on prend la infos minimum pour le livre
					$infoLivre = $this->dbLivre->findInfos($l,true);
					$this->trace("infos du livre :".$l." ".$infoLivre["titre_fr"]." ".$infoLivre["titre_en"]);							
					//vérifier la langue
					if($infoLivre["titre_fr"]){
						$idArtFr = $this->creaArticleFromIste("fr", $infoLivre);
						$this->trace("article français crée ".$idArtFr);							
						//ajoute l'auteur
						$this->dbAutL->ajouter(array("id_auteur"=>$idAutS,"id_objet"=>$idArtFr,"objet"=>"article"));
					}
					if($infoLivre["titre_en"]){
						$idArtEn = $this->creaArticleFromIste("en", $infoLivre);
						$this->trace("article anglais crée ".$idArtEn);							
						//ajoute l'auteur
						$this->dbAutL->ajouter(array("id_auteur"=>$idAutS,"id_objet"=>$idArtEn,"objet"=>"article"));
					}
					//vérifie s'il faut marquer la traduction
					if($idArtFr && $idArtEn){
						$this->dbArt->edit($idArtEn, array("id_trad"=>$idArtEn));						
						$this->dbArt->edit($idArtFr, array("id_trad"=>$idArtEn));						
					}
					//ajout des documents
					$arrFics = $this->dbImpFic->findByObj("livre", $infoLivre["id_livre"]);
					foreach ($arrFics as $f) {
						//création du document
						$ext = pathinfo($f["url"], PATHINFO_EXTENSION);
						$dataDoc = array("extension"=>$ext,"titre"=>$f["nom"],"fichier"=>$f["url"]
							,"descriptif"=>$f["type"], "distant"=>"oui", "mode"=>"document", "statut"=>$this->statueDocument, "taille"=>$f["size"]);
						if (in_array($ext,$this->extImg)) {
							$size = getimagesize($f["url"]);
						    $dataDoc["media"]="image";
						    $dataDoc["largeur"]=$size[0];
						    $dataDoc["hauteur"]=$size[1];
						}
						$idDoc = $this->dbD->ajouter($dataDoc);	
						$this->dbSpip->ajouter(array("id_spip"=>$idDoc,"id_iste"=>$f["id_importfic"],"obj_spip"=>"documents","obj_iste"=>"importfic"));
						$this->trace("document ajouté ".$f["id_importfic"]." ".$f["type"]." = ".$idDoc);	
						//lie le document aux articles
						if($idArtFr)$this->dbDL->ajouter(array("id_document"=>$idDoc,"id_objet"=>$idArtFr,"objet"=>"article"));
						if($idArtEn)$this->dbDL->ajouter(array("id_document"=>$idDoc,"id_objet"=>$idArtEn,"objet"=>"article"));			
					}
					
				}
			}
		
		$this->trace("FIN ".__METHOD__);		
		
	}

	/**
	 * création d'un article multilingue
	 * 
	 * @param	array		$data
	 * @param	int			$idBdRef
	 * @param	int			$idAutS
	 * @param	string		$typeRub
	 * 
	 * @return array
	 */
	public function creaArticleMultilingue($data, $idBdRef, $idAutS, $typeRub=false) {
		
		$i=0;
		$ids = array();
		foreach ($this->arrLangue as $l) {
			if($typeRub) $data["id_rubrique"]=$this->arrRub[$l]["Liste"]; 
			
			if($i==0){
				$data["lang"]=$l;
				$idArtRef = $this->dbArt->ajouter($data);				
				$this->dbArt->edit($idArtRef, array("id_trad"=>$idArtRef));
				$idArt=$idArtRef;
			}else{
				$data["lang"]=$l;
				$data["id_trad"]=$idArtRef;
				$idArt = $this->dbArt->ajouter($data);								
			}
			$ids[]=$idArt;
			$this->dbSpip->ajouter(array("id_spip"=>$idArt,"id_iste"=>$idBdRef,"obj_spip"=>"articles","obj_iste"=>"auteur","lang"=>$l));
			//ajoute l'auteur
			$this->dbAutL->ajouter(array("id_auteur"=>$idAutS,"id_objet"=>$idArt,"objet"=>"article"));
			$i ++;
		}		
		return $ids;	
	}
	
	/**
	 * création d'un article 
	 * 
	 * @param	string		$lang
	 * @param	array		$infoLivre
	 * 
	 * @return int
	 */
	public function creaArticleFromIste($lang, $infoLivre) {
				
		$this->trace("DEBUT ".__METHOD__);		
		$this->trace("livre ".$infoLivre["id_livre"]." - ".$infoLivre["titre_fr"]." - ".$infoLivre["titre_en"]);		
		
		$first = true;
		$chapo = "";
		//création du chapo
		//plus nécessaire car on passe par une table extérieure SPIP
		/*
		if($infoLivre["isbns"]){
			$isbns = explode(":", $infoLivre["isbns"]);
			$prix = explode(":", $infoLivre["prix"]);
			for ($i = 0; $i < count($isbns); $i++) {
				$arrIsbn = explode(",", $isbns[$i]);
				$arrPrix = explode(",", $prix[$i]);
				if($first){
					$p = explode(",", $arrPrix[$i]);
					$chapo .= $arrIsbn[4]." pages - ";
					$dateParu = new DateTime($arrIsbn[3]);
					$dateParu = $dateParu->getTimestamp();
					if($lang=="fr"){
						setlocale(LC_TIME, "fr_FR");
						$chapo .= strftime('%B %Y',$dateParu)."\n";		
					}
					if($lang=="en"){
						setlocale(LC_TIME, "en_EN");
						$chapo .= strftime('%B %Y',$dateParu)."\n";		
						if($infoLivre["prix"])$chapo .= substr($arrIsbn[2],0,-3)." : ".$p[2]."&pound;\n";
					}
					if($infoLivre["prix"]){
						if($lang=="fr")$chapo .= substr($arrIsbn[2],0,-3)." : ".$p[1]."&euro;\n";	
						if($lang=="en")$chapo .= substr($arrIsbn[2],0,-3)." : ".$p[2]."&pound;\n";
					}
				}
				if($lang==substr($arrIsbn[2],-3,2)){
					$chapo .= "ISBN: ".$arrIsbn[1]."(".substr($arrIsbn[2],0,-3).")\n";									
				}
				$first = false;
			}			
		}
		*/
		$chapo = "";
		
		//récupère la date de parution
		$arrDate = explode(",", $infoLivre["date_parution"]);
		$dateParution=false;
		foreach ($arrDate as $d) {
			if($d!="0000-00-00" || $d==null)$dateParution=$d;
		}
		$dataArt = array("id_rubrique"=>$this->arrRub[$lang]["Catalog"]
			, "chapo"=>$chapo, "titre"=>$infoLivre["titre_".$lang], "soustitre"=>$infoLivre["soustitre_".$lang]
			, "descriptif"=>$infoLivre["contexte_".$lang], "ps"=>$infoLivre["bio_".$lang], "texte"=>$infoLivre["tdm_".$lang]
			, "lang"=>$lang, "langue_choisie"=>"oui"
			);
		if($dateParution){
			$dataArt["statut"] = "publie"; 	
			$dataArt["date"] = $dateParution; 	
		}else $dataArt["statut"] = "prepa";			
		if($infoLivre["contexte_".$lang]=="")$dataArt["statut"] = "prepa";	
		
		//ajout de l'article
		$idArt = $this->dbArt->ajouter($dataArt);				
			
		$this->dbSpip->ajouter(array("id_spip"=>$idArt,"id_iste"=>$infoLivre["id_livre"],"obj_spip"=>"articles","obj_iste"=>"livre","lang"=>$lang));
		
		//ajout des mots clefs
		if($infoLivre["series"]){
			$series = explode(":", $infoLivre["series"]);
			foreach ($series as $s) {
				$this->creaMCFromIste(explode(",", $s), "serie", "article", $idArt);
			}
		}
		if($infoLivre["comites"]){
			$comites = explode(":", $infoLivre["comites"]);
			foreach ($comites as $c) {
				$this->creaMCFromIste(explode(",", $c), "comite", "article", $idArt);
			}
		}
		
		$this->trace("FIN ".__METHOD__);		
		
		return $idArt;
	}

	/**
	 * création des mots clefs
	 * 
	 * @param	int		$id
	 * @param	string	$type
	 * 
	 * @return array
	 */
	public function creaMCFromIste($mc, $type, $obj, $id) {

		if(!$mc[2] && !$mc[1]) return;
		if(!$mc[1])$mc[1]=$mc[2];
		if(!$mc[2])$mc[2]=$mc[1];
		
		$idMC = $this->dbM->ajouter(array("titre"=>"<multi>[fr]".$mc[2]."[en]".$mc[1]."</multi>","id_groupe"=>$this->arrMC[$type]));
		$this->dbSpip->ajouter(array("id_spip"=>$idMC,"id_iste"=>$mc[0],"obj_spip"=>"mots","obj_iste"=>$type));
		$this->dbML->ajouter(array("objet"=>$obj,"id_objet"=>$id,"id_mot"=>$idMC));
				
	}
	
	/**
	 * mis à jour des articles
	 * 
	 * @param	int		$idLivre
	 * 
	 * @return array
	 */
	public function modifArticleFromIste($idLivre) {

		$this->trace("DEBUT ".__METHOD__);		
		$this->trace("id_livre = ".$idLivre);										
		//récupère les infos du livre
		$infoLivre = $this->dbLivre->getProductionLivre($idLivre);
		$this->trace("Infos livre ".$infoLivre["titre_fr"]." ".$infoLivre["titre_en"]);
		//récupère la date de parution
		$arrDate = explode(",", $infoLivre["date_parution"]);
		$dateParution=false;
		foreach ($arrDate as $d) {
			if($d!="0000-00-00" || $d!=null)$dateParution=$d;
		}
		//récupère l'identifiant de l'article
		$arrArt = $this->dbSpip->findArtSpip($idLivre,"livre","articles",$this->idBase);
		$this->trace("Infos Article ",$arrArt);
		foreach ($arrArt as $art) {
			$lang = $art["lang"];
			$dataArt = array("chapo"=>"", "titre"=>$infoLivre["titre_".$lang], "soustitre"=>$infoLivre["soustitre_".$lang]
			, "descriptif"=>$infoLivre["contexte_".$lang], "ps"=>$infoLivre["bio_".$lang], "texte"=>$infoLivre["tdm_".$lang]
			, "lang"=>$lang, "langue_choisie"=>"oui");
			if($dateParution){
				$dataArt["statut"] = "publie"; 	
				$dataArt["date"] = $dateParution; 	
			}else $dataArt["statut"] = "prepa";			
			$this->dbArt->edit($art["id_article"], $dataArt);
			$this->trace("article mis à jour ".$idArt. " avec ".$idLivre);							
		}
		$this->trace("FIN ".__METHOD__);		
	}
	
}