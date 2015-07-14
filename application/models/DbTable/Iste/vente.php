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
	    	if(!$id){
	    	 	$id = $this->insert($data);
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
            ->joinInner(array("l" => "iste_licence"),
                'l.id_licence = v.id_licence', array("id_licence","licence"=>"CONCAT(nom,' ',IFNULL(licence_unitaire,''),' ',IFNULL(licence_coef,'- '),'% ',IFNULL(licence_illimite,''),' ',IFNULL(mutiplicateur,''))"))
            ->joinInner(array("i" => "iste_isbn"),
                'v.id_isbn = i.id_isbn', array())
			->where( "i.id_livre = ?", $idLivre);

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
        		->from( array("v" => "iste_vente"), array("tot_e"=>"SUM(montant_euro)","tot_l"=>"SUM(montant_livre)","tot_d"=>"SUM(montant_dollar)"
        			,"boutique", "nbIsbn"=>"COUNT(DISTINCT(v.id_isbn))", "nb"=>"SUM(nombre)", "dMin"=>"MIN(date_vente)", "dMax"=>"MAX(date_vente)"
        			,"nbA"=>"COUNT(DISTINCT(v.acheteur))"
        			))
        		->group("boutique");
        	if($idLivre){
        		$query->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
        			->joinInner(array("i" => "iste_isbn"),'v.id_isbn = i.id_isbn')
				->where( "i.id_livre = ?", $idLivre);        		
        	}

        return $this->fetchAll($query)->toArray(); 
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
    
}
