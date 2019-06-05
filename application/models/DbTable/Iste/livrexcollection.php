<?php
/**
 * Ce fichier contient la classe Iste_livrexcollection.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_livrexcollection extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_livrexcollection';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_livre';
    
    /**
     * Vérifie si une entrée Iste_livrexcollection existe.
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
     * Ajoute une entrée Iste_livrexcollection.
     *
     * @param array $data
     * @param boolean $existe
     * @param boolean $rs
     *  
     * @return integer
     */
    public function ajouter($data, $existe=true, $rs=false)
    {    	
	    	$id=false;
	    	if($existe)$id = $this->existe($data);
	    	if(!$id){
	    	 	$id = $this->insert($data);
	    	};
	    	if($rs)
	    		return $this->findByLivreCollection($data["id_livre"], $data["id_collection"]);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_livrexcollection avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
	    	$this->update($data, 'iste_livrexcollection.id_livre = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_livrexcollection avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param int $idLivre
     * @param int $idCollection
     *
     * @return void
     */
    public function remove($idLivre, $idCollection)
    {
	    	$this->delete('iste_livrexcollection.id_collection = '.$idCollection.' AND iste_livrexcollection.id_livre = '.$idLivre);
    }
    
    /**
     * Récupère toutes les entrées Iste_livrexcollection avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_livrexcollection" => "iste_livrexcollection") );
                    
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
     * Recherche une entrée Iste_livrexcollection avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_livre
     *
     * @return array
     */
    public function findById_livre($id_livre)
    {
        $query = $this->select()
			->from( array("i" => "iste_livrexcollection") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("c" => "iste_collection"),
                'i.id_collection = c.id_collection', array("titre"=>"CONCAT(c.titre_fr,' / ',c.titre_en,' / ',c.titre_es)", "recid"=>"id_collection"))
        		->where( "i.id_livre = ?", $id_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livrexcollection avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_collection
     *
     * @return array
     */
    public function findById_collection($id_collection)
    {
        $query = $this->select()
			->from( array("i" => "iste_livrexcollection") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("c" => "iste_collection"),
                'i.id_collection = c.id_collection', array("titre"=>"CONCAT(c.titre_fr,' / ',c.titre_en,' / ',c.titre_es)", "recid"=>"id_collection"))
        		->where( "i.id_collection = ?", $idCollection );
 
        return $this->fetchAll($query)->toArray(); 
    }
    
	/**
     * Recherche une entrée Iste_livrexcollection avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idLivre
     * @param int $idCollection
     *
     * @return array
     */
    public function findByLivreCollection($idLivre, $idCollection)
    {
        $query = $this->select()
        		->from( array("i" => "iste_livrexcollection") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("c" => "iste_collection"),
                'i.id_collection = c.id_collection', array("titre"=>"CONCAT(c.titre_fr,' / ',c.titre_en,' / ',c.titre_es)", "recid"=>"id_collection"))
        		->where( "i.id_collection = ?", $idCollection )
            ->where( "i.id_livre = ?", $idLivre );
        		
        return $this->fetchAll($query)->toArray(); 
    }    
        
}
