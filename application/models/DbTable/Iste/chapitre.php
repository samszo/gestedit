<?php
/**
 * Ce fichier contient la classe Iste_chapitre.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_chapitre extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_chapitre';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_chapitre';
    
    /**
     * Vérifie si une entrée Iste_chapitre existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_chapitre'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_chapitre; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_chapitre.
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
     * Recherche une entrée Iste_chapitre avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_chapitre.id_chapitre = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_chapitre avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		//récupère les processus
    		$dbP = new Model_DbTable_Iste_prevision();
    		$dbPC = new Model_DbTable_Iste_processusxchapitre();
    		$arrC = $dbPC->findById_chapitre($id);
    		//supprime les lignes
    		foreach ($arrC as $c) {
    			$dbP->removePxuObj($c["id_pcu"],"chapitre");
    			$dbPC->remove($c["id_pcu"]);
    		}
	    	$this->delete('iste_chapitre.id_chapitre = ' . $id);
    }
    
    /**
     * Récupère toutes les entrées Iste_chapitre avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_chapitre" => "iste_chapitre") );
                    
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
     * Recherche une entrée Iste_chapitre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_chapitre
     *
     * @return array
     */
    public function findById_chapitre($id_chapitre)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_chapitre") )                           
                    ->where( "i.id_chapitre = ?", $id_chapitre );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_chapitre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_fr
     *
     * @return array
     */
    public function findByTitre_fr($titre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_chapitre") )                           
                    ->where( "i.titre_fr = ?", $titre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_chapitre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $titre_en
     *
     * @return array
     */
    public function findByTitre_en($titre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_chapitre") )                           
                    ->where( "i.titre_en = ?", $titre_en );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_chapitre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $soustitre_fr
     *
     * @return array
     */
    public function findBySoustitre_fr($soustitre_fr)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_chapitre") )                           
                    ->where( "i.soustitre_fr = ?", $soustitre_fr );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_chapitre avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $soustitre_en
     *
     * @return array
     */
    public function findBySoustitre_en($soustitre_en)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_chapitre") )                           
                    ->where( "i.soustitre_en = ?", $soustitre_en );

        return $this->fetchAll($query)->toArray(); 
    }
    
    
}
