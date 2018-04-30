<?php
/**
 * Ce fichier contient la classe Iste_vente.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_vente extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_vente';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_vente';
    
    /**
     * Vérifie si une entrée Iste_vente existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_vente'));
		foreach($data as $k=>$v){
		    if($k=="id_isbn" || $k=="id_importdata" || $k=="type" || $k=="id_importdata")
		        $select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_vente; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_vente.
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
	    	if(!isset($data['maj']))$data['maj']= new Zend_Db_Expr('NOW()');
	    	if(!$id){
	    	 	$id = $this->insert($data);
	    	}else{
	    	 	$this->edit($id, $data);	    		
	    	}
	    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_vente avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {           	
	    	if(!isset($data['maj']))$data['maj']= new Zend_Db_Expr('NOW()');
    		$this->update($data, 'iste_vente.id_vente = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_vente avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		//suprime les royalties associé à cette vente
    		$n = array();
    		$dbR = new Model_DbTable_Iste_royalty();
    		$n["Model_DbTable_Iste_royalty"] = $dbR->removeVente($id);
	    $n["Model_DbTable_Iste_vente"] = $this->delete('iste_vente.id_vente = ' . $id);
    }

    /**
     * Recherche une entrée Iste_vente avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function removeIsbn($id)
    {
    		//suprime les royalties associé à cette vente
    		$n = array();
    		$rs = $this->findById_isbn($id);
    		foreach ($rs as $r) {
    			$n["Model_DbTable_Iste_vente_".$r['id_vente']] = $this->remove($r['id_vente']);
    		}
    		return $n;
    }
    
    /**
     * Récupère toutes les entrées Iste_vente avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_vente" => "iste_vente") );
                    
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
     * Récupère les date de vente
     */
    public function getDateVente()
    {
	    	$query = $this->select()
        		->from( array("iste_vente" => "iste_vente"),array("dv"=>"DATE_FORMAT(date_vente, '%Y-%m-%d')"))
        		->group(array("date_vente"));
                    
        return $this->fetchAll($query)->toArray();
    }    
    
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_vente
     *
     * @return array
     */
    public function findById_vente($id_vente)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_vente") )                           
                    ->where( "i.id_vente = ?", $id_vente );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_isbn
     *
     * @return array
     */
    public function findById_isbn($id_isbn)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_vente") )                           
                    ->where( "i.id_isbn = ?", $id_isbn );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idLivre
     *
     * @return array
     */
    public function findById_livre($idLivre)
    {
        $query = $this->select()
			->from( array("v" => "iste_vente") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("vid" => "iste_vente"),
                'vid.id_vente = v.id_vente', array("recid"=>"id_vente"))
            ->joinInner(array("i" => "iste_isbn"),
                'v.id_isbn = i.id_isbn', array())
            ->joinInner(array("b" => "iste_boutique"),
                'b.id_boutique = v.id_boutique', array("boutique"=>"b.nom"))
            ->joinLeft(array("l" => "iste_licence"),
                'l.id_licence = v.id_licence', array("id_licence","licence"=>"CONCAT(l.nom,' ',IFNULL(licence_unitaire,''),' ',IFNULL(licence_coef,'- '),'% ',IFNULL(licence_illimite,''),' ',IFNULL(mutiplicateur,''))"))
            ->joinLeft(array("p" => "iste_prix"),
                'p.id_prix = v.id_prix', array("prix_euro","prix_livre","prix_dollar"))
			->where( "i.id_livre = ?", $idLivre);

        return $this->fetchAll($query)->toArray(); 
    }    
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idAuteur
     *
     * @return array
     */
    public function findById_auteur($idAuteur)
    {
        $query = $this->select()
			->from( array("v" => "iste_vente") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("vid" => "iste_vente"),
                'vid.id_vente = v.id_vente', array("recid"=>"id_vente"))
            ->joinInner(array("i" => "iste_isbn"),
                'v.id_isbn = i.id_isbn', array("num","type","date_parution"))
            ->joinInner(array("pro" => "iste_proposition"),
                'pro.id_livre = i.id_livre', array("base_contrat"))
            ->joinInner(array("l" => "iste_livre"),
                'l.id_livre = i.id_livre', array("livre"=>"CONCAT(IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,''))"))
            ->joinInner(array("la" => "iste_livrexauteur"),
                'la.id_livre = l.id_livre', array())
            ->joinInner(array("b" => "iste_boutique"),
                'b.id_boutique = v.id_boutique', array("boutique"=>"b.nom"))
            ->joinLeft(array("p" => "iste_prix"),
                'p.id_prix = v.id_prix', array("prix_euro","prix_livre","prix_dollar"))
            ->joinLeft(array("li" => "iste_licence"),
                'li.id_licence = v.id_licence', array("id_licence","licence"=>"CONCAT(li.nom,' ',IFNULL(licence_unitaire,''),' ',IFNULL(licence_coef,'- '),'% ',IFNULL(licence_illimite,''),' ',IFNULL(mutiplicateur,''))"))
            ->joinLeft(array("ac" => "iste_auteurxcontrat"),
                'ac.id_auteur = la.id_auteur AND ac.id_livre = la.id_livre', array("date_contrat"=>"MIN(ac.date_signature)"))
            ->where( "la.id_auteur = ?", $idAuteur)
			->group("v.id_vente");

        return $this->fetchAll($query)->toArray(); 
    }    
    /**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_devise
     *
     * @return array
     */
    public function findById_devise($id_devise)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_vente") )                           
                    ->where( "i.id_devise = ?", $id_devise );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $date_vente
     *
     * @return array
     */
    public function findByDate_vente($date_vente)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_vente") )                           
                    ->where( "i.date_vente = ?", $date_vente );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $boutique
     *
     * @return array
     */
    public function findByBoutique($boutique)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_vente") )                           
                    ->where( "i.boutique = ?", $boutique );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $nombre
     *
     * @return array
     */
    public function findByNombre($nombre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_vente") )                           
                    ->where( "i.nombre = ?", $nombre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $montant_livre
     *
     * @return array
     */
    public function findByMontant_livre($montant_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_vente") )                           
                    ->where( "i.montant_livre = ?", $montant_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $montant_euro
     *
     * @return array
     */
    public function findByMontant_euro($montant_euro)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_vente") )                           
                    ->where( "i.montant_euro = ?", $montant_euro );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $montant_dollar
     *
     * @return array
     */
    public function findByMontant_dollar($montant_dollar)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_vente") )                           
                    ->where( "i.montant_dollar = ?", $montant_dollar );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_vente avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param tinyint $avec_droit
     *
     * @return array
     */
    public function findByAvec_droit($avec_droit)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_vente") )                           
                    ->where( "i.avec_droit = ?", $avec_droit );

        return $this->fetchAll($query)->toArray(); 
    }
    
    	/**
     * Calcule les totaux des ventes
     *
     * @param int $idLivre
     *
     * @return array
     */
    public function getTotaux($idLivre=false)
    {
        $query = $this->select()
        		->from( array("v" => "iste_vente"), array("tot_e"=>"SUM(v.montant_euro)","tot_l"=>"SUM(v.montant_livre)","tot_d"=>"SUM(v.montant_dollar)"
        			,"id_boutique", "nbLivre"=>"COUNT(DISTINCT(i.id_livre))", "nbIsbn"=>"COUNT(DISTINCT(v.id_isbn))", "nb"=>new Zend_Db_Expr("SUM(nombre)/COUNT(DISTINCT(la.id_auteur))"), "dMin"=>"MIN(date_vente)", "dMax"=>"MAX(date_vente)"
        			,"nbAut"=>"COUNT(DISTINCT(la.id_auteur))","nbA"=>"COUNT(DISTINCT(v.acheteur))","nbV"=>"COUNT(DISTINCT(v.id_vente))"
        			))
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
        		->joinInner(array("i" => "iste_isbn"),'v.id_isbn = i.id_isbn')
        		->joinInner(array("la" => "iste_livrexauteur"),'la.id_livre = i.id_livre')
        		->joinLeft(array("b" => "iste_boutique"),       
                'v.id_boutique = b.id_boutique', array("boutique"=>"nom"))
			->joinLeft(array("p" => "iste_prix"),       
                'p.id_prix = v.id_prix', array("prix_e"=>"SUM(p.prix_euro)","prix_l"=>"SUM(p.prix_livre)","prix_d"=>"SUM(p.prix_dollar)"))
			->joinLeft(array("r" => "iste_royalty"),       
                'r.id_vente = v.id_vente', array("r_livre"=>"SUM(r.montant_livre)"))
			->joinLeft(array("rDue" => "iste_royalty"),       
                "rDue.id_vente = v.id_vente AND rDue.date_paiement = '0000-00-00'", array("r_livreDue"=>"SUM(rDue.montant_livre)"))
			->joinLeft(array("rPaie" => "iste_royalty"),       
                "rPaie.id_vente = v.id_vente AND rDue.date_paiement != '0000-00-00'", array("r_livrePaie"=>"SUM(rPaie.montant_livre)"))
			->group("id_boutique");
        	if($idLivre){
        		$query->where( "i.id_livre = ?", $idLivre);        		
        	}

        return $this->fetchAll($query)->toArray(); 
    }
    
    
   	/**
     * Récupère le résumé des ventes
     *
     * @return array
     */
    public function getResume()
    {
	    $rsR = $this->getTotaux();
		$i=1;
		$rs = array();
        foreach ($rsR as $r) {
			$rs[]= array("summary"=>true,"recid"=>"S-".$i,"boutiques"=>$r["boutique"]
				,"auteur"=>$r["nbAut"],"livres"=>$r["nbLivre"]
				,"nb_vente"=>$r["nb"],"isbns"=>$r["nbIsbn"]
				,"date_first"=>$r["dMin"],"date_last"=>$r["dMax"]
				,"mt_e"=>$r["tot_e"],"mt_l"=>$r["tot_l"],"mt_d"=>$r["tot_d"]
				,"mt_rTot"=>$r["r_livre"],"mt_rDue"=>$r["r_livreDue"],"mt_rPaie"=>$r["r_livrePaie"]
				);
		}
		return $rs;
    }
    
   	/**
     * Récupère les ventes avec montant abascent
     *
     * @return array
     */
    public function findMontantAbscent()
    {
        $query = $this->select()
        		->from( array("v" => "iste_vente"))
        		->where("montant_livre is null OR montant_dollar is null OR montant_euro is null");
        		
        return $this->fetchAll($query)->toArray(); 
    }

	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param array 		$arrWhere
     * @param boolean	$bLivre
     *
     * @return array
     */
    public function findId($arrWhere, $bLivre=false)
    {
    		if(!$bLivre)
			$sql = "SELECT GROUP_CONCAT(DISTINCT v.id_vente) ids ";
		else
			$sql = "SELECT GROUP_CONCAT(DISTINCT l.id_livre) ids ";
		$sql .= " FROM iste_vente v 
					INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
					INNER JOIN iste_livre l ON l.id_livre = i.id_livre ";
		
	    	foreach ($arrWhere as $w) {
	    		//création de l'opérateur
	    		//print_r($w);
	    		//vérification de la valeur
	    		if($w["field"]=="date_vente"){
	    			if($w["operator"]=="between") {
		    			$dt = new DateTime($w["value"][0]);
		    			$w["value"][0] = $dt->format('Y-m-d');
		    			$dt = new DateTime($w["value"][1]);
		    			$w["value"][1] = $dt->format('Y-m-d');
	    			}else{
		    			$dt = new DateTime($w["value"]);
		    			$w["value"] = $dt->format('Y-m-d');
	    			}
	    		}	    		
	    		
	    		switch ($w["operator"]) {
	    			case "is":
	    				$op = $w["field"]." ='".$w["value"]."' ";
	    			break;
	    			case "begins":
	    				$op = $w["field"]." LIKE '".$w["value"]."%' ";
	    			break;
	    			case "ends":
	    				$op = $w["field"]." LIKE '%".$w["value"]."' ";
	    			break;
	    			case "contains":
	    				$op = $w["field"]." LIKE '%".$w["value"]."%' ";
	    			break;
	    			case "less":
	    				$op = $w["field"]." < '".$w["value"]."' ";
	    			break;
	    			case "more":
	    				$op = $w["field"]." > '".$w["value"]."' ";
	    			break;
	    			case "between":
	    				$op = $w["field"]." BETWEEN '".$w["value"][0]."' AND '".$w["value"][1]."' ";
	    			break;	    			
	    		}
	    		//modification de la requête
			switch ($w["field"]) {
				case "titre":
					$nop = str_replace("titre", "l.titre_fr", $op)." OR ".str_replace("titre", "l.titre_en", $op);
					$sql .= " WHERE ".$nop; 
				break;
				case "nom":
					$sql .= " INNER JOIN iste_livrexauteur lan ON lan.id_livre = l.id_livre
					INNER JOIN iste_auteur a ON a.id_auteur = lan.id_auteur AND a.".$op;
				break;
				case "sum_mt_e_r":
					$nop = str_replace("sum_mt_e_r", "r.montant_euro", $op);
					$sql .= "INNER JOIN iste_royalty r ON r.id_vente = v.id_vente AND ".$nop;
				break;
				default:
					$sql .= " WHERE ".$op;
				break;
			}
		}
		
		//echo $sql;
	    	$db = $this->_db->query($sql);
	    return $db->fetchAll();
    }    
}
