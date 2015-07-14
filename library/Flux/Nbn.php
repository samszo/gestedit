<?php
/**
* Class pour gérer les flux de données BN
*
*
* @author     Samuel Szoniecky <samuel.szoniecky@univ-paris8.fr>
* @license    CC0 1.0 Universal (CC0 1.0) Public Domain Dedication http://creativecommons.org/publicdomain/zero/1.0/ 
*/
class Flux_Nbn extends Flux_Site{
        
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
		$rs = $dbData->findNbnSalesByIdFic($idFic);
		$type = "NBN";
		$idLicGatuit = $dbLic->ajouter(array("licence_unitaire"=>0, "nom"=>$type." gratuit"));
		//traite les lignes de ventes
		foreach ($rs as $r) {
			//traitement des lignes
			$nbRetour = $this->tofloat($r["col5"]);
			$nbGratis = $this->tofloat($r["col8"]);
			$netVente = $this->tofloat($r["col4"]);
			$nbVente = $netVente-$nbGratis;
			$prixUni = $this->tofloat($r["col12"]); 
			$prixVente = $this->tofloat($r["col7"]); 
			$prixRetour = $prixUni*$nbRetour;
			//ajout licence
			$idLic = $dbLic->ajouter(array("licence_unitaire"=>$prixUni, "nom"=>$type));
			$this->trace("ajout licence : ".$idLic."=".$prixUni." ".$type." ".$r["col4"]);
			//ajout vente
			if($nbRetour){
				$idVente = $dbVente->ajouter(array("id_isbn"=>$r["id_isbn"], "id_importdata"=>$r["id_importdata"], "date_vente"=>$r["periode_fin"], "boutique"=>"NBN"
					, "nombre"=>$nbRetour, "montant_euro"=>$prixRetour, "id_licence"=>$idLic));					
				$this->trace("ajout retour : ".$idVente."=".$nbRetour." ".$type." => ".$prixRetour);
			}
			if($nbVente){
				$idVente = $dbVente->ajouter(array("id_isbn"=>$r["id_isbn"], "id_importdata"=>$r["id_importdata"], "date_vente"=>$r["periode_fin"], "boutique"=>"NBN"
					, "nombre"=>$nbVente, "montant_euro"=>$prixVente, "id_licence"=>$idLic));					
				$this->trace("ajout vente : ".$idVente."=".$nbVente." ".$type." => ".$prixVente);
			}
			if($nbGratis){
				$idVente = $dbVente->ajouter(array("id_isbn"=>$r["id_isbn"], "id_importdata"=>$r["id_importdata"], "date_vente"=>$r["periode_fin"], "boutique"=>"NBN"
					, "nombre"=>$nbVente, "montant_euro"=>0, "id_licence"=>$idLicGatuit));					
				$this->trace("ajout vente : ".$idVente."=".$nbVente." ".$type." gratuit => ".$prixVente);
			}
			
		}
		$this->trace("FIN ".__METHOD__);				
	}
    
    /**
	* méthode pour importer un fichier NBN
	*
    * @param string 		$path
    * @param string 		$dateImport
    * @param integer		$idFic
    * 
    */
	public function importer($path, $dateImport, $idFic=false){
		$this->trace("DEB ".__METHOD__);
		$dbFic = new Model_DbTable_Iste_importfic();
		$dbData = new Model_DbTable_Iste_importdata();
		$dbLivre = new Model_DbTable_Iste_livre();
		$dbIsbn = new Model_DbTable_Iste_isbn();
		
		if($idFic){
			$rsFic = $dbFic->findById_importfic($idFic);
			$path = $rsFic["url"];
			$this->trace("//url du fichier = ".$path);
		}
		
		$this->trace("//charge les données du fichier");
		$data = $this->csvToArray($path,"0",",");
		
		$bFirst = true;
		$i=1;
		//définition des colonnes à sauvegarder
		$arrCol = array(1,2,3,4,5,6,7,8,19,21,22,30,32,33,34,36,42,43);
		$nbCol = count($arrCol);						
		foreach ($data as $d) {
			if($bFirst){
				//construction de la description des colonnes
				foreach ($arrCol as $c) {
					$descColo[]=$d[$c-1];
				}
				$descColo = json_encode($descColo);
				if($idFic){
					$dbFic->edit($idFic,array("coldesc"=>$descColo));					
				}else					
					$idFic = $dbFic->ajouter(array("url"=>$path,"type"=>"NBN"
						,"coldesc"=>$descColo
						,"periode_fin"=>$dateImport));
				$bFirst = false;
				$this->trace("//enregistre le fichier = ".$idFic);									
			}else{
				$this->trace("//enregistre les données");
				$r = array("id_importfic"=>$idFic,"numrow"=>$i);
				$isbn = $d[0];
				//vérifie l'existence par isbn
				$arrIsbn = false;
				if($isbn) $arrIsbn = $dbIsbn->findByNum($isbn);
				if(!$arrIsbn){
					$r["commentaire"]="isbn introuvable";
					$this->trace($i." isbn introuvable : ".$isbn);
				}else{
					$r["id_isbn"]=$arrIsbn["id_isbn"];
					$r["id_livre"]=$arrIsbn["id_livre"];
				}
				$j=1;
				foreach ($arrCol as $c) {
					if(isset($d[$c-1]))$r["col".$j] = $d[$c-1];
					$j++;
				}
				$idD = $dbData->ajouter($r);
				$this->trace($i." références : ".$d[1]." : ".$isbn." ligne enregistrée = ".$idD." = ".$arrIsbn["num"]);
				
			}
			$i++;
		}
			
		$this->trace("FIN ".__METHOD__);		
	}
    
}