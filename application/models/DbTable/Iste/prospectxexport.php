<?php
/**
 * Ce fichier contient la classe Iste_prospectxexport.
 *
 * @copyright  2019 Roch Delannay
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_prospectxexport extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_prospectxexport';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_prospect';
    
    /**
     * Vérifie si une entrée Iste_prospectxexport existe.
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
     * Ajoute une entrée Iste_prospectxexport.
     *
     * @param array $data
     * @param boolean $existe
     * @param boolean $rs
     *  
     * @return integer
     */
    public function ajouter($data, $existe=false, $rs=false)
    {
	    	
	    	$id=false;
	    	if($existe)$id = $this->existe($data);
	    	if(!$id){
	    		if(!isset($data['maj']))$data['maj']= new Zend_Db_Expr('NOW()');
	    		$id = $this->insert($data);
	    	}
	    	if($rs)
    			return $this->findById_processus($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_prospectxexport avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_prospectxexport.id_prospect = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_prospectxexport avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id, $nom)
    {
            $this->delete('iste_prospectxexport.id_prospect = ' . $id)
           // ->where('iste_prospectxexport.nom = ' . $nom);
    }
    
    /**
     * Récupère toutes les entrées Iste_prospectxexport avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("n" => "iste_prospectxexport") )
                    ->joinInner(array("nid" => "iste_prospectxexport"),
                    'n.nom = nid.nom', array("recid"=>"n.nom"));
                    
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
