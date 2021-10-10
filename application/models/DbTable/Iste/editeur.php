<?php
/**
 * Ce fichier contient la classe Iste_editeur.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_editeur extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_editeur';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_editeur';
    
    /**
     * Vérifie si une entrée Iste_editeur existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_editeur'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_editeur; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_editeur.
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
	    	}else return "existe";
	    	if($rs)
			return $this->findById_editeur($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_editeur avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_editeur.id_editeur = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_editeur avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_editeur.id_editeur = ' . $id);
    }

    /**
     * Renvoie la liste des entrée
     *
     * @return void
     */
    public function getListe()
    {
    		$query = $this->select()
            ->from( array("l" => $this->_name)
            		,array("id"=>$this->_primary[1],"text"=>"nom"))
            ->order("nom");        
        return $this->fetchAll($query)->toArray();
	} 
	
    /**
     * Récupère toutes les entrées Iste_editeur avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_editeur" => "iste_editeur") );
                    
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
     * Recherche une entrée Iste_editeur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_editeur
     *
     * @return array
     */
    public function findById_editeur($id_editeur)
    {
        $query = $this->select()
			->from( array("e" => "iste_editeur") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("eid" => "iste_editeur"),
                'e.id_editeur = eid.id_editeur', array("recid"=>"id_editeur"))
            ->where( "e.id_editeur = ?", $id_proposition );
			
        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_editeur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nom
     *
     * @return array
     */
    public function findByNom($nom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_editeur") )                           
                    ->where( "i.nom = ?", $nom );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
