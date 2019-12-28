<?php
/**
 * Ce fichier contient la classe Iste_serie.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_serie extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_serie';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_serie';

	protected $_dependentTables = array(
       	"Model_DbTable_Iste_livrexserie"
       	,"Model_DbTable_Iste_coordination"
       	);    
    
    
    /**
     * Vérifie si une entrée Iste_serie existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_serie'));
		foreach($data as $k=>$v){
			if($k!="ref_racine")
				$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_serie; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_serie.
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
	    	 	$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->findById_serie($id);
	    	else
		    	return $id;
	    	} 
           
    /**
     * Recherche une entrée Iste_serie avec la clef primaire spécifiée
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
	    	$this->update($data, 'iste_serie.id_serie = ' . $id);
    		if($bGetRow)return $this->getListe($id);
    }
    
    /**
     * Recherche une entrée Iste_serie avec la clef primaire spécifiée
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
	        $n[$t] = $dbT->delete('id_serie ='.$id);
        }
        //vérifie si des contrats sont associés
        $dbAC = new Model_DbTable_Iste_auteurxcontrat();
        $arr = $dbAC->findBySerie($id);
        if(count($arr)==0)    	
		    $n["Model_DbTable_Iste_serie"] = $this->delete('iste_serie.id_serie = ' . $id);
		else
		    $n["message"] = "La série est supprimée pour les livres.\Impossible de supprimer la série.\Des contrats lui sont liés.";
		
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
            		,array("recid"=>$this->_primary[1],"id"=>$this->_primary[1],"text"=>"CONCAT(IFNULL(titre_fr,''),' / ', IFNULL(titre_en,''),' / ', IFNULL(titre_es,''))","titre_fr", "titre_en", "titre_es"))
            ->order(array("titre_fr","titre_en","titre_es"));        
        if($id)$query->where( "l.id_serie = ?", $id);        
        return $this->fetchAll($query)->toArray();
	} 
    /**
     * Récupère toutes les entrées Iste_serie avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_serie" => "iste_serie") );
                    
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
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_serie
     *
     * @return array
     */
    public function findById_serie($id_serie)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_serie")
                    ,array("recid"=>$this->_primary[1],"id"=>$this->_primary[1],"text"=>"CONCAT(IFNULL(titre_fr,' '),' / ',IFNULL(titre_en,' '),' / ',IFNULL(titre_es,' '))","titre_fr", "titre_en", "titre_es"))                           
                    ->where( "i.id_serie = ?", $id_serie );

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
		$sql = "INSERT INTO iste_serie (titre_fr, titre_en, titre_es) 
				SELECT CONCAT('copie ',titre_fr), CONCAT('copy ',titre_en), CONCAT('copy ',titre_es) FROM iste_serie WHERE id_serie = ".$id; 	 
	    $this->_db->query($sql);
		$newId = $this->_db->lastInsertId();
	    $dt = $this->getDependentTables();
	    foreach($dt as $t){
	        	$dbT = new $t($this->_db);
			$dbT->copierSerie($newId, $id);
        }
        return $this->findById_serie($newId);
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
		$sql = "INSERT INTO iste_serie (titre_fr, titre_en, titre_es) 
				SELECT CONCAT('fusion : ',GROUP_CONCAT(DISTINCT titre_fr ORDER BY titre_fr DESC SEPARATOR ' - '))
					, CONCAT('fusion : ',GROUP_CONCAT(DISTINCT titre_en ORDER BY titre_en DESC SEPARATOR ' - ')) 
					, CONCAT('fusion : ',GROUP_CONCAT(DISTINCT titre_es ORDER BY titre_es DESC SEPARATOR ' - ')) 
				FROM iste_serie WHERE id_serie IN (".implode(",", $ids).")"; 	 
	    $this->_db->query($sql);
		$newId = $this->_db->lastInsertId();
	    $dt = $this->getDependentTables();
	    foreach($dt as $t){
	        	$dbT = new $t($this->_db);
	        	foreach ($ids as $id) {
				$dbT->copierSerie($newId, $id);
	        	}
        }
        return $this->findById_serie($newId);
    }    
    
    	/**
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_fr
     *
     * @return array
     */
    public function findByTitre_fr($titre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_serie") )                           
                    ->where( "i.titre_fr = ?", $titre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_en
     *
     * @return array
     */
    public function findByTitre_en($titre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_serie") )                           
                    ->where( "i.titre_en = ?", $titre_en );

        return $this->fetchAll($query)->toArray(); 
    }

	/**
     * Recherche une entrée Iste_serie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id
     *
     * @return array
     */
    public function findUser($id)
    {
        $query = $this->select()
			->from( array("c" => "iste_coordination"), array("id_coordination","recid"=>"id_coordination") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = c.id_auteur', array("nom"=>"CONCAT(prenom, ' ', nom)"))
			->where( "c.id_serie = ?", $id);
            
        return $this->fetchAll($query)->toArray(); 
        
    }   

	/**
     * Récupère les détails d'une série
     *
     * @param int $id
     *
     * @return array
     */
    public function getDetails($id)
    {
    		//création de la copie
		$sql = "SELECT s.id_serie, s.titre_fr serie_titre_fr, s.titre_en serie_titre_en, s.titre_es serie_titre_es
		, GROUP_CONCAT(DISTINCT IFNULL(ac.prenom,'') , ' ', IFNULL(ac.nom,'') SEPARATOR ', ') coordinateur
		, l.titre_en, l.titre_fr, l.titre_es
		, GROUP_CONCAT(DISTINCT IFNULL(a.prenom,'') , ' ', IFNULL(a.nom,'') SEPARATOR ', ') auteurs
		, pp.fin pFin, pp.prevision pPrev, pp.commentaire pCom
		, pc.fin cFin, pc.prevision cPrev, pc.commentaire cCom
		, pm.fin mFin, pm.prevision mPrev, pm.commentaire mCom
		, p.commentaire
		FROM iste_serie s
			INNER JOIN iste_coordination c ON c.id_serie = s.id_serie
			INNER JOIN iste_auteur ac ON ac.id_auteur = c.id_auteur
			INNER JOIN iste_livrexserie ls ON ls.id_serie = s.id_serie
			INNER JOIN iste_livre l ON l.id_livre = ls.id_livre
			INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
			INNER JOIN iste_livrexauteur la ON la.id_livre = ls.id_livre AND la.role = 'auteur'
		    INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
		    INNER JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre AND pl.id_processus = 3
		    INNER JOIN iste_prevision pp ON pp.id_pxu = pl.id_plu AND pp.id_tache = 25
		    INNER JOIN iste_prevision pc ON pc.id_pxu = pl.id_plu AND pc.id_tache = 37
		    INNER JOIN iste_prevision pm ON pm.id_pxu = pl.id_plu AND pm.id_tache = 15
		WHERE s.id_serie = ".$id."
		GROUP BY l.id_livre
		ORDER BY s.id_serie"; 	 
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }    
    
    
}
