<?php
/**
 * Ce fichier contient la classe Iste_auteurxcontrat.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_auteurxcontrat extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_auteurxcontrat';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_auteur';
    
    /**
     * Vérifie si une entrée Iste_auteurxcontrat existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_auteur'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_auteur; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_auteurxcontrat.
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
     * Recherche une entrée Iste_auteurxcontrat avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_auteurxcontrat.id_auteur = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_auteurxcontrat avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_auteurxcontrat.id_auteur = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_auteurxcontrat avec la clef de lieu
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
     * Récupère toutes les entrées Iste_auteurxcontrat avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_auteurxcontrat" => "iste_auteurxcontrat") );
                    
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
     * Recherche une entrée Iste_auteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_auteur
     *
     * @return array
     */
    public function findById_auteur($id_auteur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteurxcontrat") )                           
                    ->where( "i.id_auteur = ?", $id_auteur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_contrat
     *
     * @return array
     */
    public function findById_contrat($id_contrat)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteurxcontrat") )                           
                    ->where( "i.id_contrat = ?", $id_contrat );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $date_signature
     *
     * @return array
     */
    public function findByDate_signature($date_signature)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteurxcontrat") )                           
                    ->where( "i.date_signature = ?", $date_signature );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
