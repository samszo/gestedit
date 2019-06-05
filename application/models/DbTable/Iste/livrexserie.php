<?php
/**
 * Ce fichier contient la classe Iste_livrexserie.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_livrexserie extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_livrexserie';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_livre';
    
    /**
     * Vérifie si une entrée Iste_livrexserie existe.
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
     * Ajoute une entrée Iste_livrexserie.
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
	    	};
	    	if($rs)
	    		return $this->findByLivreSerie($data["id_livre"], $data["id_serie"]);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_livrexserie avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
	   	$this->update($data, 'iste_livrexserie.id_livre = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_livrexserie avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param int $idLivre
     * @param int $idSerie
     *
     * @return void
     */
    public function remove($idLivre, $idSerie)
    {
    		$this->delete('iste_livrexserie.id_serie = ' . $idSerie.' AND iste_livrexserie.id_livre = ' . $idLivre);
    }
    
    /**
     * Récupère toutes les entrées Iste_livrexserie avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    		$query = $this->select()
                    ->from( array("iste_livrexserie" => "iste_livrexserie") );
                    
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
     * Recherche une entrée Iste_livrexserie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_livre
     *
     * @return array
     */
    public function findById_livre($id_livre)
    {
        $query = $this->select()
        		->from( array("ls" => "iste_livrexserie") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("s" => "iste_serie"),
                's.id_serie = ls.id_serie', array("titre"=>"CONCAT(s.titre_fr,' / ',s.titre_en,' / ',s.titre_es)", "recid"=>"id_serie"))
        		->where( "ls.id_livre = ?", $id_livre );
        
        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livrexserie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_serie
     *
     * @return array
     */
    public function findById_serie($id_serie)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livrexserie") )                           
                    ->where( "i.id_serie = ?", $id_serie );

        return $this->fetchAll($query)->toArray(); 
    }
    
	/**
     * Recherche une entrée Iste_livrexserie avec la valeur spécifiée
     * et copie cette entrée
     *
     * @param int $id_serie
     *
     */
    public function copierSerie($newSerie, $oldSerie)
    {
		$sql = "INSERT INTO iste_livrexserie (id_serie, id_livre) 
				SELECT ".$newSerie.", id_livre FROM iste_livrexserie WHERE id_serie = ".$oldSerie; 	 
	    $this->_db->query($sql);
    }    
	/**
     * Recherche une entrée Iste_livrexserie avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idLivre
     * @param int $idSerie
     *
     * @return array
     */
    public function findByLivreSerie($idLivre, $idSerie)
    {
        $query = $this->select()
        		->from( array("ls" => "iste_livrexserie") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("s" => "iste_serie"),
                'ls.id_serie = s.id_serie', array("titre"=>"CONCAT(s.titre_fr,' / ',s.titre_en,' / ',s.titre_es)", "recid"=>"id_serie"))
        		->where( "ls.id_serie = ?", $idSerie )
            ->where( "ls.id_livre = ?", $idLivre );
        		
        return $this->fetchAll($query)->toArray(); 
    }    
            
}
