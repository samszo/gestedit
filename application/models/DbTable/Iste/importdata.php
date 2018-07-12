<?php
/**
 * Ce fichier contient la classe Iste_importdata.
 *
 * @copyright  2013 Samuel Szoniecky
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_importdata extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_importdata';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_importdata';
    
    /**
     * Vérifie si une entrée Iste_importdata existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_importdata'));
		foreach($data as $k=>$v){
			if($k=="id_importfic" || $k=="numsheet" || $k=="numrow")$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_importdata; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_importdata.
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
	    	if(!isset($data['creation']))$data['creation']= new Zend_Db_Expr('NOW()');
	    	if(!$id){
	    		$id = $this->insert($data);
	    	}else{
			$this->edit($id, $data);	    		
	    	}
	    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_importdata avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_importdata.id_importdata = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_importdata avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    		$this->delete('iste_importdata.id_importdata = ' . $id);
    }
    
	/**
     * Recherche une entrée Iste_importdata avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return string
     */
    public function removeIdFic($id)
    {
            //supprime les rapports du fichier
    		$sql = "DELETE r.* FROM iste_rapport r WHERE r.id_importfic = ".$id;
    		$stmt = $this->_db->query($sql);

            //supprime les royalties du fichier
    		$sql = "DELETE r.*
            FROM iste_royalty r
            INNER JOIN iste_vente v ON v.id_vente = r.id_vente
            INNER JOIN iste_importdata id ON id.id_importdata = v.id_importdata AND id.id_importfic = ".$id;
    		$stmt = $this->_db->query($sql);

            //supprime les ventes du fichier
    		$sql = "DELETE v.*
            FROM iste_vente v
            INNER JOIN iste_importdata id ON id.id_importdata = v.id_importdata AND id.id_importfic = ".$id;
    		$stmt = $this->_db->query($sql);

    		//supprime les data du fichier
    		$this->delete('iste_importdata.id_importfic = ' . $id);
    }
        
    /**
     * Récupère toutes les entrées Iste_importdata avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_importdata" => "iste_importdata") );
                    
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
     * Recherche des entrées avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int       $idFic
     *
     * @return array
     */
    public function findByIdFic($idFic)
    {
        $query = $this->select()
            ->from( array("id" => "iste_importdata") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("idi" => "iste_importdata"),
                'idi.id_importdata = id.id_importdata', array("recid"=>"id_importdata"))
            ->where( "id.id_importfic = ?", $idFic );    

        return $this->fetchAll($query)->toArray(); 
        
    }    

	/**
     * Calcul le résumé pour les data d'un fichier
     *
     * @param int       $idFic
     *
     * @return array
     */
    public function getResumeByIdFic($idFic)
    {
        $sql = "SELECT 
                COUNT(DISTINCT d.id_isbn) nbIsbn,
                COUNT(DISTINCT la.id_auteur) nbAuteur,
                COUNT(DISTINCT d.id_livre) nbLivre,
                COUNT(DISTINCT v.id_vente) nbVente,
                SUM(d.col3) qtyPaper,
                SUM(d.col4) sumPaper,
                SUM(d.col5) sumEbook
            FROM
                iste_importdata d
                    INNER JOIN
                iste_importfic f ON f.id_importfic = d.id_importfic
                    INNER JOIN
                iste_vente v ON v.id_importdata = d.id_importdata
                    INNER JOIN
                iste_livrexauteur la ON la.id_livre = d.id_livre
            WHERE
                d.id_importfic =".$idFic;    
        $stmt = $this->_db->query($sql);
        return $stmt->fetchAll();
        
    }    

    /**
     * Recherche des entrées avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int   $idFic
     * @param array $cols
     *
     * @return array
     */
    public function findErreurByIdFic($idFic, $cols)
    {
        
        $query = $this->select()
            ->from( array("id" => "iste_importdata"),$cols)
            ->where( "id.id_importfic = ?", $idFic )
            ->where( "id.commentaire IS NOT NULL")
            ->order("id.commentaire");
            
        return $this->fetchAll($query)->toArray();
            
    }
    
	/**
     * Exporte en csv des entrées avec la valeur spécifiée
     *
     * @param int $idFic
     *
     * @return array
     */
    public function exportByIdFic($idFic)
    {
    		$dbFic = new Model_DbTable_Iste_importfic();
    		$rsFic = $dbFic->findById_importfic($idFic);
    		$cols = json_decode($rsFic["coldesc"]);

    		//construction de la requête
    		$arrC = array("ID"=>"id_importdata","ligne"=>"numrow", "onglet"=>"numsheet", "commentaire","id_livre","id_isbn");
    		
    		$i=1;
    		foreach ($cols as $c) {
    			$arrC[$c]="col".$i;
    			$i++;
    		}
    		
    		   		
    		$query = $this->select()
            ->from( array("id" => "iste_importdata"), $arrC )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("if" => "iste_importfic"),
                'if.id_importfic = id.id_importfic', array("nom","type","url","periode_debut","periode_fin"))
            ->where( "id.id_importfic = ?", $idFic );

        return $this->fetchAll($query)->toArray(); 
        
    }    
    
    
	/**
     * Recherche des entrées avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idFic
     *
     * @return array
     */
    public function findWileySalesByIdFic($idFic)
    {
		//élimine les isbn introuvable
		//traite uniquement la feuille Sales-Activity    	
        $query = $this->select()
            ->from( array("d" => "iste_importdata") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("f" => "iste_importfic"),
                'f.id_importfic = d.id_importfic', array("periode_debut","periode_fin"))
            ->where( "d.commentaire != 'isbn introuvable'")
            ->where( "d.numsheet = 1")
            ->where( "d.id_importfic = ?", $idFic )
            ->order("d.id_importdata");

        return $this->fetchAll($query)->toArray(); 
        
    }    
    
	/**
     * Recherche des entrées avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idFic
     *
     * @return array
     */
    public function findNbnSalesByIdFic($idFic)
    {
		//élimine les isbn introuvable
        $query = $this->select()
            ->from( array("d" => "iste_importdata") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("f" => "iste_importfic"),
                'f.id_importfic = d.id_importfic', array("periode_debut","periode_fin"))
            ->where( "d.commentaire != 'isbn introuvable'")
            ->where( "d.id_importfic = ?", $idFic )
            ->order("d.id_importdata");

        return $this->fetchAll($query)->toArray(); 
        
    }    
    
	/**
     * Recherche des entrées avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $idFic
     *
     * @return array
     */
    public function findSalesByIdFic($idFic)
    {
		//élimine les isbn introuvable
        $query = $this->select()
            ->from( array("d" => "iste_importdata") )                           
			->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
            ->joinInner(array("f" => "iste_importfic"),
                'f.id_importfic = d.id_importfic', array("periode_debut","periode_fin"))
            ->where( "d.id_importfic = ?", $idFic )
            ->order("d.id_importdata");
        echo $query->__toString();    

        return $this->fetchAll($query)->toArray(); 
        
    }    
    
    /**
     * Recherche la définition des colonnes pour un fichier
     * et retourne ces entrées.
     *
     * @param int $idFic
     * @param array $cols
     *
     * @return array
     */
    public function getColForFic($idFic,$cols=NULL){
        //calcul les colonnes
        if(!$cols){
            $dbFic = new Model_DbTable_Iste_importfic();
            $rsFic = $dbFic->findById_importfic($idFic);
            $cols = json_decode($rsFic["coldesc"]);
        }
        $arrC = array("recid"=>"id_importdata", "numrow", "creation", "id_isbn", "id_livre", "commentaire");
        $i=1;
        foreach ($cols as $k => $c) {
            $arrC[$k]=$c;
            $i++;
        }
        return $arrC;
    }

    /**
     * Calcul les sommes pour un fichier 
     * et retourne ces entrées.
     *
     * @param int $idFic
     *
     * @return array
     */
    public function getSommesForFic($idFic){
        //calcul les sommes des datas importées
        $query = $this->select()
        ->from( array("d" => "iste_importdata"),array("nbVenteImp"=>"SUM(d.col3)", "mtPapier"=>"SUM(d.col4)", "mtEbook"=>"SUM(d.col5)"))
            ->where( "d.id_importfic = ?", $idFic );            
        $arrData = $this->fetchAll($query)->toArray();

        //calcul les sommes des ventes
        $query = $this->select()
        ->from( array("d" => "iste_importdata"),NULL )
        ->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
        ->joinInner(array("v" => "iste_vente"),
            'v.id_importdata = d.id_importdata', array("type", "nbVente"=>"SUM(v.nombre)","mtLivre"=>"SUM(v.montant_livre)"))
            ->where( "d.id_importfic = ?", $idFic )
            ->group("type");
        $arrVente = $this->fetchAll($query)->toArray();
            
        return array("data"=>$arrData,"vente"=>$arrVente);
    }
    
    /**
     * Recherche les data sans vente
     * et retourne ces entrées.
     *
     * @param int $idFic
     * @param array $cols
     *
     * @return array
     */
    public function getDataSansVenteForFic($idFic, $cols){
        
        //calcul les sommes des ventes
        $query = $this->select()
        ->from( array("d" => "iste_importdata"),$cols)
        ->setIntegrityCheck(false) //pour pouvoir sélectionner des colonnes dans une autre table
        ->joinInner(array("f" => "iste_importfic"),
            'f.id_importfic = d.id_importfic', array("periode_debut", "periode_fin"))
        ->joinLeft(array("v" => "iste_vente"),
            'v.id_importdata = d.id_importdata', array("vente"=>"id_importdata"))
            ->where( "d.id_importfic = ?", $idFic )
            ->where( "v.id_importdata IS NULL")
            ->order("d.id_importdata");
           
        return $this->fetchAll($query)->toArray();
    }    
    
    /**
     * Recherche les data sans contrat
     * et retourne ces entrées.
     *
     * @param int $idFic
     *
     * @return array
     */
    public function getDataSansContrat($idFic){
        
        //calcul les sommes des ventes
        $sql="SELECT DISTINCT
                i.num,
                a.id_auteur,
                a.nom,
                a.prenom,
                l.id_livre,
                l.titre_en,
                l.titre_fr
            FROM
            iste_importdata d
                INNER JOIN
                iste_importfic f ON f.id_importfic = d.id_importfic
                INNER JOIN
                iste_vente v ON v.id_importdata = d.id_importdata
                INNER JOIN
                iste_isbn i ON i.id_isbn = v.id_isbn
                INNER JOIN
                iste_livrexauteur la ON la.id_livre = i.id_livre
                INNER JOIN
                iste_auteur a ON a.id_auteur = la.id_auteur
                INNER JOIN
                iste_livre l ON l.id_livre = i.id_livre
                LEFT JOIN
                iste_auteurxcontrat ac ON ac.id_auteur = la.id_auteur
                AND ac.id_livre = la.id_livre
            WHERE
                d.id_importfic = $idFic
                AND ac.id_auteurxcontrat IS NULL
            ORDER BY v.id_importdata";
        $stmt = $this->_db->query($sql);
        return $stmt->fetchAll();
    }   

    /**
     * Recherche les data sans base contrat
     * et retourne ces entrées.
     *
     * @param int $idFic
     *
     * @return array
     */
    public function getDataSansBaseContrat($idFic){
        
        //calcul les sommes des ventes
        $sql="SELECT DISTINCT
                i.num,
                i.id_livre
            FROM
            iste_importdata d
                INNER JOIN
                iste_importfic f ON f.id_importfic = d.id_importfic
                INNER JOIN
                iste_vente v ON v.id_importdata = d.id_importdata
                INNER JOIN
                iste_isbn i ON i.id_isbn = v.id_isbn
                INNER JOIN
                iste_proposition p ON p.id_livre = i.id_livre
            WHERE
                d.id_importfic = $idFic
                AND p.base_contrat IS NULL
            ORDER BY v.id_importdata";
        $stmt = $this->_db->query($sql);
        return $stmt->fetchAll();
    }   

}
