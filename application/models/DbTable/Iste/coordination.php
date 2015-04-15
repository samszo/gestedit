<?php
/**
 * Ce fichier contient la classe Iste_coordination.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_coordination extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_coordination';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_collection';
    
    /**
     * Vérifie si une entrée Iste_coordination existe.
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
     * Ajoute une entrée Iste_coordination.
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
     * Recherche une entrée Iste_coordination avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_coordination.id_collection = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_coordination avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_coordination.id_collection = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_coordination avec la clef de lieu
     * et supprime ces entrées.
     *
     * @param integer $idLieu
     *
     * @return void
     */
    public function removeLieu($idLieu)
    {
		$this->delete('id_lieu = ' . $idLieu);
    }
    
    /**
     * Récupère toutes les entrées Iste_coordination avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_coordination" => "iste_coordination") );
                    
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
     * Recherche une entrée Iste_coordination avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_collection
     *
     * @return array
     */
    public function findById_collection($id_collection)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_coordination") )                           
                    ->where( "i.id_collection = ?", $id_collection );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_coordination avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_auteur
     *
     * @return array
     */
    public function findById_auteur($id_auteur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_coordination") )                           
                    ->where( "i.id_auteur = ?", $id_auteur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_coordination avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $prime
     *
     * @return array
     */
    public function findByPrime($prime)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_coordination") )                           
                    ->where( "i.prime = ?", $prime );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
