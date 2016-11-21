<?php
/**
 * Ce fichier contient la classe Iste_chapitre.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_comite extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_comite';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_comite';
    
	protected $_dependentTables = array(
       	"Model_DbTable_Iste_comitexauteur"
       	,"Model_DbTable_Iste_comitexlivre"
       	);    
    
    /**
     * Vérifie si une entrée Iste_comite existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_comite'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_comite; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_comite.
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
			return $this->findById_comite($id);
	    	else
		    	return $id;    
    } 
           
    /**
     * Recherche une entrée Iste_comite avec la clef primaire spécifiée
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
    		$this->update($data, 'iste_comite.id_comite = ' . $id);
    	    	if($bGetRow)return $this->getListe($id);
    }
    
    /**
     * Recherche une entrée Iste_comite avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
		$n = array();
    		$dt = $this->getDependentTables();
        foreach($dt as $t){
	        	$dbT = new $t($this->_db);
	        $n[$t] = $dbT->delete('id_comite ='.$id);
        }
		$n["Model_DbTable_Iste_comite"] = $this->delete('iste_comite.id_comite = ' . $id);
		return $n;    	
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
            		,array("recid"=>$this->_primary[1],"id"=>$this->_primary[1],"text"=>"CONCAT(titre_fr, ' / ', titre_en)","titre_fr", "titre_en"))
            ->order(array("titre_fr","titre_en"));        
        if($id)$query->where( "l.id_comite = ?", $id);        
        return $this->fetchAll($query)->toArray();
	} 
	
	/**
     * Copier une entrée de la table
     *
     * @param int $id
     *
     * @return array
     */
    public function copier($id)
    {
    		//création de la copie
		$sql = "INSERT INTO iste_comite (titre_fr, titre_en) 
				SELECT CONCAT('copie ',titre_fr), CONCAT('copy ',titre_en) FROM iste_comite WHERE id_comite = ".$id; 	 
	    $this->_db->query($sql);
		$newId = $this->_db->lastInsertId();
	    $dt = $this->getDependentTables();
	    foreach($dt as $t){
	        	$dbT = new $t($this->_db);
			$dbT->copierComite($newId, $id);
        }
        return $this->findById_comite($newId);
    }    
	
	/**
     * Fusionner une entrée de la table
     *
     * @param string $ids
     *
     * @return array
     */
    public function fusion($ids)
    {
    		//création de la copie
		$sql = "INSERT INTO iste_comite (titre_fr, titre_en) 
				SELECT CONCAT('fusion : ',GROUP_CONCAT(DISTINCT titre_fr ORDER BY titre_fr DESC SEPARATOR ' - '))
					, CONCAT('fusion : ',GROUP_CONCAT(DISTINCT titre_en ORDER BY titre_en DESC SEPARATOR ' - ')) 
				FROM iste_comite WHERE id_comite IN (".implode(",", $ids).")"; 	 
	    $this->_db->query($sql);
		$newId = $this->_db->lastInsertId();
	    $dt = $this->getDependentTables();
	    foreach($dt as $t){
	        	$dbT = new $t($this->_db);
	        	foreach ($ids as $id) {
				$dbT->copierComite($newId, $id);
	        	}
        }
        return $this->findById_comite($newId);
    }    
    
    /**
     * Récupère toutes les entrées Iste_comite avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_comite" => "iste_comite") );
                    
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
     * Recherche une entrée Iste_comite avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_comite
     *
     * @return array
     */
    public function findById_comite($id_comite)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_comite")
                    ,array("recid"=>$this->_primary[1],"id"=>$this->_primary[1],"text"=>"CONCAT(titre_fr,' / ', titre_en)","titre_fr", "titre_en") )                           
                    ->where( "i.id_comite = ?", $id_comite );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_comite avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_fr
     *
     * @return array
     */
    public function findByTitre_fr($titre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_comite") )                           
                    ->where( "i.titre_fr = ?", $titre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_comite avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_en
     *
     * @return array
     */
    public function findByTitre_en($titre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_comite") )                           
                    ->where( "i.titre_en = ?", $titre_en );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_comite avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $soustitre_fr
     *
     * @return array
     */
    public function findBySoustitre_fr($soustitre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_comite") )                           
                    ->where( "i.soustitre_fr = ?", $soustitre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_comite avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $soustitre_en
     *
     * @return array
     */
    public function findBySoustitre_en($soustitre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_comite") )                           
                    ->where( "i.soustitre_en = ?", $soustitre_en );

        return $this->fetchAll($query)->toArray(); 
    }
    
    	/**
     * Recherche une entrée Iste_comite avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id
     *
     * @return array
     */
    public function findUser($id)
    {
        $query = $this->select()
			->from( array("ca" => "iste_comitexauteur"), array("recid"=>"CONCAT(ca.id_comite, '_', ca.id_auteur)")  )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = ca.id_auteur', array("nom"=>"CONCAT(prenom, ' ', nom)"))
			->where( "ca.id_comite = ?", $id);
            
        return $this->fetchAll($query)->toArray(); 
    }
    
}
