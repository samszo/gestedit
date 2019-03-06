<?php
/**
 * Ce fichier contient la classe Iste_prospectxetab.
 *
 * @copyright  2019 Roch Delannay
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_prospectxetab extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_prospectxetab';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_prospect';
    
    /**
     * Vérifie si une entrée Iste_prospectxetab existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_prospect'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_prospect; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_prospectxetab.
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
	    		if(!isset($data['date_creation']))$data['date_creation']= new Zend_Db_Expr('NOW()');
	    		$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->findById_processus($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_prospectxetab avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_prospectxetab.id_prospect = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_prospectxetab avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		$this->delete('iste_prospectxetab.id_prospect = ' . $id);
    }
    
    /**
     * Récupère toutes les entrées Iste_prospectxetab avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_prospectxetab" => "iste_prospectxetab") );
                    
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
