<?php

class IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
    		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {						
			// l'identité existe ; on la récupère
		    $this->view->identite = $auth->getIdentity();
		    $ssUti = new Zend_Session_Namespace('uti');
		    $this->view->uti = json_encode($ssUti->uti);
		}else{			
		    $this->view->uti = json_encode(array("login"=>"inconnu", "id_uti"=>0));
		}
    	
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

    public function livreAction()
    {
		$this->view->ajax = $this->_getParam('ajax');
		$this->view->idObj = $this->_getParam('idObj');
		$this->view->typeObj = $this->_getParam('typeObj');
		//récupère les enregistrements
		$bdd = new Model_DbTable_Iste_livre();
		if($this->view->idObj){
			$rs = $bdd->getAll();			
		}else{
			$rs = $bdd->getAll();
		}
		$this->view->json = json_encode($rs);		
    }

    public function traductionAction()
    {
    	
    		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {						
			// l'identité existe ; on la récupère
		    $this->view->identite = $auth->getIdentity();
		    $ssUti = new Zend_Session_Namespace('uti');
		    $this->view->uti = json_encode($ssUti->uti);
		}else{			
		    $this->view->uti = 0;
		}
		    	
		$this->view->ajax = $this->_getParam('ajax');
		$this->view->idObj = $this->_getParam('idObj');
		$this->view->typeObj = $this->_getParam('typeObj');
		//récupère les enregistrements
		$bdd = new Model_DbTable_Iste_livre();
		$rs = $bdd->getTraductionLivre();
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
			if($this->_getParam('obj')=="collection" || $this->_getParam('obj')=="comite" || $this->_getParam('obj')=="serie")
				$arrListe[]=array("id"=>$r[$oBdd->_primary[1]],"text"=>$r["titre_fr"]." / ".$r["titre_en"]);
			elseif ($this->_getParam('obj')=="auteur")
				$arrListe[]=array("id"=>$r[$oBdd->_primary[1]],"text"=>$r["prenom"]." ".$r["nom"]);
			elseif ($this->_getParam('obj')=="uti")
				$arrListe[]=array("id"=>$r[$oBdd->_primary[1]],"text"=>$r["login"]);
			else
				$arrListe[]=array("id"=>$r[$oBdd->_primary[1]],"text"=>$r[$this->_getParam('text',"nom")]);
		}
		$this->view->rs = $arrListe;
    }    
	public function testAction()
    {
    }    
    
}



