<?php
/**
 * Ce fichier contient la classe Iste_proposition.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_proposition extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_proposition';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_proposition';
    
    /**
     * Vérifie si une entrée Iste_proposition existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_proposition'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_proposition; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_proposition.
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
	    		if(!isset($data['date_debut']))$data['date_debut']= new Zend_Db_Expr('NOW()');
	    	 	$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->findById_proposition($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_proposition avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
	    	$this->update($data, 'iste_proposition.id_proposition = ' . $id);
    }

    /**
     * Recherche une entrée Iste_proposition avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function editByLivre($id, $data)
    {        
	    	$this->update($data, 'iste_proposition.id_livre = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_proposition avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_proposition.id_proposition = ' . $id);
    }
    
    /**
     * Récupère toutes les entrées Iste_proposition avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    		$query = $this->select()
                    ->from( array("iste_proposition" => "iste_proposition") );
                    
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
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_proposition
     *
     * @return array
     */
    public function findById_proposition($id_proposition)
    {
        $query = $this->select()
            ->from( array("p" => "iste_proposition") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("pid" => "iste_proposition"),
                'p.id_proposition = pid.id_proposition', array("recid"=>"id_proposition"))
            ->where( "p.id_proposition = ?", $id_proposition );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $date_debut
     *
     * @return array
     */
    public function findByDate_debut($date_debut)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_proposition") )                           
                    ->where( "i.date_debut = ?", $date_debut );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $date_contrat
     *
     * @return array
     */
    public function findByDate_contrat($date_contrat)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_proposition") )                           
                    ->where( "i.date_contrat = ?", $date_contrat );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $base_contrat
     *
     * @return array
     */
    public function findByBase_contrat($base_contrat)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_proposition") )                           
                    ->where( "i.base_contrat = ?", $base_contrat );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $date_manuscrit
     *
     * @return array
     */
    public function findByDate_manuscrit($date_manuscrit)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_proposition") )                           
                    ->where( "i.date_manuscrit = ?", $date_manuscrit );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $langue
     *
     * @return array
     */
    public function findByLangue($langue)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_proposition") )                           
                    ->where( "i.langue = ?", $langue );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $traduction
     *
     * @return array
     */
    public function findByTraduction($traduction)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_proposition") )                           
                    ->where( "i.traduction = ?", $traduction );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param tinyint $publication_fr
     *
     * @return array
     */
    public function findByPublication_fr($publication_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_proposition") )                           
                    ->where( "i.publication_fr = ?", $publication_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param tinyint $publication_en
     *
     * @return array
     */
    public function findByPublication_en($publication_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_proposition") )                           
                    ->where( "i.publication_en = ?", $publication_en );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nb_page
     *
     * @return array
     */
    public function findByNb_page($nb_page)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_proposition") )                           
                    ->where( "i.nb_page = ?", $nb_page );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_proposition avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idLivre
     *
     * @return array
     */
    public function findById_livre($idLivre)
    {
        $query = $this->select()
			->from( array("p" => "iste_proposition") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("pid" => "iste_proposition"),
                'p.id_proposition = pid.id_proposition', array("recid"=>"id_proposition"))
			->where( "p.id_livre = ?", $idLivre );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
