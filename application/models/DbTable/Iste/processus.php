<?php
/**
 * Ce fichier contient la classe Iste_processus.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_processus extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_processus';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_processus';
    
    /**
     * Vérifie si une entrée Iste_processus existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_processus'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_processus; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_processus.
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
     * Recherche une entrée Iste_processus avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        	   	
	    	$this->update($data, 'iste_processus.id_processus = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_processus avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
	    	$this->delete('iste_processus.id_processus = ' . $id);
    }
    
    /**
     * Récupère toutes les entrées Iste_processus avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    		$query = $this->select()
                    ->from( array("iste_processus" => "iste_processus") );
                    
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
     * Recherche une entrée Iste_processus avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_processus
     *
     * @return array
     */
    public function findById_processus($id_processus)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_processus") )                           
                    ->where( "i.id_processus = ?", $id_processus );

        return $this->fetchAll($query)->toArray(); 
    }
    
	/**
     * Recherche une entrée Iste_processus avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $process
     *
     * @return array
     */
    public function findTacheByProcess($process)
    {
        $query = $this->select()
			->from( array("p" => "iste_processus"))
				->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
	            ->joinInner(array("t" => "iste_tache"),
	                't.id_processus = p.id_processus', array("id_tache","tache"=>"nom"))
	        ->where( "p.nom = ?", $process);
        return $this->fetchAll($query)->toArray(); 
    }    
    
    /**
     * Recherche une entrée Iste_processus avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nom
     *
     * @return array
     */
    public function findByNom($nom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_processus") )                           
                    ->where( "i.nom = ?", $nom );

        return $this->fetchAll($query)->toArray(); 
    }

	/**
     * récupère le processus de traduction d'un livre
     *
     * @param varchar	$process
     * @param int 		$idLivre
     * @param int 		$idProcessus
     * 
     * @return array
     */
    public function getProcessusByLivre($process, $idLivre, $idProcessus=0)
    {
    		switch ($process) {
    			case "All":
				$where = " ";
    				break;    			
    			case "production":
    				$where = " AND p.id_processus = ".$idProcessus." ";
    				break;    			
    			default:
    				$where = " AND p.nom = '".$process."' ";
    				break;
    		}
	    	$sql = "SELECT 
				p.nom, p.id_processus
				, pl.date_creation, pl.id_plu
				, u.login, u.id_uti
			    , t.nom tache, t.ordre
			    , pre.id_prevision recid, pre.debut, pre.prevision, pre.fin, pre.commentaire, pre.alerte, pre.relance
			FROM iste_processus p
				INNER JOIN iste_processusxlivre pl ON pl.id_processus = p.id_processus
				INNER JOIN iste_prevision pre ON pre.id_pxu = pl.id_plu AND pre.obj = 'livre'     
				INNER JOIN iste_uti u ON u.id_uti = pl.id_uti
				INNER JOIN iste_tache t ON t.id_tache = pre.id_tache 
			WHERE pl.id_livre = ".$idLivre.$where."
			ORDER BY t.ordre";
	 	//echo $sql."<br/>";
	    $db = $this->_db->query($sql);
	    return $db->fetchAll();
    }    

	/**
     * ajoute un processus  pour un livre
     *
     * @param varchar	$process
     * @param int 		$idLivre
     * @param int 		$idUti
     * @param bool 		$rs
     * 
     * @return array
     */
    public function setProcessusForLivre($process, $idLivre, $idUti=1, $rs=true)
    {
    	
    		$dbPrev = new Model_DbTable_Iste_prevision();
    		$dbProcLiv = new Model_DbTable_Iste_processusxlivre();
    		
		//récupère les tâches du processus
        $rsT = $this->findTacheByProcess($process); 
    	        
        //création des tâches prévisionnelles du processus pour le livre
        $bFirst = true;
        foreach ($rsT as $t) {
        		if($bFirst){
	        	    //echo "création du processus pour le livre et l'utilisateur";
	        		$idPLU = $dbProcLiv->ajouter(array("id_livre"=>$idLivre, "id_processus"=>$t['id_processus'], "id_uti"=>$idUti));
				$bFirst=false;        			
        		}        	
	        	$dbPrev->ajouter(array("id_tache"=>$t['id_tache'], "id_pxu"=>$idPLU, "obj"=>"livre"));
        }
    	
        return $rs ? $this->getProcessusByLivre($process, $idLivre) : $idPLU;
    } 

	/**
     * ajoute un processus pour un chapitre
     *
     * @param varchar	$process
     * @param int 		$idChap
     * @param int 		$idUti
     * 
     * @return array
     */
    public function setProcessusForChapitre($process, $idChap, $idUti)
    {
    	
    		$dbPrev = new Model_DbTable_Iste_prevision();
    		$dbProcChap = new Model_DbTable_Iste_processusxchapitre();
    		
		//récupère les tâches du processus
        $rsT = $this->findTacheByProcess($process); 
    	        
        //création des tâches prévisionnelles du processus pour le chapitre
        $bFirst = true;
        foreach ($rsT as $t) {
        		if($bFirst){
	        	    //echo "création du processus pour le livre et l'utilisateur";
	        		$idPCU = $dbProcChap->ajouter(array("id_chapitre"=>$idChap, "id_processus"=>$t['id_processus'], "id_uti"=>$idUti));
				$bFirst=false;        			
        		}        	
	        	$idP = $dbPrev->ajouter(array("id_tache"=>$t['id_tache'], "id_pxu"=>$idPCU, "obj"=>chapitre));
        }
    	
        return $this->getProcessusTradForChapitre($process, $idChap);
    }     
    
	/**
     * récupère le processus de traduction d'un chapitre
     *
     * @param varchar	$process
     * @param int 		$idChap
     * 
     * @return array
     */
    public function getProcessusTradForChapitre($process, $idChap)
    {
	    	$sql = "SELECT 
			p.nom
			, pc.date_creation
		    , c.id_chapitre recid, CONCAT(c.num,' - ',c.titre_fr) content
			, u.login
		    , pre1.id_prevision id1, pre1.fin tache1
		    , pre2.id_prevision id2, pre2.fin tache2
		    , pre3.id_prevision id3, pre3.fin tache3
		    , pre4.id_prevision id4, pre4.fin tache4
		    , pre5.id_prevision id5, pre5.fin tache5
		FROM iste_processus p
			INNER JOIN iste_processusxchapitre pc ON pc.id_processus = p.id_processus
			INNER JOIN iste_chapitre c ON c.id_chapitre = pc.id_chapitre 
			INNER JOIN iste_uti u ON u.id_uti = pc.id_uti
			INNER JOIN iste_prevision pre1 ON pre1.id_pxu = pc.id_pcu AND pre1.obj = 'chapitre' AND pre1.id_tache = 10     
			INNER JOIN iste_prevision pre2 ON pre2.id_pxu = pc.id_pcu AND pre2.obj = 'chapitre' AND pre2.id_tache = 11     
			INNER JOIN iste_prevision pre3 ON pre3.id_pxu = pc.id_pcu AND pre3.obj = 'chapitre' AND pre3.id_tache = 12     
			INNER JOIN iste_prevision pre4 ON pre4.id_pxu = pc.id_pcu AND pre4.obj = 'chapitre' AND pre4.id_tache = 13     
			INNER JOIN iste_prevision pre5 ON pre5.id_pxu = pc.id_pcu AND pre5.obj = 'chapitre' AND pre5.id_tache = 14         
		WHERE pc.id_chapitre = ".$idChap." AND p.nom = '".$process."'
		GROUP BY c.id_chapitre";
	 	//echo $sql."<br/>";
	    $db = $this->_db->query($sql);
	    return $db->fetchAll();
    } 
	/**
     * récupère le processus de traduction des chapitre d'un chapitre
     *
     * @param varchar	$process
     * @param int 		$idLivre
     * 
     * @return array
     */
    public function getProcessusTradChapitreForLivre($process, $idLivre)
    {
	    	$sql = "SELECT 
			p.nom
			, pc.date_creation
		    , c.id_chapitre recid, CONCAT(c.num,' - ',c.titre_fr) content
			, u.login
		    , pre1.id_prevision id1, pre1.fin tache1
		    , pre2.id_prevision id2, pre2.fin tache2
		    , pre3.id_prevision id3, pre3.fin tache3
		    , pre4.id_prevision id4, pre4.fin tache4
		    , pre5.id_prevision id5, pre5.fin tache5
		FROM iste_processus p
			INNER JOIN iste_processusxchapitre pc ON pc.id_processus = p.id_processus
			INNER JOIN iste_chapitre c ON c.id_chapitre = pc.id_chapitre 
			INNER JOIN iste_uti u ON u.id_uti = pc.id_uti
			INNER JOIN iste_prevision pre1 ON pre1.id_pxu = pc.id_pcu AND pre1.obj = 'chapitre' AND pre1.id_tache = 10     
			INNER JOIN iste_prevision pre2 ON pre2.id_pxu = pc.id_pcu AND pre2.obj = 'chapitre' AND pre2.id_tache = 11     
			INNER JOIN iste_prevision pre3 ON pre3.id_pxu = pc.id_pcu AND pre3.obj = 'chapitre' AND pre3.id_tache = 12     
			INNER JOIN iste_prevision pre4 ON pre4.id_pxu = pc.id_pcu AND pre4.obj = 'chapitre' AND pre4.id_tache = 13     
			INNER JOIN iste_prevision pre5 ON pre5.id_pxu = pc.id_pcu AND pre5.obj = 'chapitre' AND pre5.id_tache = 14         
		WHERE c.id_livre = ".$idLivre." AND p.nom = '".$process."'
		GROUP BY c.id_chapitre";
	 	//echo $sql."<br/>";
	    $db = $this->_db->query($sql);
	    return $db->fetchAll();
    }         
    
    /**
     * Renvoie la liste des entrée
     *
     * @return void
     */
    public function getListe()
    {
    		$query = $this->select()
            ->from( array("l" => $this->_name)
            		,array("recid"=>$this->_primary[1],"id"=>$this->_primary[1],"text"=>"nom","nom"))
            ->order(array("nom"));
        return $this->fetchAll($query)->toArray();
	} 

	
	/**
     * ajoute une tache à toutes les prévisions 
     *
     * @param int 		$idTache
     * @param bool 		$rs
     * 
     * @return array
     */
    public function setProcessusForTache($idTache)
    {
    	
    		$sql = "INSERT INTO iste_prevision (id_tache, id_pxu, obj)
		SELECT t.id_tache, pl.id_plu, 'livre'
		FROM iste_tache t
		INNER JOIN iste_processusxlivre pl ON pl.id_processus = t.id_processus
		LEFT JOIN iste_prevision p ON p.id_tache = t.id_tache AND p.id_pxu = pl.id_plu AND p.obj = 'livre' 
		WHERE t.id_tache = ".$idTache." AND p.id_prevision IS NULL";
	    $this->_db->query($sql);
    		
    } 	
}
