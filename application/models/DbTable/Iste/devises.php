<?php
/**
 * Ce fichier contient la classe Iste_devises.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_devises extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_devises';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_devise';
    
    /**
     * Vérifie si une entrée Iste_devises existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_devise'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_devise; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_devises.
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
     * Recherche une entrée Iste_devises avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_devises.id_devise = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_devises avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_devises.id_devise = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_devises avec la clef de lieu
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
     * Récupère toutes les entrées Iste_devises avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_devises" => "iste_devises") );
                    
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
     * Recherche une entrée Iste_devises avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_devise
     *
     * @return array
     */
    public function findById_devise($id_devise)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devises") )                           
                    ->where( "i.id_devise = ?", $id_devise );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_devises avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $date_taux
     *
     * @return array
     */
    public function findByDate_taux($date_taux)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devises") )                           
                    ->where( "i.date_taux = ?", $date_taux );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_devises avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $taux_euro_livre
     *
     * @return array
     */
    public function findByTaux_euro_livre($taux_euro_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devises") )                           
                    ->where( "i.taux_euro_livre = ?", $taux_euro_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_devises avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $taux_livre_euro
     *
     * @return array
     */
    public function findByTaux_livre_euro($taux_livre_euro)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devises") )                           
                    ->where( "i.taux_livre_euro = ?", $taux_livre_euro );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_devises avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $taux_dollar_livre
     *
     * @return array
     */
    public function findByTaux_dollar_livre($taux_dollar_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devises") )                           
                    ->where( "i.taux_dollar_livre = ?", $taux_dollar_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_devises avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $taux_livre_dollar
     *
     * @return array
     */
    public function findByTaux_livre_dollar($taux_livre_dollar)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devises") )                           
                    ->where( "i.taux_livre_dollar = ?", $taux_livre_dollar );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
