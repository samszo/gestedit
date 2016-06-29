<?php
/**
 * Ce fichier contient la classe Iste_histomodif.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_histomodif extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_histomodif';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_histomodif';
    
    /**
     * Vérifie si une entrée Iste_histomodif existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_histomodif'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_histomodif; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_histomodif.
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
	    		if(!isset($data['maj']))$data['maj']= new Zend_Db_Expr('NOW()');
	    		$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->findById_histomodif($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_histomodif avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {          	
	    	$this->update($data, 'iste_histomodif.id_histomodif = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_histomodif avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		return $this->delete('iste_histomodif.id_histomodif = ' . $id);
    }
    
    /**
     * Récupère toutes les entrées Iste_histomodif avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    		$query = $this->select()
    			->from( array("iste_histomodif" => "iste_histomodif"),array("recid"=>"id_histomodif","id_histomodif","maj","action","obj","id_obj","data"));
                    
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
     * Recherche une entrée Iste_histomodif avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id
     *
     * @return array
     */
    public function findById_histomodif($id)
    {
        $query = $this->select()
			->from( array("i" => "iste_histomodif"),array("recid"=>"id_histomodif","id_histomodif","maj","action","obj","id_obj","data") )                           
            ->where( "i.id_histomodif = ?", $id);

        return $this->fetchAll($query)->toArray(); 
    }
    
    	/**
     * Recherche une entrée Iste_histomodif avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param string		$obj
     * @param date	 	$dateDeb
     *
     * @return array
     */
    public function findByIdObjDate($obj, $dateDeb)
    {
        $query = $this->select()
			->from( array("i" => "iste_histomodif"),array("recid"=>"id_histomodif","id_histomodif","maj","action","obj","id_obj","data") )                           
            ->where( "i.maj > ?", $dateDeb)
			->where( "i.obj = ?", $obj);

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
