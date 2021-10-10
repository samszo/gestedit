<?php
/**
 * Ce fichier contient la classe Iste_processusxchapitre.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_processusxchapitre extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_processusxchapitre';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_pcu';
    
    /**
     * Vérifie si une entrée Iste_processusxchapitre existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_pcu'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_pcu; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_processusxchapitre.
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
     * Recherche une entrée Iste_processusxchapitre avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_processusxchapitre.id_pcu = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_processusxchapitre avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		$this->delete('iste_processusxchapitre.id_pcu = ' . $id);
    }
    
    /**
     * Récupère toutes les entrées Iste_processusxchapitre avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_processusxchapitre" => "iste_processusxchapitre") );
                    
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
     * Recherche une entrée Iste_processusxchapitre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_processus
     *
     * @return array
     */
    public function findById_processus($id_processus)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_processusxchapitre") )                           
                    ->where( "i.id_processus = ?", $id_processus );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_processusxchapitre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_chapitre
     *
     * @return array
     */
    public function findById_chapitre($id_chapitre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_processusxchapitre") )                           
                    ->where( "i.id_chapitre = ?", $id_chapitre );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
