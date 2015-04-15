<?php
/**
 * Ce fichier contient la classe Iste_royalty.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_royalty extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_royalty';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_royalty';
    
    /**
     * Vérifie si une entrée Iste_royalty existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_royalty'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_royalty; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_royalty.
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
     * Recherche une entrée Iste_royalty avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_royalty.id_royalty = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_royalty avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_royalty.id_royalty = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_royalty avec la clef de lieu
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
     * Récupère toutes les entrées Iste_royalty avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_royalty" => "iste_royalty") );
                    
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
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_royalty
     *
     * @return array
     */
    public function findById_royalty($id_royalty)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.id_royalty = ?", $id_royalty );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_vente
     *
     * @return array
     */
    public function findById_vente($id_vente)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.id_vente = ?", $id_vente );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_auteur
     *
     * @return array
     */
    public function findById_auteur($id_auteur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.id_auteur = ?", $id_auteur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $montant_livre
     *
     * @return array
     */
    public function findByMontant_livre($montant_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.montant_livre = ?", $montant_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $montant_euro
     *
     * @return array
     */
    public function findByMontant_euro($montant_euro)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.montant_euro = ?", $montant_euro );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $montant_dollar
     *
     * @return array
     */
    public function findByMontant_dollar($montant_dollar)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.montant_dollar = ?", $montant_dollar );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $taxe_taux
     *
     * @return array
     */
    public function findByTaxe_taux($taxe_taux)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.taxe_taux = ?", $taxe_taux );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $taxe_deduction
     *
     * @return array
     */
    public function findByTaxe_deduction($taxe_deduction)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.taxe_deduction = ?", $taxe_deduction );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_royalty avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $pourcentage
     *
     * @return array
     */
    public function findByPourcentage($pourcentage)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_royalty") )                           
                    ->where( "i.pourcentage = ?", $pourcentage );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
