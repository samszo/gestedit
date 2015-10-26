<?php
/**
 * Ce fichier contient la classe Iste_isbn.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_isbn extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_isbn';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_isbn';
    
	protected $_dependentTables = array(
       "Model_DbTable_Iste_prix"
       ,"Model_DbTable_Iste_auteurxcontrat"
       ,"Model_DbTable_Iste_vente"
       );    
        
    /**
     * Vérifie si une entrée Iste_isbn existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_isbn'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_isbn; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_isbn.
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
	    	 	$id = $this->insert($data);
	    	}
	    	if($rs)
			return $this->findById_isbn($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_isbn avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
	    	$this->update($data, 'iste_isbn.id_isbn = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_isbn avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
        $dt = $this->getDependentTables();
        $n = array();
        foreach($dt as $t){
	        	$dbT = new $t($this->_db);
	        	switch ($t) {
	        		case "Model_DbTable_Iste_vente":
	        			$n[$t] = $dbT->removeIsbn($id);
	        		break;
	        		default:
	        			$n[$t] = $dbT->delete('id_isbn ='.$id);
	        		break;
	        	}			    
        }
    		$n["Model_DbTable_Iste_isbn"] = $this->delete('iste_isbn.id_isbn = ' . $id);
    		return $n;
    }

	/**
     * Recherche les entrées avec la clef spécifiée
     * et supprime ces entréeq.
     *
     * @param integer $id
     *
     * @return void
     */
    public function removeLivre($id)
    {
    		//suprime les royalties associé à cette vente
    		$rs = $this->findById_livre($id);
    		$n = array();
    		foreach ($rs as $r) {
    			$n["removeLivre_".$r['id_livre']] = $this->remove($r['id_livre']);
    		}
    		return $n;
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
            		,array("id"=>$this->_primary[1],"text"=>"num","id_livre"))
            	->where("length(num)>=13")
            ->order("num");        
        return $this->fetchAll($query)->toArray();
	}     
    
    /**
     * Récupère toutes les entrées Iste_isbn avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_isbn" => "iste_isbn") );
                    
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
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_isbn
     *
     * @return array
     */
    public function findById_isbn($id_isbn)
    {
        $query = $this->select()
			->from( array("i" => "iste_isbn") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("iid" => "iste_isbn"),
                'i.id_isbn = iid.id_isbn', array("recid"=>"id_isbn"))
            ->where( "i.id_isbn = ?", $id_isbn );
		$rs = $this->fetchAll($query)->toArray();
        if(count($rs))	
	        return $rs[0] ;
	    else 
	    		return false; 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_livre
     *
     * @return array
     */
    public function findById_livre($id_livre)
    {
        $query = $this->select()
			->from( array("i" => "iste_isbn") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("iid" => "iste_isbn"),
                'i.id_isbn = iid.id_isbn', array("recid"=>"id_isbn"))
			->where( "i.id_livre = ?", $id_livre )
			->order("i.ordre");

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_editeur
     *
     * @return array
     */
    public function findById_editeur($id_editeur)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.id_editeur = ?", $id_editeur );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar 	$titre
     * @param int 		$idEditeur
     * @param varchar 	$langue
     *
     * @return array
     */
    public function findByTitreEditeur($titre, $idEditeur, $langue="en")
    {
        $query = $this->select()
			->from( array("i" => "iste_isbn"))
				->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
	            ->joinInner(array("l" => "iste_livre"),
	                'l.id_livre = i.id_livre', array("id_livre"))
	        ->where( "i.id_editeur = ?", $idEditeur)
	        ->where( "l.titre_".$langue." = ?", $titre);
    
        return $this->fetchAll($query)->toArray(); 
    }
	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar 	$titre
     * @param varchar 	$langue
     *
     * @return array
     */
    public function findByTitre($titre, $langue="en")
    {
        $query = $this->select()
			->from( array("i" => "iste_isbn"))
				->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
	            ->joinInner(array("l" => "iste_livre"),
	                'l.id_livre = i.id_livre', array("id_livre"))
	        ->where( "l.titre_".$langue." = ?", $titre);
    
        return $this->fetchAll($query)->toArray(); 
    }    
    /**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_licence
     *
     * @return array
     */
    public function findById_licence($id_licence)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.id_licence = ?", $id_licence );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $num
     *
     * @return array
     */
    public function findByNum($num)
    {
        $query = $this->select()
			->from( array("i" => "iste_isbn") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("l" => "iste_livre"),
                'i.id_livre = l.id_livre', array("titre_fr","titre_en"))
			->where( "i.num = ?", $num );
		$rs = $this->fetchAll($query)->toArray();
        if(count($rs))	
	        return $rs[0] ;
	    else 
	    		return false; 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $tirage
     *
     * @return array
     */
    public function findByTirage($tirage)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.tirage = ?", $tirage );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $nb_page
     *
     * @return array
     */
    public function findByNb_page($nb_page)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.nb_page = ?", $nb_page );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $cout_total
     *
     * @return array
     */
    public function findByCout_total($cout_total)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.cout_total = ?", $cout_total );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $cout_page
     *
     * @return array
     */
    public function findByCout_page($cout_page)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.cout_page = ?", $cout_page );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param decimal $prix_catalogue
     *
     * @return array
     */
    public function findByPrix_catalogue($prix_catalogue)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.prix_catalogue = ?", $prix_catalogue );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $devise
     *
     * @return array
     */
    public function findByDevise($devise)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.devise = ?", $devise );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param date $date_parution
     *
     * @return array
     */
    public function findByDate_parution($date_parution)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.date_parution = ?", $date_parution );

        return $this->fetchAll($query)->toArray(); 
    }
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param varchar $type
     *
     * @return array
     */
    public function findByType($type)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn") )                           
                    ->where( "i.type = ?", $type );

        return $this->fetchAll($query)->toArray(); 
    }
    
    	/**
     * Recherche un isbn dans une chaine
     *
     * @param varchar $str
     *
     * @return int
     */
    function findIsbn($str)
	{
		//http://stackoverflow.com/questions/14095778/regex-differentiating-between-isbn-10-and-isbn-13
	    $regex = '/\b(?:ISBN(?:: ?| ))?((?:97[89])?\d{9}[\dx])\b/i';
	    //http://regexlib.com/Search.aspx?k=isbn
	    //$regex = '(ISBN[-]*(1[03])*[ ]*(: ){0,1})*(([0-9Xx][- ]*){13}|([0-9Xx][- ]*){10})';
		$regex = '^\d{9}[\d|X]$';
		$regex = "/\bisbn\b/i";
		
	    if (preg_match($regex, $str, $matches)) {
	        print_r($matches);
	    }
	    /*
	    if (preg_match($regex, str_replace('-', '', $str), $matches)) {
	        return (10 === strlen($matches[1]))
	            ? 1   // ISBN-10
	            : 2;  // ISBN-13
	    }
	    */
	    return "NO ISBN";
	}    
	
    	/**
     * Valide un isbn 10
     *
     * @param varchar $str
     *
     * @return int
     */
	function isValidIsbn10($isbn)
	{
	    $check = 0;
	
	    for ($i = 0; $i < 10; $i++) {
	        if ('x' === strtolower($isbn[$i])) {
	            $check += 10 * (10 - $i);
	        } elseif (is_numeric($isbn[$i])) {
	            $check += (int)$isbn[$i] * (10 - $i);
	        } else {
	            return false;
	        }
	    }
	
	    return (0 === ($check % 11)) ? 1 : false;
	}

    	/**
     * Valide un isbn 13
     *
     * @param varchar $str
     *
     * @return int
     */
	function isValidIsbn13($isbn)
	{
	    $check = 0;
	
	    for ($i = 0; $i < 13; $i += 2) {
	        $check += (int)$isbn[$i];
	    }
	
	    for ($i = 1; $i < 12; $i += 2) {
	        $check += 3 * $isbn[$i];
	    }
	
	    return (0 === ($check % 10)) ? 2 : false;
	}	
	
    	/**
     * recherche google book avec isbn
     *
     * @param varchar $isbn
     * http://code18.blogspot.fr/2011/06/recuperer-des-informations-dun-livre.html
     * 
     * @return array
     */
	function findGoogleBookIsbn($isbn)
	{
		// ou si vous préférez hardcodé  
		// $isbn = '0061234001';  
		  
		$request = 'https://www.googleapis.com/books/v1/volumes?q=isbn:' . $isbn;  
		$response = file_get_contents($request);  
		$results = json_decode($response);  
		  
		if($results->totalItems > 0){  
		   // avec de la chance, ce sera le 1er trouvé  
		   $book = $results->items[0];  
		  
		   $infos['isbn'] = $book->volumeInfo->industryIdentifiers[0]->identifier;  
		   $infos['titre'] = $book->volumeInfo->title;  
		   $infos['auteur'] = $book->volumeInfo->authors[0];  
		   $infos['langue'] = $book->volumeInfo->language;  
		   $infos['publication'] = $book->volumeInfo->publishedDate;  
		   $infos['pages'] = $book->volumeInfo->pageCount;  
		  
		   if( isset($book->volumeInfo->imageLinks) ){  
		       $infos['image'] = str_replace('&edge=curl', '', $book->volumeInfo->imageLinks->thumbnail);  
		   }  
		  
		   return $infos;  
		}else{  
		   return false;  
		} 	
	}	
	
	/**
     * récupère les isbn en doublons
     *
     * @return array
     */
	function findDoublons(){
		
 		$sql = "SELECT 
			count(*) nb , num
			, GROUP_CONCAT(id_isbn ORDER BY id_isbn) ids, GROUP_CONCAT(ifnull(nb_page,0) ORDER BY id_isbn) nbPages
			, GROUP_CONCAT(id_editeur ORDER BY id_isbn) edit,  GROUP_CONCAT(i.id_livre ORDER BY id_isbn) idsLivre
			,  GROUP_CONCAT(ifnull(date_parution,0) ORDER BY id_isbn) dates
			,  GROUP_CONCAT(ifnull(titre_fr,0) ORDER BY id_isbn SEPARATOR ' --- ') titresFR,  GROUP_CONCAT(ifnull(titre_en,0) ORDER BY id_isbn SEPARATOR ' --- ') titresEN
			FROM iste_isbn i
			INNER JOIN iste_livre l ON l.id_livre = i.id_livre
			WHERE num is not null 
			GROUP BY num
			HAVING nb > 1
			ORDER BY nb DESC 	";
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);
	    	return $db->fetchAll();
				
	}
	
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     *
     * @return array
     */
    public function findParu()
    {
        $query = $this->select()
                    ->from( array("i" => "iste_isbn"),array("date_parution","id_isbn","id_livre","id_editeur") )                           
                    ->where( "i.date_parution != '0000-00-00'")
                    ->where( "i.date_parution IS NOT NULL");

        return $this->fetchAll($query)->toArray(); 
    }
    
    	/**
     * Recherche une entrée Iste_isbn avec la valeur spécifiée
     * et retourne cette entrée.
     *
     *
     * @return array
     */
    public function setType()
    {
		/*
		Hardback en
		E-Book en
		Ouvrage papier fr
		E-Book fr
		$iste_editeur = array(
		  array('id_editeur' => '1','nom' => 'ISTE Editions'),
		  array('id_editeur' => '2','nom' => 'ISTE International'),
		  array('id_editeur' => '3','nom' => 'ISTE Press'),
		  array('id_editeur' => '4','nom' => 'Elsevier'),
		  array('id_editeur' => '5','nom' => 'Wiley'),
		  array('id_editeur' => '6','nom' => 'Inconnu')
		);
		
		*/    	
		$sql = "UPDATE iste_isbn
        		SET type = 'Hardback en' 
         	WHERE id_editeur = 4"; 
	    	//echo $sql."<br/>";
	    	$db = $this->_db->query($sql);

	    	
	    	    	
    }
    
}
