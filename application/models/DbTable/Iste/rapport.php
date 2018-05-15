<?php
/**
 * Ce fichier contient la classe Iste_rapport.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_rapport extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_rapport';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_rapport';
    
    /**
     * Vérifie si une entrée Iste_rapport existe.
     *
     * @param array 	$data
     * @param bool 	$rs
     *
     * @return integer
     */
    public function existe($data, $rs=false)
    {
		$select = $this->select();
		$select->from($this, array('id_rapport'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0){
	    		if($rs) return $this->findById_rapport($rows[0]->id_rapport);
	    		else $id=$rows[0]->id_rapport; 
	    }else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_rapport.
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
	    		if(!isset($data['maj']))$data['maj']= new Zend_Db_Expr('NOW()');
	    		$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->findById_rapport($id);
	    	else
		    	return $id;
    } 

    	/**
     * Recherche une entrée avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id
     *
     * @return array
     */
    public function findById_rapport($id)
    {
        $query = $this->select()
            ->from( array("i" => "iste_rapport") )                           
            ->where( "i.id_rapport = ?", $id);
		$rs = $this->fetchAll($query)->toArray();
        if(count($rs))return $rs[0];
        else return false; 
    }      

 	/**
     * Recherche une entrée avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int 		$id
     * @param string	 	$type
     *
     * @return array
     */
    public function findByObj($id, $type)
    {
        $query = $this->select()
            ->from( array("i" => "iste_rapport") )                           
            ->where( "i.obj_type = ?", $type)
            ->where( "i.obj_id = ?", $id);
		$rs = $this->fetchAll($query)->toArray();
        
		return $rs; 
    }          

     /**
     * Recherche une entrée avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int 		$idMod
     * @param int	 	$idLivre
     *
     * @return array
     */
    public function findByModeleLivre($idMod, $idLivre)
    {
        $query = $this->select()
            ->from( array("r" => "iste_rapport"),array("recid"=>"id_rapport","url","maj") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("a" => "iste_auteur"),
                'a.id_auteur = SUBSTRING_INDEX(r.obj_id,"_",1)', array("nom","prenom","id_auteur"))
            ->joinInner(array("l" => "iste_livre"),
                'l.id_livre = SUBSTRING_INDEX(r.obj_id,"_",-1)', array("titre_fr","titre_en","id_livre"))
            ->where( "l.id_livre = ?", $idLivre)            
            ->where( "r.id_importfic = ?", $idMod);            
            
        $rs = $this->fetchAll($query)->toArray();
        
		return $rs; 
    }          

    
     /**
     * Recherche une entrée avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int	 	$idLivre
     *
     * @return array
     */
    public function findPaiementByAuteur($idAuteur)
    {
        $sql = "SELECT 
			r.id_rapport recid, r.url, r.maj
		    , ids.idAuteur, ids.idLivre
			, nom, prenom, id_auteur
			, titre_fr, titre_en, id_livre    
		    , SUM(roy.montant_livre) montant_livre
		    , MIN(date_paiement) date_paiement, MIN(date_edition) date_edition, MIN(date_encaissement) date_encaissement, MIN(date_envoi) date_envoi
			, base_contrat, DATE_FORMAT(date_taux,'%Y') periode
		FROM iste_rapport r
			INNER JOIN (SELECT id_rapport  
				, SUBSTRING_INDEX(obj_id,'_',1) idAuteur
				, SUBSTRING_INDEX(SUBSTRING_INDEX(obj_id,'_',-2),'_',1) idLivre
				FROM iste_rapport) ids ON ids.id_rapport = r.id_rapport
			INNER JOIN iste_auteur a ON a.id_auteur = ids.idAuteur
		    INNER JOIN iste_livre l ON l.id_livre = ids.idLivre
		    INNER JOIN iste_royalty roy ON roy.id_rapport = r.id_rapport
		    INNER JOIN iste_devise d  ON d.id_devise = roy.id_devise
		WHERE a.id_auteur = ".$idAuteur."
		GROUP BY r.id_rapport ";          
            
		$stmt = $this->_db->query($sql);
    		$rs = $stmt->fetchAll();
    		        
		return $rs; 
    }          

     /**
     * Recherche une entrée avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int	 	$idFic
     *
     * @return array
     */
    public function findPaiementByFic($idFic)
    {
        $sql = "SELECT 
			r.id_rapport recid, r.url, r.maj
		    , ids.idAuteur, ids.idLivre
			, nom, prenom, id_auteur
			, titre_fr, titre_en, id_livre    
		    , SUM(roy.montant_livre) montant_livre
		    , MIN(date_paiement) date_paiement, MIN(date_edition) date_edition, MIN(date_encaissement) date_encaissement
			, base_contrat, DATE_FORMAT(date_taux,'%Y') periode
		FROM iste_rapport r
			INNER JOIN (SELECT id_rapport  
				, SUBSTRING_INDEX(obj_id,'_',1) idAuteur
				, SUBSTRING_INDEX(SUBSTRING_INDEX(obj_id,'_',-2),'_',1) idLivre
				FROM iste_rapport) ids ON ids.id_rapport = r.id_rapport
			INNER JOIN iste_auteur a ON a.id_auteur = ids.idAuteur
		    INNER JOIN iste_livre l ON l.id_livre = ids.idLivre
		    INNER JOIN iste_royalty roy ON roy.id_rapport = r.id_rapport
		    INNER JOIN iste_devise d  ON d.id_devise = roy.id_devise
		WHERE a.id_auteur = ".$idAuteur."
		GROUP BY r.id_rapport ";          
            
		$stmt = $this->_db->query($sql);
    		$rs = $stmt->fetchAll();
    		        
		return $rs; 
    }              
    
    	/**
     * Recherche une entrée avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $url
     * @param varchar $order
     *
     * @return array
     */
    public function findByUrl($url, $order=null)
    {
        $query = $this->select()
            ->from( array("i" => "iste_rapport") )                           
			->where( "i.url = ?", $url);
            
        if($order != null)
        {
            $query->order($order);
        }
            
		$rs = $this->fetchAll($query)->toArray();
        if(count($rs))return $rs[0];
        else return false; 
    }           
    
    /**
     * Recherche une entrée Iste_rapport avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_rapport.id_rapport = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_rapport avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		//récupère le rapport
    		$r = $this->findById_rapport($id);
    		//supprime le fichier
    		unlink(str_replace(WEB_ROOT, ROOT_PATH, $r['url']));
    		//met à jour les royalty
		//mise à jour de la date d'éditions
		$dbRoyalty = new Model_DbTable_Iste_royalty();
		$dbRoyalty->update(array("id_rapport"=>"","date_edition"=>"0000-00-00"), 'iste_royalty.id_rapport = '.$id);
    		
    		//suprime la ligne
    		$this->delete('iste_rapport.id_rapport = ' . $id);
    		
    }
    
    /**
     * Recherche une entrée Iste_rapport avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param varchar $url
     *
     * @return void
     */
    public function removeByUrl($url)
    {
    		echo $this->delete('iste_rapport.url LIKE "'.$id.'"');
    }
    
    /**
     * Récupère toutes les entrées Iste_rapport avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_rapport" => "iste_rapport") );
                    
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

    
}
