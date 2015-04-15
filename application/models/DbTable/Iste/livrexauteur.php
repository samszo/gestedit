<?php
/**
 * Ce fichier contient la classe Iste_livrexauteur.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_livrexauteur extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_livrexauteur';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_livre';
    
    /**
     * Vérifie si une entrée Iste_livrexauteur existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_livre'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_livre; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_livrexauteur.
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
     * Recherche une entrée Iste_livrexauteur avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_livrexauteur.id_livre = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_livrexauteur avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_livrexauteur.id_livre = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_livrexauteur avec la clef de lieu
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
     * Récupère toutes les entrées Iste_livrexauteur avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_livrexauteur" => "iste_livrexauteur") );
                    
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
     * Recherche une entrée Iste_livrexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_livre
     *
     * @return array
     */
    public function findById_livre($id_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livrexauteur") )                           
                    ->where( "i.id_livre = ?", $id_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livrexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_auteur
     *
     * @return array
     */
    public function findById_auteur($id_auteur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livrexauteur") )                           
                    ->where( "i.id_auteur = ?", $id_auteur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livrexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $role
     *
     * @return array
     */
    public function findByRole($role)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livrexauteur") )                           
                    ->where( "i.role = ?", $role );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
