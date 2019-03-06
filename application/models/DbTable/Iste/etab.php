<?php
/**
 * Ce fichier contient la classe Iste_etab.
 *
 * @copyright  2019  Roch Delannay
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_etab extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_etab';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_etab';
    
    /**
     * Vérifie si une entrée Iste_etab existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_etab'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_etab; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_etab.
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
     * Recherche une entrée Iste_etab avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
    	$this->update($data, 'iste_etab.id_etab = ' . $id);
    }

    /**
     * Recherche une entrée Iste_etab avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_etab.id_etab = ' . $id);
    }

        /**
     * Récupère toutes les entrées Iste_etab avec certains critères
     * de tri, intervalles
     *  @param string $order
     * 
     * @return array
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("n" => "iste_etab") )
                    ->joinInner(array("nid" => "iste_etab"),
                    'n.id_etab = nid.id_etab', array("recid"=>"n.id_etab"));
                    
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

}        

