<?php
/**
 * Ce fichier contient la classe Iste_serie.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_serie extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_serie';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_serie';

	protected $_dependentTables = array(
       	"Model_DbTable_Iste_livrexserie"
       	,"Model_DbTable_Iste_coordination"
       	);    
    
    
    /**
     * Vérifie si une entrée Iste_serie existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_serie'));
		foreach($data as $k=>$v){
			if($k!="ref_racine")
				$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_serie; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_serie.
     *
     * @param array $data
     * @param boolean $existe
     * @param boolean $rs
     *  
     * @return integer
     */
    public function ajouter($data, $existe=true, $rs=true)
    {    	
	    	$id=false;
	    	if($existe)$id = $this->existe($data);
	    	if(!$id){
	    	 	$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->findById_serie($id);
	    	else
		    	return $id;
	    	} 
           
    /**
     * Recherche une entrée Iste_serie avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {           	
	    	$this->update($data, 'iste_serie.id_serie = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_serie avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		$n = array();
    		$dt = $this->getDependentTables();
        foreach($dt as $t){
	        	$dbT = new $t($this->_db);
	        $n[$t] = $dbT->delete('id_serie ='.$id);
        }
        //vérifie si des contrats sont associés
        $dbAC = new Model_DbTable_Iste_auteurxcontrat();
        $arr = $dbAC->findBySerie($id);
        if(count($arr)==0)    	
		    $n["Model_DbTable_Iste_serie"] = $this->delete('iste_serie.id_serie = ' . $id);
		else
		    $n["message"] = "La série est supprimée pour les livres.\Impossible de supprimer la série.\Des contrats lui sont liés.";
		
		return $n;
	    		    	
    }

    
    /**
     * Renvoie la liste des entrée
     *
     * @return void
     */
    public function getListe()
    {
    		$query = $this->select()
            ->from( array("l" => $this->_name)
            		,array("recid"=>$this->_primary[1],"id"=>$this->_primary[1],"text"=>"CONCAT(titre_fr,' / ', titre_en)","titre_fr", "titre_en"))
            ->order(array("titre_fr","titre_en"));        
        return $this->fetchAll($query)->toArray();
	} 
    /**
     * Récupère toutes les entrées Iste_serie avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_serie" => "iste_serie") );
                    
        if($order != null)
        {
            $query->order($order);
        }

        if($limit != 0)
        {
            $query->limit($limit, $from);
        }

        return $this->fetchAll($query)->toArray();
    }

    
    	/**
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_serie
     *
     * @return array
     */
    public function findById_serie($id_serie)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_serie")
                    ,array("recid"=>$this->_primary[1],"id"=>$this->_primary[1],"text"=>"CONCAT(titre_fr,' / ', titre_en)","titre_fr", "titre_en"))                           
                    ->where( "i.id_serie = ?", $id_serie );

        return $this->fetchAll($query)->toArray(); 
    }
    
	/**
     * Copier une entrée de la table
     *
     * @param int $id
     *
     * @return array
     */
    public function copier($id)
    {
    		//création de la copie
		$sql = "INSERT INTO iste_serie (titre_fr, titre_en) 
				SELECT CONCAT('copie ',titre_fr), CONCAT('copy ',titre_en) FROM iste_serie WHERE id_serie = ".$id; 	 
	    $this->_db->query($sql);
		$newId = $this->_db->lastInsertId();
	    $dt = $this->getDependentTables();
	    foreach($dt as $t){
	        	$dbT = new $t($this->_db);
			$dbT->copierSerie($newId, $id);
        }
        return $this->findById_serie($newId);
    }    

	/**
     * Fusionner une entrée de la table
     *
     * @param string $ids
     *
     * @return array
     */
    public function fusion($ids)
    {
    		//création de la copie
		$sql = "INSERT INTO iste_serie (titre_fr, titre_en) 
				SELECT CONCAT('fusion : ',GROUP_CONCAT(DISTINCT titre_fr ORDER BY titre_fr DESC SEPARATOR ' - '))
					, CONCAT('fusion : ',GROUP_CONCAT(DISTINCT titre_en ORDER BY titre_en DESC SEPARATOR ' - ')) 
				FROM iste_serie WHERE id_serie IN (".implode(",", $ids).")"; 	 
	    $this->_db->query($sql);
		$newId = $this->_db->lastInsertId();
	    $dt = $this->getDependentTables();
	    foreach($dt as $t){
	        	$dbT = new $t($this->_db);
	        	foreach ($ids as $id) {
				$dbT->copierSerie($newId, $id);
	        	}
        }
        return $this->findById_serie($newId);
    }    
    
    	/**
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_fr
     *
     * @return array
     */
    public function findByTitre_fr($titre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_serie") )                           
                    ->where( "i.titre_fr = ?", $titre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_en
     *
     * @return array
     */
    public function findByTitre_en($titre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_serie") )                           
                    ->where( "i.titre_en = ?", $titre_en );

        return $this->fetchAll($query)->toArray(); 
    }

	/**
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id
     *
     * @return array
     */
    public function findUser($id)
    {
        $query = $this->select()
			->from( array("c" => "iste_coordination"), array("id_coordination","recid"=>"id_coordination") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = c.id_auteur', array("nom"=>"CONCAT(prenom, ' ', nom)"))
			->where( "c.id_serie = ?", $id);
            
        return $this->fetchAll($query)->toArray(); 
        
    }    
}
