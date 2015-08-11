<?php
/**
 * Ce fichier contient la classe Iste_coordination.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_coordination extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_coordination';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_coordination';
    
    /**
     * Vérifie si une entrée Iste_coordination existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_coordination'));
		foreach($data as $k=>$v){
			if($k!="prime")
				$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_coordination; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_coordination.
     *
     * @param array $data
     * @param boolean $existe
     * @param boolean $rs
     *  
     * @return mixed
     */
    public function ajouter($data, $existe=true, $rs=false)
    {    	
	    	$id=false;
	    	if($existe)$id = $this->existe($data);
	    	if(!$id){
	    	 	$id = $this->insert($data);
	    	}
	    	if($rs)
	    		return $this->findByAuteurSerie($data["id_auteur"], $data["id_serie"]);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_coordination avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $idAuteur
     * @param integer $idSerie
     * @param array $data
     *
     * @return void
     */
    public function edit($idAuteur, $idSerie, $data)
    {           	
	    	$this->update($data, 'iste_coordination.id_auteur = ' . $idAuteur.' AND iste_coordination.id_serie = ' . $idSerie);
    }
    
    /**
     * Recherche une entrée Iste_coordination avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $idAuteur
     * @param integer $idSerie
     *
     * @return void
     */
    public function remove($idAuteur, $idSerie)
    {
    		$this->delete('iste_coordination.id_auteur = ' . $idAuteur.' AND iste_coordination.id_serie = ' . $idSerie);
    }

    /**
     * Récupère toutes les entrées Iste_coordination avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_coordination" => "iste_coordination") );
                    
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
     * Recherche une entrée Iste_coordination avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_serie
     *
     * @return array
     */
    public function findById_serie($id_serie)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_coordination") )                           
                    ->where( "i.id_serie = ?", $id_serie );

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
        		->from( array("c" => "iste_coordination") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("s" => "iste_serie"),
                's.id_serie = c.id_serie', array("titre"=>"CONCAT(s.titre_fr,' / ',s.titre_en)", "recid"=>"id_serie"))
        		->where( "c.id_auteur = ?", $id_auteur );

        return $this->fetchAll($query)->toArray(); 
    }
	/**
     * Recherche une entrée Iste_coordination avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idAuteur
     * @param int $idSerie
     *
     * @return array
     */
    public function findByAuteurSerie($idAuteur, $idSerie)
    {
        $query = $this->select()
        		->from( array("i" => "iste_coordination"), array("id_coordination","recid"=>"id_coordination") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("s" => "iste_serie"),
                'i.id_serie = s.id_serie', array("titre"=>"CONCAT(s.titre_fr,' / ',s.titre_en)", "id_serie"))
            ->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = i.id_auteur', array("nom"=>"CONCAT(a.prenom,' ',a.nom)", "id_auteur"))
            ->where( "i.id_serie = ?", $idSerie )
            ->where( "i.id_auteur = ?", $idAuteur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_coordination avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $prime
     *
     * @return array
     */
    public function findByPrime($prime)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_coordination") )                           
                    ->where( "i.prime = ?", $prime );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
