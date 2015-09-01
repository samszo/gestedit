<?php
/**
 * Ce fichier contient la classe Iste_tache.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_tache extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_tache';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_tache';
    
    /**
     * Vérifie si une entrée Iste_tache existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_tache'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_tache; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_tache.
     *
     * @param array $data
     * @param boolean $existe
     * @param boolean $rs
     *  
     * @return integer
     */
    public function ajouter($data, $existe=true, $rs=true)
    {
    	
	    	$id=false;
	    	if($existe)$id = $this->existe($data);
	    	if(!$id){
		    	if(!isset($data['ordre']))$data['ordre']= $this->getNextOrdre($data['id_processus']);
	    		$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->getListe($id);
	    	else
		    	return $id;
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
            		,array("recid"=>$this->_primary[1],"id"=>$this->_primary[1],"text"=>"nom","id_processus","nom","ordre"))
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("p" => "iste_processus"),
                'p.id_processus = l.id_processus', array("processus"=>"nom"))            		
            ->order(array("p.nom","l.ordre"));
        if($id)$query->where( "l.id_tache = ?", $id);        
        return $this->fetchAll($query)->toArray();
	}     
    
    /**
     * Recherche une entrée Iste_tache avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {           	
    		$this->update($data, 'iste_tache.id_tache = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_tache avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		//suprime toute les prévisions avec cette tache
    		$dbPrev = new Model_DbTable_Iste_prevision();
    		$dbPrev->removeTache($id);
	    	$this->delete('iste_tache.id_tache = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_tache avec la clef de lieu
     * et supprime ces entrées.
     *
     * @param integer $idLieu
     *
     * @return void
     */
    public function removeLieu($idLieu)
    {
		$this->delete('id_lieu = ' . $idLieu);
    }
    
    /**
     * Récupère toutes les entrées Iste_tache avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_tache" => "iste_tache") );
                    
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
     * Recherche une entrée Iste_tache avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_tache
     *
     * @return array
     */
    public function findById_tache($id_tache)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_tache") )                           
                    ->where( "i.id_tache = ?", $id_tache );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_tache avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_processus
     *
     * @return array
     */
    public function findById_processus($id_processus)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_tache") )                           
                    ->where( "i.id_processus = ?", $id_processus );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_tache avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nom
     *
     * @return array
     */
    public function findByNom($nom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_tache") )                           
                    ->where( "i.nom = ?", $nom );

        return $this->fetchAll($query)->toArray(); 
    }
	/**
     * Recherche le dernier numéro d'ordre
     * et retourne cette entrée.
     *
     * @param int $idProcessus
     *
     * @return int
     */
    public function getNextOrdre($idProcessus)
    {
		$sql = "SELECT MAX(ordre)+1 o 
			FROM iste_tache
			WHERE id_processus = ".$idProcessus;
	 	//echo $sql."<br/>";
	    $db = $this->_db->query($sql);
	    $rs = $db->fetchAll();
		if(count($rs)) return $rs[0]["o"];
		else return 1;
    }    
    
}
