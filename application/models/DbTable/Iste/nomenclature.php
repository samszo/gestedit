<?php
/**
 * Ce fichier contient la classe Iste_nomenclature.
 *
 * @copyright  2019  Roch Delannay
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_nomenclature extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_nomenclature';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_nomenclature';
    
    /**
     * Vérifie si une entrée Iste_nomenclature existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_nomenclature'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_nomenclature; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_nomenclature.
     *
     * @param array $data
     * @param boolean $existe
     *  
     * @return integer
     */
    public function ajouter($data, $existe=true, $rs=false)
    {    	
	    	$id=false;
	    	if($existe)$id = $this->existe($data);
	    	if(!$id){
	    	 	$id = $this->insert($data);
            }
            if($rs)
               return $this->getById($id);
            else
    	    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_nomenclature avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
    	$this->update($data, 'iste_nomenclature.id_nomenclature = ' . $id);
    }

    /**
     * Recherche une entrée Iste_nomenclature avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_nomenclature.id_nomenclature = ' . $id);
    }

        /**
     * Récupère toutes les entrées Iste_nomenclature avec certains critères
     * de tri, intervalles
     *  @param string $order
     * 
     * @return array
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("n" => "iste_nomenclature") )
                    ->joinInner(array("nid" => "iste_nomenclature"),
                    'n.id_nomenclature = nid.id_nomenclature', array("recid"=>"n.id_nomenclature"));
                    
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

    public function getById($id)
    {
   	
    	$query = $this->select()
                    ->from( array("n" => "iste_nomenclature") )
                    ->joinInner(array("nid" => "iste_nomenclature"),
                    'n.id_nomenclature = nid.id_nomenclature', array("recid"=>"n.id_nomenclature"))
                    ->where('n.id_nomenclature',$id);
                    
        
        $rs = $this->fetchAll($query)->toArray();
        if(count($rs))return end($rs);
        else return false;
    }

}        

