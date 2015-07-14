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
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
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
			->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = r.id_auteur', array("auteur"=>"CONCAT(IFNULL(nom,''),' ',IFNULL(prenom,''))"))
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
     * @param int $id_auteur
     *
     * @return array
     */
    public function findById_auteur($id_auteur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.id_auteur = ?", $id_auteur );

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
			->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = r.id_auteur', array("auteur"=>"CONCAT(IFNULL(nom,''),' ',IFNULL(prenom,''))"))
			->where( "i.id_livre = ?", $idLivre);

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
                'v.id_vente = r.id_vente', array("nb"=>"SUM(nombre)", "dMin"=>"MIN(date_vente)", "dMax"=>"MAX(date_vente)"))
        		->joinInner(array("i" => "iste_isbn"),'v.id_isbn = i.id_isbn',array("nbIsbn"=>"COUNT(DISTINCT(v.id_isbn))"))
			->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = r.id_auteur', array("auteur"=>"CONCAT(IFNULL(nom,''),' ',IFNULL(prenom,''))"))
        		->group("auteur");
        	if($idLivre){
				$query->where( "i.id_livre = ?", $idLivre);        		
        	}

        return $this->fetchAll($query)->toArray(); 
    }    
    
	/**
     * Calcule les royalties pour les auteurs
     *
     * @return array
     */
    public function setForAuteur()
    {
    	//récupère les vente qui n'ont pas de royalty
    	$sql = "SELECT 
			GROUP_CONCAT(DISTINCT ac.id_auteur) idsA,
		    COUNT(DISTINCT ac.id_auteur) nbA,
		    ac.id_isbn, ac.pc_papier, ac.pc_ebook
		 , v.id_vente, v.date_vente, v.montant_euro, v.boutique
		 , i.id_editeur, i.type
		 , d.id_devise, d.taux_euro_dollar, d.taux_euro_livre
		FROM iste_auteurxcontrat ac
		 INNER JOIN iste_vente v ON v.id_isbn = ac.id_isbn
		 INNER JOIN iste_isbn i ON i.id_isbn = v.id_isbn
		 INNER JOIN iste_livrexauteur la ON la.id_livre = i.id_livre AND la.id_auteur = ac.id_auteur AND la.role = 'auteur'
		 INNER JOIN iste_devise d on
				    DATE_FORMAT(date_taux, '%d-%m-%Y') = DATE_FORMAT(date_vente, '%d-%m-%Y')
		 LEFT JOIN iste_royalty r ON r.id_vente = v.id_vente AND r.id_auteur = ac.id_auteur
		WHERE pc_papier is not null AND pc_ebook is not null AND pc_papier != 0 AND pc_ebook != 0
			AND v.montant_euro > 0
		    AND r.id_royalty is null
		GROUP BY v.id_vente";

    		$stmt = $this->_db->query($sql);
    		$rs = $stmt->fetchAll(); 
    		$arrResult = array();
    		foreach ($rs as $r) {
    			//récupère les auteurs
    			$arrA = explode(",", $r["idsA"]);
    			foreach ($arrA as $a) {
    				//calcule les royalties
    				$mtE = floatval($r["montant_euro"]) / intval($r["nbA"]);
    				$mtE *= floatval($r["pc_papier"])/100;
    				$mtD = $mtE*floatval($r["taux_euro_dollar"]);
    				$mtL = $mtE*floatval($r["taux_euro_livre"]);
    				//ajoute les royalties pour l'auteur et la vente
	    			$arrResult[]= $this->ajouter(array("pourcentage"=>$r["pc_papier"],"id_devise"=>$r["id_devise"],"id_vente"=>$r["id_vente"],"id_auteur"=>$a,"montant_euro"=>$mtE,"montant_livre"=>$mtL,"montant_dollar"=>$mtD),true,true);
    			}
    		}
    		
    		return $arrResult;
    }
    
}
