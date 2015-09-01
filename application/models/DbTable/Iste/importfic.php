<?php
/**
 * Ce fichier contient la classe Iste_importfic.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_importfic extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_importfic';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_importfic';
    
    /**
     * Vérifie si une entrée Iste_importfic existe.
     *
     * @param array 	$data
     * @param bool 	$rs
     *
     * @return integer
     */
    public function existe($data, $rs=false)
    {
		$select = $this->select();
		$select->from($this, array('id_importfic'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0){
	    		if($rs) return $this->findById_importfic($rows[0]->id_importfic);
	    		else $id=$rows[0]->id_importfic; 
	    }else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_importfic.
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
	    		if(!isset($data['reception']))$data['reception']= new Zend_Db_Expr('NOW()');
	    		$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->findById_importfic($id);
	    	else
		    	return $id;
    } 

    	/**
     * Recherche une entrée avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id
     *
     * @return array
     */
    public function findById_importfic($id)
    {
        $query = $this->select()
            ->from( array("i" => "iste_importfic") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinLeft(array("id" => "iste_importdata"),
                'id.id_importfic = i.id_importfic', array("nbLigne"=>"COUNT(DISTINCT id.id_importdata)"))
            ->joinLeft(array("v" => "iste_vente"),
                'id.id_importdata = v.id_importdata', array("nbVente"=>"COUNT(DISTINCT id_vente)"))
            ->group(array("i.id_importfic"))
            ->where( "i.id_importfic = ?", $id);
		$rs = $this->fetchAll($query)->toArray();
        if(count($rs))return $rs[0];
        else return false; 
    }           

    	/**
     * Recherche une entrée avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param string $type
     *
     * @return array
     */
    public function findByType($type)
    {
        $query = $this->select()
            ->from( array("i" => "iste_importfic") )                           
            ->where( "i.type = ?", $type);
		$rs = $this->fetchAll($query)->toArray();
        if(count($rs))return $rs[0];
        else return false; 
    }           
    
    /**
     * Recherche une entrée avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $url
     * @param varchar $order
     *
     * @return array
     */
    public function findByUrl($url, $order=null)
    {
        $query = $this->select()
            ->from( array("i" => "iste_importfic") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinLeft(array("id" => "iste_importdata"),
                'id.id_importfic = i.id_importfic', array("nbLigne"=>"COUNT(DISTINCT id.id_importdata)"))
            ->joinLeft(array("v" => "iste_vente"),
                'id.id_importdata = v.id_importdata', array("nbVente"=>"COUNT(DISTINCT id_vente)"))
            ->group(array("i.id_importfic"))
			->where( "i.url = ?", $url);
            
        if($order != null)
        {
            $query->order($order);
        }
            
		$rs = $this->fetchAll($query)->toArray();
        if(count($rs))return $rs[0];
        else return false; 
    }           
    
    /**
     * Recherche une entrée Iste_importfic avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_importfic.id_importfic = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_importfic avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		//supprime les data liées
    		$dbData = new Model_DbTable_Iste_importdata();
    		$dbData->removeIdFic($id);
    		$this->delete('iste_importfic.id_importfic = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_importfic avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param varchar $url
     *
     * @return void
     */
    public function removeByUrl($url)
    {
    		echo $this->delete('iste_importfic.url LIKE "'.$id.'"');
    }
    
    /**
     * Récupère toutes les entrées Iste_importfic avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_importfic" => "iste_importfic") );
                    
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
