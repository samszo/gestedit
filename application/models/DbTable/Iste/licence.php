<?php
/**
 * Ce fichier contient la classe Iste_licence.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_licence extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_licence';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_licence';
    
    /**
     * Vérifie si une entrée Iste_licence existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_licence'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_licence; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_licence.
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
     * Recherche une entrée Iste_licence avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_licence.id_licence = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_licence avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_licence.id_licence = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_licence avec la clef de lieu
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
     * Récupère toutes les entrées Iste_licence avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_licence" => "iste_licence") );
                    
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
     * Recherche une entrée Iste_licence avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_licence
     *
     * @return array
     */
    public function findById_licence($id_licence)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_licence") )                           
                    ->where( "i.id_licence = ?", $id_licence );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_licence avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $licence_unitaire
     *
     * @return array
     */
    public function findByLicence_unitaire($licence_unitaire)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_licence") )                           
                    ->where( "i.licence_unitaire = ?", $licence_unitaire );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_licence avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $licence_coef
     *
     * @return array
     */
    public function findByLicence_coef($licence_coef)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_licence") )                           
                    ->where( "i.licence_coef = ?", $licence_coef );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_licence avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $licence_illimite
     *
     * @return array
     */
    public function findByLicence_illimite($licence_illimite)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_licence") )                           
                    ->where( "i.licence_illimite = ?", $licence_illimite );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_licence avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $mutiplicateur
     *
     * @return array
     */
    public function findByMutiplicateur($mutiplicateur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_licence") )                           
                    ->where( "i.mutiplicateur = ?", $mutiplicateur );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
