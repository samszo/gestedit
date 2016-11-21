<?php
/**
 * Ce fichier contient la classe Iste_web.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_web extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_web';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_web';
    
    /**
     * Vérifie si une entrée Iste_web existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_web'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_web; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_web.
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
			return $this->findByIdPage($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_web avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {          	
	    	$this->update($data, 'iste_web.id_web = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_web avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		return $this->delete('iste_web.id_web = ' . $id);
    }
    
    /**
     * Récupère toutes les entrées Iste_web avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    		$query = $this->select()
    			->from( array("iste_web" => "iste_web"),array("recid"=>"id_web","id_web","maj","type","url","id_livre"));
                    
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
     * Recherche une entrée Iste_web avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idPage
     *
     * @return array
     */
    public function findByIdPage($idPage)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_web"),array("recid"=>"id_web","id_web","maj","type","url","id_livre") )                           
                    ->where( "i.id_web = ?", $idPage );

        return $this->fetchAll($query)->toArray(); 
    }

    	/**
     * Recherche une entrée Iste_web avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idLivre
     *
     * @return array
     */
    public function findById_livre($idLivre)
    {
        $query = $this->select()
			->from( array("i" => "iste_web"),array("recid"=>"id_web","id_web","maj","type","url","id_livre") )                           
            ->where( "i.id_livre = ?", $idLivre);

        return $this->fetchAll($query)->toArray(); 
    }
    
    
    
}
