<?php
/**
* Class pour gérer les flux de vente
*
*
* @author     Samuel Szoniecky <samuel.szoniecky@univ-paris8.fr>
* @license    CC0 1.0 Universal (CC0 1.0) Public Domain Dedication http://creativecommons.org/publicdomain/zero/1.0/ 
*/
class Flux_Vente extends Flux_Site{
        
    function __construct($idBase=false,$idTrace=false){    	
    	    	
    		parent::__construct($idBase,$idTrace);
    		
    }

	
    /**
	* méthode pour importer un fichier Wiley
	*
    * @param string 		$path
    * @param integer		$idFic
    * @param integer		$anFin
    * 
    */
	public function importer($path, $idFic=false, $anFin=1900){
		$this->trace("DEB ".__METHOD__);
		$this->dbFic = new Model_DbTable_Iste_importfic();
		$this->dbData = new Model_DbTable_Iste_importdata();
		$this->dbLivre = new Model_DbTable_Iste_livre();
		$this->dbIsbn = new Model_DbTable_Iste_isbn();
		$this->data = new ExcelReader();
		
		if($idFic){
			$rsFic = $this->dbFic->findById_importfic($idFic);
			$path = str_replace(WEB_ROOT, ROOT_PATH, $rsFic["url"]);
			$this->trace("//url du fichier = ".$path);
		}		
		
		$this->trace("//charge les données du fichier");
				
		/**
		 * ATTENTION IL FAUT enlevé les caractère en trop "\0"
		 */
		$this->data->read($path);
		
		
		$ref = str_replace("\0", "", $this->data->sheets[0]['cells'][1][1]);
		$anDeb = $anFin-1;
		$descColo = array("col1","col2","col3","col4","col5","col6");	
		$this->trace("données de références : ".$anDeb." - ".$anFin);
		
		if($idFic){
			$this->dbFic->edit($idFic,array("reference"=>$ref,"coldesc"=>json_encode($descColo)
				));
		}else{
			$idFic = $this->dbFic->ajouter(array("url"=>$path,"type"=>"Vente Globale","coldesc"=>json_encode($descColo)
				,"reference"=>$ref,"periode_debut"=>$anDeb,"periode_fin"=>$anFin));
		}
		$this->trace("fichier enregistré");

		//enregistre les onglets
		for ($z = 0; $z < 3; $z++) {
			$this->trace("//enregistre les données de l'onglet $z : ".$this->data->sheets[$z]['numRows']." ligne(s);");
			//for ($i = 2; $i <= $data->sheets[$z]['numRows']; $i++) {
			foreach ($this->data->sheets[$z]['cells'] as $i => $c) {
				if($i!=1){
					$r = array("id_importfic"=>$idFic,"numsheet"=>$z,"numrow"=>$i);
					$this->insertData($c, $r);
				}
			}					
		}		
		
		$this->trace("FIN ".__METHOD__);		
	}
    
	function insertData($c, $r){
		
		//enregistre la ligne
		if(isset($c[1]) && $c[1]){
			//récupère l'isbn
			switch ($r["numsheet"]) {
				case 0:
					$isbn = $c[1];
					break;
				case 1:
					//ISBN: 9781848216624 / 1848216629
					$isbn = substr($c[1], 6, 13);
					break;
				case 2:
					$isbn = $c[1];
					break;
			}
			//récupère les valeurs de colonnes
			for ($j = 1; $j <= $this->data->sheets[$r["numsheet"]]['numCols']; $j++) {
				if(isset($c[$j]))$r["col".$j] = str_replace("\0", "",trim($c[$j]));
			}				
			//vérifie l'existence par isbn
			$arrIsbn = $this->dbIsbn->findByNum($isbn);
			if(!$arrIsbn){
				$r["commentaire"]="isbn introuvable";					
				$idD = $this->dbData->ajouter($r);
				$this->trace($r["numrow"]." isbn introuvable : ".$isbn." = ".$idD);
			}else{
				$r["id_isbn"]=$arrIsbn["id_isbn"];
				$r["id_livre"]=$arrIsbn["id_livre"];
				$idD = $this->dbData->ajouter($r);
				$this->trace($r["numrow"]." ".$isbn." ligne enregistrée = ".$idD." = ".$arrIsbn["num"]);						
			}									
		}else{
			$this->trace($r["numrow"]." ligne vide");				
		}						
	}

	
/**
	* méthode pour calculer les ventes d'un fichier importé
	*
    * @param int $idFic
    * 
    */
	public function calculerVentes($idFic){
		$this->bTraceFlush = false;		
		$this->trace("DEB ".__METHOD__);
		$dbData = new Model_DbTable_Iste_importdata();
		$dbVente = new Model_DbTable_Iste_vente();
		$dbBout = new Model_DbTable_Iste_boutique();
		/*
		$dbLic = new Model_DbTable_Iste_licence();
		$dbRoy = new Model_DbTable_Iste_royalty();
		$dbPrix = new Model_DbTable_Iste_prix();
		$dbA = new Model_DbTable_Iste_auteur();
		$dbC = new Model_DbTable_Iste_contrat();
		$dbAC = new Model_DbTable_Iste_auteurxcontrat();
		*/
		//récupération des références
		/*
		$idAuteurISTE = $dbA->ajouter(array("nom"=>"ISTE"));
		$idContratISTEWiley = $dbC->ajouter(array("nom"=>"Wiley - ISTE","type"=>"distribution"));
		$idContratISTEElsevier = $dbC->ajouter(array("nom"=>"Elsevier - ISTE","type"=>"distribution"));
		$idContratISTE = $dbC->ajouter(array("nom"=>"ISTE","type"=>"distribution"));
		*/
		$idBoutWiley = $dbBout->ajouter(array("nom"=>"Wiley"));
		$idBoutElsevier = $dbBout->ajouter(array("nom"=>"Elsevier"));
		$idBoutISTE = $dbBout->ajouter(array("nom"=>"ISTE"));
		
		$this->trace("//charge les données du fichier");
		$rs = $dbData->findSalesByIdFic($idFic);
		//traite les lignes de ventes
		foreach ($rs as $r) {
			//traitement des lignes suivant l'onglet
			switch ($r["numsheet"]) {
				/*
				case 0:
					$nbVente = 1;
					$type = "N";
					$mt = $r["col3"];
					$idBout = $idBoutISTE;
					break;
				*/
				case 0:
					$nbVente = $r["col4"] ? $r["col4"] : 1;
					$type = $r["col3"];
					$mt = $r["col5"];
					$idBout = $idBoutISTE;
					break;
				case 1:
					$nbVente = $r["col4"] ? $r["col4"] : 1;
					$type = $r["col3"];
					$mt = $r["col5"];
					$idBout = $idBoutWiley;
					break;
				case 2:
					$nbVente = $r["col5"] ? $r["col5"] : 1;
					$type = $r["col3"];
					$mt = $r["col6"];
					$idBout = $idBoutElsevier;
					break;
			}
			//enregistre la vente
			$idVente = $dbVente->ajouter(array("id_isbn"=>$r["id_isbn"], "id_importdata"=>$r["id_importdata"]
				, "date_vente"=>$r["periode_fin"], "id_boutique"=>$idBout, "type"=>$type
				, "nombre"=>$nbVente, "montant_livre"=>$mt, "id_licence"=>-1, "id_prix"=>-1));
			$this->trace("ajout vente : ".$idVente."=".$mt);						
		}
		$this->trace("FIN ".__METHOD__);				
	}	
	
}