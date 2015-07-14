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
			$select->where($k.' = ?', $v);
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
	    	if(!$id){
	    		if(!isset($data['creation']))$data['creation']= new Zend_Db_Expr('NOW()');
	    		$id = $this->insert($data);
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
     * @return void
     */
    public function removeIdFic($id)
    {
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
     * @param int $idFic
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
}
