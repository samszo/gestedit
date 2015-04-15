<?php
/**
 * Ce fichier contient la classe Iste_commitexlivre.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_commitexlivre extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_commitexlivre';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_commite';
    
    /**
     * Vérifie si une entrée Iste_commitexlivre existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_commite'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_commite; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_commitexlivre.
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
     * Recherche une entrée Iste_commitexlivre avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_commitexlivre.id_commite = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_commitexlivre avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_commitexlivre.id_commite = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_commitexlivre avec la clef de lieu
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
     * Récupère toutes les entrées Iste_commitexlivre avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_commitexlivre" => "iste_commitexlivre") );
                    
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
     * Recherche une entrée Iste_commitexlivre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_commite
     *
     * @return array
     */
    public function findById_commite($id_commite)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_commitexlivre") )                           
                    ->where( "i.id_commite = ?", $id_commite );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_commitexlivre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_livre
     *
     * @return array
     */
    public function findById_livre($id_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_commitexlivre") )                           
                    ->where( "i.id_livre = ?", $id_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
