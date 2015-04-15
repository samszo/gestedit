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
    	$this->delete('iste_vente.id_vente = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_vente avec la clef de lieu
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
    
    
}
