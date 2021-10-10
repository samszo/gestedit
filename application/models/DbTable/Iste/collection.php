<?php
/**
 * Ce fichier contient la classe Iste_collection.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_collection extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_collection';
    
    /**
     * Clef primaire de la table.
     * public poru la création dynamique des listes cf. index/liste?obj=
     */
    public $_primary = 'id_collection';
    
    /**
     * Vérifie si une entrée Iste_collection existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_collection'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_collection; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_collection.
     *
     * @param array $data
     * @param boolean $existe
     *  
     * @return integer
     */
    public function ajouter($data, $existe=true)
    {    	
	    	$id=false;
	    	if($existe)$id = $this->existe($data);
	    	if(!$id){
	    	 	$id = $this->insert($data);
	    	}
	    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_collection avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_collection.id_collection = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_collection avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_collection.id_collection = ' . $id);
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
                ,array("id"=>$this->_primary[1],"text"=>"CONCAT(IFNULL(titre_fr,''), '/', IFNULL(titre_en,''),' / ', IFNULL(titre_es,''))"))
        ->order("titre_fr");        
        return $this->fetchAll($query)->toArray();
    }    
    /**
     * Récupère toutes les entrées Iste_collection avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_collection" => "iste_collection") );
                    
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
     * Recherche une entrée Iste_collection avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_collection
     *
     * @return array
     */
    public function findById_collection($id_collection)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_collection") )                           
                    ->where( "i.id_collection = ?", $id_collection );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_collection avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_fr
     *
     * @return array
     */
    public function findByTitre_fr($titre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_collection") )                           
                    ->where( "i.titre_fr = ?", $titre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_collection avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_en
     *
     * @return array
     */
    public function findByTitre_en($titre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_collection") )                           
                    ->where( "i.titre_en = ?", $titre_en );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
