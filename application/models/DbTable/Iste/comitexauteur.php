<?php
/**
 * Ce fichier contient la classe Iste_comitexauteur.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_comitexauteur extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_comitexauteur';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_comite';
    
    /**
     * Vérifie si une entrée Iste_comitexauteur existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_comite'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_comite; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_comitexauteur.
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
	    		return $this->findByAuteurComite($data["id_auteur"], $data["id_comite"]);
	    	else
		    	return $id;
	    	 
    } 
           
    /**
     * Recherche une entrée Iste_comitexauteur avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {           	
	    	$this->update($data, 'iste_comitexauteur.id_comite = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_comitexauteur avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param int $idAuteur
     * @param int $idComite
     *
     * @return void
     */
    public function remove($idAuteur, $idComite)
    {
    		$this->delete('iste_comitexauteur.id_auteur = '.$idAuteur.' AND iste_comitexauteur.id_comite = '.$idComite);
    }
    
    /**
     * Récupère toutes les entrées Iste_comitexauteur avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_comitexauteur" => "iste_comitexauteur") );
                    
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
     * Recherche une entrée avec la valeur spécifiée
     * et copie cette entrée
     *
     * @param int $newId
     * @param int $oldId
     *
     */
    public function copierComite($newId, $oldId)
    {
		$sql = "INSERT INTO iste_comitexauteur (id_comite, id_auteur) 
				SELECT ".$newId.", id_auteur FROM iste_comitexauteur WHERE id_comite = ".$oldId; 	 
	    $this->_db->query($sql);
    }  
        
    	/**
     * Recherche une entrée Iste_comitexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_comite
     *
     * @return array
     */
    public function findById_comite($id_comite)
    {
        $query = $this->select()
			->from( array("i" => "iste_comitexauteur") )                           
            ->where( "i.id_comite = ?", $id_comite );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_comitexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_auteur
     *
     * @return array
     */
    public function findLivreById_auteur($id_auteur)
    {
        $query = $this->select()
        		->from( array("i" => "iste_comitexauteur") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("c" => "iste_comite"),
                'i.id_comite = c.id_comite', array("titre"=>"CONCAT(IFNULL(c.titre_fr,''),' / ',IFNULL(c.titre_en,''),' / ',IFNULL(c.titre_es,''))", "recid"=>"id_comite"))
        		->where( "i.id_auteur = ?", $id_auteur );
        		
        return $this->fetchAll($query)->toArray(); 
    }

    	/**
     * Recherche une entrée Iste_comitexauteur avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idAuteur
     * @param int $idComite
     *
     * @return array
     */
    public function findByAuteurComite($idAuteur, $idComite)
    {
        $query = $this->select()
        		->from( array("i" => "iste_comitexauteur") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("c" => "iste_comite"),
                'i.id_comite = c.id_comite', array("titre"=>"CONCAT(IFNULL(c.titre_fr,''),' / ',IFNULL(c.titre_en,''),' / ',IFNULL(c.titre_es,''))", "recid"=>"id_comite"))
            ->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = i.id_auteur', array("nom"=>"CONCAT(a.prenom,' ',a.nom)", "id_auteur"))
            ->where( "i.id_comite = ?", $idComite )
            ->where( "i.id_auteur = ?", $idAuteur );
        		
        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
