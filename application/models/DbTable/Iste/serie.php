<?php
/**
 * Ce fichier contient la classe Iste_serie.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_serie extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_serie';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_serie';
    
    /**
     * Vérifie si une entrée Iste_serie existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_serie'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_serie; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_serie.
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
     * Recherche une entrée Iste_serie avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_serie.id_serie = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_serie avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_serie.id_serie = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_serie avec la clef de lieu
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
     * Récupère toutes les entrées Iste_serie avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_serie" => "iste_serie") );
                    
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
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_serie
     *
     * @return array
     */
    public function findById_serie($id_serie)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_serie") )                           
                    ->where( "i.id_serie = ?", $id_serie );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_fr
     *
     * @return array
     */
    public function findByTitre_fr($titre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_serie") )                           
                    ->where( "i.titre_fr = ?", $titre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_en
     *
     * @return array
     */
    public function findByTitre_en($titre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_serie") )                           
                    ->where( "i.titre_en = ?", $titre_en );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
