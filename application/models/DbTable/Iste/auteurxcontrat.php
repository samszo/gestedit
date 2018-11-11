<?php
/**
 * Ce fichier contient la classe Iste_auteurxcontrat.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_auteurxcontrat extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_auteurxcontrat';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_auteurxcontrat';
    
    /**
     * Vérifie si une entrée Iste_auteurxcontrat existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_auteurxcontrat'));
		if($data["id_livre"])$select->where('id_livre = ?', $data["id_livre"]);
		if($data["id_serie"])$select->where('id_serie = ?', $data["id_serie"]);
		if($data["id_isbn"])$select->where('id_isbn = ?', $data["id_isbn"]);
		if($data["type_isbn"])$select->where('type_isbn = ?', $data["type_isbn"]);
		$select->where('id_auteur = ?', $data["id_auteur"]);
		$select->where('id_contrat = ?', $data["id_contrat"]);
		
		$rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_auteurxcontrat; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_auteurxcontrat.
     *
     * @param array $data
     * @param boolean $existe
     * @param boolean $rs
     * @param boolean $edit
     *  
     * @return integer
     */
    public function ajouter($data, $existe=true, $rs=false, $edit=false)
    {
    	
    	$id=false;
    	
    	if(isset($data["type"])){
            //récupère l'identifiant du contrat
            $dbC = new Model_DbTable_Iste_contrat();
            $item = $dbC->findByType($data["type"]);
            $data["id_contrat"] = $item[0]["id_contrat"];
            unset($data['type']);	    			
    	}
    	
    	if($existe)$id = $this->existe($data);
    	if(!$id){
            if(!isset($data['date_signature']))$data['date_signature']= new Zend_Db_Expr('NOW()');
    	 	$id = $this->insert($data);
    	}elseif ($edit){
    		$this->edit($id, $data);
    	}
    	if($rs){
    		$dbC = new Model_DbTable_Iste_contrat();
    		return $dbC->getAllContratAuteur($id);
    	}else
	    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_auteurxcontrat avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {   
	    $this->update($data, 'iste_auteurxcontrat.id_auteurxcontrat = ' . $id);
    }

    /**
     * modifie l'isbn des contrats pour les types d'isbn
     *
     * @param integer   $id
     * @param string    $type
     *
     * @return array
     */
    public function changeISBN($id, $type)
    {   
        if($type=="Hardback EN" || $type=="Papier FR"){
            //récupère les contrats pour le livre et le type associés à l'isbn
            $sql = "SELECT 
                    ac.id_auteurxcontrat
                FROM
                    iste_auteurxcontrat ac
                        INNER JOIN
                    iste_isbn i ON i.id_livre = ac.id_livre
                        AND i.id_isbn = ".$id."
                WHERE
                    ac.type_isbn = '".$type."'";
            $db = $this->_db->query($sql);
            $rows = $db->fetchAll();
            $ids = "";        
            foreach ($rows as $r) {
                $this->update(array("id_isbn"=>$id), 'iste_auteurxcontrat.id_auteurxcontrat = ' . $r['id_auteurxcontrat']);
                $ids .= $r['id_auteurxcontrat'].",";        
            }
            //récupère les lignes affectée
    		if($ids){
                $dbC = new Model_DbTable_Iste_contrat();
                $ids .= '-1';
                return $dbC->getAllContratAuteur("","","",$ids);
            } 
        }        		
    }

    /**
     * création des contrat ou mis à jour des existants
     *
     *
     * @return void
     */
    public function correctionsISBN()
    {   
        /*
        Si PAS d'ISBN dans le contrat (264 livres)
            pour chaque ISBN du livre PAPIER FR ou HARDBACK EN 
            - mettre à jour le numéro ISBN du contrat
            et si 2 ISBN créer un nouveau contrat pour la même personne avec le même taux 
        Si ISBN dans le contrat (724 livres)
            pour chaque ISBN du livre différent de celui du contrat 
            créer un nouveau contrat pour la même personne avec le même taux 
        */
        //récupère les contrats et les ISBN associés au livre du contrat
        $sql = "SELECT 
            ac.id_auteurxcontrat,
            ac.id_auteur,
            ac.id_contrat,
            ac.id_livre,
            ac.id_isbn acISBN,
            ac.type_isbn,
            ac.pc_papier,
            ac.pc_ebook,
            ac.date_signature,
            i.id_livre,
            i.id_isbn ISBN,
            i.type
        FROM
            iste_auteurxcontrat ac
                LEFT JOIN
            iste_isbn i ON i.id_livre = ac.id_livre
        WHERE
            ac.id_livre IS NOT NULL AND i.type != 'E-Book FR' AND i.type != 'E-Book EN'
        ORDER BY ac.id_livre";
        $db = $this->_db->query($sql);
        $rows = $db->fetchAll();
        $idLivreO = -1;
        foreach ($rows as $r) {
            if($r['acISBN']==$r['ISBN'])
                $this->update(array("type_isbn"=>$r['type']), 'iste_auteurxcontrat.id_auteurxcontrat = ' . $r['id_auteurxcontrat']);
            else{
                if($r['date_signature']=='0000-00-00')$r['date_signature']=null;
                if($idLivreO != $r['id_livre'] && $r['acISBN']==0)
                    $this->update(array("type_isbn"=>$r['type'],"id_isbn"=>$r['ISBN']), 'iste_auteurxcontrat.id_auteurxcontrat = ' . $r['id_auteurxcontrat']);
                else
                    $this->ajouter(array("type_isbn"=>$r['type'],"id_auteur"=>$r['id_auteur'],"id_contrat"=>$r['id_contrat'],"id_livre"=>$r['id_livre']
                    ,"id_isbn"=>$r['ISBN'],"pc_papier"=>$r['pc_papier'],"pc_ebook"=>$r['pc_ebook'],"date_signature"=>$r['date_signature']));
                $idLivreO = $r['id_livre'];
            }
        }
    }        		

    
    /**
     * Recherche des entrée Iste_auteurxcontrat avec l'identifiant ISBN
     * et modifie ces entrées avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function editByISBN($id, $data)
    {           		
	    return	$this->update($data, 'iste_auteurxcontrat.id_isbn = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_auteurxcontrat avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     * @param boolean $force
     *
     * @return void
     */
    public function remove($id, $force=false)
    {
    		//vérifie l'éxistence de royalties
    		$dbR = new Model_DbTable_Iste_royalty();
    		if($force){
	    		$dbR->removeAuteurContrat($id);	
    		}else{
	    		$rs = $dbR->verifEnCoursByIdAuteurContrat($id);
	    		if($rs[0]["mtDue"]>0){
	    			return array("message"=>"Il reste : ".$rs[0]["mtDue"]." &pound; à payer ou encaisser.<br/>Vous ne pouvez pas supprimer le contrat.");
	    		}
    		}
    		$this->delete('iste_auteurxcontrat.id_auteurxcontrat = ' . $id);
    }

    
    /**
     * Récupère toutes les entrées Iste_auteurxcontrat avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_auteurxcontrat" => "iste_auteurxcontrat") );
                    
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
     * Recherche une entrée Iste_auteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_auteur
     *
     * @return array
     */
    public function findById_auteur($id_auteur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteurxcontrat") )                           
                    ->where( "i.id_auteur = ?", $id_auteur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idAut
     * @param int $idCont
     * @param int $idIsbn
     * 
     * @return array
     */
    public function findByIdAutIdContIdIsbn($idAut, $idCont, $idIsbn)
    {
        $query = $this->select()
			->from( array("i" => "iste_auteurxcontrat") )                           
            ->where( "i.id_auteur = ?", $idAut)
            ->where( "i.id_contrat = ?", $idCont)
            ->where( "i.id_isbn = ?", $idIsbn);
		$rs = $this->fetchAll($query)->toArray(); 
        return count($rs) ? $rs[0] : false;
    }

    	/**
     * Recherche une entrée Iste_auteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idIsbn
     * 
     * @return array
     */
    public function findByIdIsbn($idIsbn)
    {
        $query = $this->select()
			->from( array("i" => "iste_auteurxcontrat") )                           
            ->where( "i.id_isbn = ?", $idIsbn);
		return $this->fetchAll($query)->toArray(); 
    }
    
	/**
     * Recherche une entrée Iste_contrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $idSerie
     *
     * @return array
     */
    public function findBySerie($idSerie)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteurxcontrat") )                           
                    ->where( "i.id_serie = ?", $idSerie);

        return $this->fetchAll($query)->toArray(); 
    }    
    
    /**
     * Recherche une entrée Iste_auteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_contrat
     *
     * @return array
     */
    public function findById_contrat($id_contrat)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteurxcontrat") )                           
                    ->where( "i.id_contrat = ?", $id_contrat );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_auteurxcontrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $date_signature
     *
     * @return array
     */
    public function findByDate_signature($date_signature)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_auteurxcontrat") )                           
                    ->where( "i.date_signature = ?", $date_signature );

        return $this->fetchAll($query)->toArray(); 
    }
    
	/**
     * Copier une entrée de la table
     *
     * @param int $idLivreSrc
     * @param int $idLivreDst
     *
     * @return array
     */
    public function copier($idLivreSrc, $idLivreDst)
    {
    		//création de la copie
		$sql = "INSERT INTO iste_auteurxcontrat (id_auteur, id_livre, id_contrat, date_signature, pc_papier, pc_ebook) 
				SELECT id_auteur, ".$idLivreDst.", id_contrat, date_signature, pc_papier, pc_ebook
				FROM iste_auteurxcontrat WHERE id_livre = ".$idLivreSrc; 	 
	    $this->_db->query($sql);
	    $dbC = new Model_DbTable_Iste_contrat();
        return $dbC->getAllContratAuteur(false,"",$idLivreDst);
    }    
    
}
