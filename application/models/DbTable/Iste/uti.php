<?php
/**
 * Ce fichier contient la classe Iste_uti.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_uti extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_uti';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_uti';
    
    /**
     * Vérifie si une entrée Iste_uti existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_uti'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_uti; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_uti.
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
     * Recherche une entrée Iste_uti avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_uti.id_uti = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_uti avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_uti.id_uti = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_uti avec la clef de lieu
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
     * Récupère toutes les entrées Iste_uti avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_uti" => "iste_uti") );
                    
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
     * Recherche une entrée Iste_uti avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_uti
     *
     * @return array
     */
    public function findById_uti($id_uti)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_uti") )                           
                    ->where( "i.id_uti = ?", $id_uti );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_uti avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nom
     *
     * @return array
     */
    public function findByNom($nom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_uti") )                           
                    ->where( "i.nom = ?", $nom );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_uti avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $login
     *
     * @return array
     */
    public function findByLogin($login)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_uti") )                           
                    ->where( "i.login = ?", $login );
		$rs = $this->fetchAll($query)->toArray(); 
        return count($rs) ? $rs[0] : $rs; 
    }
    	/**
     * Recherche une entrée Iste_uti avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $mdp
     *
     * @return array
     */
    public function findByMdp($mdp)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_uti") )                           
                    ->where( "i.mdp = ?", $mdp );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_uti avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $role
     *
     * @return array
     */
    public function findByRole($role)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_uti") )                           
                    ->where( "i.role = ?", $role );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
