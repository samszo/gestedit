<?php
/**
 * Ce fichier contient la classe Iste_devise.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_devise extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_devise';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_devise';
    
    /**
     * Vérifie si une entrée Iste_devise existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_devise'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_devise; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_devise.
     *
     * @param array $data
     * @param boolean $existe
     *  
     * @return integer
     */
    public function ajouter($data, $existe=true)
    {
    	
    	$id=false;
    	if($existe)$id = $this->existe($data);
    	if(!$id){
    	 	$id = $this->insert($data);
    	}
    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_devise avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_devise.id_devise = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_devise avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_devise.id_devise = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_devise avec la clef de lieu
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
     * Récupère toutes les entrées Iste_devise avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_devise" => "iste_devise") );
                    
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
     * Recherche une entrée Iste_devise avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_devise
     *
     * @return array
     */
    public function findById_devise($id_devise)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devise") )                           
                    ->where( "i.id_devise = ?", $id_devise );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_devise avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $date_taux
     *
     * @return array
     */
    public function findByDate_taux($date_taux)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devise") )                           
                    ->where( "i.date_taux = ?", $date_taux );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_devise avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $taux_euro_livre
     *
     * @return array
     */
    public function findByTaux_euro_livre($taux_euro_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devise") )                           
                    ->where( "i.taux_euro_livre = ?", $taux_euro_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_devise avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $taux_livre_euro
     *
     * @return array
     */
    public function findByTaux_livre_euro($taux_livre_euro)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devise") )                           
                    ->where( "i.taux_livre_euro = ?", $taux_livre_euro );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_devise avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $taux_dollar_livre
     *
     * @return array
     */
    public function findByTaux_dollar_livre($taux_dollar_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devise") )                           
                    ->where( "i.taux_dollar_livre = ?", $taux_dollar_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_devise avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $taux_livre_dollar
     *
     * @return array
     */
    public function findByTaux_livre_dollar($taux_livre_dollar)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devise") )                           
                    ->where( "i.taux_livre_dollar = ?", $taux_livre_dollar );

        return $this->fetchAll($query)->toArray(); 
    }
    
	/**
     * Récupère les dates de vente sans devise
     */
    public function getDateSansDevise()
    {
	    	$query = $this->select()
        		->from( array("v" => "iste_vente"),array("dv"=>"DATE_FORMAT(date_vente, '%Y-%m-%d')"))
        		->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
        		->joinLeft(array("d" => "iste_devise"),"DATE_FORMAT(date_taux, '%Y-%m-%d') = DATE_FORMAT(date_vente, '%Y-%m-%d')")        		
        		->where("date_taux is null")
        		->group(array("date_vente"));
                    
        return $this->fetchAll($query)->toArray();
    }    

	/**
     * Met à jour les montants vides
     */
    public function setMontantSansDevise()
    {
	    	$sql = "update iste_vente v
		inner join iste_devise d on
		    DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
		set
		    v.id_devise = d.id_devise
		    , v.montant_euro = d.taux_dollar_euro * v.montant_dollar 
		    , v.montant_livre = d.taux_dollar_livre * v.montant_dollar 
		where (v.montant_euro is null OR v.montant_euro=0) AND (v.montant_livre is null OR v.montant_livre = 0)";
    		$stmt = $this->_db->query($sql);

	    	$sql = "update iste_vente v
		inner join iste_devise d on
		    DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
		set
		    v.id_devise = d.id_devise
		    , v.montant_dollar = d.taux_euro_dollar * v.montant_euro 
		    , v.montant_livre = d.taux_euro_livre * v.montant_euro 
		where (v.montant_dollar is null OR v.montant_dollar=0) AND (v.montant_livre is null OR v.montant_livre = 0)";
    		$stmt = $this->_db->query($sql);
    		
	    	$sql = "update iste_vente v
		inner join iste_devise d on
		    DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
		set
		    v.id_devise = d.id_devise
		    , v.montant_dollar = d.taux_livre_dollar * v.montant_livre 
		    , v.montant_euro = d.taux_livre_euro * v.montant_livre 
		where (v.montant_euro is null OR v.montant_euro=0) AND (v.montant_dollar is null OR v.montant_dollar = 0)";
		$stmt = $this->_db->query($sql);
    		
    		$sql = "update iste_royalty r
		inner join iste_vente v on
		    r.id_vente = v.id_vente
		inner join iste_devise d on
		    DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
		set
		    r.id_devise = d.id_devise
		    , r.montant_euro = d.taux_dollar_euro * r.montant_dollar 
		    , r.montant_livre = d.taux_dollar_livre * r.montant_dollar 
		where (r.montant_euro is null OR r.montant_euro=0) AND (r.montant_livre is null OR r.montant_livre = 0)";
    		$stmt = $this->_db->query($sql);

    		$sql = "update iste_royalty r
		inner join iste_vente v on
		    r.id_vente = v.id_vente
		inner join iste_devise d on
		    DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
		set
		    r.id_devise = d.id_devise
		    , r.montant_dollar = d.taux_euro_dollar * r.montant_euro 
		    , r.montant_livre = d.taux_euro_livre * r.montant_euro 
		where (r.montant_dollar is null OR r.montant_dollar=0) AND (r.montant_livre is null OR r.montant_livre = 0)";
  		$stmt = $this->_db->query($sql);
    		
    		$sql = "update iste_royalty r
		inner join iste_vente v on
		    r.id_vente = v.id_vente
		inner join iste_devise d on
		    DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
		set
		    r.id_devise = d.id_devise
		    , r.montant_euro = d.taux_livre_euro * r.montant_livre 
		    , r.montant_dollar = d.taux_livre_dollar * r.montant_livre 
		where (r.montant_euro is null OR r.montant_euro=0) AND (r.montant_dollar is null OR r.montant_dollar = 0)";
		$stmt = $this->_db->query($sql);
    }    
    
    
	/**
     * Récupère le taux de devise pour une période
     *
     * @param date		$deb
     * @param date		$fin
     * 
     * @return array
     */
    function getTauxPeriode($deb, $fin){
    		
    		//récupère les royalty pour les livres sélectionnés
	    	$sql = "SELECT 
		    SUM(d.taux_livre_euro) tle, SUM(d.taux_livre_dollar) tld, SUM(taux_euro_livre) tel
		    , SUM(d.taux_dollar_livre) tdl, SUM(d.taux_euro_dollar) ted, SUM(taux_dollar_euro) tde 
	    	    , COUNT(d.id_devise) nb
		FROM iste_devise d 
		WHERE d.date_taux BETWEEN '".$deb."' AND '".$fin."'";
		//echo $sql;
    		$stmt = $this->_db->query($sql);
    		$rs = $stmt->fetchAll();
    		return $rs[0]; 
    		
    }        
    
}

