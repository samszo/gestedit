<?php
/**
 * Ce fichier contient la classe Iste_traducteurxcontrat.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_traducteurxcontrat extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_traducteurxcontrat';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_traducteurxcontrat';
    
    /**
     * Vérifie si une entrée Iste_traducteurxcontrat existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_traducteurxcontrat'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_traducteurxcontrat; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_traducteurxcontrat.
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
     * Recherche une entrée Iste_traducteurxcontrat avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_traducteurxcontrat.id_traducteurxcontrat = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_traducteurxcontrat avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_traducteurxcontrat.id_traducteurxcontrat = ' . $id);
    }

    
    /**
     * Récupère toutes les entrées Iste_traducteurxcontrat avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_traducteurxcontrat" => "iste_traducteurxcontrat") );
                    
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
     * Recherche une entrée Iste_traducteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_traducteur
     *
     * @return array
     */
    public function findById_traducteur($id_traducteur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteurxcontrat") )                           
                    ->where( "i.id_traducteur = ?", $id_traducteur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_traducteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_contrat
     *
     * @return array
     */
    public function findById_contrat($id_contrat)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteurxcontrat") )                           
                    ->where( "i.id_contrat = ?", $id_contrat );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_traducteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $date_signature
     *
     * @return array
     */
    public function findByDate_signature($date_signature)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteurxcontrat") )                           
                    ->where( "i.date_signature = ?", $date_signature );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
