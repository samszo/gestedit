<?php
/**
 * Ce fichier contient la classe Iste_livrexauteur.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_livrexauteur extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_livrexauteur';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_livrexauteur';
    
    /**
     * Vérifie si une entrée Iste_livrexauteur existe.
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
     * Ajoute une entrée Iste_livrexauteur.
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
	    		return $this->findByLivreAuteurRole($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_livrexauteur avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_livrexauteur.id_livrexauteur = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_livrexauteur avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		$this->delete('iste_livrexauteur.id_livrexauteur = '.$id);
    }


    /**
     * Récupère toutes les entrées Iste_livrexauteur avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_livrexauteur" => "iste_livrexauteur") );
                    
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
     * Recherche une entrée Iste_livrexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_livre
     *
     * @return array
     */
    public function findById_livre($id_livre)
    {
        $query = $this->select()
        		->from( array("la" => "iste_livrexauteur") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("a" => "iste_auteur"),
                'la.id_auteur = a.id_auteur', array("auteur"=>"CONCAT(a.prenom,' ',a.nom)", "recid"=>"la.id_livrexauteur"))
            ->where( "la.id_livre = ?", $id_livre);
        
        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livrexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_auteur
     *
     * @return array
     */
    public function findById_auteur($id_auteur)
    {
        $query = $this->select()
        		->from( array("la" => "iste_livrexauteur") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("a" => "iste_auteur"),
                'la.id_auteur = a.id_auteur', array("auteur"=>"CONCAT(a.prenom,' ',a.nom)", "recid"=>"la.id_livrexauteur"))
        		->where( "la.id_auteur = ?", $idAuteur );
        
        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livrexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $role
     *
     * @return array
     */
    public function findByRole($role)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livrexauteur") )                           
                    ->where( "i.role = ?", $role );

        return $this->fetchAll($query)->toArray(); 
    }
    
	/**
     * Recherche une entrée Iste_livrexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idLivre
     * @param int $idAuteur
     *
     * @return array
     */
    public function findByLivreAuteur($idLivre, $idAuteur)
    {
        $query = $this->select()
        		->from( array("la" => "iste_livrexauteur") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("a" => "iste_auteur"),
                'la.id_auteur = a.id_auteur', array("auteur"=>"CONCAT(a.prenom,' ',a.nom)", "recid"=>"la.id_livrexauteur"))
        		->where( "la.id_auteur = ?", $idAuteur )
            ->where( "la.id_livre = ?", $idLivre );
        		
        return $this->fetchAll($query)->toArray(); 
    }

    	/**
     * Recherche une entrée Iste_coordination avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_auteur
     *
     * @return array
     */
    public function findLivreById_auteur($id_auteur)
    {
        $query = $this->select()
        		->from( array("la" => "iste_livrexauteur") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("l" => "iste_livre"),
                'l.id_livre = la.id_livre', array("titre_fr","titre_en", "recid"=>"id_livre"))
        		->where( "la.id_auteur = ?", $id_auteur );

        return $this->fetchAll($query)->toArray(); 
    }    
	/**
     * Recherche une entrée Iste_livrexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int 		$id
     *
     * @return array
     */
    public function findByLivreAuteurRole($id)
    {
        $query = $this->select()
        		->from( array("la" => "iste_livrexauteur") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("a" => "iste_auteur"),
                'la.id_auteur = a.id_auteur', array("auteur"=>"CONCAT(a.prenom,' ',a.nom)", "recid"=>"la.id_livrexauteur"))
        		->where( "la.id_livrexauteur = ?", $id);
        		
        return $this->fetchAll($query)->toArray(); 
    }
    
}
