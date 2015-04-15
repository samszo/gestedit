<?php
/**
 * Ce fichier contient la classe Iste_livre.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_livre extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_livre';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_livre';
    
    /**
     * Vérifie si une entrée Iste_livre existe.
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
     * Ajoute une entrée Iste_livre.
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
     * Recherche une entrée Iste_livre avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_livre.id_livre = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_livre avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_livre.id_livre = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_livre avec la clef de lieu
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
     * Récupère toutes les entrées Iste_livre avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_livre" => "iste_livre") );
                    
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
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_livre
     *
     * @return array
     */
    public function findById_livre($id_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.id_livre = ?", $id_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $reference
     *
     * @return array
     */
    public function findByReference($reference)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.reference = ?", $reference );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_fr
     *
     * @return array
     */
    public function findByTitre_fr($titre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.titre_fr = ?", $titre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_en
     *
     * @return array
     */
    public function findByTitre_en($titre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.titre_en = ?", $titre_en );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $num_vol
     *
     * @return array
     */
    public function findByNum_vol($num_vol)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.num_vol = ?", $num_vol );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $type_1
     *
     * @return array
     */
    public function findByType_1($type_1)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.type_1 = ?", $type_1 );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $type_2
     *
     * @return array
     */
    public function findByType_2($type_2)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.type_2 = ?", $type_2 );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $soustitre_fr
     *
     * @return array
     */
    public function findBySoustitre_fr($soustitre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.soustitre_fr = ?", $soustitre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_livre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $soustitre_en
     *
     * @return array
     */
    public function findBySoustitre_en($soustitre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_livre") )                           
                    ->where( "i.soustitre_en = ?", $soustitre_en );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
