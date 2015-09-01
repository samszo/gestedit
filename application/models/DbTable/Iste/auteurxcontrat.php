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
    public $_primary = 'id_auteurxcontrat';
    
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
		$select->from($this, array('id_auteurxcontrat'));
		foreach($data as $k=>$v){
			if($v)$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_auteurxcontrat; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_auteurxcontrat.
     *
     * @param array $data
     * @param boolean $existe
     * @param boolean $rs
     * @param boolean $edit
     *  
     * @return integer
     */
    public function ajouter($data, $existe=true, $rs=false, $edit=false)
    {
    	
    	$id=false;
    	if($existe)$id = $this->existe($data);
    	if(!$id){
    	 	$id = $this->insert($data);
    	}elseif ($edit){
    		$this->edit($id, $data);
    	}
    	if($rs){
    		$dbC = new Model_DbTable_Iste_contrat();
    		return $dbC->getAllContratAuteur($id);
    	}else
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
   	
    	$this->update($data, 'iste_auteurxcontrat.id_auteurxcontrat = ' . $id);
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
    	$this->delete('iste_auteurxcontrat.id_auteurxcontrat = ' . $id);
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
     * @param int $idAut
     * @param int $idCont
     * @param int $idIsbn
     * 
     * @return array
     */
    public function findByIdAutIdContIdIsbn($idAut, $idCont, $idIsbn)
    {
        $query = $this->select()
			->from( array("i" => "iste_auteurxcontrat") )                           
            ->where( "i.id_auteur = ?", $idAut)
            ->where( "i.id_contrat = ?", $idCont)
            ->where( "i.id_isbn = ?", $idIsbn);
		$rs = $this->fetchAll($query)->toArray(); 
        return count($rs) ? $rs[0] : false;
    }
    
	/**
     * Recherche une entrée Iste_contrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $idSerie
     *
     * @return array
     */
    public function findBySerie($idSerie)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteurxcontrat") )                           
                    ->where( "i.id_serie = ?", $idSerie);

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
