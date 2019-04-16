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
			$this->dbProspect = new Model_DbTable_Iste_prospect();
			$this->dbEtab = new Model_DbTable_Iste_etab();
			$this->dbNomen = new Model_DbTable_Iste_nomenclature();
			$this->dbPxE = new Model_DbTable_Iste_prospectxetab();
			$this->dbPxN = new Model_DbTable_Iste_prospectxnomenclature();

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

	/** insertion des données dans les différentes tables:
	 * @param integer	$idFic
	 * */ 

	public function insertData($idFic){	
		$this->trace("DEB ".__METHOD__);
		
		$arr = $this->dbData->findByIdFic($idFic);

		// Boucle sur les données de importdata par $idFic
		foreach ($arr as $d) {
			//vérifie si la ligne est en erreur
			if(substr($d['commentaire'],0,7)!='erreur:'){
				//prospect : voir dbTable/Iste/prospect.php L33 pour éviter la création de doublons
				$data = array('nom_prenom'=>$d['col2'], 'origine'=>$d['col14'], 'email'=>$d['col15']);
				$idP = $this->dbProspect->ajouter($data);
				//etab
				$idE = $this->dbEtab->ajouter(array('url_labo'=>$d['col1'], 'ville_cp'=>$d['col7'], 'pays'=>$d['col8']
					, 'affiliation1'=>$d['col3'], 'affiliation2'=>$d['col4'], 'affiliation3'=>$d['col5']));
				//etabxprospect
				$idPxE = $this->dbPxE->ajouter(array("id_prospect"=>$idP, "id_etab"=>$idE));
				//nomenclature
				//TODO:vérifier à l'import que tous les codes sont bien présents sinon mettre un commentaire
				// = erreur : Il n'y a que les id_nomenclature = 160 qui sont renseignées dans la table prospectxnomenclature
				for ($i=1; $i <= 3; $i++) { 
					//récupère le code
					$code = $d['col'.(8+$i)];
					//vérifie que le code est renseigné
					if($code){
						//récupère l'identifiant de nomenclature
						$rsN = $this->dbNomen->getByCode($code);
						if($rsN){
							//ajoute la relation entre le prospect et la nomenclature
							$this->dbPxN->ajouter(array("id_prospect"=>$idP,"id_nomenclature"=>$rsN['id_nomenclature']));
						}
					}
				}
			}	
		}	
		$this->trace("FIN ".__METHOD__);
	}
}
