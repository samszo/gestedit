<?php

class IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
    }
    public function topAction()
    {
    }
    public function auteurAction()
    {
		$this->view->ajax = $this->_getParam('ajax');
		$this->view->idObj = $this->_getParam('idObj');
		$this->view->typeObj = $this->_getParam('typeObj');
		//récupère les enregistrements
		$bdd = new Model_DbTable_Iste_auteur();
		if($this->view->idObj){
			$rs = $bdd->getAll();			
		}else{
			$rs = $bdd->getAll();
		}
		$this->view->json = json_encode($rs);		
    }
    
    public function institutionAction()
    {
    		$this->view->ajax = $this->_getParam('ajax');
		$this->view->idObj = $this->_getParam('idObj');
		$this->view->typeObj = $this->_getParam('typeObj');
		//récupère les enregistrements
		$bdd = new Model_DbTable_Iste_institution();
		if($this->view->idObj){
			$rs = $bdd->getAll();			
		}else{
			$rs = $bdd->getAll();
		}
		$this->view->rs = $rs;
    }
	public function listeAction()
    {
    	    	$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
		$rs = $oBdd->getAll();
		//print_r($rs);
		$arrListe = array();
		foreach ($rs as $r) {
			$arrListe[]=array("id"=>$r[$oBdd->_primary[1]],"text"=>$r[$this->_getParam('text',"nom")]);
		}
		$this->view->rs = $arrListe;
    }    
	public function testAction()
    {
    }    
    
}



