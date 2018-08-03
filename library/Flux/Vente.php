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
	* méthode pour importer un fichier de vente
	*
    * @param string 		$path
    * @param integer		$idFic
    * @param integer		$anFin
	* @param integer		$nbOnglet
    * 
    */
    public function importer($path, $idFic=false, $anFin=1900, $nbOnglet=3){
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
		for ($z = 0; $z < $nbOnglet; $z++) {
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

	
	/**
	 * méthode pour importer un fichier de vente
	 *
     * @param integer		$idFic
	 *
	 */
	public function importerNew($idFic){
	    $this->trace("DEB ".__METHOD__);
	    $this->dbFic = new Model_DbTable_Iste_importfic();
	    $this->dbData = new Model_DbTable_Iste_importdata();
	    $this->dbLivre = new Model_DbTable_Iste_livre();
	    $this->dbIsbn = new Model_DbTable_Iste_isbn();
	    	    
        $rsFic = $this->dbFic->findById_importfic($idFic);
        $path = str_replace(WEB_ROOT, ROOT_PATH, $rsFic["url"]);
        $this->trace("//url du fichier = ".$path);

        $this->trace("//charge les données du fichier");
        $this->data = $this->csvToArray($path);
        $descColo = array("ISBN"=>"col1","auteurs"=>"col2","QTY PAPER"=>"col3","AMOUNT PAPER"=>"col4","AMOUNT EBOOK"=>"col5");
        /*
        foreach ($this->data[0] as $k => $v) {
            $descColo[]="col".($k+1);
        }
        */
        $nbCol = count($descColo);
        $this->dbFic->edit($idFic,array("type"=>"Vente Globale","coldesc"=>json_encode($descColo),"reference"=>"rien"));
	    $this->trace("fichier enregistré");
	    
	    //enregistre les onglets
	    $i=0;
	    foreach ($this->data as $c) {
	        $this->trace("//enregistre les données de la ligne $i");
            $r = array("id_importfic"=>$idFic,"numsheet"=>0,"numrow"=>$i);
            if($c[0]){
                //récupère les valeurs de colonnes
                for ($j = 0; $j < $nbCol; $j++) {
                    if(isset($c[$j]))$r["col".($j+1)] = str_replace("\0", "",trim($c[$j]));
                }
                //vérifie l'existence par isbn
                $arrIsbn = $this->dbIsbn->findByNum($c[0]);
                if(!$arrIsbn){
                    $r["commentaire"]="isbn introuvable";
                    $idD = $this->dbData->ajouter($r);
                    $this->trace($r["numrow"]." isbn introuvable : ".$isbn." = ".$idD);
                }else{
                    $r["id_isbn"]=$arrIsbn["id_isbn"];
                    $r["id_livre"]=$arrIsbn["id_livre"];
                    $idD = $this->dbData->ajouter($r);
                    $this->trace($r["numrow"]." ".$c[0]." ligne enregistrée = ".$idD." = ".$arrIsbn["num"]);
                }
            }else{
                $this->trace($i." ligne vide");
            }
            $i++;
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

	/**
	 * méthode pour calculer les ventes d'un fichier importé
	 *
	 * @param int $idFic
	 *
	 */
	public function calculerVentesNew($idFic){
	    $this->bTraceFlush = false;
	    $this->trace("DEB ".__METHOD__);
	    $dbData = new Model_DbTable_Iste_importdata();
	    $dbVente = new Model_DbTable_Iste_vente();
	    $dbBout = new Model_DbTable_Iste_boutique();
	    $idBoutISTE = $dbBout->ajouter(array("nom"=>"ISTE"));
	    
	    $this->trace("//charge les données du fichier");
	    $rs = $dbData->findSalesByIdFic($idFic);
	    //traite les lignes de ventes
	    foreach ($rs as $r) {
	        if(!$r["commentaire"]){
				//création des lignes pour le papier
				if($r["col3"]){
					$nbVente = $r["col3"] ? $r["col3"] : 1;
					$type = "papier";
					$mt = $this->tofloat($r["col4"]);
					$mtE = $mt*floatval($r["conversion_livre_euro"])/100;
					$idBout = $idBoutISTE;
					//enregistre la vente
					$idVente = $dbVente->ajouter(array("id_isbn"=>$r["id_isbn"], "id_importdata"=>$r["id_importdata"]
						, "date_vente"=>$r["periode_fin"], "id_boutique"=>$idBout, "type"=>$type
						, "nombre"=>$nbVente, "montant_euro"=>$mtE, "montant_livre"=>$mt, "id_licence"=>-1, "id_prix"=>-1));
					$this->trace("ajout vente : ".$idVente."=".$mt);
				}
				//création des lignes pour les ebook
				if($r["col5"]){
					$nbVente = 1;
					$type = "ebook";
					$mt = $this->tofloat($r["col5"]);
					$mtE = $mt*floatval($r["conversion_livre_euro"])/100;
					$idBout = $idBoutISTE;
					//enregistre la vente
					$idVente = $dbVente->ajouter(array("id_isbn"=>$r["id_isbn"], "id_importdata"=>$r["id_importdata"]
						, "date_vente"=>$r["periode_fin"], "id_boutique"=>$idBout, "type"=>$type
						, "nombre"=>$nbVente, "montant_euro"=>$mtE, "montant_livre"=>$mt, "id_licence"=>-1, "id_prix"=>-1));
					$this->trace("ajout vente : ".$idVente."=".$mt);
				}
			}
	    }
	    $this->trace("FIN ".__METHOD__);
	}	
	
	function tofloat($num) {
	    $dotPos = strrpos($num, '.');
	    $commaPos = strrpos($num, ',');
	    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
	    ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
	    
	    if (!$sep) {
	        return floatval(preg_replace("/[^0-9]/", "", $num));
	    }
	    
	    return floatval(
	        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
	        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
	        );
	}
	
	public function updateTauxDevise()
	{
	    $dbD = new Model_DbTable_Iste_devise();
	    
	    //récupère les dates de ventes
	    $rsDV = $dbD->getDateSansDevise();
	    $arrC = array(
	        array("url"=>'/usd/eur',"sql"=>"taux_dollar_euro")
	        ,array("url"=>'/eur/usd',"sql"=>"taux_euro_dollar")
	        ,array("url"=>'/gbp/usd',"sql"=>"taux_livre_dollar")
	        ,array("url"=>'/usd/gbp',"sql"=>"taux_dollar_livre")
	        ,array("url"=>'/eur/gbp',"sql"=>"taux_euro_livre")
	        ,array("url"=>'/gbp/eur',"sql"=>"taux_livre_euro")
	    );
	    //pour chaque date
	    foreach ($rsDV as $d) {
	        $this->trace($d['dv']);
	        $data = array("date_taux"=>$d['dv'],"date_taux_fin"=>$d['dv'],"base_contrat"=>'FR','taxe_taux'=>0,'taxe_deduction'=>0);
	        foreach ($arrC as $c) {
	            //récupère les taux de conversion pour la date
	            $url = 'http://currencies.apps.grandtrunk.net/getrate/'.$d['dv'].$c["url"];
	            $t = $this->getUrlBodyContent($url);
	            $data[$c["sql"]] = $t;
	            $this->trace($c["sql"].' = '.$t);
	        }
	        //Enregistre le taux
	        $dbD->ajouter($data);
	    }
	    
	}  
	
	/**
	 * méthode pour calculer les problèmes liés à l'oimportation d'un fichier de vente
	 *
	 * @param int $idFic
	 *
	 * @return array
	 */
	public function getProblemesFic($idFic){
	    
	    //récupère la définition du fichier
	    $dbFic = new Model_DbTable_Iste_importfic();
	    $dbID = new Model_DbTable_Iste_importdata();
	    
	    $rsFic = $dbFic->findById_importfic($idFic);
	    $rs['fichier']=$rsFic;
	    $cols = $dbID->getColForFic($idFic, json_decode($rsFic["coldesc"]));
	    
	    //récupère les lignes de data sans isbn et autres erreur
	    $rs['commentaires']=$dbID->findErreurByIdFic($idFic, $cols);

	    //calcul les sommes importées et les sommes de ventes
	    $rs['sommes']=$dbID->getSommesForFic($idFic);
	    
	    /*récupère les lignes sans ventes
	     * correspond au sommes vide aux ISBN introuvable ???
	    */
	    $rs['data_sans_vente']=$dbID->getDataSansVenteForFic($idFic, $cols);
	    
	    //récupère les lignes sans contrat
	    $rs['data_sans_contrat']=$dbID->getDataSansContrat($idFic);
	    
		//récupère les lignes sans base contrat		
	    //$rs['data_sans_basecontrat']=$dbID->getDataSansBaseContrat($idFic);
		
	    return  $rs;
	}

	/**
	 * méthode pour calculer les problèmes de vente
	 *
	 *
	 * @return array
	 */
	public function getProblemes(){
	    //TODO:faire les requête pour les erreurs possibles	    
	    //récupère les lignes sans contrat
	    $rs['data_sans_contrat']=$dbID->getDataSansContrat($idFic);
	    
		//récupère les lignes sans base contrat
	    $rs['data_sans_basecontrat']=$dbID->getDataSansBaseContrat($idFic);
		
	    
	    return  $rs;
	}

}