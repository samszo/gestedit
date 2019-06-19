<?php
/**
 * Ce fichier contient la classe Iste_prospectxexport.
 *
 * @copyright  2019 Roch Delannay
 * @license    "New" BSD License
*/
class Model_DbTable_Iste_prospectxexport extends Zend_Db_Table_Abstract
{
    
    /**
     * Nom de la table.
     */
    protected $_name = 'iste_prospectxexport';
    
    /**
     * Clef primaire de la table.
     */
    protected $_primary = 'id_prospect';
    
    /**
     * Vérifie si une entrée Iste_prospectxexport existe.
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
			$select->where($k.' = ?', $v);
		}
	    $rows = $this->fetchAll($select);        
	    if($rows->count()>0)$id=$rows[0]->id_prospect; else $id=false;
        return $id;
    } 
        
    /**
     * Ajoute une entrée Iste_prospectxexport.
     *
     * @param array $data
     * @param boolean $existe
     * @param boolean $rs
     *  
     * @return integer
     */
    public function ajouter($data, $existe=false, $rs=false)
    {
	    	
	    	$id=false;
	    	if($existe)$id = $this->existe($data);
	    	if(!$id){
	    		if(!isset($data['maj']))$data['maj']= new Zend_Db_Expr('NOW()');
	    		$id = $this->insert($data);
	    	}
	    	if($rs)
    			return $this->findById_processus($id);
	    	else
		    	return $id;
    } 
           
    /**
     * Recherche une entrée Iste_prospectxexport avec la clef primaire spécifiée
     * et modifie cette entrée avec les nouvelles données.
     *
     * @param integer $id
     * @param array $data
     *
     * @return void
     */
    public function edit($id, $data)
    {        
   	
    	$this->update($data, 'iste_prospectxexport.id_prospect = ' . $id);
    }
    
    /**
     * Recherche une entrée Iste_prospectxexport avec la clef primaire spécifiée
     * et supprime cette entrée.
     *
     * @param integer $id
     *
     * @return void
     */
    public function remove($idProspect, $idExport)
    {
        $this->delete('iste_prospectxexport.id_prospect = '.$idProspect.' AND iste_prospectxexport.id_export = '.$idExport);

    }
    
    /**
     * Récupère toutes les entrées Iste_prospectxexport avec certains critères
     * de tri, intervalles
     */
    public function getAll($order=null, $limit=0, $from=0)
    {
   	
    	$query = $this->select()
                    ->from( array("n" => "iste_prospectxexport") )
                    ->joinInner(array("nid" => "iste_prospectxexport"),
                    'n.id_prospect = nid.id_prospect', array("recid"=>"n.id_export"));
                    
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
     * Récupère toutes les entrées Iste_prospectxexport avec certains critères
     * de tri, intervalles
     */
    public function getListe()
    {
   	
    	$query = $this->select()
                    ->from( array("n" => "iste_prospectxexport") )
                    ->joinInner(array("nid" => "iste_prospectxexport"),
                    'n.id_prospect = nid.id_prospect', array("recid"=>"n.id_export"))
                    ->group;
                    

        return $this->fetchAll($query)->toArray();
    }      
    /**
     * Récupère une entrées Iste_prospect avec certains critères
     * de tri, intervalles
     *  @param int    $id_prospect   
     * 
     * @return array
     */
    public function getProspectByIdExport($id_export){
        $sql = 'SELECT 
                    p.id_prospect recid, p.nom_prenom, p.email
                FROM
                    iste_prospectxexport pe
                        INNER JOIN
                    iste_prospect p ON p.id_prospect = pe.id_prospect
                WHERE pe.id_export = '.$id_export; 
        	    $db = $this->_db->query($sql);
                $rs = $db->fetchAll();
        return $rs;
    }
    /**
     * Récupère une entrées Iste_prospect avec certains critères
     * de tri, intervalles
     *  @param string    $date   
     *  @param string    $nom   
     * 
     * @return array
     */
    public function getProspectByDateNom($date, $nom, $format="%d/%m/%Y"){
        $sql = 'SELECT 
                    p.id_prospect recid, p.nom_prenom, p.email
                FROM
                    iste_prospectxexport pe
                        INNER JOIN
                    iste_prospect p ON p.id_prospect = pe.id_prospect
                WHERE DATE_FORMAT(pe.maj,"'.$format.'") = "'.$date.'" ';
                if($nom) $sql .= ' AND pe.nom = "'.$nom.'" '; 
                else $sql .= ' AND pe.nom = "" '; 
                //echo $sql;
        	    $db = $this->_db->query($sql);
                $rs = $db->fetchAll();
        return $rs;
    }    
}
