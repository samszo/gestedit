<?php
/**
 * Ce fichier contient la classe Iste_royalty.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_royalty extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_royalty';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_royalty';
    
    /**
     * Vérifie si une entrée Iste_royalty existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_royalty'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_royalty; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_royalty.
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
	    	if($rs) return $this->findById_royalty($id);
	    else return $id;
    } 
           
    /**
     * Recherche une entrée Iste_royalty avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer 	$id
     * @param array 		$data
     * @param string 	$ids
     *
     * @return void
     */
    public function edit($id, $data, $ids=false)
    {   
    		if(isset($data['royIds'])){
    			$ids = $data['royIds'];
    			unset($data['royIds']);
    		}
    		if($ids)        	
	    		$this->update($data, 'iste_royalty.id_royalty IN ('.$ids.')');
	    	else
	    		$this->update($data, 'iste_royalty.id_royalty = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_royalty avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
	    	$this->delete('iste_royalty.id_royalty = ' . $id);
    }

    /**
     * Recherche une entrée Iste_royalty avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function removeVente($id)
    {
	    return 	$this->delete('iste_royalty.id_vente = ' . $id);
    }

    /**
     * Recherche une entrée Iste_royalty avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function removeAuteurContrat($id)
    {
	    return 	$this->delete('iste_royalty.id_auteurxcontrat = ' . $id);
    }
    
    
    /**
     * Récupère toutes les entrées Iste_royalty avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_royalty" => "iste_royalty") );
                    
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
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_royalty
     *
     * @return array
     */
    public function findById_royalty($id_royalty)
    {
        $query = $this->select()
			->from( array("r" => "iste_royalty") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("rid" => "iste_royalty"),
                'rid.id_royalty = r.id_royalty', array("recid"=>"id_royalty"))
			->joinInner(array("v" => "iste_vente"),
                'v.id_vente = r.id_vente', array("date_vente"))
			->joinInner(array("i" => "iste_isbn"),
                'v.id_isbn = i.id_isbn', array())
			->joinInner(array("ac" => "iste_auteurxcontrat"),
                'ac.id_auteurxcontrat = r.id_auteurxcontrat', array())
			->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = ac.id_auteur', array("auteur"=>"CONCAT(IFNULL(nom,''),' ',IFNULL(prenom,''))"))
			->where( "r.id_royalty = ?", $id_royalty);

        $rs = $this->fetchAll($query)->toArray(); 
    		if(count($rs)>0)return $rs[0]; else return $rs;
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_vente
     *
     * @return array
     */
    public function findById_vente($id_vente)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.id_vente = ?", $id_vente );

        return $this->fetchAll($query)->toArray(); 
    }
    /**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_rapport
     *
     * @return array
     */
    public function findById_rapport($id_rapport)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.id_rapport = ?", $id_rapport );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idAuteur
     *
     * @return array
     */
    public function findById_auteur($idAuteur)
    {
        $query = $this->select()
			->from( array("r" => "iste_royalty"),array("recid"=>"id_royalty","montant_livre","montant_euro","montant_dollar","taxe_taux","taxe_deduction","pourcentage","date_paiement","date_encaissement","date_edition"))                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
			->joinInner(array("d" => "iste_devise"),
                'd.id_devise = r.id_devise', array("id_devise","base_contrat",'annee'=>"DATE_FORMAT(date_taux,'%Y')"))
            ->joinInner(array("v" => "iste_vente"),
                'v.id_vente = r.id_vente', array("date_vente","montant_vente"=>"v.montant_livre",))
			->joinInner(array("i" => "iste_isbn"),
                'v.id_isbn = i.id_isbn', array("type_isbn"=>"type"))
			->joinInner(array("l" => "iste_livre"),
                'l.id_livre = i.id_livre', array("livre"=>"CONCAT(IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,''))"))
			->joinInner(array("ac" => "iste_auteurxcontrat"),
                'ac.id_auteurxcontrat = r.id_auteurxcontrat', array())
			->joinInner(array("c" => "iste_contrat"),
                'c.id_contrat = ac.id_contrat', array("type_contrat"=>"type"))
			->where( "ac.id_auteur = ?", $idAuteur);
    	
        return $this->fetchAll($query)->toArray(); 
    }

    /**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param string $table
     * @param string $ids
     *
     * @return array
     */
    public function findDetails($table, $ids)
    {
        $query = $this->select()
			->from( array("r" => "iste_royalty"),array("recid"=>"id_royalty","montant_livre","montant_euro","montant_dollar","taxe_taux","taxe_deduction","pourcentage","date_paiement","date_encaissement","date_edition","conversion_livre_euro"))                           
            ->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            /*
			->joinInner(array("d" => "iste_devise"),
                'd.id_devise = r.id_devise', array("id_devise","base_contrat",'annee'=>"DATE_FORMAT(date_taux,'%Y')"))
            */
            ->joinInner(array("v" => "iste_vente"),
                'v.id_vente = r.id_vente', array("type","nombre","date_vente","montant_vente"=>"v.montant_livre"))
			->joinInner(array("i" => "iste_isbn"),
                'v.id_isbn = i.id_isbn', array("type_isbn"=>"type"))
			->joinInner(array("l" => "iste_livre"),
                'l.id_livre = i.id_livre', array("livre"=>"CONCAT(IFNULL(titre_fr,''), ' / ', IFNULL(titre_en,''))"))
			->joinInner(array("ac" => "iste_auteurxcontrat"),
                'ac.id_auteurxcontrat = r.id_auteurxcontrat', array())
            ->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = ac.id_auteur', array("signataire"=>"CONCAT(a.prenom, ' ', a.nom)"))
			->joinInner(array("c" => "iste_contrat"),
                'c.id_contrat = ac.id_contrat', array("type_contrat"=>"type"));
        if($table=='auteur')
           $query->where( "ac.id_auteur IN (".$ids.")");
        if($table=='isbn')
            $query->where( "i.id_isbn IN (".$ids.")");    	
        if($table=='fichier'){
            $query->joinInner(array("imp" => "iste_importdata"),
                'imp.id_importdata = v.id_importdata', array())
                ->where( "imp.id_importfic IN (".$ids.")");    	
        }
        return $this->fetchAll($query)->toArray(); 
    }    
    
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idAuteurContrat
     *
     * @return array
     */
    public function verifEnCoursByIdAuteurContrat($idAuteurContrat)
    {
        $query = $this->select()
			->from( array("r" => "iste_royalty"),array("mtDue"=>"SUM(montant_livre)"))                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
			->where( "r.date_paiement IS NULL OR r.date_paiement != '0000-00-00' OR r.date_encaissement IS NULL OR r.date_encaissement != '0000-00-00'")
			->where( "r.id_auteurxcontrat = ?", $idAuteurContrat);
    	
        return $this->fetchAll($query)->toArray(); 
    	
    }
    
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idLivre
     *
     * @return array
     */
    public function verifEnCoursByIdLivre($idLivre)
    {
        $query = $this->select()
			->from( array("r" => "iste_royalty"),array("mtDue"=>"SUM(montant_livre)"))                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
			->joinInner(array("ac" => "iste_auteurxcontrat"),
                'ac.id_auteurxcontrat = r.id_auteurxcontrat', array())
			->where( "r.date_paiement IS NULL OR r.date_paiement != '0000-00-00' OR r.date_encaissement IS NULL OR r.date_encaissement != '0000-00-00'")
			->where( "ac.id_livre = ?", $idLivre);
    	
        return $this->fetchAll($query)->toArray(); 
    	
    }
    
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $montant_livre
     *
     * @return array
     */
    public function findByMontant_livre($montant_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.montant_livre = ?", $montant_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $montant_euro
     *
     * @return array
     */
    public function findByMontant_euro($montant_euro)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.montant_euro = ?", $montant_euro );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $montant_dollar
     *
     * @return array
     */
    public function findByMontant_dollar($montant_dollar)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.montant_dollar = ?", $montant_dollar );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $taxe_taux
     *
     * @return array
     */
    public function findByTaxe_taux($taxe_taux)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.taxe_taux = ?", $taxe_taux );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $taxe_deduction
     *
     * @return array
     */
    public function findByTaxe_deduction($taxe_deduction)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.taxe_deduction = ?", $taxe_deduction );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $pourcentage
     *
     * @return array
     */
    public function findByPourcentage($pourcentage)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.pourcentage = ?", $pourcentage );

        return $this->fetchAll($query)->toArray(); 
    }
    

	/**
     * Recherche une entrée avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idLivre
     *
     * @return array
     */
    public function findById_livre($idLivre)
    {
        $query = $this->select()
			->from( array("r" => "iste_royalty") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("rid" => "iste_royalty"),
                'rid.id_royalty = r.id_royalty', array("recid"=>"id_royalty"))
			->joinInner(array("v" => "iste_vente"),
                'v.id_vente = r.id_vente', array("date_vente"))
			->joinInner(array("i" => "iste_isbn"),
                'v.id_isbn = i.id_isbn', array())
			->joinInner(array("ac" => "iste_auteurxcontrat"),
                'ac.id_auteurxcontrat = r.id_auteurxcontrat', array())
			->joinInner(array("c" => "iste_contrat"),
                'c.id_contrat = ac.id_contrat', array("type_contrat"=>"type"))
			->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = ac.id_auteur', array("auteur"=>"CONCAT(IFNULL(a.nom,''),' ',IFNULL(prenom,''))"))
			->where( "i.id_livre = ?", $idLivre)
			->group("r.id_royalty");

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
        		->from( array("r" => "iste_royalty"), array("tot_e"=>"SUM(r.montant_euro)","tot_l"=>"SUM(r.montant_livre)","tot_d"=>"SUM(r.montant_dollar)"))
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("v" => "iste_vente"),
                'v.id_vente = r.id_vente', array("montant_vente"=>"SUM(v.montant_livre)","nb"=>"SUM(nombre)", "dMin"=>"MIN(date_vente)", "dMax"=>"MAX(date_vente)"))
        		->joinInner(array("i" => "iste_isbn"),'v.id_isbn = i.id_isbn',array("nbIsbn"=>"COUNT(DISTINCT(v.id_isbn))"))
			->joinInner(array("ac" => "iste_auteurxcontrat"),
                'ac.id_auteurxcontrat = r.id_auteurxcontrat', array())
        		->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = ac.id_auteur', array("auteur"=>"CONCAT(IFNULL(nom,''),' ',IFNULL(prenom,''))"))
        		->group("auteur");
        	if($idLivre){
				$query->where( "i.id_livre = ?", $idLivre);        		
        	}

        return $this->fetchAll($query)->toArray(); 
    }    
    
	/**
     * Calcule les royalties pour les auteurs
     * 
     *
     * @return array
     */
    public function setForAuteur()
    {
            //met à jour les proposition qui n'ont pas de base contrat et qui ne sont pas null
            /*PLUS BESOIN DE BASE CONTRAT
    		$dbP = new Model_DbTable_Iste_proposition();
    		$dbP->update(array("base_contrat"=>null), "base_contrat=''");
            */
	    	//récupère les vente qui n'ont pas de royalty
	    	$sql = "SELECT 
                ac.id_auteurxcontrat
                , ac.id_isbn, ac.pc_papier, ac.pc_ebook
                , a.prenom, a.nom, c.type, IFNULL(a.taxe_uk,'oui') taxe_uk
                ,i.num
                , v.id_vente, v.date_vente, v.montant_livre, v.id_boutique, v.type typeVente
                , i.id_editeur, i.type typeISBN
                , impF.conversion_livre_euro
                -- , d.base_contrat, d.id_devise, d.taux_livre_dollar, d.taux_livre_euro, d.date_taux, d.date_taux_fin, d.taxe_taux, d.taxe_deduction                
                FROM iste_auteurxcontrat ac
                INNER JOIN iste_auteur a ON a.id_auteur = ac.id_auteur
                INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
                INNER JOIN iste_livre l ON l.id_livre = ac.id_livre
                INNER JOIN iste_isbn i ON i.id_livre = l.id_livre
                INNER JOIN iste_proposition p ON p.id_livre = l.id_livre
                INNER JOIN iste_vente v ON v.id_isbn = i.id_isbn
                INNER JOIN iste_importdata impD ON impD.id_importdata = v.id_importdata
                INNER JOIN iste_importfic impF ON impF.id_importfic = impD.id_importfic
                -- INNER JOIN iste_devise d ON d.base_contrat = IFNULL(p.base_contrat,'GB')
                --            AND DATE_FORMAT(date_vente, '%Y') = DATE_FORMAT(date_taux, '%Y')
                LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente AND r.id_auteurxcontrat = ac.id_auteurxcontrat
                WHERE pc_papier is not null AND pc_ebook is not null AND pc_papier != 0 AND pc_ebook != 0
                    AND v.montant_livre > 0
                    AND r.id_royalty is null";

            $stmt = $this->_db->query($sql);
            
    		$rs = $stmt->fetchAll(); 
    		$arrResult = array();
    		foreach ($rs as $r) {
			//calcule les royalties
    			//$mtE = floatval($r["montant_euro"]) / intval($r["nbA"]);
    			//$mtE *= floatval($r["pc_papier"])/100;
    			if($r["typeVente"]=="ebook")$pc = $r["pc_ebook"];
    			else $pc = $r["pc_papier"];
                $mtL = floatval($r["montant_livre"])*floatval($pc)/100;
                //ATTENTION le taux de conversion est passé en paramètre à l'import et le montant des ventes est calculé à ce moment
    			//$mtD = $mtL*floatval($r["taux_livre_dollar"]);
    			$mtE = $mtL*floatval($r['conversion_livre_euro'])/100;;
                //ajoute les royalties pour l'auteur et la vente
                //ATTENTION les taxes de déduction sont calculer lors de l'édition avec le taux de l'année en cours
	    		$arrResult[]= $this->ajouter(array("pourcentage"=>$pc,"id_vente"=>$r["id_vente"]
                    ,"id_auteurxcontrat"=>$r["id_auteurxcontrat"],"montant_euro"=>$mtE,"montant_livre"=>$mtL
                    //,"id_devise"=>$r["id_devise"],"montant_dollar"=>$mtD
                    //,"taxe_taux"=>$r["taxe_taux"],"taxe_deduction"=>$r["taxe_deduction"]
                    ,"conversion_livre_euro"=>$r['conversion_livre_euro'])
                    ,true,true);
    		}
    		
    		return $arrResult;
    }
    

	

	/**
     * Calcule les paiements pour lancer les éditions
     *
     * @param string		$idsLivre
     * 
     * @return array
     */
    function paiementLivre($idsLivre){
    		
    		//récupère les royalty pour les livres sélectionnés
	    	$sql = "SELECT 
			GROUP_CONCAT(DISTINCT r.id_royalty) idsRoyalty
		    , SUM(v.nombre) vNb, SUM(v.montant_livre) vMtLivre, MIN(v.date_vente) minDateVente, MAX(v.date_vente) maxDateVente
		    , a.id_auteur, a.nom autNom, a.prenom, a.adresse_1, a.adresse_2, a.civilite, a.code_postal, a.ville, a.pays
		    , ac.pc_papier, ac.pc_ebook
		    , c.nom contNom
            , MIN(i.date_parution) parution
		    , l.id_livre, l.titre_en, l.titre_fr
		FROM iste_royalty r 
			INNER JOIN iste_vente v ON v.id_vente = r.id_vente
		    INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		    INNER JOIN iste_livre l ON l.id_livre = i.id_livre AND i.id_livre IN (".$idsLivre.")
		    INNER JOIN iste_auteurxcontrat ac ON ac.id_auteurxcontrat = r.id_auteurxcontrat
		    INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
		    INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.role = c.type
		    INNER JOIN iste_auteur a ON a.id_auteur = ac.id_auteur
		WHERE r.date_paiement IS NULL
		GROUP BY ac.id_auteur, l.id_livre";
		//echo $sql;
    		$stmt = $this->_db->query($sql);
    		
    		return $stmt->fetchAll(); 
    		
    }
    
	/**
     * Calcule les paiements pour lancer les éditions
     *
     * @param string		$idsAuteur
     * 
     * @return array
     */
    function paiementAuteur($idsAuteur){
    		
    		//récupère les royalty pour les auteurs sélectionnés
	    	$sql = "SELECT 
			GROUP_CONCAT(DISTINCT r.id_royalty) idsRoyalty
		    , SUM(v.nombre) vNb, SUM(v.montant_livre) vMtLivre, MIN(v.date_vente) minDateVente, MAX(v.date_vente) maxDateVente
		    , a.id_auteur, a.nom autNom, a.prenom, a.adresse_1, a.adresse_2, a.civilite, a.code_postal, a.ville, a.pays
            , MIN(i.date_parution) parution, GROUP_CONCAT(DISTINCT i.num SEPARATOR ' - ') isbns
		    , l.id_livre, l.titre_en, l.titre_fr
            , d.base_contrat, DATE_FORMAT(d.date_taux,'%Y') annee, d.date_taux, d.date_taux_fin, d.taux_livre_euro, d.taux_livre_dollar, d.taxe_taux, d.taxe_deduction
		FROM iste_royalty r 
			INNER JOIN iste_vente v ON v.id_vente = r.id_vente
		    INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		    INNER JOIN iste_livre l ON l.id_livre = i.id_livre 
		    INNER JOIN iste_auteurxcontrat ac ON ac.id_auteurxcontrat = r.id_auteurxcontrat AND ac.id_auteur IN (".$idsAuteur.")
		    INNER JOIN iste_auteur a ON a.id_auteur = ac.id_auteur
		    INNER JOIN iste_devise d ON d.id_devise = r.id_devise
		WHERE r.date_paiement IS NULL
		GROUP BY ac.id_auteur, l.id_livre
        ORDER BY ac.id_auteur, l.id_livre";
		//echo $sql;
    		$stmt = $this->_db->query($sql);
    		
    		return $stmt->fetchAll(); 
    		
    }    
    
	/**
     * Calcule les paiements pour lancer les éditions
     *
     * @param string		$idsAuteur
     * 
     * @return array
     */
    function paiementAuteurFic($idsAuteur){
    		
        //récupère les royalty pour les auteurs sélectionnés
        $sql = "SELECT 
        GROUP_CONCAT(DISTINCT r.id_royalty) idsRoyalty, r.id_auteurxcontrat,
        GROUP_CONCAT(DISTINCT impD.id_importfic SEPARATOR ',') idsFicImport,
        SUM(v.nombre) vNb,
        SUM(v.montant_livre) vMtLivre,
        MIN(impF.periode_debut) minDateVente,
        MAX(impF.periode_fin) maxDateVente,
        a.id_auteur,
        a.taxe_uk,
        a.paiement_euro,
        a.nom autNom,
        a.prenom,
        a.adresse_1,
        a.adresse_2,
        a.civilite,
        a.code_postal,
        a.ville,
        a.pays
    FROM
        iste_royalty r
            INNER JOIN
        iste_vente v ON v.id_vente = r.id_vente
            INNER JOIN
        iste_importdata impD ON impD.id_importdata = v.id_importdata 
            INNER JOIN
        iste_importfic impF ON impF.id_importfic = impD.id_importfic 
            INNER JOIN
        iste_auteurxcontrat ac ON ac.id_auteurxcontrat = r.id_auteurxcontrat
            -- AND ac.id_auteur IN (".$idsAuteur.")
            INNER JOIN
        iste_auteur a ON a.id_auteur = ac.id_auteur
    WHERE
        r.date_envoi IS NULL
    GROUP BY a.id_auteur
    ORDER BY a.nom, a.prenom";
    //echo $sql;
        $stmt = $this->_db->query($sql);
        
        return $stmt->fetchAll(); 
        
}    

	/**
     * Récupère le détail des royalty
     *
     * @param string		$idsRoy
     * 
     * @return array
     */
    function getDetails($idsRoy){
    		
    		//récupère les royalty pour les livres sélectionnés
	    	$sql = "SELECT 
			COUNT(DISTINCT r.id_royalty) nbRoy
		    ,SUM(v.montant_livre) rMtVente, SUM(v.nombre) unit, v.type typeVente
	    	,SUM(r.montant_livre) rMtRoy
			,MIN(r.taxe_taux) taux, MIN(r.taxe_deduction) deduction, MIN(r.pourcentage) pc
			,i.id_isbn, i.date_parution, i.type typeIsbn, i.num
            ,c.type typeContrat
		FROM iste_royalty r 
			INNER JOIN iste_vente v ON v.id_vente = r.id_vente
			INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		    INNER JOIN iste_auteurxcontrat ac ON ac.id_auteurxcontrat = r.id_auteurxcontrat
		    INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
		WHERE r.id_royalty IN (".$idsRoy.")
		GROUP BY i.id_isbn";
		//echo $sql;
    		$stmt = $this->_db->query($sql);
    		
    		return $stmt->fetchAll(); 
    		
    }    
    
	/**
     * Récupère le détail des royalty pour les livres
     *
     * @param string		$idsRoy
     * 
     * @return array
     */
    function getDetailsLivre($idsRoy){
    		
        //récupère les royalty pour les livres sélectionnés
        $sql = "SELECT 
            COUNT(DISTINCT r.id_royalty) nbRoy
            ,MIN(v.date_vente) perDeb, MAX(v.date_vente) perFin, SUM(v.montant_livre) rMtVente, SUM(v.nombre) unit, v.type typeVente
            ,SUM(r.montant_livre) rMtRoy
            ,MIN(r.pourcentage) pc
            , i.num num, i.type typeISBN
            ,l.id_livre, l.titre_en, l.titre_fr
            ,IFNULL(la.role,' ... ') role
            ,c.type typeContrat, c.param, c.id_contrat
            ,SUM(r.conversion_livre_euro) taux_livre_euro
        FROM iste_royalty r 
            INNER JOIN iste_vente v ON v.id_vente = r.id_vente
            INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
            INNER JOIN iste_livre l ON l.id_livre = i.id_livre
            INNER JOIN iste_auteurxcontrat ac ON ac.id_auteurxcontrat = r.id_auteurxcontrat AND ac.id_livre = l.id_livre
            INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
            LEFT JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.id_auteur = ac.id_auteur
        WHERE r.id_royalty IN (".$idsRoy.")
        GROUP BY l.id_livre, i.id_isbn, v.type
        ";
        //echo $sql;
        $stmt = $this->_db->query($sql);
        
        return $stmt->fetchAll(); 
        
    }       

	/**
     * Récupère le détail des royalty pour les séries
     *
     * @param string		$idsRoy
     * 
     * @return array
     */
    function getDetailsSerie($idsRoy){
    		
        //récupère les royalty pour les livres sélectionnés
        $sql = "SELECT 
            COUNT(DISTINCT r.id_royalty) nbRoy
            ,MIN(v.date_vente) perDeb, MAX(v.date_vente) perFin
            ,SUM(v.montant_livre) rMtVente, SUM(v.nombre) unit, v.type typeVente
            ,SUM(r.montant_livre) rMtRoy
            ,MIN(r.taxe_taux) taux, MIN(r.taxe_deduction) deduction, MIN(r.pourcentage) pc
            ,l.id_livre, l.titre_en, l.titre_fr
            ,c.type typeContrat, c.param
            ,s.id_serie, s.titre_fr, s.titre_en
        FROM iste_royalty r 
            INNER JOIN iste_vente v ON v.id_vente = r.id_vente
            INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
            INNER JOIN iste_livre l ON l.id_livre = i.id_livre
            INNER JOIN iste_livrexserie ls ON ls.id_livre = l.id_livre
            INNER JOIN iste_auteurxcontrat ac ON ac.id_auteurxcontrat = r.id_auteurxcontrat AND ac.id_serie = ls.id_serie
            INNER JOIN iste_serie s ON s.id_serie = ac.id_serie
            INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
        WHERE r.id_royalty IN (".$idsRoy.")
        GROUP BY s.id_serie";
        //echo $sql;
        $stmt = $this->_db->query($sql);
        
        return $stmt->fetchAll(); 
        
    }       

    	/**
     * Récupère le détail des royalty pour les séries
     *
     * @param string		$idsRoy
     * 
     * @return array
     */
    function getDetailsEditoriaux($idsRoy){
    		
        //récupère les royalty pour les livres sélectionnés
        $sql = "SELECT
                COUNT(DISTINCT r.id_royalty) nbRoy
                ,MIN(v.date_vente) perDeb, MAX(v.date_vente) perFin, SUM(v.montant_livre) rMtVente, SUM(v.nombre) unit, v.type typeVente
                ,SUM(r.montant_livre) rMtRoy
                ,MIN(r.pourcentage) pc
                ,l.id_livre, l.titre_en, l.titre_fr
                ,la.role
                ,c.type typeContrat, c.param, c.id_contrat
                ,SUM(r.conversion_livre_euro) taux_livre_euro
            FROM iste_royalty r 
                INNER JOIN iste_vente v ON v.id_vente = r.id_vente
                INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
                INNER JOIN iste_livre l ON l.id_livre = i.id_livre
                INNER JOIN iste_auteurxcontrat ac ON ac.id_auteurxcontrat = r.id_auteurxcontrat 
                INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat AND c.type != 'auteur'
                INNER JOIN iste_livrexauteur la ON la.id_livre = l.id_livre AND la.id_auteur = ac.id_auteur
            WHERE r.id_royalty IN (".$idsRoy.")
            GROUP BY l.id_livre";
        //echo $sql;
        $stmt = $this->_db->query($sql);
        
        return $stmt->fetchAll(); 
        
    }     
	/**
     * Récupère le détail des royalty pour les comite
     *
     * @param string		$idsRoy
     *  
     * @return array
     */
    function getDetailsComite($idsRoy){
    		
        //récupère les royalty pour les livres sélectionnés
        $sql = "SELECT 
            COUNT(DISTINCT r.id_royalty) nbRoy
            ,SUM(v.montant_livre) rMtVente, SUM(v.nombre) unit, v.type typeVente
            ,SUM(r.montant_livre) rMtRoy
            ,MIN(r.taxe_taux) taux, MIN(r.taxe_deduction) deduction, MIN(r.pourcentage) pc
            ,l.id_livre, l.titre_en, l.titre_fr
            ,c.type typeContrat
            ,com.id_comite, com.titre_fr, com.titre_en
        FROM iste_royalty r 
            INNER JOIN iste_vente v ON v.id_vente = r.id_vente
            INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
            INNER JOIN iste_livre l ON l.id_livre = i.id_livre
            INNER JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
            INNER JOIN iste_auteurxcontrat ac ON ac.id_auteurxcontrat = r.id_auteurxcontrat AND ac.id_comite = cl.id_comite
            INNER JOIN iste_comite com ON c.id_comite = ac.id_comite
            INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
        WHERE r.id_royalty IN (".$idsRoy.")
        GROUP BY com.id_comite";
        //echo $sql;
        $stmt = $this->_db->query($sql);
        
        return $stmt->fetchAll(); 
        
    }       

    
	/**
     * Modifie la date pour les royalti
     *
     * @param string		$idsRoy
     *  
     * @return array
     */
    function setDateForRapport($idsRoy){
    		
        //récupère les royalty pour les livres sélectionnés
        $sql = "SELECT 
            COUNT(DISTINCT r.id_royalty) nbRoy
            ,SUM(v.montant_livre) rMtVente, SUM(v.nombre) unit, v.type typeVente
            ,SUM(r.montant_livre) rMtRoy
            ,MIN(r.taxe_taux) taux, MIN(r.taxe_deduction) deduction, MIN(r.pourcentage) pc
            ,l.id_livre, l.titre_en, l.titre_fr
            ,c.type typeContrat
            ,com.id_comite, com.titre_fr, com.titre_en
        FROM iste_royalty r 
            INNER JOIN iste_vente v ON v.id_vente = r.id_vente
            INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
            INNER JOIN iste_livre l ON l.id_livre = i.id_livre
            INNER JOIN iste_comitexlivre cl ON cl.id_livre = l.id_livre
            INNER JOIN iste_auteurxcontrat ac ON ac.id_auteurxcontrat = r.id_auteurxcontrat AND ac.id_comite = cl.id_comite
            INNER JOIN iste_comite com ON c.id_comite = ac.id_comite
            INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
        WHERE r.id_royalty IN (".$idsRoy.")
        GROUP BY com.id_comite";
        //echo $sql;
        $stmt = $this->_db->query($sql);
        
        return $stmt->fetchAll(); 
        
    }       

}
