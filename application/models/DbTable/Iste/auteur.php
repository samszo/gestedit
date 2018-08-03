<?php
/**
 * Ce fichier contient la classe Iste_auteur.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_auteur extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_auteur';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_auteur';
    
    /**
     * Vérifie si une entrée Iste_auteur existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_auteur'));
		foreach($data as $k=>$v){
			if($v)$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_auteur; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_auteur.
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
			return $this->findById_auteur($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_auteur avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {           	
	    	$this->update($data, 'iste_auteur.id_auteur = ' . $id);
	    	return $this->findById_auteur($id);
    }
    
    /**
     * Recherche une entrée Iste_auteur avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
	    	$this->delete('iste_auteur.id_auteur = ' . $id);
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
            		,array("id"=>$this->_primary[1],"text"=>"CONCAT(nom, ' ', prenom)"))
            ->order(array("nom", "prenom"));        
        return $this->fetchAll($query)->toArray();
	} 
    
    /**
     * Récupère toutes les entrées Iste_auteur avec certains critères
     * de tri, intervalles
     * 
     * @param string 	$order
     * @param int 		$limit
     * @param int 		$from
     * @param string 	$where
     * @param string 	$ids
     * 
     * @return array
     * 
     */
    public function getAll($order=null, $limit=0, $from=0, $where=null,$ids=false)
    {
   	
	    	$query = $this->select()
		->from( array("a" => "iste_auteur"))
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("aid" => "iste_auteur"),
                'a.id_auteur = aid.id_auteur', array("recid"=>"id_auteur"))
			->joinLeft(array("i" => "iste_institution"),
                'i.id_institution = a.id_institution', array("instNom"=>"nom"));
		
        if($order != null)
        {
            $query->order($order);
        }

        if($limit != 0)
        {
            $query->limit($limit, $from);
        }
        if($ids){
            $query->where("a.id_auteur IN (".$ids.")");
        }
        
        return $this->fetchAll($query)->toArray();
    }

    
    	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_auteur
     *
     * @return array
     */
    public function findById_auteur($id_auteur)
    {
        $query = $this->select()
		->from( array("a" => "iste_auteur"))
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("aid" => "iste_auteur"),
                'a.id_auteur = aid.id_auteur', array("recid"=>"id_auteur"))
			->joinLeft(array("i" => "iste_institution"),
                'i.id_institution = a.id_institution', array("instNom"=>"nom"))
        ->where( "a.id_auteur = ?", $id_auteur );

		$rs = $this->fetchAll($query)->toArray(); 
        return count($rs) ? $rs[0] : false;
    }
    
	/**
     * récupère les livres avec coordination et direction
     *
     * @return array
     */
    public function findRoleCoorDir()
    {
 		$sql = "SELECT 
		l.id_livre, l.titre_en, l.titre_fr
		, la.id_auteur, la.role
		, ls.id_serie
		, cl.id_comite
		FROM iste_livre l
		 INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre
		 INNER JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
		 INNER JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
		WHERE la.role != 'auteur'
		ORDER BY l.id_livre 	";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }     
    
    	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_institution
     *
     * @return array
     */
    public function findById_institution($id_institution)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteur") )                           
                    ->where( "i.id_institution = ?", $id_institution );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nom
     *
     * @return array
     */
    public function findByNom($nom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteur") )                           
                    ->where( "i.nom = ?", $nom );

        return $this->fetchAll($query)->toArray(); 
    }
	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nom
     * @param varchar $prenom
     *
     * @return array
     */
    public function findByNomPrenom($nom, $prenom="")
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteur") )                           
                    ->where( "i.prenom = ?", $prenom )
                    ->where( "i.nom = ?", $nom );
		$rs = $this->fetchAll($query)->toArray(); 
        return count($rs) ? $rs[0] : false;
    }    
    	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $prenom
     *
     * @return array
     */
    public function findByPrenom($prenom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteur") )                           
                    ->where( "i.prenom = ?", $prenom );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $adresse
     *
     * @return array
     */
    public function findByAdresse($adresse)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteur") )                           
                    ->where( "i.adresse = ?", $adresse );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $ville
     *
     * @return array
     */
    public function findByVille($ville)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteur") )                           
                    ->where( "i.ville = ?", $ville );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $code_postal
     *
     * @return array
     */
    public function findByCode_postal($code_postal)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteur") )                           
                    ->where( "i.code_postal = ?", $code_postal );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $pays
     *
     * @return array
     */
    public function findByPays($pays)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteur") )                           
                    ->where( "i.pays = ?", $pays );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $telephone
     *
     * @return array
     */
    public function findByTelephone($telephone)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteur") )                           
                    ->where( "i.telephone = ?", $telephone );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $isni
     *
     * @return array
     */
    public function findByIsni($isni)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteur") )                           
                    ->where( "i.isni = ?", $isni );

        return $this->fetchAll($query)->toArray(); 
    }
    
    	/**
     * Recherche les informations liées à l'auteur
     * et retourne ces informations.
     *
     * @param varchar $idAuteur
     *
     * @return array
     */
    public function findInfos($idAuteur)
    {
		$sql = 'SELECT a.id_auteur
		, GROUP_CONCAT(DISTINCT c.id_comite, ",", c.titre_en, ",", c.titre_fr SEPARATOR ":") comites
		, GROUP_CONCAT(DISTINCT s.id_serie, ",", s.titre_en, ",", s.titre_fr SEPARATOR ":") series
		, GROUP_CONCAT(DISTINCT la.id_livre) livres
		FROM iste_auteur a
		LEFT JOIN iste_comitexauteur ca ON ca.id_auteur = a.id_auteur
		LEFT JOIN iste_comite c ON c.id_comite = ca.id_comite
		LEFT JOIN iste_coordination co ON co.id_auteur = a.id_auteur 
		LEFT JOIN iste_serie s ON s.id_serie = co.id_serie
		LEFT JOIN iste_livrexauteur la ON la.id_auteur = a.id_auteur
		WHERE a.id_auteur ='.$idAuteur;     
		       
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }
    
/**
     * Récupère toutes les entrées Iste_livre avec certains critères
     * de tri, intervalles
     * @param int $resume
     * 
     * @return array
     * 
     */
    public function getAllVente($resume=true)
    {
		$sql = "SELECT 	
			a.id_auteur recid, CONCAT(a.prenom,' ',a.nom) auteur
			, COUNT(DISTINCT l.id_livre) nbL
            , GROUP_CONCAT(DISTINCT IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,'')) livres
			, GROUP_CONCAT(DISTINCT(i.num)) isbns
			, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d, GROUP_CONCAT(DISTINCT(IFNULL(b.nom,''))) boutiques			
			, MAX(v.date_vente) date_last , MIN(v.date_vente) date_first			
			, SUM(rTot.montant_livre) mt_rTot
			, SUM(rDue.montant_livre) mt_rDue
			, SUM(rPaie.montant_livre) mt_rPaie
			, p.prix_livre, prix_euro, prix_dollar
			FROM iste_auteur a 
				INNER JOIN iste_livrexauteur la ON a.id_auteur = la.id_auteur
				INNER JOIN iste_livre l ON l.id_livre = la.id_livre
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
				INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
				INNER JOIN iste_boutique b ON b.id_boutique = v.id_boutique
				LEFT JOIN iste_royalty rTot ON rTot.id_vente = v.id_vente
				LEFT JOIN iste_royalty rDue ON rDue.id_vente = v.id_vente AND rDue.date_paiement = '0000-00-00'
				LEFT JOIN iste_royalty rPaie ON rPaie.id_vente = v.id_vente AND rPaie.date_paiement != '0000-00-00'				
				LEFT JOIN iste_prix p ON p.id_prix = v.id_prix
			GROUP BY a.id_auteur";
		$sql = "SELECT 	
			a.id_auteur recid, CONCAT(a.prenom,' ',a.nom) auteur
			, GROUP_CONCAT(DISTINCT la.role) roles
            , GROUP_CONCAT(DISTINCT IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,'')) livres
--			, COUNT(l.id_livre) nbIdLivre, COUNT(DISTINCT l.id_livre) nbIdLivreDist
--			, COUNT(i.id_isbn) nbIdIsbn, COUNT(DISTINCT i.num) nbIdIsbnDist
			, GROUP_CONCAT(DISTINCT(i.num)) isbns
            , vDir.nb_vente vDirnb_vente, vDir.mt_l vDirmt_l
            , vAut.nb_vente vAutnb_vente, vAut.mt_l vAutmt_l
            , vCoor.nb_vente vCoornb_vente, vCoor.mt_l vCoormt_l
            , MIN(v.date_vente) date_first, MAX(v.date_vente) date_last			
			, GROUP_CONCAT(DISTINCT(b.nom)) boutiques
			, rTot.montant_livre mt_rTot
			, rDue.montant_livre mt_rDue
			, rPaie.montant_livre mt_rPaie
			FROM iste_auteur a 
				INNER JOIN iste_livrexauteur la ON a.id_auteur = la.id_auteur
				INNER JOIN iste_livre l ON l.id_livre = la.id_livre
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
                INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
                INNER JOIN iste_boutique b ON b.id_boutique = v.id_boutique
				LEFT JOIN (SELECT
					 la.id_auteur
					, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d
					FROM iste_vente v
					INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
					INNER JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.role = 'directeur'
					GROUP BY la.id_auteur) vDir ON vDir.id_auteur = la.id_auteur
				LEFT JOIN (SELECT
					 la.id_auteur
					, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d
					FROM iste_vente v
					INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
					INNER JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.role = 'coordinateur'
					GROUP BY la.id_auteur) vCoor ON vDir.id_auteur = la.id_auteur
				LEFT JOIN (SELECT
					 la.id_auteur
					, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d
					FROM iste_vente v
					INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
					INNER JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.role = 'auteur'
					GROUP BY la.id_auteur) vAut ON vAut.id_auteur = la.id_auteur
				LEFT JOIN (SELECT  SUM(r.montant_livre) montant_livre, ac.id_auteur 
					FROM iste_auteurxcontrat ac 
					INNER JOIN iste_royalty r ON r.id_auteurxcontrat = ac.id_auteurxcontrat
                    GROUP BY ac.id_auteur) rTot ON rTot.id_auteur = la.id_auteur
				LEFT JOIN (SELECT  SUM(r.montant_livre) montant_livre, ac.id_auteur 
					FROM iste_auteurxcontrat ac 
					INNER JOIN iste_royalty r ON r.id_auteurxcontrat = ac.id_auteurxcontrat AND date_paiement = '0000-00-00'	
                    GROUP BY ac.id_auteur) rDue ON rDue.id_auteur = la.id_auteur
				LEFT JOIN (SELECT  SUM(r.montant_livre) montant_livre, ac.id_auteur 
					FROM iste_auteurxcontrat ac 
					INNER JOIN iste_royalty r ON r.id_auteurxcontrat = ac.id_auteurxcontrat AND date_paiement != '0000-00-00'	
                    GROUP BY ac.id_auteur) rPaie ON rPaie.id_auteur = la.id_auteur			
			WHERE vDir.nb_vente IS NOT NULL OR vAut.nb_vente IS NOT NULL OR vCoor.nb_vente IS NOT NULL
            GROUP BY a.id_auteur";            
	    	$db = $this->_db->query($sql);
	    	$rs = $db->fetchAll();
	    	
	    	if($resume){
			//ajoute les résumés
			$bdd = new Model_DbTable_Iste_vente();
			$rs = array_merge($rs,$bdd->getResume());
	    	}
		return $rs;
	    	
    }    

    
	/**
     * Recherche une entrée Iste_auteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param array $arrWhere
     *
     * @return array
     */
    public function findId($arrWhere)
    {
	$sql = "SELECT GROUP_CONCAT(DISTINCT a.id_auteur) ids
		FROM iste_auteur a ";
		$where = false;
	
	    	foreach ($arrWhere as $w) {
	    		//création de l'opérateur
	    		//print_r($w);
	    		//vérification du champ
	    		if(strpos($w["field"], "-")){
	    			$arrTache = explode("-", $w["field"]);
	    			$w["field"] = $arrTache[2];
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
	    		if($w["field"]=="date_parution"){
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
	    		/*modification de la requête pour les champs liés
   		    { field: 'recid', caption: 'id', type: 'text', hidden:true },
   		    { field: 'civilite', caption: 'civilite', type: 'text', hidden:true },
            { field: 'prenom', caption: 'Prénom', type: 'text' },
            { field: 'nom', caption: 'Nom', type: 'text' },
            { field: 'instNom', caption: 'Institution', type: 'text' },
            { field: 'id_comite', caption: 'Comité', type: 'combo', options: { items: arrListes['comite']} },
            { field: 'id_serie', caption: 'Coordination', type: 'combo', options: { items: arrListes['serie']} },
            { field: 'titre_fr', caption: 'Titre FR', type: 'text' },
            { field: 'titre_en', caption: 'Titre EN', type: 'text' },		            
			*/	    		
			switch ($w["field"]) {
				case "instNom":
					$sql .= "INNER JOIN iste_institution ins ON ins.id_institution = a.id_institution AND ins.".$op;
				break;
				case "id_serie":
					$nop = str_replace("id_serie", "s.titre_fr", $op)." OR ".str_replace("id_serie", "s.titre_en", $op);
					$sql .= "INNER JOIN iste_coordination c ON c.id_auteur = a.id_auteur
					INNER JOIN iste_serie s ON s.id_serie = c.id_serie AND (".$nop.")";
				break;
				case "id_comite":
					$nop = str_replace("id_comite", "c.titre_fr", $op)." OR ".str_replace("id_comite", "c.titre_en", $op);
					$sql .= "INNER JOIN iste_comitexauteur ca ON ca.id_auteur = a.id_auteur
					INNER JOIN iste_comite c ON c.id_comite = ca.id_comite AND (".$nop.")";
				break;
				case "titre_fr":
					$sql .= "INNER JOIN iste_livrexauteur la ON la.id_auteur = a.id_auteur
						INNER JOIN iste_livre l ON l.id_livre = la.id_livre AND ".$op;
						break;
				case "titre_en":
					$sql .= "INNER JOIN iste_livrexauteur la ON la.id_auteur = a.id_auteur
						INNER JOIN iste_livre l ON l.id_livre = la.id_livre AND ".$op;
						break;
				case "date_parution":
					$sql .= "INNER JOIN iste_livrexauteur la ON la.id_auteur = a.id_auteur
						INNER JOIN iste_isbn i ON i.id_livre = la.id_livre AND i.date_parution != '0000-00-00' AND ".$op;
					break;
				default:
					if(!$where)
						$where = " WHERE ".$op;
					else 
						$where .= " AND ".$op;
				break;
			}
		}
		if($where)		
			$sql .= $where;
		//echo $sql; return;
	    	$db = $this->_db->query($sql);
	    return $db->fetchAll();
    }    
}
