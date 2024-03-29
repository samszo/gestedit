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
     * renvoie les paramètres formaté pour un grid
     * 
     * @param integer $idContrat
     *
     *
     * @return array
     */
    public function getParams($idContrat=null)
    {       
        $result = array();
        if($idContrat){
            $arr = $this->findById_contrat($idContrat);
        }else{
            $arr = $this->getAll();
        }
        foreach ($arr as $r) {
            if($r['param']){
                $o = json_decode($r['param']);
                foreach ($o->params as $r) {
                    $result[] = $r;       
                }                 
            }else{
                //initialisation des paramètres de contrat
                $this->edit($r["id_contrat"],array("param"=>
                    json_encode(array("params"=>array(                
                        array("nom"=>$r["nom"],"id_contrat"=>$r["id_contrat"],"recid"=>($r["id_contrat"]+1),'base_contrat'=>"FR","moisDeb"=>"janvier","dateDeb"=>"01/01","dateFin"=>"31/12")        
                        ,array("nom"=>$r["nom"],"id_contrat"=>$r["id_contrat"],"recid"=>($r["id_contrat"]+2),'base_contrat'=>"EN","moisDeb"=>"janvier","dateDeb"=>"01/01","dateFin"=>"31/12")
                    )))
                ));
                array_merge($result,$this->getParams($r["id_contrat"]));
            }
        }        

        return $result;

    }
    
    /**
     * met à jour les paramètres formaté pour un grid
     * 
     * @param integer   $idContrat
     * @param integer   $idParam
     * @param string    $nom
     * @param string    $val
     *
     *
     * @return array
     */
    public function editParams($idContrat, $idParam, $nom, $val)
    {       
        $arr = $this->findById_contrat($idContrat);
        foreach ($arr as $r) {
            $o = json_decode($r['param']);
            foreach ($o->params as $r) {
                if("recid"==$idParam){
                    $o->params[$nom]=$val;
                    $this->edit($id_contrat,array("param"=>json_encode($o)));
                    return $this->findById_contrat($idContrat);
                }          
            }
        }        

        return array();                 

    }

    /**
     * calcul les période pour chaque contrat
     * 
     * @param int $annee
     * @param int $idContrat
     *
     * @return array
     */
    public function getPeriodes($annee=false, $idContrat=false)
    {   
        $arrMois = array('janvier'=>1, 'février'=>2,'mars'=>3,'avril'=>4,'mai'=>5,'juin'=>6,'juillet'=>7,'aout'=>8,'septembre'=>9,'octobre'=>10,'novembre'=>11,'décembre'=>12);
        if(!$annee)$annee==date("Y");
        if($idContrat) $contrats = $this->findById_contrat($idContrat);
        else  $contrats = $this->getAll();
        $result = array();
        for ($i=0; $i < count($contrats); $i++) {
            $c = json_decode($contrats[$i]['param']);
            foreach ($c->params as $p) {
                //le jour de début
                $deb  = mktime(0, 0, 0, $arrMois[$p->moisDeb],   1,   $annee);
                //le dernier jour du mois précédent, un an plus tard
                $fin  = mktime(0, 0, 0, $arrMois[$p->moisDeb],   0,   $annee+1);
                $result[$contrats[$i]['id_contrat']][$p->base_contrat]['deb']=$deb;//strftime("%c", $deb);
                $result[$contrats[$i]['id_contrat']][$p->base_contrat]['fin']=$fin;//strftime("%c", $fin);
            } 
        }
        return $result;
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
     * @param int 		$idLivre
     * @param string 	$inAutCont
     *
     * @return array
     */
    public function getAllContratAuteur($idAutCont=false,$type="",$idLivre=false, $inAutCont=false)
    {
	 	$sql = "SELECT 
			id_auteurxcontrat recid, date_signature, pc_papier, pc_ebook, ac.commentaire, ac.type_isbn
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
	 	if($idLivre)$sql .= "  WHERE ac.id_livre=".$idLivre;
	 	if($type)$sql .= "  WHERE c.type='".$type."'";
	 	if($inAutCont)$sql .= "  WHERE ac.id_auteurxcontrat IN (".$inAutCont.")";
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
            		,array("id"=>$this->_primary[1],"text"=>"type"))
            ->order(array("type"));        
        return $this->fetchAll($query)->toArray();
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
