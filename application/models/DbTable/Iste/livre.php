<?php
/**
 * Ce fichier contient la classe Iste_livre.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_livre extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_livre';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_livre';
    
protected $_dependentTables = array(
       "Model_DbTable_Iste_livrexauteur"
       ,"Model_DbTable_Iste_livrexcollection"
       ,"Model_DbTable_Iste_livrexprevision"
       ,"Model_DbTable_Iste_livrexserie"
       ,"Model_DbTable_Iste_comitexlivre"
       );    
    
    /**
     * Vérifie si une entrée Iste_livre existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_livre'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_livre; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_livre.
     *
     * @param array $data
     * @param boolean $existe
     * @param boolean $rs
     *  
     * @return integer
     */
    public function ajouter($data, $existe=true, $rs)
    {    	
	    	$id=false;
	    	if($existe)$id = $this->existe($data);
	    	if(!$id){
	    	 	$id = $this->insert($data);
	    	};
	    	if($rs)
			return $this->findById_livre($id);
	    	else
		    	return $id;
	    	} 
           
    /**
     * Recherche une entrée Iste_livre avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {           	
    		$this->update($data, 'iste_livre.id_livre = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_livre avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
        $dt = $this->getDependentTables();
        foreach($dt as $t){
	        	$dbT = new $t($this->_db);
		    	$dbT->delete('id_livre ='.$id);
        }
	    	$this->delete('iste_livre.id_livre = ' . $id);
    }
    
    /**
     * Récupère toutes les entrées Iste_livre avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
	    	$query = $this->select()
			->from( array("l" => "iste_livre") )
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("lid" => "iste_livre"),
                'l.id_livre = lid.id_livre', array("recid"=>"id_livre"));
			
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
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_livre
     *
     * @return array
     */
    public function findById_livre($id_livre)
    {
        $query = $this->select()
            ->from( array("l" => "iste_livre") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("lid" => "iste_livre"),
                'l.id_livre = lid.id_livre', array("recid"=>"id_livre"))
            ->where( "l.id_livre = ?", $id_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $reference
     *
     * @return array
     */
    public function findByReference($reference)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.reference = ?", $reference );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_fr
     *
     * @return array
     */
    public function findByTitre_fr($titre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.titre_fr = ?", $titre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_en
     *
     * @return array
     */
    public function findByTitre_en($titre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.titre_en = ?", $titre_en );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $num_vol
     *
     * @return array
     */
    public function findByNum_vol($num_vol)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.num_vol = ?", $num_vol );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $type_1
     *
     * @return array
     */
    public function findByType_1($type_1)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.type_1 = ?", $type_1 );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $type_2
     *
     * @return array
     */
    public function findByType_2($type_2)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.type_2 = ?", $type_2 );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $soustitre_fr
     *
     * @return array
     */
    public function findBySoustitre_fr($soustitre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.soustitre_fr = ?", $soustitre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $soustitre_en
     *
     * @return array
     */
    public function findBySoustitre_en($soustitre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.soustitre_en = ?", $soustitre_en );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * récupère les livres à traduire
     *
     * @return array
     */
    public function getTraductionLivre()
    {
 	$sql = "SELECT 
			i.id_isbn recid, i.date_parution, i.num isbn, i.nb_page 
			, GROUP_CONCAT(DISTINCT CONCAT(a.prenom, ' ', a.nom)) auteurs
			, l.titre_en, l.soustitre_en, l.type_2, l.id_livre
		    , CONCAT(p.langue, ' -> ', p.traduction) traduction
		    , GROUP_CONCAT(DISTINCT e.nom) editeur
		FROM iste_livre l
			INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
			INNER JOIN iste_proposition p ON p.id_livre = l.id_livre     
			INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.role = 'auteur'
			INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur 
			INNER JOIN iste_editeur e ON e.id_editeur = i.id_editeur 
		GROUP BY i.id_livre";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }
    
}