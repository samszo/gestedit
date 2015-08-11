<?php
/**
 * Ce fichier contient la classe Iste_prevision.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_prevision extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_prevision';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_prevision';
    
    /**
     * Vérifie si une entrée Iste_prevision existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_prevision'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_prevision; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_prevision.
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
	    		//if(!isset($data['debut']))$data['debut']= new Zend_Db_Expr('NOW()');
	    		$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->findById_prevision($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_prevision avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {          	
	    	$this->update($data, 'iste_prevision.id_prevision = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_prevision avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		return $this->delete('iste_prevision.id_prevision = ' . $id);
    }
    
    /**
     * Récupère toutes les entrées Iste_prevision avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_prevision" => "iste_prevision") );
                    
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
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_prevision
     *
     * @return array
     */
    public function findById_prevision($id_prevision)
    {
	$sql = "SELECT 
				p.nom, p.id_processus
				, pl.date_creation, pl.id_plu
				, u.login, u.id_uti
			    , t.nom tache, t.ordre
			    , pre.id_prevision recid, pre.debut, pre.prevision, pre.fin, pre.commentaire, pre.alerte
			FROM iste_processus p
				INNER JOIN iste_processusxlivre pl ON pl.id_processus = p.id_processus
				INNER JOIN iste_prevision pre ON pre.id_pxu = pl.id_plu AND pre.obj = 'livre'     
				INNER JOIN iste_uti u ON u.id_uti = pl.id_uti
				INNER JOIN iste_tache t ON t.id_tache = pre.id_tache 
			WHERE pre.id_prevision = ".$id_prevision."
			ORDER BY t.ordre";
	 	//echo $sql."<br/>";
	    $db = $this->_db->query($sql);
	    $rs = $db->fetchAll();
		if(count($rs)) return $rs[0];
		else return false;
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_tache
     *
     * @return array
     */
    public function findById_tache($id_tache)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.id_tache = ?", $id_tache );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $commentaire
     *
     * @return array
     */
    public function findByCommentaire($commentaire)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.commentaire = ?", $commentaire );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $debut
     *
     * @return array
     */
    public function findByDebut($debut)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.debut = ?", $debut );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $prevision
     *
     * @return array
     */
    public function findByPrevision($prevision)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.prevision = ?", $prevision );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $fin
     *
     * @return array
     */
    public function findByFin($fin)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.fin = ?", $fin );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_prevision avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $alerte
     *
     * @return array
     */
    public function findByAlerte($alerte)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_prevision") )                           
                    ->where( "i.alerte = ?", $alerte );

        return $this->fetchAll($query)->toArray(); 
    }
    
    	/**
     * Recherche les alertes pour les livres
     *
     * @return array
     */
    public function getAlerteLivre()
    {
        $sql = "SELECT pre.id_prevision recid
			, pre.commentaire, pre.obj
			, DATEDIFF(pre.alerte, pre.prevision) nbJour
			, pro.nom processus, t.nom tache
			, l.id_livre, CONCAT(l.titre_fr, ' / ', l.titre_en) titre
			, 'background-color: #C2F5B4' as 'style' 
			, GROUP_CONCAT(DISTINCT i.id_isbn) isbns
			FROM iste_prevision pre
			INNER JOIN iste_tache t ON t.id_tache = pre.id_tache
			INNER JOIN iste_processus pro ON pro.id_processus = t.id_processus
			INNER JOIN iste_processusxlivre pl ON pl.id_plu = pre.id_pxu
			INNER JOIN iste_livre l ON l.id_livre = pl.id_livre
			LEFT JOIN iste_isbn i ON i.id_livre = l.id_livre
			WHERE pre.alerte is not null AND pre.fin is null AND pre.obj = 'livre'
            GROUP BY pre.id_prevision
			ORDER BY nbJour";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }
    
}
