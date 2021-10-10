<?php
/**
 * Ce fichier contient la classe Iste_boutique.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_boutique extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_boutique';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_boutique';
        
    /**
     * Vérifie si une entrée Iste_boutique existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_boutique'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_boutique; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_boutique.
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
	    	}
		if($rs)
			return $this->findById_boutique($id);
	    	else
		    	return $id;    
    } 
           
    /**
     * Recherche une entrée Iste_boutique avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     * @param boolean $bGetRow
     *
     * @return void
     */
    public function edit($id, $data, $bGetRow=true)
    {           	
	    	$this->update($data, 'iste_boutique.id_boutique = ' . $id);
    		if($bGetRow)return $this->getListe($id);
    }
    
    /**
     * Recherche une entrée Iste_boutique avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
		$this->delete('iste_boutique.id_boutique = ' . $id);
    }

    /**
     * Renvoie la liste des entrée
     * 
     * @param int	$id
     *
     * @return void
     */
    public function getListe($id=false)
    {
    		$query = $this->select()
            ->from( array("l" => $this->_name)
            		,array("recid"=>$this->_primary[1],"id"=>$this->_primary[1],"text"=>"nom","nom","coef"))
            ->order(array("nom"));        
        if($id)$query->where( "l.id_boutique = ?", $id);        
        return $this->fetchAll($query)->toArray();
	} 
	    
    /**
     * Récupère toutes les entrées Iste_boutique avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_boutique" => "iste_boutique") );
                    
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
     * Recherche une entrée Iste_boutique avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $id
     *
     * @return array
     */
    public function findById_boutique($id)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_boutique"),array("recid"=>"id_boutique","id_boutique","nom","coef") )                           
                    ->where( "i.id_boutique = ?", $id);

        return $this->fetchAll($query)->toArray(); 
    }
    
}
