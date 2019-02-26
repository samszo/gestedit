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
       ,"Model_DbTable_Iste_processusxlivre"
       ,"Model_DbTable_Iste_prevision"
       ,"Model_DbTable_Iste_livrexserie"
       ,"Model_DbTable_Iste_comitexlivre"
       ,"Model_DbTable_Iste_isbn"
       ,"Model_DbTable_Iste_web"
       ,"Model_DbTable_Iste_proposition"
       ,"Model_DbTable_Iste_auteurxcontrat"
       ,"Model_DbTable_Iste_page"
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
    public function ajouter($data, $existe=true, $rs=false)
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
     * @return int
     */
    public function remove($id)
    {
    		//vérifie les contrats en cours
    		$dbR = new Model_DbTable_Iste_royalty();
    		$rs = $dbR->verifEnCoursByIdLivre($id);
    		if($rs[0]["mtDue"]>0){
    			return array("message"=>"Il reste : ".$rs[0]["mtDue"]." &pound; à payer ou encaisser.<br/>Vous ne pouvez pas supprimer le livre.");
    		}
    		
    		$n = array();
        $dt = $this->getDependentTables();
        foreach($dt as $t){
	        	$dbT = new $t($this->_db);
	        	switch ($t) {
	        		case "Model_DbTable_Iste_isbn":
	        			$n[$t] = $dbT->removeLivre($id);
	        		break;
	        		case "Model_DbTable_Iste_processusxlivre":	        			
				    	$n[$t] = "suppression avec les prévisions";	        		
	    	        		break;	        		
	        		case "Model_DbTable_Iste_prevision":	        	
	        			$dbPre = new Model_DbTable_Iste_processusxlivre();
	        			$arr = $dbPre->findById_livre($id);
	        			foreach ($arr as $pl) {
					    	$n[$t] = $dbT->delete('id_pxu ='.$pl["id_plu"].' AND obj="livre"');	        		
	        			}	
	        			$dbPre->	delete('id_livre ='.$id);
	    	        		break;	        		
	        		default:
	        			$n[$t] = $dbT->delete('id_livre ='.$id);
	        		break;
	        	}			    
        }
	    $n["Model_DbTable_Iste_livre"] = $this->delete('iste_livre.id_livre = ' . $id);
	    return $n;
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
            		,array("id"=>$this->_primary[1],"text"=>"CONCAT(IFNULL(titre_fr,''), '/', IFNULL(titre_en,''))"))
            ->order("titre_fr");        
        return $this->fetchAll($query)->toArray();
	} 
	    
    
    /**
     * Récupère toutes les entrées Iste_livre avec certains critères
     * de tri, intervalles
     * 
     * @param string 	$order
     * @param int 		$limit
     * @param int 		$from
     * @param string 	$where
     * @param string 	$ids
     * 
     * @return array
     */
    public function getAll($order=null, $limit=0, $from=0, $where=null,$ids=false)
    {
   	
	    	$query = $this->select()
			->from( array("l" => "iste_livre"),array("recid"=>"id_livre","id_livre","reference","titre_fr","soustitre_fr","titre_en","soustitre_en","num_vol","type_1","type_2","production") )
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("i" => "iste_isbn"),
                'i.id_livre = l.id_livre', array("isbns"=>"GROUP_CONCAT(DISTINCT(i.num) ORDER BY i.ordre)"))
            ->joinLeft(array("e" => "iste_editeur"),
                'e.id_editeur = i.id_editeur', array("editeurs"=>"GROUP_CONCAT(DISTINCT(e.nom))"))
            ->joinLeft(array("la" => "iste_livrexauteur"),
                'la.id_livre = l.id_livre AND la.ordre > 0 AND la.role = "auteur"', array())
            ->joinLeft(array("a" => "iste_auteur"),
                'a.id_auteur = la.id_auteur', array("auteurs"=>"GROUP_CONCAT(DISTINCT(CONCAT(' ',a.prenom,' ',a.nom)) ORDER BY la.ordre)"))
            ->joinLeft(array("lad" => "iste_livrexauteur"),
                'lad.id_livre = l.id_livre AND lad.ordre > 0 AND lad.role = "directeur"', array())
            ->joinLeft(array("ad" => "iste_auteur"),
                'ad.id_auteur = lad.id_auteur', array("directeurs"=>"GROUP_CONCAT(DISTINCT(CONCAT(' ',ad.prenom,' ',ad.nom)) ORDER BY lad.ordre)"))
            ->joinLeft(array("lac" => "iste_livrexauteur"),
                'lac.id_livre = l.id_livre AND lac.ordre > 0 AND lac.role IN ("coordonnateur","Coordonnateur SCIENCES")', array())
            ->joinLeft(array("ac" => "iste_auteur"),
                'ac.id_auteur = lac.id_auteur', array("coordonnateurs"=>"GROUP_CONCAT(DISTINCT(CONCAT(' ',ac.prenom,' ',ac.nom)) ORDER BY lac.ordre)"))
            ->joinLeft(array("lar" => "iste_livrexauteur"),
                'lar.id_livre = l.id_livre AND lar.ordre > 0 AND lar.role IN ("resp. série","SCIENCES-Responsable thème")', array())
            ->joinLeft(array("ar" => "iste_auteur"),
                'ar.id_auteur = lar.id_auteur', array("resp"=>"GROUP_CONCAT(DISTINCT(CONCAT(' ',ar.prenom,' ',ar.nom)))"))
            ->joinLeft(array("pl" => "iste_processusxlivre"),
                'pl.id_livre = l.id_livre AND pl.id_processus = 3', array())
            ->joinLeft(array("p" => "iste_prevision"),
                'p.id_pxu = pl.id_plu AND p.obj = "livre" AND p.id_tache = 15', array("prod"=>"IFNULL(DATE_FORMAT(p.fin,'oui'),'non')"))
            ->group("l.id_livre")
            //->order("la.ordre")
            ;
        if($order != null)
        {
            $query->order($order);
        }
        if($where != null)
        {
            $query->where($where);
        }
        
        if($limit != 0)
        {
            $query->limit($limit, $from);
        }
        if($ids){
            $query->where("l.id_livre IN (".$ids.")");
        }

        return $this->fetchAll($query)->toArray();
    }

	/**
     * Récupère les entrées Iste_livre et les formate pour une visualisation keshif
     * 
     * @return array
     */
    public function getKeshif()
    {
		$sql = "SELECT 	
			l.id_livre recid, titre_fr, titre_en, soustitre_fr, soustitre_en, type_1, type_2, num_vol
			, GROUP_CONCAT(DISTINCT(CONCAT(a.prenom,' ',a.nom))) auteurs
			, GROUP_CONCAT(DISTINCT(i.num)) isbns, GROUP_CONCAT(DISTINCT(i.nb_page)) nbPage
            , GROUP_CONCAT(DISTINCT(e.nom)) editeurs
			, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d, GROUP_CONCAT(DISTINCT(b.nom)) boutiques			
			, MAX(v.date_vente) date_last , MIN(v.date_vente) date_first			
			, SUM(r.montant_livre) mt_e_r
			, p.prix_livre, prix_euro, prix_dollar
			, GROUP_CONCAT(DISTINCT f.type,':',f.url) fics
			FROM iste_livre l
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
				INNER JOIN iste_editeur e ON e.id_editeur = i.id_editeur 
				INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre
                INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
				LEFT JOIN iste_vente v ON v.id_isbn = i.id_isbn
				LEFT JOIN iste_boutique b ON b.id_boutique = v.id_boutique
				LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente
				LEFT JOIN iste_prix p ON p.id_prix = v.id_prix
				LEFT JOIN iste_importfic f ON f.id_obj = l.id_livre AND f.obj = 'livre' AND (f.type = 'Couverture en.' OR f.type = 'Couverture fr.') 
			GROUP BY i.id_livre";            
	    	$db = $this->_db->query($sql);
	    	$rs = $db->fetchAll();    	
		/*
	    	foreach ($rs as $r) {
    			;
    		}
    		*/
	    	return $rs;
    }
        
    
/**
     * Récupère toutes les entrées Iste_livre avec certains critères
     * de tri, intervalles
     * 
     * @param string 	$order
     * @param int 		$limit
     * @param int 		$from
     * @param string 	$where
     * 
     * 
     */
    public function getAllId($order=null, $limit=0, $from=0, $where=null)
    {
   	
	    	$query = $this->select()
			->from( array("l" => "iste_livre"),array("id_livre"))
            ;
        if($order != null)
        {
            $query->order($order);
        }
        if($where != null)
        {
            $query->where($where);
        }
        
        if($limit != 0)
        {
            $query->limit($limit, $from);
        }

        return $this->fetchAll($query)->toArray();
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
   		/*
	    	$query = $this->select()
			->from( array("l" => "iste_livre"),array("recid"=>"id_livre", "titre"=>"CONCAT(IFNULL(titre_en,''),' / ',IFNULL(titre_fr,''))"))
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("la" => "iste_livrexauteur"),
                'la.id_livre = l.id_livre', array())
            ->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = la.id_auteur', array("auteurs"=>"GROUP_CONCAT(DISTINCT(CONCAT(a.prenom,' ',a.nom)))"))
            ->joinInner(array("i" => "iste_isbn"),
                'i.id_livre = l.id_livre', array("isbns"=>"GROUP_CONCAT(DISTINCT(i.num))"))
            ->joinInner(array("v" => "iste_vente"),
                'v.id_isbn = i.id_isbn', array("mt_e"=>"SUM(v.montant_euro)","mt_l"=>"SUM(v.montant_livre)","mt_d"=>"SUM(v.montant_dollar)"
            			,"nb_vente"=>"SUM(v.nombre)","boutiques"=>"GROUP_CONCAT(DISTINCT(v.boutique))"
            			,"date_first"=>"MIN(v.date_vente)","date_last"=>"MAX(v.date_vente)"))
            ->group("i.id_isbn");
        */
		$sql = "SELECT 	
			l.id_livre recid, CONCAT(IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,'')) titre
			, ca.auteurs
			, GROUP_CONCAT(DISTINCT(i.num)) isbns
			, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d
            , GROUP_CONCAT(DISTINCT(b.nom)) boutiques			
			, MAX(v.date_vente) date_last , MIN(v.date_vente) date_first			
			, SUM(r.montant_livre) mt_e_r
			, p.prix_livre, prix_euro, prix_dollar
			FROM iste_livre l
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
				INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
				INNER JOIN iste_boutique b ON b.id_boutique = v.id_boutique
				INNER JOIN (SELECT GROUP_CONCAT(DISTINCT(CONCAT(a.prenom,' ',a.nom))) auteurs, la.id_livre
				FROM iste_auteur a 
				INNER JOIN iste_livrexauteur la ON a.id_auteur = la.id_auteur
				GROUP BY la.id_livre
				) ca ON ca.id_livre = l.id_livre
				LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente
				LEFT JOIN iste_prix p ON p.id_prix = v.id_prix
			GROUP BY i.id_isbn";            
	    	$db = $this->_db->query($sql);
	    	$rs = $db->fetchAll();
	    	
	    	if($resume){
    			//ajoute les résumés
    			$bdd = new Model_DbTable_Iste_vente();
    			$rsR = $bdd->getTotaux();
    			$i=1;
    	        foreach ($rsR as $r) {
    				$rs[]= array("summary"=>true,"recid"=>"S-".$i,"boutiques"=>$r["boutique"]
    					,"auteurs"=>$r["nbA"],"titre"=>$r["nbLivre"]
    					,"nb_vente"=>$r["nb"],"isbns"=>$r["nbIsbn"]
    					,"date_first"=>$r["dMin"],"date_last"=>$r["dMax"]
    					,"mt_e"=>$r["tot_e"],"mt_l"=>$r["tot_l"],"mt_d"=>$r["tot_d"],"mt_e_r"=>$r["r_livre"]
    					);
    			}
	    	}
		return $rs;
	    	
    }
    
    /**
     * Récupère toutes les entrées Iste_livre avec certains critères
     * de tri, intervalles
     * @param int $resume
     *
     * @return array
     *
     */
    public function getAllVenteISBN($resume=true)
    {
        $sql = "SELECT
		i.id_isbn recid, l.titre_fr, l.titre_en
		, ca.auteurs
		, i.num, i.type, GROUP_CONCAT(DISTINCT v.type) typeVente
		, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d, GROUP_CONCAT(DISTINCT(b.nom)) boutiques
		, MAX(v.date_vente) date_last , MIN(v.date_vente) date_first
		, sr.mt_e_r
		, p.prix_livre, prix_euro, prix_dollar
		FROM iste_livre l
			INNER JOIN iste_isbn i ON i.id_livre = l.id_livre
			INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
			INNER JOIN (SELECT GROUP_CONCAT(DISTINCT(CONCAT(a.prenom,' ',a.nom,' (',la.role,')'))) auteurs, la.id_livre
			FROM iste_auteur a
			INNER JOIN iste_livrexauteur la ON a.id_auteur = la.id_auteur
			GROUP BY la.id_livre
			) ca ON ca.id_livre = l.id_livre
			INNER JOIN iste_boutique b ON b.id_boutique = v.id_boutique
			INNER JOIN (SELECT SUM(r.montant_livre) mt_e_r, r.id_vente
			FROM iste_royalty r
			GROUP BY r.id_vente
			) sr ON sr.id_vente = v.id_vente
			-- LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente
			LEFT JOIN iste_prix p ON p.id_prix = v.id_prix
		GROUP BY i.id_isbn
		ORDER BY l.titre_fr, l.titre_en";
        $db = $this->_db->query($sql);
        $rs = $db->fetchAll();
        
        if($resume){
            //ajoute les résumés
            $bdd = new Model_DbTable_Iste_vente();
            $rsR = $bdd->getTotaux();
            $i=1;
            foreach ($rsR as $r) {
                $rs[]= array("summary"=>true,"recid"=>"S-".$i,"boutiques"=>$r["boutique"]
                    ,"auteurs"=>$r["nbA"],"titre"=>$r["nbLivre"]
                    ,"nb_vente"=>$r["nb"],"isbns"=>$r["nbIsbn"]
                    ,"date_first"=>$r["dMin"],"date_last"=>$r["dMax"]
                    ,"mt_e"=>$r["tot_e"],"mt_l"=>$r["tot_l"],"mt_d"=>$r["tot_d"],"mt_e_r"=>$r["r_livre"]
                );
            }
        }
        return $rs;
        
    }
    
	/**
     * Récupère toutes les entrées Iste_livre avec certains critères
     * de tri, intervalles
     * @param int $idLivre
     * @param int $resume
     * 
     * @return array
     * 
     */
    public function getIdLivreVente($idLivre, $resume=true)
    {
		$sql = "SELECT 	
			l.id_livre recid, CONCAT(IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,'')) titre
			, ca.auteurs
			, GROUP_CONCAT(DISTINCT(i.num)) isbns
			, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d
			, GROUP_CONCAT(DISTINCT(b.nom)) boutiques			
			, MAX(v.date_vente) date_last , MIN(v.date_vente) date_first			
			FROM iste_livre l
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
				INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
				INNER JOIN iste_boutique b ON b.id_boutique = v.id_boutique
				INNER JOIN (SELECT GROUP_CONCAT(DISTINCT(CONCAT(a.prenom,' ',a.nom))) auteurs, la.id_livre
				FROM iste_auteur a 
				INNER JOIN iste_livrexauteur la ON a.id_auteur = la.id_auteur
				GROUP BY la.id_livre
				) ca ON ca.id_livre = l.id_livre
			WHERE l.id_livre = ".$idLivre."
			GROUP BY i.id_isbn";            
	    	$db = $this->_db->query($sql);
	    	$rs = $db->fetchAll();
	    	
	    	if($resume){
			//ajoute les résumés
			$bdd = new Model_DbTable_Iste_vente();
			$rsR = $bdd->getTotaux();
			$i=1;
	        foreach ($rsR as $r) {
				$rs[]= array("summary"=>true,"recid"=>"S-".$i,"boutiques"=>$r["boutique"]
					,"auteurs"=>'<span style="float: right;">Nb de vente</span>',"titre"=>$r["nb"]
					,"nb_vente"=>'<span style="float: right;">Nb ISBN</span>',"isbns"=>$r["nbIsbn"]
					,"date_first"=>$r["dMin"],"date_last"=>$r["dMax"]
					,"mt_e"=>$r["tot_e"],"mt_l"=>$r["tot_l"],"mt_d"=>$r["tot_d"]
					);
			}
	    	}
		return $rs;
	    	
    }    
    
	/**
     * Récupère toutes les entrées Iste_livre avec certains critères
     * de tri, intervalles
     * @param int $idLivre
     * @param int $resume
     * 
     * @return array
     * 
     */
    public function getIdAuteurVente($idLivre, $resume=true)
    {
		$sql = "SELECT 	
			a.id_auteur recid, CONCAT(a.prenom,' ',a.nom) auteur
			, COUNT(DISTINCT l.id_livre) nbL
            , GROUP_CONCAT(DISTINCT IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,'')) livres
			, GROUP_CONCAT(DISTINCT(i.num)) isbns
			, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d, GROUP_CONCAT(DISTINCT(b.nom)) boutiques			
			, MAX(v.date_vente) date_last , MIN(v.date_vente) date_first			
			, SUM(r.montant_livre) mt_e_r
			, p.prix_livre, prix_euro, prix_dollar
			FROM iste_auteur a 
				INNER JOIN iste_livrexauteur la ON a.id_auteur = la.id_auteur
				INNER JOIN iste_livre l ON l.id_livre = la.id_livre
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
				INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
				INNER JOIN iste_boutique b ON b.id_boutique = v.id_boutique
				LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente
				LEFT JOIN iste_prix p ON p.id_prix = v.id_prix
    			WHERE l.id_livre = ".$idLivre."
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
     * @param varchar $langue
     *
     * @return array
     */
    public function findByTitre($titre, $langue)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )
                    ->where( "i.titre_".$langue." = ?", $titre);

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titreFr
     * @param varchar $titreEn
     *
     * @return array
     */
    public function findByAllTitre($titreFr, $titreEn)
    {
        $query = $this->select()
           	->from( array("i" => "iste_livre") )
			->where( "i.titre_en = ?", $titreEn)
           	->where( "i.titre_fr = ?", $titreFr);

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
    public function findByTitreLike($titre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
					->where( 'i.titre_en LIKE "%'.$titre.'%"')
					->orWhere( 'i.titre_fr LIKE "%'.$titre.'%"');

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
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param array $arrWhere
     *
     * @return array
     */
    public function findId($arrWhere)
    {
		/*Problème avec la limite en octet du group concat
		 * 
		 $sql = "SELECT GROUP_CONCAT(DISTINCT l.id_livre) ids
			FROM iste_livre l ";
		*/
		$sql = "SELECT DISTINCT l.id_livre id
		FROM iste_livre l ";
		
		$where = false;
	
	    	foreach ($arrWhere as $w) {
	    		//création de l'opérateur
	    		//print_r($w);
	    		//vérification de la valeur
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
	    		//prise en compte de / dans les collections
	    		$colFied = "";
	    		if(strpos($w["value"], "/")){
	    			$arrVal = explode("/", $w["value"]);
	    			if(ltrim($arrVal[0])){
	    				$w["value"]=rtrim(ltrim($arrVal[0]));
	    				$colFied = "titre_fr";	
	    			}
	    			if(rtrim($arrVal[1])){
	    				$w["value"]=rtrim(ltrim($arrVal[1]));
	    				$colFied = "titre_en";		    				
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
				case "prenom":
					$sql .= "INNER JOIN iste_livrexauteur lap ON lap.id_livre = l.id_livre
					INNER JOIN iste_auteur ap ON ap.id_auteur = lap.id_auteur AND ap.".$op;
				break;
				case "nom":
					$sql .= "INNER JOIN iste_livrexauteur lan ON lan.id_livre = l.id_livre
					INNER JOIN iste_auteur an ON an.id_auteur = lan.id_auteur AND an.".$op;
				break;
				case "id_serie":
					if($colFied)$nop = str_replace("id_serie", "s.".$colFied, $op);
					else $nop = str_replace("id_serie", "s.titre_fr", $op)." OR ".str_replace("id_serie", "s.titre_en", $op);
					$sql .= "INNER JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
					INNER JOIN iste_serie s ON s.id_serie = ls.id_serie AND (".$nop.")";
				break;
				case "id_comite":
					if($colFied)$nop = str_replace("id_comite", "c.".$colFied, $op);
					else $nop = str_replace("id_comite", "c.titre_fr", $op)." OR ".str_replace("id_comite", "c.titre_en", $op);
					$sql .= "INNER JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
					INNER JOIN iste_comite c ON c.id_comite = cl.id_comite AND (".$nop.")";
				break;
				case "num":
					$sql .= "INNER JOIN iste_isbn i ON i.id_livre = l.id_livre AND ".$op;
				break;
				case "prevision":
					$sql .= "INNER JOIN iste_processusxlivre pc ON pc.id_livre = l.id_livre AND pc.id_processus = 3 
						INNER JOIN iste_prevision p ON p.id_pxu = pc.id_plu AND p.id_tache =".$arrTache[1]." AND ".$op;
				break;
				case "fin":
					$sql .= "INNER JOIN iste_processusxlivre pc ON pc.id_livre = l.id_livre AND pc.id_processus = 3 
						INNER JOIN iste_prevision p ON p.id_pxu = pc.id_plu AND p.id_tache =".$arrTache[1]." AND ".$op;
				break;
				case "relance":
					$sql .= "INNER JOIN iste_processusxlivre pc ON pc.id_livre = l.id_livre AND pc.id_processus = 3 
						INNER JOIN iste_prevision p ON p.id_pxu = pc.id_plu AND ".$op;
				break;
				case "alerte":
					$sql .= "INNER JOIN iste_processusxlivre pc ON pc.id_livre = l.id_livre AND pc.id_processus = 3 
						INNER JOIN iste_prevision p ON p.id_pxu = pc.id_plu AND ".$op;
				break;
				case "date_parution":
					$sql .= "INNER JOIN iste_isbn i ON i.id_livre = l.id_livre AND i.date_parution != '0000-00-00' AND ".$op;
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
	    	//construction de la réponse
	    	foreach ($arr as $v) {
	    		$result .= $v["id_livre"].",";
	    	}	    	
	    	$result = substr($result, 0, -1);
	    return array(0=>$result);
    }
    	/**
     * récupère les livres à traduire
     * 
     * @param string		$ids
     *
     * @return array
     */
    public function getTraductionLivre($ids=false)
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
			INNER JOIN iste_editeur e ON e.id_editeur = i.id_editeur"; 
		if($ids)$sql .= " WHERE i.id_isbn IN (".$ids.")";
 		$sql .= " GROUP BY i.id_isbn";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }
	/**
     * récupère les livres à produire
     * 
     * @param int	$idLivre
     * 
     * @return array
     */
    public function getProductionLivre($idLivre=false)
    {
 		$sql = "SELECT 
			GROUP_CONCAT(i.id_isbn) idsIsbn, GROUP_CONCAT(i.date_parution) date_parution, GROUP_CONCAT(i.num) isbn, GROUP_CONCAT(i.nb_page) nb_page 
			, GROUP_CONCAT(DISTINCT IFNULL(a.nom,'') , ' ', IFNULL(a.prenom,'') ORDER BY la.ordre SEPARATOR ', ') 'auteur'
			, GROUP_CONCAT(DISTINCT IFNULL(co.nom,'') , ' ', IFNULL(co.prenom,'') ORDER BY lac.ordre SEPARATOR ', ') 'coordonateur'			
						
			, l.titre_fr, l.soustitre_fr, l.titre_en, l.soustitre_en, l.type_1, l.type_2, l.id_livre, l.id_livre recid
			, l.contexte_fr, l.contexte_en, l.bio_fr, l.bio_en, l.tdm_fr, l.tdm_en, l.production 
		    , p.traduction, p.langue
		    , GROUP_CONCAT(DISTINCT e.nom) editeur
		FROM iste_livre l
			INNER JOIN iste_proposition p ON p.id_livre = l.id_livre     
			LEFT JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.role = 'auteur'
			LEFT JOIN iste_auteur a ON a.id_auteur = la.id_auteur 
			LEFT JOIN iste_livrexauteur lac ON lac.id_livre = l.id_livre AND lac.role IN ('coordonnateur','Coordonnateur SCIENCES')
			LEFT JOIN iste_auteur co ON co.id_auteur = lac.id_auteur				
			LEFT JOIN iste_isbn i ON i.id_livre = l.id_livre 
			LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur ";
			//WHERE l.production = 'oui' "; 
		if($idLivre) $sql .= "WHERE l.id_livre = ".$idLivre;
 		$sql .= " GROUP BY i.id_livre ";
 		//aucun filtre sur les livres
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    $rs = $db->fetchAll();
	    if($idLivre && count($rs>0))$rs = $rs[0]; else false;
	    return $rs;
    }    

	/**
     * récupère les informations d'un livre
     * 
     * @param	int			$id
     * @param	boolean		$min
     *
     * @return array
     */
    public function findInfos($id, $min=false)
    {
	 	if($min)
		 	$sql = "SELECT 
			l.* 
			, GROUP_CONCAT(i.id_isbn) idsIsbn, GROUP_CONCAT(i.date_parution) date_parution, GROUP_CONCAT(i.num) isbn 
			, GROUP_CONCAT(DISTINCT s.id_serie, ',', s.titre_fr, ',', s.titre_en SEPARATOR ':') series
			, GROUP_CONCAT(DISTINCT c.id_comite, ',', c.titre_fr, ',', c.titre_en SEPARATOR ':') comites
			FROM iste_livre l
			INNER JOIN iste_isbn i ON i.id_livre = l.id_livre
			LEFT JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
			LEFT JOIN iste_serie s ON s.id_serie = ls.id_serie
			LEFT JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
			LEFT JOIN iste_comite c ON c.id_comite = cl.id_comite
			WHERE l.id_livre =".$id."
			GROUP BY l.id_livre";
    		else
		 	$sql = "SELECT 
		l.* 
		, GROUP_CONCAT(DISTINCT a.prenom, ' ',a.nom, ':', la.role) auteurs
		, GROUP_CONCAT(i.id_isbn, ',', i.num, ',', i.type, ',', i.date_parution, ',', i.nb_page SEPARATOR ':') isbns
		, GROUP_CONCAT(e.nom) editeur
		, GROUP_CONCAT(p.prix_dollar, ',', p.prix_euro, ',', p.prix_livre SEPARATOR ':') prix
		, GROUP_CONCAT(DISTINCT s.id_serie, ',', s.titre_fr, ',', s.titre_en SEPARATOR ':') series
		, GROUP_CONCAT(DISTINCT c.id_comite, ',', c.titre_fr, ',', c.titre_en SEPARATOR ':') comites
		, GROUP_CONCAT(DISTINCT fic.id_importfic, ',', fic.type, ',', fic.url SEPARATOR ':') fics
		FROM iste_livre l
		INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre
		INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
		INNER JOIN iste_isbn i ON i.id_livre = l.id_livre
		LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur
		LEFT JOIN iste_prix p ON p.id_isbn = i.id_isbn AND p.type = 'prix catalogue'
		LEFT JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
		LEFT JOIN iste_serie s ON s.id_serie = ls.id_serie
		LEFT JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
		LEFT JOIN iste_comite c ON c.id_comite = cl.id_comite
		LEFT JOIN iste_importfic fic ON fic.obj = 'livre' AND fic.id_obj = l.id_livre 
		WHERE l.id_livre =".$id;

	 	
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	$arr = $db->fetchAll();
	    	return $arr[0];
    }    


	/**
     * récupère les informations d'un livre
     *
     * @return array
     */
    public function getTresorie()
    {
    		/*
    		 * Nom auteur
Titre FR ou GB sur des lignes indépendantes
Nbre Pages prévision GB (le plus récent dans l’historique)
Nbre Pages prévision FR (le plus récent dans l’historique)
Langue du manuscrit : FR ou GB
Publication prévue FR = 1 si OUI / 0 si NON
Publication prévue GB = 1 si OUI / 0 si NON
Si c’est une traduction ou pas (coder 1= traduction ou 0 ) 
Date de remise prévue du manuscrit
Date de réception du manuscrit
Date de réception de la traduction
Date de publication GB
Date de publication FR
Editeur Wiley ou Elsevier (coder 1 pour Wiley ou 2 pour Elsevier)
    		 */
    	
	 	$sql = "SELECT 
		GROUP_CONCAT(DISTINCT a.nom, ' ',a.prenom, ':', la.role) auteurs
		,l.titre_en 
		,l.titre_fr 
		,pGB.nombre 'Nbre Pages prévision GB'
		,pFR.nombre 'Nbre Pages prévision FR'
        , ELT(FIND_IN_SET(p.langue,'Français,Anglais'), 'FR', 'GB') 'Langue du manuscrit'
        ,p.publication_en 'Publication prévue GB'
        ,p.publication_fr 'Publication prévue FR'
        , FIELD(p.traduction,'français -> anglais') 'traduction'
		, pre1.prevision 'Date de remise prévue du manuscrit'
		, pre1.fin 'Date de réception du manuscrit'
		, pre2.fin 'Date de réception de la traduction'
		, pre3.fin 'Date de publication GB'
		, pre4.fin 'Date de publication FR'
		, FIND_IN_SET(e.nom,'Wiley,Elsevier') editeur
		FROM iste_livre l
		INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre
		INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
		INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
		INNER JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre AND pl.id_processus = 3
        INNER JOIN iste_prevision pre1 ON pre1.id_pxu = pl.id_plu AND pre1.id_tache = 15
        INNER JOIN iste_prevision pre2 ON pre2.id_pxu = pl.id_plu AND pre2.id_tache = 16
        INNER JOIN iste_prevision pre3 ON pre3.id_pxu = pl.id_plu AND pre3.id_tache = 17
        INNER JOIN iste_prevision pre4 ON pre4.id_pxu = pl.id_plu AND pre4.id_tache = 18
		INNER JOIN iste_isbn i ON i.id_livre = l.id_livre
		LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur
        LEFT JOIN iste_page pGB ON pGB.id_livre = l.id_livre AND
			pGB.maj = (SELECT MAX(pGBm.maj) FROM iste_page pGBm WHERE pGBm.id_livre = pGB.id_livre AND pGBm.type = 'prévu GB')
        LEFT JOIN iste_page pFR ON pFR.id_livre = l.id_livre AND
			pFR.maj = (SELECT MAX(pFRm.maj) FROM iste_page pFRm WHERE pFRm.id_livre = pFR.id_livre AND pFRm.type = 'prévu FR')
		WHERE i.date_parution IS NULL OR i.date_parution > NOW()
		GROUP BY l.id_livre";
 	
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }     
	/**
     * récupère les livres où il manque des propositions
     *
     * @return array
     */
    public function findPropManques()
    {
 		$sql = "SELECT 
		 l.id_livre
		FROM iste_livre l
			LEFT JOIN iste_proposition p ON p.id_livre = l.id_livre
		WHERE
			p.id_livre IS NULL  
		ORDER BY l.id_livre 	";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }    
	/**
     * récupère les livres où il manque des propositions
     *     
     * @return array
     */
    public function findProcessManques()
    {
 		$sql = "SELECT 
			l.id_livre
			 , GROUP_CONCAT(pl.id_processus ORDER BY pl.id_processus) pid
			FROM iste_livre l
			LEFT JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre
			GROUP BY l.id_livre
			ORDER BY pid ";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }    
    
	/**
     * récupère les livres où il manque des isbn
     *     
     * @return array
     */
    public function findIsbnManques()
    {
 		$sql = "SELECT 
			 l.id_livre
			FROM iste_livre l
				LEFT JOIN iste_isbn i ON i.id_livre = l.id_livre
			WHERE
				i.id_livre IS NULL  
			ORDER BY l.id_livre ";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }    
    
	/**
     * récupère les nb de page
     *     
     * @return array
     */
    public function getNbPage()
    {
 		$sql = "SELECT l.id_livre
			, p.nb_page_en, p.nb_page_fr 
			, i.nb_page, i.type
			FROM iste_livre l
			LEFT JOIN iste_proposition p ON p.id_livre = l.id_livre AND (nb_page_fr > 0 OR nb_page_en > 0)
			LEFT JOIN iste_isbn i ON i.id_livre = l.id_livre AND nb_page > 0 ";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }    
    
	/**
     * récupère l'état pour les éditeur
     * 
     * @param int $idEditeur
     * 
     * @return array
     */
    public function getEtatEditeur($idEditeur)
    {
 		$sql = "SELECT 
			i.num 'ISBN'
			, GROUP_CONCAT(DISTINCT IFNULL(a.nom,'') , ' ', IFNULL(a.prenom,'') SEPARATOR ', ') 'AUTHOR(s)'
			, l.titre_en 'TITLE', l.soustitre_en 'SUBTITLE', l.type_2 'TYPE 2', l.type_1 'TYPE 1'
			, s.titre_en 'Set Title'
			, c.titre_en 'Catalog Section'
			, MAX(pa.nombre) 'ISTE Pages (projected)'
			, pm.prevision 'ISTE MS due date'
			, 0 'ISTE MS in production'
			, pp.prevision 'ISTE MS pud date'
			, pr.prix_dollar 'ISTE Proposed Price (USD)'
			FROM iste_livre l
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre AND i.id_editeur = ".$idEditeur."
				INNER JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
				INNER JOIN iste_serie s ON s.id_serie = ls.id_serie
			    INNER JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
			    INNER JOIN iste_comite c ON c.id_comite = cl.id_comite
				INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
				INNER JOIN iste_livrexauteur la ON la.id_livre = ls.id_livre AND la.role = 'auteur'
			    INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
			    INNER JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre AND pl.id_processus = 3
			    LEFT JOIN iste_prevision pp ON pp.id_pxu = pl.id_plu AND pp.id_tache = 17
			    LEFT JOIN iste_prevision pm ON pm.id_pxu = pl.id_plu AND pm.id_tache = 15
			    LEFT JOIN iste_prix pr ON pr.id_isbn = i.id_isbn AND pr.type = 'prix catalogue'
			    LEFT JOIN iste_page pa ON pa.id_livre = l.id_livre AND (pa.type = 'prévu GB' OR pa.type = 'pr&#233;vu')			    
			GROUP BY i.id_isbn
			ORDER BY i.num";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }    
    
	/**
     * récupère l'état pour le suivi
     * 
     * @param string $ids
     * 
     * @return array
     */
    public function getEtatSuivi($ids)
    {
 		$sql = "SELECT 
			l.id_livre, l.titre_fr, l.soustitre_fr, l.titre_en, l.soustitre_en, l.type_1, l.type_2
			, GROUP_CONCAT(DISTINCT IFNULL(a.nom,'') , ' ', IFNULL(a.prenom,'') ORDER BY la.ordre SEPARATOR ', ') 'auteur'
			, GROUP_CONCAT(DISTINCT IFNULL(co.nom,'') , ' ', IFNULL(co.prenom,'') ORDER BY lac.ordre SEPARATOR ', ') 'coordonateur'			
			, GROUP_CONCAT(DISTINCT IFNULL(ad.nom,'') , ' ', IFNULL(ad.prenom,'') ORDER BY lad.ordre SEPARATOR ', ') 'directeur'
			, GROUP_CONCAT(DISTINCT IFNULL(ar.nom,'') , ' ', IFNULL(ar.prenom,'') ORDER BY las.ordre SEPARATOR ', ') 'resp. série'
			,iW.num 'ISBN Wiley', CONCAT(IFNULL(iW.date_parution,''), IFNULL(iE.date_parution,'')) 'Fin Parution GB'
			,iE.num 'ISBN Elsevier'
			,iI.num 'ISBN ISTE', iI.date_parution 'Fin Parution FR'
			
		    , GROUP_CONCAT(DISTINCT IFNULL(s.titre_en,'') , ' / ', IFNULL(s.titre_fr,'') SEPARATOR ', ') 'Série'
			-- , GROUP_CONCAT(DISTINCT IFNULL(aSerie.prenom,'') , ' ', IFNULL(aSerie.nom,'') SEPARATOR ', ') 'Resp. de la Série'
		
		    , GROUP_CONCAT(DISTINCT IFNULL(c.titre_en,'') , ' / ', IFNULL(c.titre_fr,'') SEPARATOR ', ') 'Comité'
			-- , GROUP_CONCAT(DISTINCT IFNULL(aCom.prenom,'') , ' ', IFNULL(aCom.nom,'') SEPARATOR ', ') 'Directeur du comite'
		
			, l.production
			
			, eFR.nom 'Editeur FR'
			, eGB.nom 'Editeur GB'
			
		    , MAX(pa.nombre) 'Pages Prévu'
		    , MAX(pfGB.nombre) 'Pages final GB'
		    , MAX(pfFR.nombre) 'Pages final FR'
		    
			, pm.prevision 'Prévision de réception du manuscrit'
		    , pm.commentaire 'réception du manuscrit commentaire'
			
		    , pt.prevision 'Prévision de réception de la traduction'
			
		    , pp.prevision 'Prévisions de parution GB'
		
		    , ppr.debut 'Gestion de proposal origine'
		    , ppr.fin 'Gestion de proposal fin'
		    , ppr.commentaire 'Gestion de proposal commentaire'
		
		    , ppc.debut 'Gestion de contrat origine'
		    , ppc.fin 'Gestion de contrat fin'
		    , ppc.commentaire 'Gestion de contrat commentaire'
		
			, MAX(pr.prix_dollar) 'Prix catalogue dollar'
			-- , prp.prix_dollar 'Prix papier GB livre'
		
			FROM iste_livre l
				LEFT JOIN iste_isbn iW ON iW.id_livre = l.id_livre AND iW.id_editeur = 5
				LEFT JOIN iste_isbn iE ON iE.id_livre = l.id_livre AND iE.id_editeur = 4
				LEFT JOIN iste_isbn iI ON iI.id_livre = l.id_livre AND iI.id_editeur = 1
				
				LEFT JOIN iste_editeur eFR ON eFR.id_editeur = iI.id_editeur
				LEFT JOIN iste_editeur eGB ON eGB.id_editeur = iE.id_editeur	OR eGB.id_editeur = iW.id_editeur								
				
				LEFT JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
				LEFT JOIN iste_serie s ON s.id_serie = ls.id_serie
				-- INNER JOIN iste_coordination coo ON coo.id_serie = s.id_serie
				-- INNER JOIN iste_auteur aSerie ON aSerie.id_auteur = coo.id_auteur
		
				LEFT JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
				LEFT JOIN iste_comite c ON c.id_comite = cl.id_comite
				-- INNER JOIN iste_comitexauteur ca ON ca.id_comite = c.id_comite
				-- INNER JOIN iste_auteur aCom ON aCom.id_auteur = ca.id_auteur
		
				INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
		
				LEFT JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.role = 'auteur'
				LEFT JOIN iste_auteur a ON a.id_auteur = la.id_auteur
		
				LEFT JOIN iste_livrexauteur lad ON lad.id_livre = l.id_livre AND lad.role = 'directeur'
				LEFT JOIN iste_auteur ad ON ad.id_auteur = lad.id_auteur
		
				LEFT JOIN iste_livrexauteur las ON las.id_livre = l.id_livre AND las.role = 'resp. série'
				LEFT JOIN iste_auteur ar ON ar.id_auteur = las.id_auteur

				LEFT JOIN iste_livrexauteur lac ON lac.id_livre = l.id_livre AND lac.role = 'coordonnateur'
				LEFT JOIN iste_auteur co ON co.id_auteur = lac.id_auteur				
				
				LEFT JOIN iste_processusxlivre pl ON pl.id_livre = l.id_livre AND pl.id_processus = 3
				LEFT JOIN iste_prevision pt ON pt.id_pxu = pl.id_plu AND pt.id_tache = 16
				LEFT JOIN iste_prevision pm ON pm.id_pxu = pl.id_plu AND pm.id_tache = 15
				LEFT JOIN iste_prevision pp ON pp.id_pxu = pl.id_plu AND pp.id_tache = 17        
				LEFT JOIN iste_prevision ppr ON ppr.id_pxu = pl.id_plu AND ppr.id_tache = 25
		
				LEFT JOIN iste_processusxlivre plc ON plc.id_livre = l.id_livre AND plc.id_processus = 3
				LEFT JOIN iste_prevision ppc ON ppc.id_pxu = plc.id_plu AND ppc.id_tache = 37
		
				LEFT JOIN iste_prix pr ON (pr.id_isbn = iW.id_isbn OR pr.id_isbn = iE.id_isbn OR pr.id_isbn = iI.id_isbn)  AND pr.type = 'prix catalogue'
				LEFT JOIN iste_prix prp ON (prp.id_isbn = iW.id_isbn OR prp.id_isbn = iE.id_isbn OR prp.id_isbn = iI.id_isbn)  AND prp.type = 'papier GB'
		
				LEFT JOIN iste_page pa ON pa.id_livre = l.id_livre AND (pa.type = 'prévu FR' OR pa.type = 'prévu GB' OR pa.type = 'pr&#233;vu')			    
					AND pa.maj = (SELECT MAX(maj) FROM iste_page WHERE id_livre = l.id_livre AND (type = 'prévu FR' OR type = 'prévu GB' OR type = 'pr&#233;vu'))		    
				LEFT JOIN iste_page pfGB ON pfGB.id_livre = l.id_livre AND (pfGB.type = 'final GB') 
					AND pfGB.maj = (SELECT MAX(maj) FROM iste_page WHERE id_livre = l.id_livre AND (type = 'final GB'))		    
				LEFT JOIN iste_page pfFR ON pfFR.id_livre = l.id_livre AND (pfFR.type = 'final FR')			    
					AND pfFR.maj = (SELECT MAX(maj) FROM iste_page WHERE id_livre = l.id_livre AND (type = 'final FR'))		    
			WHERE l.id_livre IN (".$ids.")
			GROUP BY l.id_livre
 		";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }      
    
    
    
    
}