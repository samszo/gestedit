<?php
/**
 * Ce fichier contient la classe Iste_prevision.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_prevision extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_prevision';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_prevision';
    
    /**
     * Vérifie si une entrée Iste_prevision existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_prevision'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_prevision; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_prevision.
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
	    		//if(!isset($data['debut']))$data['debut']= new Zend_Db_Expr('NOW()');
	    		$id = $this->insert($data);
	    	}
	    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_prevision avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {          	
	    	$this->update($data, 'iste_prevision.id_prevision = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_prevision avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_prevision.id_prevision = ' . $id);
    }
    
    /**
     * Récupère toutes les entrées Iste_prevision avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_prevision" => "iste_prevision") );
                    
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
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_prevision
     *
     * @return array
     */
    public function findById_prevision($id_prevision)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.id_prevision = ?", $id_prevision );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_tache
     *
     * @return array
     */
    public function findById_tache($id_tache)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.id_tache = ?", $id_tache );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $commentaire
     *
     * @return array
     */
    public function findByCommentaire($commentaire)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.commentaire = ?", $commentaire );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $debut
     *
     * @return array
     */
    public function findByDebut($debut)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.debut = ?", $debut );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $prevision
     *
     * @return array
     */
    public function findByPrevision($prevision)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.prevision = ?", $prevision );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $fin
     *
     * @return array
     */
    public function findByFin($fin)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.fin = ?", $fin );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $alerte
     *
     * @return array
     */
    public function findByAlerte($alerte)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.alerte = ?", $alerte );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
