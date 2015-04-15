<?php
/**
 * Ce fichier contient la classe Iste_prix.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_prix extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_prix';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_prix';
    
    /**
     * Vérifie si une entrée Iste_prix existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_prix'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_prix; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_prix.
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
     * Recherche une entrée Iste_prix avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_prix.id_prix = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_prix avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_prix.id_prix = ' . $id);
    }

    /**
     * Recherche les entrées de Iste_prix avec la clef de lieu
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
     * Récupère toutes les entrées Iste_prix avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_prix" => "iste_prix") );
                    
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
     * Recherche une entrée Iste_prix avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_prix
     *
     * @return array
     */
    public function findById_prix($id_prix)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prix") )                           
                    ->where( "i.id_prix = ?", $id_prix );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prix avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_editeur
     *
     * @return array
     */
    public function findById_editeur($id_editeur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prix") )                           
                    ->where( "i.id_editeur = ?", $id_editeur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prix avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $nb_page
     *
     * @return array
     */
    public function findByNb_page($nb_page)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prix") )                           
                    ->where( "i.nb_page = ?", $nb_page );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prix avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $pdf
     *
     * @return array
     */
    public function findByPdf($pdf)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prix") )                           
                    ->where( "i.pdf = ?", $pdf );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prix avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $prix_dollar
     *
     * @return array
     */
    public function findByPrix_dollar($prix_dollar)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prix") )                           
                    ->where( "i.prix_dollar = ?", $prix_dollar );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prix avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $prix_euro
     *
     * @return array
     */
    public function findByPrix_euro($prix_euro)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prix") )                           
                    ->where( "i.prix_euro = ?", $prix_euro );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prix avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $prix_livre
     *
     * @return array
     */
    public function findByPrix_livre($prix_livre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prix") )                           
                    ->where( "i.prix_livre = ?", $prix_livre );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
