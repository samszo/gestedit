<?php
/**
 * Ce fichier contient la classe Iste_isbn.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_isbn extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_isbn';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_isbn';
    
    /**
     * Vérifie si une entrée Iste_isbn existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_isbn'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_isbn; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_isbn.
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
	    	}else return "existe";
	    	if($rs)
			return $this->findById_isbn($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_isbn avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_isbn.id_isbn = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_isbn avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_isbn.id_isbn = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_isbn avec la clef de lieu
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
     * Récupère toutes les entrées Iste_isbn avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_isbn" => "iste_isbn") );
                    
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
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_isbn
     *
     * @return array
     */
    public function findById_isbn($id_isbn)
    {
        $query = $this->select()
			->from( array("i" => "iste_isbn") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("iid" => "iste_isbn"),
                'i.id_isbn = iid.id_isbn', array("recid"=>"id_isbn"))
            ->where( "i.id_isbn = ?", $id_isbn );
			
        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_livre
     *
     * @return array
     */
    public function findById_livre($id_livre)
    {
        $query = $this->select()
			->from( array("i" => "iste_isbn") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("iid" => "iste_isbn"),
                'i.id_isbn = iid.id_isbn', array("recid"=>"id_isbn"))
			->where( "i.id_livre = ?", $id_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_editeur
     *
     * @return array
     */
    public function findById_editeur($id_editeur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.id_editeur = ?", $id_editeur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_licence
     *
     * @return array
     */
    public function findById_licence($id_licence)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.id_licence = ?", $id_licence );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $num
     *
     * @return array
     */
    public function findByNum($num)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.num = ?", $num );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $tirage
     *
     * @return array
     */
    public function findByTirage($tirage)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.tirage = ?", $tirage );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $nb_page
     *
     * @return array
     */
    public function findByNb_page($nb_page)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.nb_page = ?", $nb_page );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $cout_total
     *
     * @return array
     */
    public function findByCout_total($cout_total)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.cout_total = ?", $cout_total );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $cout_page
     *
     * @return array
     */
    public function findByCout_page($cout_page)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.cout_page = ?", $cout_page );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $prix_catalogue
     *
     * @return array
     */
    public function findByPrix_catalogue($prix_catalogue)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.prix_catalogue = ?", $prix_catalogue );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $devise
     *
     * @return array
     */
    public function findByDevise($devise)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.devise = ?", $devise );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $date_parution
     *
     * @return array
     */
    public function findByDate_parution($date_parution)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.date_parution = ?", $date_parution );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $type
     *
     * @return array
     */
    public function findByType($type)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.type = ?", $type );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
