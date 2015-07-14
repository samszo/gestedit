<?php
/**
* Class pour gérer les flux de données Wiley
*
*
* @author     Samuel Szoniecky <samuel.szoniecky@univ-paris8.fr>
* @license    CC0 1.0 Universal (CC0 1.0) Public Domain Dedication http://creativecommons.org/publicdomain/zero/1.0/ 
*/
class Flux_Wiley extends Flux_Site{
        
    function __construct($idBase=false,$idTrace=false){    	
    	    	
    		parent::__construct($idBase,$idTrace);
    	    
    }

	/**
	* méthode pour calculer les ventes d'un fichier importé
	*
    * @param int $idFic
    * 
    */
	public function calculerVentes($idFic){
		$this->trace("DEB ".__METHOD__);
		$dbData = new Model_DbTable_Iste_importdata();
		$dbVente = new Model_DbTable_Iste_vente();
		$dbLic = new Model_DbTable_Iste_licence();
		$dbRoy = new Model_DbTable_Iste_royalty();
		
		$this->trace("//charge les données du fichier");
		$rs = $dbData->findWileySalesByIdFic($idFic);
		//traite les lignes de ventes
		foreach ($rs as $r) {
			//traitement des lignes
			switch ($r["col1"]) {
				case "DOMESTIC-REGULAR":
					//réinitialise les variables
					$nbRetour = 0;
					$nbVente = 0;
					$type = "";
					$prixUni = 0;					
					$type = $r["col1"];
					break;
				case 'ON-DEMAND PRINT':
					//réinitialise les variables
					$nbRetour = 0;
					$nbVente = 0;
					$type = "";
					$prixUni = 0;					
					$type = $r["col1"];
					break;
				case "GROSS":
					$nbVente = $r["col2"];
					break;
				case "RETURNS":
					$nbRetour = $r["col2"];
					$prixRetour = $r["col3"];
					break;
				default:
					//calcule les prix;
					//'NET @  255.00'
					$pos = strpos($r["col1"], "@");
					$pri = trim(substr($r["col1"], $pos+1));
					$prixUni = $this->tofloat($pri); 
					$prixVente = $this->tofloat($r["col3"]); 
					$nbVente = $r["col2"];					
					//ajout licence
					$idLic = $dbLic->ajouter(array("licence_unitaire"=>$prixUni, "licence_coef"=>$r["col4"], "nom"=>$type));
					$this->trace("ajout licence : ".$idLic."=".$prixUni." ".$type." ".$r["col4"]);
					//ajout vente
					if($nbRetour){
						$prixRetour = "-".substr($prixRetour, 0, -1);
						$nbRetour = "-".substr($r["col2"], 0, -1);
						$idVente = $dbVente->ajouter(array("id_isbn"=>$r["id_isbn"], "id_importdata"=>$r["id_importdata"], "date_vente"=>$r["periode_fin"], "boutique"=>"Wiley"
							, "nombre"=>$nbRetour, "montant_dollar"=>$prixRetour, "id_licence"=>$idLic));					
						$this->trace("ajout retour : ".$idVente."=".$nbRetour." ".$type." => ".$prixRetour);
					}
					if($nbVente){
						$idVente = $dbVente->ajouter(array("id_isbn"=>$r["id_isbn"], "id_importdata"=>$r["id_importdata"], "date_vente"=>$r["periode_fin"], "boutique"=>"Wiley"
							, "nombre"=>$nbVente, "montant_dollar"=>$prixVente, "id_licence"=>$idLic));					
						$this->trace("ajout vente : ".$idVente."=".$nbVente." ".$type." => ".$prixVente);
						//ajout royaltie à ISTE
						$prixRoy = $this->tofloat($r["col5"]); 
						$dbRoy->ajouter(array("id_vente"=>$idVente,"id_auteur"=>-1,"montant_dollar"=>$prixRoy, "pourcentage"=>$r["col4"]));					
					}
				break;
			}
		}
		$this->trace("FIN ".__METHOD__);				
	}
    
    /**
	* méthode pour importer un fichier Wiley
	*
    * @param string 		$path
    * @param integer		$idFic
    * 
    */
	public function importer($path, $idFic=false){
		$this->trace("DEB ".__METHOD__);
		$dbFic = new Model_DbTable_Iste_importfic();
		$dbData = new Model_DbTable_Iste_importdata();
		$dbLivre = new Model_DbTable_Iste_livre();
		$dbIsbn = new Model_DbTable_Iste_isbn();
		$data = new ExcelReader();
		
		if($idFic){
			$rsFic = $dbFic->findById_importfic($idFic);
			$path = str_replace(WEB_ROOT, ROOT_PATH, $rsFic["url"]);
			$this->trace("//url du fichier = ".$path);
		}		
		
		$this->trace("//charge les données du fichier");
		/**
		 * ATTENTION IL FAUT enlevé les caractère en trop "\0"
		 */
		$data->read($path);
		
		$this->trace("//récupère les données de références");
		$ref = str_replace("\0", "", $data->sheets[0]['cells'][5][8]);
		$per = $data->sheets[0]['cells'][2][4];
		$per = explode(":", $per);
		$fin = str_replace("\0", "", trim($per[1]));
		$date = DateTime::createFromFormat('m-d-y', $fin);
		$fin = $date->format('Y-m-d');
		$date->sub(new DateInterval('P3M'));
		$date->add(new DateInterval('P1D'));
		$deb = $date->format('Y-m-d');

		$this->trace("//récupère la description des colonnes");
		//on ne traite que l'onglet 1
		//$descColo[] = explode(";",str_replace("\0", "",implode(";", $data->sheets[0]['cells'][13])));
		$descColo = explode(";",str_replace("\0", "",implode(";", $data->sheets[1]['cells'][13])));
		//$descColo[] = explode(";",str_replace("\0", "",implode(";", $data->sheets[2]['cells'][13])));
		
		$this->trace("//enregistre le fichier");
		if($idFic){
			$dbFic->edit($idFic,array("reference"=>$ref,"coldesc"=>json_encode($descColo)
				,"periode_debut"=>$deb,"periode_fin"=>$fin));
		}else{
			$idFic = $dbFic->ajouter(array("url"=>$path,"type"=>"Wiley"
				,"reference"=>$ref,"coldesc"=>json_encode($descColo)
				,"periode_debut"=>$deb,"periode_fin"=>$fin));
		}
		/*
		$z = 0;
		$this->trace("//enregistre les données de la feuille Summary : ".$data->sheets[$z]['numRows']." ligne(s);");
		for ($i = 14; $i <= $data->sheets[$z]['numRows']; $i++) {
			$r = array("id_importfic"=>$idFic,"numsheet"=>$z,"numrow"=>$i);
			//récupère les références
			$titre = explode(":", $data->sheets[$z]['cells'][$i][1]);
			//gestion des TOTAL
			if(count($titre)==1){
				$i++;
				$titre = explode(":", $data->sheets[$z]['cells'][$i][1]);
			}
			$titre = trim(str_replace("\0", "",$titre[1]));
			//change de ligne
			$i++;
			$isbn = explode(":", $data->sheets[$z]['cells'][$i][1]);
			$isbn = explode("/", $isbn[1]);
			$isbn = trim(str_replace("\0", "",$isbn[0]));
			//vérifie l'existence par isbn
			$arrIsbn = $dbIsbn->findByNum($isbn);
			if(!$arrIsbn){
				$r["commentaire"]="isbn introuvable";
				$this->trace($i." isbn introuvable : ".$titre." : ".$isbn." = ".$idD);
			}else{
				$r["id_isbn"]=$arrIsbn["id_isbn"];
				$r["id_livre"]=$arrIsbn["id_livre"];
			}						
			for ($j = 2; $j <= $data->sheets[$z]['numCols']; $j++) {
				if(isset($data->sheets[$z]['cells'][$i][$j]))$r["col".$j] = str_replace("\0", "",trim($data->sheets[$z]['cells'][$i][$j]));
			}
			$idD = $dbData->ajouter($r);
			$this->trace($i." références : ".$titre." : ".$isbn." ligne enregistrée = ".$idD." = ".$arrIsbn["num"]);
		}
		*/		
		$z = 1;
		$this->trace("//enregistre les données de la feuille Sales-Activity : ".$data->sheets[$z]['numRows']." ligne(s);");
		for ($i = 14; $i <= $data->sheets[$z]['numRows']; $i++) {
			$r = array("id_importfic"=>$idFic,"numsheet"=>$z,"numrow"=>$i);
			//récupère les références
			$arr = explode(":", $data->sheets[$z]['cells'][$i][1]);
			$stat = trim(str_replace("\0", "",$arr[1]));
			$i++;
			$arr = explode(":", $data->sheets[$z]['cells'][$i][1]);
			$titre = trim(str_replace("\0", "",$arr[1]));
			$i++;
			$arr = explode(":", $data->sheets[$z]['cells'][$i][1]);
			$arr = explode("/", $arr[1]);
			$isbn = trim(str_replace("\0", "",$arr[0]));
			//vérifie l'existence par isbn
			$arrIsbn = $dbIsbn->findByNum($isbn);
			if(!$arrIsbn){
				$r["commentaire"]="isbn introuvable";
				for ($j = 1; $j <= $data->sheets[$z]['numCols']; $j++) {
					if(isset($data->sheets[$z]['cells'][$i][$j]))$r["col".$j] = str_replace("\0", "",trim($data->sheets[$z]['cells'][$i][$j]));
				}
				$idD = $dbData->ajouter($r);
				$this->trace($i." isbn introuvable : ".$titre." : ".$isbn." = ".$idD);
				$type = trim(str_replace("\0", "",$data->sheets[$z]['cells'][$i][1]));
				while ($type!="") {
					$i++;
					$type = trim(str_replace("\0", "",$data->sheets[$z]['cells'][$i][1]));
				}
				$i++;					
			}else{
				$r["id_isbn"]=$arrIsbn["id_isbn"];
				$r["id_livre"]=$arrIsbn["id_livre"];
				$i++;
				$type = trim(str_replace("\0", "",$data->sheets[$z]['cells'][$i][1]));
				while ($type!="") {
					if(substr($type, 0, 3)=="SUB")$i+=8;
					elseif (substr($type, 0, 3)=="TOT")$i+=4;
					else{
						for ($j = 1; $j <= $data->sheets[$z]['numCols']; $j++) {
							if(isset($data->sheets[$z]['cells'][$i][$j]))$r["col".$j] = str_replace("\0", "",trim($data->sheets[$z]['cells'][$i][$j]));
						}
						$idD = $dbData->ajouter($r);
						$this->trace($i." références : ".$titre." : ".$isbn." ligne enregistrée = ".$idD." = ".$arrIsbn["num"]);						
					}					
					$i++;
					$type = trim(str_replace("\0", "",$data->sheets[$z]['cells'][$i][1]));
				}
			}						
		}
		/*	
		$z = 2;
		$this->trace("//enregistre les données de la feuille Subsidiary : ".$data->sheets[$z]['numRows']." ligne(s);");
		for ($i = 14; $i <= $data->sheets[$z]['numRows']; $i++) {
			$r = array("id_importfic"=>$idFic,"numsheet"=>$z,"numrow"=>$i);
			//récupère les références
			$arr = explode(":", $data->sheets[$z]['cells'][$i][1]);
			$stat = trim(str_replace("\0", "",$arr[1]));
			$i++;
			$arr = explode(":", $data->sheets[$z]['cells'][$i][1]);
			$titre = trim(str_replace("\0", "",$arr[1]));
			$i++;
			$arr = explode(":", $data->sheets[$z]['cells'][$i][1]);
			$arr = explode("/", $arr[1]);
			$isbn = trim(str_replace("\0", "",$arr[0]));
			//vérifie l'existence par isbn
			$arrIsbn = $dbIsbn->findByNum($isbn);
			if(!$arrIsbn){
				$r["commentaire"]="isbn introuvable";
				for ($j = 1; $j <= $data->sheets[$z]['numCols']; $j++) {
					if(isset($data->sheets[$z]['cells'][$i][$j]))$r["col".$j] = str_replace("\0", "",trim($data->sheets[$z]['cells'][$i][$j]));
				}
				$idD = $dbData->ajouter($r);
				$this->trace($i." isbn introuvable : ".$titre." : ".$isbn." = ".$idD);
				$type = trim(str_replace("\0", "",$data->sheets[$z]['cells'][$i][1]));
				while ($type!="") {
					$i++;
					$type = trim(str_replace("\0", "",$data->sheets[$z]['cells'][$i][1]));
				}
				$i++;					
			}else{
				$r["id_isbn"]=$arrIsbn["id_isbn"];
				$r["id_livre"]=$arrIsbn["id_livre"];
				$i++;
				$i++;
				$type = trim(str_replace("\0", "",$data->sheets[$z]['cells'][$i][1]));
				while ($type!="") {
					if (substr($type, 0, 3)=="TOT")$i++;
					else{
						for ($j = 1; $j <= $data->sheets[$z]['numCols']; $j++) {
							if(isset($data->sheets[$z]['cells'][$i][$j]))$r["col".$j] = str_replace("\0", "",trim($data->sheets[$z]['cells'][$i][$j]));
						}
						$idD = $dbData->ajouter($r);
						$this->trace($i." références : ".$titre." : ".$isbn." ligne enregistrée = ".$idD." = ".$arrIsbn["num"]);						
					}					
					$i++;
					if(isset($data->sheets[$z]['cells'][$i]))$type = trim(str_replace("\0", "",$data->sheets[$z]['cells'][$i][1]));
					else $type="";
				}
			}						
		}
		*/	
		$this->trace("FIN ".__METHOD__);		
	}
    
}