<?php
/**
 * Ce fichier contient la classe Iste_contrat.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_contrat extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_contrat';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_contrat';
    
    /**
     * Vérifie si une entrée Iste_contrat existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_contrat'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_contrat; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_contrat.
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
     * Recherche une entrée Iste_contrat avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_contrat.id_contrat = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_contrat avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_contrat.id_contrat = ' . $id);
    }

    /**
     * Récupère toutes les entrées Iste_contrat avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_contrat" => "iste_contrat") );
                    
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
     * Recherche une entrée Iste_contrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_contrat
     *
     * @return array
     */
    public function findById_contrat($id_contrat)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_contrat") )                           
                    ->where( "i.id_contrat = ?", $id_contrat );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_contrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $nom
     *
     * @return array
     */
    public function findByNom($nom)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_contrat") )                           
                    ->where( "i.nom = ?", $nom );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_contrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $type
     *
     * @return array
     */
    public function findByType($type)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_contrat") )                           
                    ->where( "i.type = ?", $type );

        return $this->fetchAll($query)->toArray(); 
    }
    
    	/**
     * Recherche une entrée Iste_contrat avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $url
     *
     * @return array
     */
    public function findByUrl($url)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_contrat") )                           
                    ->where( "i.url = ?", $url );

        return $this->fetchAll($query)->toArray(); 
    }
    
	/**
     * récupère tous les contrats
     * 
     * @param int 		$idAutCont
     * @param string 	$type
     *
     * @return array
     */
    public function getAllContratAuteur($idAutCont=false,$type="")
    {
 	$sql = "SELECT 
		id_auteurxcontrat recid, date_signature, pc_papier, pc_ebook, ac.commentaire
		, a.id_auteur, a.prenom, a.nom
		, c.id_contrat, c.nom cnom, c.type ctype, c.url curl
		, l.titre_en, l.titre_fr, l.type_1, l.type_2
		, i.id_isbn, i.date_parution, i.num isbn 
		, isbn_auteur
	    , com.id_comite, com.titre_en com_en, com.titre_fr com_en
		, s.id_serie, s.titre_en serie_en, s.titre_fr serie_en
	FROM iste_auteurxcontrat ac
		INNER JOIN iste_contrat c ON c.id_contrat = ac.id_contrat
		INNER JOIN iste_auteur a ON a.id_auteur = ac.id_auteur 
	    LEFT JOIN iste_livre l ON l.id_livre = ac.id_livre
		LEFT JOIN iste_isbn i ON i.id_isbn = ac.id_isbn 
		LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur 
		LEFT JOIN iste_comite com ON com.id_comite = ac.id_comite 
		LEFT JOIN iste_serie s ON s.id_serie = ac.id_serie";
 	if($idAutCont)$sql .= "  WHERE ac.id_auteurxcontrat=".$idAutCont;
 	if($type)$sql .= "  WHERE c.type='".$type."'";
 	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    } 

	/**
     * récupère tous les contrats de traducteur
     * 
     * @param int $idTradCont
     *
     * @return array
     */
    public function getAllContratTraducteur($idTradCont=false)
    {
 	$sql = "SELECT 
		id_traducteurxcontrat recid, date_signature, tc.commentaire
		, t.id_traducteur, t.prenom, t.nom
		, c.id_contrat, c.nom cnom, c.type ctype, c.url curl
		, l.titre_en, l.titre_fr, l.type_1, l.type_2
		, i.id_isbn, i.date_parution, i.num isbn 
	FROM iste_traducteurxcontrat tc
		INNER JOIN iste_contrat c ON c.id_contrat = tc.id_contrat
		INNER JOIN iste_traducteur t ON t.id_traducteur = tc.id_traducteur 
	    LEFT JOIN iste_livre l ON l.id_livre = tc.id_livre
		LEFT JOIN iste_isbn i ON i.id_isbn = tc.id_isbn 
		LEFT JOIN iste_editeur e ON e.id_editeur = i.id_editeur"; 
 	if($idTradCont)$sql .= "  WHERE tc.id_traducteurxcontrat=".$idTradCont;
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
    }     
}
