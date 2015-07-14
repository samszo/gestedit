<?php
/**
 * Ce fichier contient la classe Iste_traducteur.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_traducteur extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_traducteur';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_traducteur';
    
    /**
     * Vérifie si une entrée Iste_traducteur existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_traducteur'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_traducteur; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_traducteur.
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
     * Recherche une entrée Iste_traducteur avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_traducteur.id_traducteur = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_traducteur avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_traducteur.id_traducteur = ' . $id);
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
            		,array("id"=>$this->_primary[1],"text"=>"nom"))
            ->order("nom");        
        return $this->fetchAll($query)->toArray();
	} 
	
    /**
     * Récupère toutes les entrées Iste_traducteur avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_traducteur" => "iste_traducteur") );
                    
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
     * Recherche une entrée Iste_traducteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_traducteur
     *
     * @return array
     */
    public function findById_traducteur($id_traducteur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteur") )                           
                    ->where( "i.id_traducteur = ?", $id_traducteur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_traducteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nom
     *
     * @return array
     */
    public function findByNom($nom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteur") )                           
                    ->where( "i.nom = ?", $nom );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_traducteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $prenom
     *
     * @return array
     */
    public function findByPrenom($prenom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteur") )                           
                    ->where( "i.prenom = ?", $prenom );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_traducteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $telephone
     *
     * @return array
     */
    public function findByTelephone($telephone)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteur") )                           
                    ->where( "i.telephone = ?", $telephone );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_traducteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $adresse
     *
     * @return array
     */
    public function findByAdresse($adresse)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteur") )                           
                    ->where( "i.adresse = ?", $adresse );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_traducteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $ville
     *
     * @return array
     */
    public function findByVille($ville)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteur") )                           
                    ->where( "i.ville = ?", $ville );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_traducteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $code_postal
     *
     * @return array
     */
    public function findByCode_postal($code_postal)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteur") )                           
                    ->where( "i.code_postal = ?", $code_postal );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_traducteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $pays
     *
     * @return array
     */
    public function findByPays($pays)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteur") )                           
                    ->where( "i.pays = ?", $pays );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_traducteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $niveau
     *
     * @return array
     */
    public function findByNiveau($niveau)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_traducteur") )                           
                    ->where( "i.niveau = ?", $niveau );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
