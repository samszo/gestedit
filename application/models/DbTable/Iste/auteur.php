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
			$select->where($k.' = ?', $v);
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
     * Récupère toutes les entrées Iste_auteur avec certains critères
     * de tri, intervalles
     */
    public function getAll($order="a.nom", $limit=0, $from=0)
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

        return $this->fetchAll($query)->toArray(); 
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
    
    
}
