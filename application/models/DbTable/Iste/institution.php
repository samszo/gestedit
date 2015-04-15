<?php
/**
 * Ce fichier contient la classe Iste_institution.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_institution extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_institution';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_institution';
    
    /**
     * Vérifie si une entrée Iste_institution existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_institution'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_institution; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_institution.
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
     * Recherche une entrée Iste_institution avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_institution.id_institution = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_institution avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_institution.id_institution = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_institution avec la clef de lieu
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
     * Récupère toutes les entrées Iste_institution avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_institution" => "iste_institution") );
                    
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
     * Recherche une entrée Iste_institution avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_institution
     *
     * @return array
     */
    public function findById_institution($id_institution)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_institution") )                           
                    ->where( "i.id_institution = ?", $id_institution );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_institution avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $id_parent
     *
     * @return array
     */
    public function findById_parent($id_parent)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_institution") )                           
                    ->where( "i.id_parent = ?", $id_parent );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_institution avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nom
     *
     * @return array
     */
    public function findByNom($nom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_institution") )                           
                    ->where( "i.nom = ?", $nom );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_institution avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $adresse
     *
     * @return array
     */
    public function findByAdresse($adresse)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_institution") )                           
                    ->where( "i.adresse = ?", $adresse );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_institution avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $ville
     *
     * @return array
     */
    public function findByVille($ville)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_institution") )                           
                    ->where( "i.ville = ?", $ville );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_institution avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $code_postal
     *
     * @return array
     */
    public function findByCode_postal($code_postal)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_institution") )                           
                    ->where( "i.code_postal = ?", $code_postal );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_institution avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $pays
     *
     * @return array
     */
    public function findByPays($pays)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_institution") )                           
                    ->where( "i.pays = ?", $pays );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_institution avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $telephone
     *
     * @return array
     */
    public function findByTelephone($telephone)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_institution") )                           
                    ->where( "i.telephone = ?", $telephone );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
