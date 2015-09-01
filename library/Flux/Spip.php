<?php
/**
* Class pour gérer les flux de données SPIP
*
*
* @author     Samuel Szoniecky <samuel.szoniecky@univ-paris8.fr>
* @license    CC0 1.0 Universal (CC0 1.0) Public Domain Dedication http://creativecommons.org/publicdomain/zero/1.0/ 
*/
class Flux_Spip extends Flux_Site{
        
	var $statueArticle = "publie";
	var $statueAuteur = "1comite";
	
    function __construct($idBase=false,$idTrace=false){    	
    	    	
    		parent::__construct($idBase,$idTrace);
    	    
    		$this->arrRub = array("Liste"=>15,"Comite"=>16,"Catalog"=>18);
		$this->arrMC = array("serie"=>1,"comite"=>2, "role"=>3);
    		
		//initialisation des objets		
		$this->dbAut = new Model_DbTable_Iste_auteur();
		$this->dbLivre = new Model_DbTable_Iste_livre();
		$this->dbSpip = new Model_DbTable_Iste_spip();
		$this->dbComite = new Model_DbTable_Iste_comite();
		$this->dbSerie = new Model_DbTable_Iste_serie();
		
		$this->dbArt = new Model_DbTable_Spip_articles($this->db);
		$this->dbAutS = new Model_DbTable_Spip_auteurs($this->db);
		$this->dbR = new Model_DbTable_Spip_rubriques($this->db);
		$this->dbM = new Model_DbTable_Spip_mots($this->db);
		$this->dbAutR = new Model_DbTable_Spip_auteursrubriques($this->db);
		$this->dbML = new Model_DbTable_Spip_motsliens($this->db);
		
		
    }

	/**
	 * création automatique des rubrique et article d'auteur
	 * 
	 * @param	int		$idAuteur
	 * 
	 * @return array
	 */
	public function creaAuteurFromIste($idAuteur=false) {
				
		//charge la liste des auteurs
		if($idAuteur) $arrAuteur = $this->dbAut->findById_auteur($idAuteur);
		else $arrAuteur = $this->dbAut->getAll();
		
		$nbM = count($arrAuteur);
		for ($i = 0; $i < $nbM; $i++) {
				
			//construction du numéro d'ordre
			$num = "";//$i."00. ";

			//vérifie si la rubrique de l'auteur existe
			$titreArtAuteur = $num.$arrAuteur[$i]["prenom"]." ".$arrAuteur[$i]["nom"];

			//création de l'auteur
			$idAutS = $this->dbAutS->ajouter(array("nom"=>$arrAuteur[$i]["prenom"]." ".$arrAuteur[$i]["nom"],"statut"=>$this->statueAuteur,"source"=>"flux"));
			$this->dbSpip->ajouter(array("id_spip"=>$idAutS,"id_iste"=>$arrAuteur[$i]["id_auteur"],"obj_spip"=>"auteurs","obj_iste"=>"auteur"));
			//création de l'article de l'auteur
			$idArtAuteur = $this->dbArt->ajouter(array("id_rubrique"=>$this->arrRub["Liste"], "texte"=>"A compléter...", "titre"=>$titreArtAuteur, "statut"=>$this->statueArticle));				
			$this->dbSpip->ajouter(array("id_spip"=>$idArtAuteur,"id_iste"=>$arrAuteur[$i]["id_auteur"],"obj_spip"=>"articles","obj_iste"=>"auteur"));
			//création des mots clefs
			$infoAut = $this->dbAut->findInfos($arrAuteur[$i]["id_auteur"]);
			//création des comités de l'auteur
			if($infoAut[0]["comites"]){
				$comites = explode(":",$infoAut[0]["comites"]);
				foreach ($comites as $sC) {
					$this->creaMCFromIste(explode(",", $sC), "comite", "auteur", $idAutS);
				}
			}
			//création des séries de l'auteur
			if($infoAut[0]["series"]){
				$series = explode(":",$infoAut[0]["series"]);
				foreach ($series as $sS) {
					$this->creaMCFromIste(explode(",", $sS), "serie", "auteur", $idAutS);
				}
			}
			//création des livres de l'auteur
			if($infoAut[0]["livres"]){
				$livres = explode(",",$infoAut[0]["livres"]);
				foreach ($livres as $l) {
					$idArtFr = false;
					$idArtEn = false;
					$infoLivre = $this->dbLivre->findInfos($l);
					//vérifier la langue
					if($infoLivre["titre_fr"]){
						$idArtFr = $this->creaArticleFromIste("fr", $infoLivre);
					}
					if($infoLivre["titre_en"]){
						$idArtEn = $this->creaArticleFromIste("en", $infoLivre);
					}
					//vérifie s'il faut marquer la traduction
					if($idArtFr && $idArtEn){
						$this->dbArt->edit($idArtEn, array("id_trad"=>$idArtFr));						
					}
				}
			}
		}				
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
				
		$first = true;
		$chapo = "";
		//création du chapo
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

		//ajout de l'article
		$idArt = $this->dbArt->ajouter(array("id_rubrique"=>$this->arrRub["Catalog"]
			, "chapo"=>$chapo, "titre"=>$infoLivre["titre_".$lang], "soustitre"=>$infoLivre["soustitre_".$lang]
			, "descriptif"=>$infoLivre["contexte_".$lang], "ps"=>$infoLivre["bio_".$lang], "texte"=>$infoLivre["tdm_".$lang]
			, "lang"=>$lang, "langue_choisie"=>"oui"
			, "statut"=>$this->statueArticle
			));				
		$this->dbSpip->ajouter(array("id_spip"=>$idArt,"id_iste"=>$infoLivre["id_livre"],"obj_spip"=>"articles","obj_iste"=>"livre"));
		
		//ajout des documents
		if($infoLivre["fics"]){
			$fics = explode(":", $infoLivre["fics"]);
			foreach ($fics as $fic) {
				$arrFic = explode(",", $fic);
				if(substr($arrFic[1], -3)=="fr."){
					$idD = $this->dbD->ajouter(array("titre"=>substr($arrFic[1], 0, -3),"fichier"=>$arrFic[2],"distant"=>"oui","statut"=>$this->statueArticle));
					$this->dbSpip->ajouter(array("id_spip"=>$idD,"id_iste"=>$arrFic[0],"obj_spip"=>"documents","obj_iste"=>"ficimport"));
					$this->dbDL->ajouter(array("objet"=>"article","id_objet"=>$idArt,"id_document"=>$idD));
				}
			}
		}
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
		
		$idMC = $this->dbM->ajouter(array("titre"=>"<multi>[fr]".$mc[2]."[en]".$mc[1]."</multi>","id_groupe"=>$this->arrMC[$type]));
		$this->dbSpip->ajouter(array("id_spip"=>$idMC,"id_iste"=>$mc[0],"obj_spip"=>"mots","obj_iste"=>$type));
		$this->dbML->ajouter(array("objet"=>$obj,"id_objet"=>$id,"id_mot"=>$idMC));
				
	}
}