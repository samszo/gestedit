<?php
/**
 * Ce fichier contient la classe Iste_prospect.
 *
 * @copyright  2019  Roch Delannay
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_prospect extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_prospect';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_prospect';
    
    /**
     * Vérifie si une entrée Iste_prospect existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_prospect'));
		foreach($data as $k=>$v){
			if($k=="email")$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_prospect; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_prospect.
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
            }else{
                $this->edit($id,$data);
            }
            if($rs)
               return $this->getById($id);
            else
    	    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_prospect avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data /*, $url=null */)
    {        
        $this->update($data, 'iste_prospect.id_prospect = ' . $id);
        /*
        if(!isset($data["maj"])) $data["maj"] = new Zend_Db_Expr('NOW()');
        	if($url)
    	        $this->update($data, 'flux_mailing.url = "'. $url.'"');
        	else        
                $this->update($data, 'flux_mailing.id_prospect = ' . $id);
        */
    }

    /**
     * Recherche une entrée Iste_prospect avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
        $this->delete('iste_prospect.id_prospect = ' . $id);
    }

        /**
     * Récupère toutes les entrées Iste_prospect avec certains critères
     * de tri, intervalles
     *  @param string $order
     * 
     * @return array
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("n" => "iste_prospect") )
                    ->joinInner(array("nid" => "iste_prospect"),
                    'n.id_prospect = nid.id_prospect', array("recid"=>"n.id_prospect"));
                    
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
     * Récupère une entrées Iste_prospect avec certains critères
     * de tri, intervalles
     *  @param int       $id
     * 
     * @return array
     */
    public function getById($id)
    {
   	
    	$query = $this->select()
                    ->from( array("n" => "iste_prospect") )
                    ->joinInner(array("nid" => "iste_prospect"),
                    'n.id_prospect = nid.id_prospect', array("recid"=>"n.id_prospect"))
                    ->where('n.id_prospect',$id);
                    
        
        $rs = $this->fetchAll($query)->toArray();
        if(count($rs))return end($rs);
        else return false;
    }

    /**
     * Récupère une entrées Iste_prospect avec certains critères
     * de tri, intervalles
     *  @param int    $id_prospect   
     * 
     * @return array
     */
    public function getNomenclatureByIdProspect($id_prospect){

        $sql = $this->select()
        ->from( array('p' => 'iste_prospect') )
        ->joinInner(array('pn' => 'iste_prospectnomenclature'),
        'pn.id_prospect = p.id_prospect')
        ->joinInner(array('n' => 'iste_nomenclature'),
        'n.id_nomenclature = pn.id_nomenclature')
        ->where('p.id_prospect', $id_prospect);
/*
        $sql = 'SELECT 
                    p.id_prospect, nom_prenom, pn.id_nomenclature, n.label
                FROM
                    iste_prospect p
                        INNER JOIN
                    iste_prospectxnomenclature pn ON pn.id_prospect = p.id_prospect
                        INNER JOIN
                    iste_nomenclature n ON n.id_nomenclature = pn.id_nomenclature
                WHERE p.id_prospect = '+$id_prospect; */
        return $this->fetchAll($sql);
        
    
    }

}        

