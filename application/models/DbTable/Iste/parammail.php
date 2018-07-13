<?php
/**
 * Ce fichier contient la classe Iste_parammail.
 *
*/
class Model_DbTable_Iste_parammail extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_parammail';
    
    /**
     * Clef primaire de la table.
     */
    public $_primary = 'id_parammail';
    
    /**
     * Vérifie si une entrée Iste_parammail existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_parammail'));
        $select->where(' champ = ?', $data);
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_parammail; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_parammail.
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
	    	if($existe)$id = $this->existe($data["champ"]);
	    	if(!$id){
	    	 	$id = $this->insert($data);
            }
            else{
                $id = $this->edit($id,$data);
            }
	    	if($rs)
			return $this->findById_parammail($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_parammail avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     * @param boolean $bGetRow
     *
     * @return void
     */
    public function edit($id, $data, $bGetRow=true)
    {           	
    		$this->update($data, 'iste_parammail.id_parammail = ' . $id);
    	    	if($bGetRow)return $this->getListe($id);
    }
    
    /**
     * Recherche une entrée Iste_parammail avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
    	$this->delete('iste_parammail.id_parammail = ' . $id);
    }

    
    /**
     * Renvoie la liste des entrée
     *
     * @param int	$id
     *
     * @return void
     */
    public function getListe($id=false)
    {
        $query = $this->select()
        ->from( array("l" => $this->_name)
                // ,array("recid"=>$this->_primary[1],"champ","contenu"));
                ,array("champ","contenu"));
        if($id)$query->where( "l.id_parammail = ?", $id);        
        return $this->fetchAll($query)->toArray();
	} 
    /**
     * Récupère toutes les entrées Iste_parammail avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("iste_parammail" => "iste_parammail") );
                    
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
     * Recherche une entrée Iste_parammail avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param int $id_parammail
     *
     * @return array
     */
    public function findById_parammail($id_parammail)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_parammail"),array("recid"=>"id_parammail","champ","contenu"))                           
                    ->where( "i.id_parammail = ?", $id_parammail );

        return $this->fetchAll($query)->toArray(); 
    }

    /**
     * Recherche une entrée Iste_parammail avec la valeur spécifiée
     * et retourne cette entrée.
     *
     * @param string $champ
     *
     * @return string
     */
    public function findByChamp_parammail($champ)
    {
        $query = $this->select()
                    ->from( array("i" => "iste_parammail"),array("contenu"))                           
                    ->where( "i.champ = ?", $champ );

        $rows = $this->fetchAll($query); 
        if($rows->count()>0)$res=$rows[0]->contenu; else $res="";
        return $res;
    }
    
    
}
