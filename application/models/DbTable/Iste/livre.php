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
    		$n = array();
        $dt = $this->getDependentTables();
        foreach($dt as $t){
	        	$dbT = new $t($this->_db);
	        	switch ($t) {
	        		case "Model_DbTable_Iste_isbn":
	        			$n[$t] = $dbT->removeLivre($id);
	        		break;
	        		case "Model_DbTable_Iste_prevision":
				    	$n[$t] = $dbT->delete('id_pxu ='.$id.' AND obj="livre"');	        		
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
            		,array("id"=>$this->_primary[1],"text"=>"CONCAT(titre_fr, '/', titre_en)"))
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
     * 
     * 
     */
    public function getAll($order=null, $limit=0, $from=0, $where=null)
    {
   	
	    	$query = $this->select()
			->from( array("l" => "iste_livre") )
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("lid" => "iste_livre"),
                'l.id_livre = lid.id_livre', array("recid"=>"id_livre"))
            /*
            ->joinLeft(array("la" => "iste_livrexauteur"),
                'la.id_livre = l.id_livre', array())
            ->joinLeft(array("a" => "iste_auteur"),
                'a.id_auteur = la.id_auteur', array("auteurs"=>"GROUP_CONCAT(DISTINCT(CONCAT(a.prenom,' ',a.nom)))"))
            ->joinLeft(array("i" => "iste_isbn"),
                'i.id_livre = l.id_livre', array("isbns"=>"GROUP_CONCAT(DISTINCT(i.num))"))
            ->group("l.id_livre")
            */
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
			, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d, GROUP_CONCAT(DISTINCT(v.boutique)) boutiques			
			, MAX(v.date_vente) date_last , MIN(v.date_vente) date_first			
			, SUM(r.montant_euro) mt_e_r			
			FROM iste_livre l
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
				INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
				INNER JOIN (SELECT GROUP_CONCAT(DISTINCT(CONCAT(a.prenom,' ',a.nom))) auteurs, la.id_livre
				FROM iste_auteur a 
				INNER JOIN iste_livrexauteur la ON a.id_auteur = la.id_auteur
				GROUP BY la.id_livre
				) ca ON ca.id_livre = l.id_livre
				LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente
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
    public function getIdLivreVente($idLivre, $resume=true)
    {
		$sql = "SELECT 	
			l.id_livre recid, CONCAT(IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,'')) titre
			, ca.auteurs
			, GROUP_CONCAT(DISTINCT(i.num)) isbns
			, SUM(v.nombre) nb_vente , SUM(v.montant_euro) mt_e , SUM(v.montant_livre) mt_l, SUM(v.montant_dollar) mt_d, GROUP_CONCAT(DISTINCT(v.boutique)) boutiques			
			, MAX(v.date_vente) date_last , MIN(v.date_vente) date_first			
			FROM iste_livre l
				INNER JOIN iste_isbn i ON i.id_livre = l.id_livre 
				INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
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
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param array $arrWhere
     *
     * @return array
     */
    public function findId($arrWhere)
    {
	$sql = "SELECT GROUP_CONCAT(DISTINCT l.id_livre) ids
		FROM iste_livre l ";
	    	//echo $sql."<br/>";
	    	foreach ($arrWhere as $w) {
	    		//création de l'opérateur
	    		//print_r($w);
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
					$nop = str_replace("id_serie", "s.titre_fr", $op)." OR ".str_replace("id_serie", "s.titre_en", $op);
					$sql .= "INNER JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
					INNER JOIN iste_serie s ON s.id_serie = ls.id_serie AND (".$nop.")";
				break;
				case "id_comite":
					$nop = str_replace("id_comite", "c.titre_fr", $op)." OR ".str_replace("id_comite", "c.titre_en", $op);
					$sql .= "INNER JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
					INNER JOIN iste_comite c ON c.id_comite = cl.id_comite AND (".$nop.")";
				break;
				case "num":
					$sql .= "INNER JOIN iste_isbn i ON i.id_livre = l.id_livre AND ".$op;
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
	/**
     * récupère les livres à produire
     *
     * @return array
     */
    public function getProductionLivre()
    {
 	$sql = "SELECT 
			i.id_isbn recid, i.date_parution, i.num isbn, i.nb_page 
			, GROUP_CONCAT(DISTINCT CONCAT(a.prenom, ' ', a.nom)) auteurs
			, l.titre_fr, l.soustitre_fr, l.titre_en, l.soustitre_en, l.type_2, l.id_livre
		    , p.traduction, p.langue
		    , GROUP_CONCAT(DISTINCT e.nom) editeur
		FROM iste_livre l
			INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.role = 'auteur'
			INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur 
			LEFT JOIN iste_isbn i ON i.id_livre = l.id_livre 
			LEFT JOIN iste_proposition p ON p.id_livre = l.id_livre     
			LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur 
		GROUP BY i.id_livre";
 		//aucun filtre sur les livres
		//WHERE i.date_parution is null OR i.date_parution < now()
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }    

	/**
     * récupère les informations d'un livre
     * 
     * @param	int	$id
     *
     * @return array
     */
    public function findInfos($id)
    {
 	$sql = "SELECT 
		l.* 
		, GROUP_CONCAT(DISTINCT a.prenom, ' ',a.nom, ':', la.role) auteurs
		, i.id_isbn, i.num, i.type, i.date_parution
		, e.id_editeur, e.nom
		, p.prix_dollar, p.prix_euro, p.prix_livre
		, GROUP_CONCAT(DISTINCT ls.id_serie) idsSerie
		, GROUP_CONCAT(DISTINCT cl.id_comite) idsComite
		FROM iste_livre l
		INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre
		INNER JOIN iste_auteur a ON a.id_auteur = la.id_auteur
		INNER JOIN iste_isbn i ON i.id_livre = l.id_livre
		INNER JOIN iste_editeur e ON e.id_editeur = i.id_editeur
		INNER JOIN iste_prix p ON p.id_isbn = i.id_isbn AND p.type = 'prix catalogue'
		INNER JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
		INNER JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
		WHERE l.id_livre = ".$id;
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }    
    

    
}