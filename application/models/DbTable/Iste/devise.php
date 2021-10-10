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
     * @param boolean $rs
     *  
     * @return integer
     */
    public function ajouter($data, $existe=true, $rs=false)
    {
    	
	    	$id=false;
    		if(isset($data["annee"])){
    			if ($data["base_contrat"]=="FR"){
    				$data["date_taux"]=$data["annee"]."/01/01";
    				$data["date_taux_fin"]=(intval($data["annee"])+1)."/12/31";
    			}else{
    				$data["date_taux"]=$data["annee"]."/01/01";
    				$data["date_taux_fin"]=(intval($data["annee"])+1)."/12/30";	    				
    			}
	    		unset($data['annee']);	    			
    		}
	    	
	    	if($existe)$id = $this->existe($data);
	    	if(!$id){
	    	 	$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->findById_devise($id);
	    	else
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
            ->from( array("iste_devise" => "iste_devise"),array('recid'=>'id_devise','id_devise'
                    ,'annee'=>"DATE_FORMAT(date_taux,'%Y')",'date_taux','date_taux_fin','base_contrat'
                    ,'taxe_taux', 'taxe_deduction'
                    ,'taux_euro_livre','taux_livre_euro','taux_dollar_livre','taux_livre_dollar','taux_euro_dollar','taux_dollar_euro') );
                    
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
                    ->from( array("i" => "iste_devise")
                        ,array('recid'=>'id_devise','id_devise','base_contrat','taxe_taux','taxe_deduction'
                        ,'annee'=>'DATE_FORMAT(date_taux, "%Y")','date_taux','date_taux_fin'
                        ,'taux_euro_livre','taux_livre_euro','taux_dollar_livre','taux_livre_dollar','taux_euro_dollar','taux_dollar_euro') )                           
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
     * @param integer $annee
     *
     * @return array
     */
    public function findByAnnee($annee)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_devise") )                           
                    ->where( "YEAR(i.date_taux) = ?", $annee);

        return $this->fetchAll($query)->toArray()[0]; 
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
     * 
     * @param integer $idFic
     * 
     * @return array
     * 
     */
    public function getDateSansDevise($idFic="")
    {
        $query = $this->select()
            ->from( array("v" => "iste_vente"),array("dv"=>"DATE_FORMAT(date_vente, '%Y-%m-%d')"))
            ->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("i" => "iste_isbn"),"i.id_isbn = v.id_isbn")        		
            ->joinInner(array("p" => "iste_proposition"),"p.id_livre = i.id_livre")        		
            ->joinLeft(array("d" => "iste_devise"),"d.base_contrat = p.base_contrat AND date_vente BETWEEN date_taux AND date_taux_fin")        		
            ->where("date_taux is null")
            ->group(array("date_vente"));
        
        if($idFic){
            $query->joinInner(array("id" => "iste_importdata"),"id.id_importfic = ".$idFic." AND id.id_importdata = v.id_importdata"); 
        }
                    
        return $this->fetchAll($query)->toArray();
    }    

	/**
     * Met à jour les montants vides
     */
    public function setMontantSansDevise()
    {
	    	$sql = "update iste_vente v
		 INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		 INNER JOIN iste_proposition p ON p.id_livre = i.id_livre
	    	 INNER JOIN iste_devise d on
		    d.base_contrat = p.base_contrat AND date_vente BETWEEN date_taux AND date_taux_fin
		set
		    v.id_devise = d.id_devise
		    , v.montant_euro = d.taux_dollar_euro * v.montant_dollar 
		    , v.montant_livre = d.taux_dollar_livre * v.montant_dollar 
		where (v.montant_euro is null OR v.montant_euro=0) AND (v.montant_livre is null OR v.montant_livre = 0)";
    		$stmt = $this->_db->query($sql);

	    	$sql = "update iste_vente v
		 INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		 INNER JOIN iste_proposition p ON p.id_livre = i.id_livre
	     INNER JOIN iste_devise d on
		    d.base_contrat = p.base_contrat AND date_vente BETWEEN date_taux AND date_taux_fin
	    	set
	    	    v.id_devise = d.id_devise
		    , v.montant_dollar = d.taux_euro_dollar * v.montant_euro 
		    , v.montant_livre = d.taux_euro_livre * v.montant_euro 
		where (v.montant_dollar is null OR v.montant_dollar=0) AND (v.montant_livre is null OR v.montant_livre = 0)";
    		$stmt = $this->_db->query($sql);
    		
	    	$sql = "update iste_vente v
		 INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		 INNER JOIN iste_proposition p ON p.id_livre = i.id_livre
	     INNER JOIN iste_devise d on
		    d.base_contrat = p.base_contrat AND date_vente BETWEEN date_taux AND date_taux_fin
	    	set
	    	    v.id_devise = d.id_devise
		    , v.montant_dollar = d.taux_livre_dollar * v.montant_livre 
		    , v.montant_euro = d.taux_livre_euro * v.montant_livre 
		where (v.montant_euro is null OR v.montant_euro=0) AND (v.montant_dollar is null OR v.montant_dollar = 0)";
		$stmt = $this->_db->query($sql);
    		
    		$sql = "update iste_royalty r
		INNER JOIN iste_vente v on r.id_vente = v.id_vente
    	INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		INNER JOIN iste_proposition p ON p.id_livre = i.id_livre
	    	INNER JOIN iste_devise d on
		    d.base_contrat = p.base_contrat AND date_vente BETWEEN date_taux AND date_taux_fin
		set
		    r.id_devise = d.id_devise
		    , r.montant_euro = d.taux_dollar_euro * r.montant_dollar 
		    , r.montant_livre = d.taux_dollar_livre * r.montant_dollar 
		where (r.montant_euro is null OR r.montant_euro=0) AND (r.montant_livre is null OR r.montant_livre = 0)";
    		$stmt = $this->_db->query($sql);

    		$sql = "update iste_royalty r
		INNER JOIN iste_vente v on r.id_vente = v.id_vente
    	INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		INNER JOIN iste_proposition p ON p.id_livre = i.id_livre
	    	INNER JOIN iste_devise d on
		    d.base_contrat = p.base_contrat AND date_vente BETWEEN date_taux AND date_taux_fin
    		set
    		    r.id_devise = d.id_devise
		    , r.montant_dollar = d.taux_euro_dollar * r.montant_euro 
		    , r.montant_livre = d.taux_euro_livre * r.montant_euro 
		where (r.montant_dollar is null OR r.montant_dollar=0) AND (r.montant_livre is null OR r.montant_livre = 0)";
  		$stmt = $this->_db->query($sql);
    		
    		$sql = "update iste_royalty r
		INNER JOIN iste_vente v on r.id_vente = v.id_vente
    		INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		INNER JOIN iste_proposition p ON p.id_livre = i.id_livre
	    	INNER JOIN iste_devise d on
		    d.base_contrat = p.base_contrat AND date_vente BETWEEN date_taux AND date_taux_fin
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
            , COUNT(d.id_devise) nb, d.base_contrat
            FROM iste_devise d 
            WHERE d.date_taux <= '".$deb."' AND d.date_taux_fin >= '".$fin."'
            GROUP BY d.base_contrat";
		//echo $sql;
        $stmt = $this->_db->query($sql);
        $rs = $stmt->fetchAll();
        return $rs; 
    		
    }         


}

