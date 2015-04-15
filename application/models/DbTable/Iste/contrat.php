<?php
/**
 * Ce fichier contient la classe Iste_contrat.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_contrat extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_contrat';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_contrat';
    
    /**
     * Vérifie si une entrée Iste_contrat existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_contrat'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_contrat; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_contrat.
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
     * Recherche une entrée Iste_contrat avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_contrat.id_contrat = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_contrat avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_contrat.id_contrat = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_contrat avec la clef de lieu
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
     * Récupère toutes les entrées Iste_contrat avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_contrat" => "iste_contrat") );
                    
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
     * Recherche une entrée Iste_contrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_contrat
     *
     * @return array
     */
    public function findById_contrat($id_contrat)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_contrat") )                           
                    ->where( "i.id_contrat = ?", $id_contrat );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_contrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nom
     *
     * @return array
     */
    public function findByNom($nom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_contrat") )                           
                    ->where( "i.nom = ?", $nom );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_contrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $type
     *
     * @return array
     */
    public function findByType($type)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_contrat") )                           
                    ->where( "i.type = ?", $type );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_contrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $url
     *
     * @return array
     */
    public function findByUrl($url)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_contrat") )                           
                    ->where( "i.url = ?", $url );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
