<?php
/**
* Class pour gérer les flux de mailing
*
*
* @author     Roch Delannay
* @license    CC0 1.0 Universal (CC0 1.0) Public Domain Dedication http://creativecommons.org/publicdomain/zero/1.0/ 
*/
class Flux_Mailing extends Flux_Site{
        
    function __construct($idBase=false,$trace=false){    	
    	    	
			parent::__construct($idBase,$trace);
			$this->dbFic = new Model_DbTable_Iste_importfic();
			$this->dbData = new Model_DbTable_Iste_importdata();
			$this->dbLivre = new Model_DbTable_Iste_livre();
			$this->dbIsbn = new Model_DbTable_Iste_isbn();
		}
	
	
    /**
	* méthode pour importer un fichier de vente
	*
    * @param integer		$idFic
    * 
    */
    public function importer($idFic){
		$this->trace("DEB ".__METHOD__);

		if($idFic){
			$rsFic = $this->dbFic->findById_importfic($idFic);
			$path = str_replace(WEB_ROOT, ROOT_PATH, $rsFic["url"]);
			$this->trace("//url du fichier = ".$path);
		}		
		
		$this->data= $this->csvToArray($path,0,",");
		
		//TODO:ajouter les autres colonnes
		$descColo = array("col1","col2","col3","col4","col5","col6","col7","col8","col9", "col10", "col11","col12", "col13", "col14", "col15");	
		
		$nbCol = count($descColo);
		$nbRow = count($this->data);
		
        $this->dbFic->edit($idFic,array("type"=>"Mailing","coldesc"=>json_encode($descColo),"reference"=>"rien"));
	    $this->trace("fichier enregistré");
	    
		//enregistre les données
		for ($i=1; $i < $nbRow; $i++) { 
			$c = $this->data[$i];
	        $this->trace("//enregistre les données de la ligne $i");
            $r = array("id_importfic"=>$idFic,"numsheet"=>0,"numrow"=>$i);
			//récupère les valeurs de colonnes
			for ($j = 0; $j < $nbCol; $j++) {
				if(isset($c[$j]))$r["col".($j+1)] = str_replace("\0", "",trim($c[$j]));
			}
			/*TODO:si nécessaires
			- faire les vérifications 
			- ajouter des commentaires suivant les erreurs
			- récupérer les identifiants
			*/
			
			//enregistre la ligne dans la table des datas
			$idD = $this->dbData->ajouter($r);
			$this->trace($r["numrow"]." ".$c[0]." ligne enregistrée = ".$idD);
	    }
	    
	    $this->trace("FIN ".__METHOD__);
	}

	// insertion des données dans les différentes tables:
	public function insertData(){	
		$this->trace("DEB ".__METHOD__);
		
		// Insertion de données dans prospect
		switch ($this->_getParam('obj')) {
		case 'prospect':
			$dbProspect = new Model_DbTable_Iste_prospect();
			$data = array('nom_prenom'=>'col2', 'affiliation1_prospect'=>'col3', 'affiliation2_prospect'=>'col4', 'affiliation3_prospect'=>'col5', 'langue_prospect'=>'col8', 'code_nomen1'=>'col9', 'code_nomen2'=>'col10', 'code_nomen3'=>'col11');
			$idP =  $dbProspect->ajouter(array('email_prospect'=>'col15'));
			$dbProspect->edit($idP, $data);
		break;
		case 'etab':
		break;
		default:
		break;
		}

		$this->trace("FIN ".__METHOD__);
	}
}
