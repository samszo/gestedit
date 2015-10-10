<?php
/**
 * Ce fichier contient la classe Iste_aram.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_param extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_param';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_param';
    
    /**
     * Vérifie si une entrée Iste_param existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_param'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_param; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_param.
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
			return $this->findById_param($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_param avec la clef primaire spécifiée
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
    		$this->update($data, 'iste_param.id_param = ' . $id);
    	    	if($bGetRow)return $this->getListe($id);
    }
    
    /**
     * Recherche une entrée Iste_param avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_param.id_param = ' . $id);
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
            		,array("id"=>"nom","recid"=>$this->_primary[1],"text"=>"nom","type"))
            ->order(array("type","nom"));        
        if($id)$query->where( "l.id_param = ?", $id);        
        return $this->fetchAll($query)->toArray();
	} 
    /**
     * Récupère toutes les entrées Iste_param avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_param" => "iste_param") );
                    
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
     * Recherche une entrée Iste_param avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_param
     *
     * @return array
     */
    public function findById_param($id_param)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_param"),array("id_param","recid"=>"id_param","type","nom","text"=>"nom"))                           
                    ->where( "i.id_param = ?", $id_param );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
