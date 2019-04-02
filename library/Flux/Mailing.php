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
    public function importer($path, $idFic=false){
		$this->trace("DEB ".__METHOD__);

		if($idFic){
			$rsFic = $this->dbFic->findById_importfic($idFic);
			$path = str_replace(WEB_ROOT, ROOT_PATH, $rsFic["url"]);
			$this->trace("//url du fichier = ".$path);
		}		
		
		$this->data= $this->csvToArray($path);
		
		$ref = str_replace("\0", "", $this->data->sheets[0]['cells'][1][1]);

		$descColo = array("col1","col2","col3","col4","col5","col6");	
		
		if($idFic){
			$this->dbFic->edit($idFic,array("reference"=>$ref,"coldesc"=>json_encode($descColo)
				));
		}else{
			$idFic = $this->dbFic->ajouter(array("url"=>$path,"type"=>"Mailing","coldesc"=>json_encode($descColo)
				,"reference"=>$ref));
		}
		$this->trace("fichier enregistré");
	}
}