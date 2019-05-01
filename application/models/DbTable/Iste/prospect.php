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
        $this->delete('iste_prospectxnomenclature.id_prospect = ' . $id);
        $this->delete('iste_prospectxetab.id_prospect = ' . $id);
        $this->delete('iste_prospectxexport.id_prospect = ' . $id);
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
     * 
     * @param string $ids
     * 
     * @return array
     */
    public function getAllHistorique($ids="")
    {
   	
    	$sql = 'SELECT 
                p.*, 
                p.id_prospect recid,
                MAX(pe.maj) lastExport, COUNT(DISTINCT id_export) nbExport
            FROM
                iste_prospect p
                    LEFT JOIN
                iste_prospectxexport pe ON pe.id_prospect = p.id_prospect ';
        if($ids)$sql .= ' WHERE p.id_prospect IN ('.$ids.')';

        $sql .= ' GROUP BY p.id_prospect';
                    
        $db = $this->_db->query($sql);
        $rs = $db->fetchAll();
        return $rs;
    }

    /**
     * Récupère une entrées Iste_prospect avec certains critères
     * de tri, intervalles
     *  @param int          $id_prospect   
     *  @param string       $ids   
     * 
     * @return array
     */
    public function getNomenclatureByIdProspect($id_prospect, $ids=""){
        $sql = 'SELECT 
                    DISTINCT pn.id_nomenclature recid, n.label, n.code
                FROM
                    iste_prospect p
                        INNER JOIN
                    iste_prospectxnomenclature pn ON pn.id_prospect = p.id_prospect
                        INNER JOIN
                    iste_nomenclature n ON n.id_nomenclature = pn.id_nomenclature';
        if($ids){
            $sql .= ' WHERE p.id_prospect IN ('.$ids.')'; 
        }else{
            $sql .= ' WHERE p.id_prospect = '.$id_prospect; 
        }
        $db = $this->_db->query($sql);
        $rs = $db->fetchAll();
        return $rs;
    }

        /**
     * Récupère une entrées Iste_prospect avec certains critères
     * de tri, intervalles
     *  @param int    $id_prospect   
     * 
     * @return array
     */
    public function getAffiliationByIdProspect($id_prospect){
        $sql = 'SELECT 
                    p.id_prospect, pe.id_etab recid, e.affiliation1, e.affiliation2, e.affiliation3
                FROM
                    iste_prospect p
                        INNER JOIN
                    iste_prospectxetab pe ON pe.id_prospect = p.id_prospect
                        INNER JOIN
                    iste_etab e ON e.id_etab = pe.id_etab
                WHERE p.id_prospect = '.$id_prospect; 
        	    $db = $this->_db->query($sql);
                $rs = $db->fetchAll();
        return $rs;
    }

     /**
     * Récupère une entrées Iste_prospect avec certains critères
     * de tri, intervalles
     *  @param string   $ids   
     *  @param string   $dateFormat
     * 
     * @return array
     */
    public function getExportByIdProsp($ids, $dateFormat='%d/%m/%Y'){
        $recid = str_replace("/","",$dateFormat);
        $sql = 'SELECT 
            DATE_FORMAT(pe.maj, "'.$dateFormat.'") recid,
            COUNT(DISTINCT p.id_prospect) nbProspect,
            DATE_FORMAT(pe.maj, "'.$dateFormat.'") date_export,
            pe.nom
        FROM
            iste_prospect p
                LEFT JOIN
            iste_prospectxexport pe ON pe.id_prospect = p.id_prospect
            ';
        if($ids)$sql .= ' WHERE p.id_prospect IN ('.$ids.') AND pe.id_export IS NOT NULL ';

        $sql .= ' GROUP BY DATE_FORMAT(pe.maj, "'.$dateFormat.'")'; 
        $db = $this->_db->query($sql);
        $rs = $db->fetchAll();
        return $rs;
    }

}        

