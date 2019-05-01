<?php
/**
 * Ce fichier contient la classe Iste_etab.
 *
 * @copyright  2019  Roch Delannay
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_etab extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_etab';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_etab';
    
    /**
     * Vérifie si une entrée Iste_etab existe.
     *
     * @param array $data
     *
     * @return integer
     */
    public function existe($data)
    {
		$select = $this->select();
		$select->from($this, array('id_etab'));
		foreach($data as $k=>$v){
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_etab; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_etab.
     *
     * @param array $data
     * @param boolean $existe
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
               return $this->getById($id);
            else
	    	    return $id;
    } 
           
    /**
     * Recherche une entrée Iste_etab avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
    	$this->update($data, 'iste_etab.id_etab = ' . $id);
    }

    /**
     * Recherche une entrée Iste_etab avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($id)
    {
        $this->delete('iste_etab.id_etab = ' . $id);
        $this->delete('iste_prospectxetab.id_etab = ' . $id);
    }

        /**
     * Récupère toutes les entrées Iste_etab avec certains critères
     * de tri, intervalles
     *  @param string $order
     * 
     * @return array
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("n" => "iste_etab") )
                    ->joinInner(array("nid" => "iste_etab"),
                    'n.id_etab = nid.id_etab', array("recid"=>"n.id_etab"));
                    
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
     * 
     * @param string $ids
     * 
     * @return array
     */
    public function getAllHistorique($ids="")
    {
   	
    	$sql = 'SELECT 
                et.*,
                et.id_etab recid,
                COUNT(DISTINCT p.id_prospect) nbProspect,
                MAX(pet.maj) lastExport,
                COUNT(DISTINCT id_export) nbExport
            FROM
                iste_etab et
                    LEFT JOIN
                iste_prospectxetab  pet ON pet.id_etab = et.id_etab
                    LEFT JOIN
                iste_prospect p ON p.id_prospect = pet.id_prospect
                    LEFT JOIN
                iste_prospectxexport pe ON pe.id_prospect = p.id_prospect
                    ';
        if($ids)$sql .= ' WHERE et.id_etab IN ('.$ids.')';

        $sql .= ' GROUP BY et.id_etab';
                    
        $db = $this->_db->query($sql);
        $rs = $db->fetchAll();
        return $rs;
    }    

    public function getById($id)
    {
   	
    	$query = $this->select()
                    ->from( array("n" => "iste_etab") )
                    ->joinInner(array("nid" => "iste_etab"),
                    'n.id_etab = nid.id_etab', array("recid"=>"n.id_etab"))
                    ->where('n.id_etab',$id);
                    
        
        $rs = $this->fetchAll($query)->toArray();
        if(count($rs))return end($rs);
        else return false;
    }

        /**
     * Récupère une entrées Iste_etab avec certains critères
     * de tri, intervalles
     *  @param int    $id_etab   
     * 
     * @return array
     */
    public function getProspectByIdEtab($id_etab){
        $sql = 'SELECT 
                    e.id_etab, ep.id_prospect recid, p.nom_prenom, p.email, p.unsub
                FROM
                    iste_etab e
                        INNER JOIN
                    iste_prospectxetab ep ON ep.id_etab = e.id_etab
                        INNER JOIN
                    iste_prospect p ON p.id_prospect = ep.id_prospect
                WHERE e.id_etab = '.$id_etab; 
        	    $db = $this->_db->query($sql);
                $rs = $db->fetchAll();
        return $rs;
    }
    
     /**
     * Récupère une entrées Iste_nomenclature avec certains critères
     * de tri, intervalles
     *  @param string   $ids   
     *  @param string   $dateFormat
     * 
     * @return array
     */
    public function getExportByIdEtab($ids, $dateFormat='%d/%m/%Y'){
        $recid = str_replace("/","",$dateFormat);
        $sql = 'SELECT 
            DATE_FORMAT(pe.maj, "'.$dateFormat.'") recid,
            COUNT(DISTINCT p.id_prospect) nbProspect,
            DATE_FORMAT(pe.maj, "'.$dateFormat.'") date_export,
            pe.nom
        FROM
            iste_etab et
                LEFT JOIN
            iste_prospectxetab pet ON pet.id_etab = et.id_etab
                LEFT JOIN
            iste_prospect p ON p.id_prospect = pet.id_prospect
                LEFT JOIN
            iste_prospectxexport pe ON pe.id_prospect = p.id_prospect
            ';
        if($ids)$sql .= ' WHERE et.id_etab IN ('.$ids.') AND pe.id_export IS NOT NULL ';

        $sql .= ' GROUP BY DATE_FORMAT(pe.maj, "'.$dateFormat.'")'; 
        $db = $this->_db->query($sql);
        $rs = $db->fetchAll();
        return $rs;
    }

        /**
     * Récupère une entrées Iste_etab avec certains critères
     * de tri, intervalles
     *  @param int    $id_etab   
     * 
     * @return array
     */
    public function getNomenByIdEtab($id_etab){
    $sql = 'SELECT DISTINCT
            e.id_etab,
            pn.id_nomenclature recid,
            n.code,
            n.label
        FROM
            iste_prospect p
                INNER JOIN
            iste_prospectxnomenclature pn ON pn.id_prospect = p.id_prospect
                INNER JOIN
            iste_nomenclature n ON n.id_nomenclature = pn.id_nomenclature
                INNER JOIN
            iste_prospectxetab pe ON pe.id_prospect = p.id_prospect
                INNER JOIN
            iste_etab e ON e.id_etab = pe.id_etab
        WHERE
            e.id_etab =' .$id_etab.'
        ORDER BY n.label';

        $db = $this->_db->query($sql);
        $rs = $db->fetchAll();
        return $rs;
    }
}        

