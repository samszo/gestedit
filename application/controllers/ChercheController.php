<?php

class ChercheController extends Zend_Controller_Action
{

    public function indexAction()
    {
    }
    
    public function livreAction()
    {
    		$this->initInstance();
    		
    		//echo __METHOD__;
    		$dbLivre = new Model_DbTable_Iste_livre();
    		$rs = $dbLivre->findId($this->_getParam('searchData'));
    		//$this->view->rs = $dbLivre->getAll(null,0,0,'l.id_livre IN ('.$rs[0]["ids"].')');
    		$this->view->rs = explode(",", $rs[0]["ids"]);
    		if(!count($rs[0]["ids"]))$nb=0;
    		else $nb = count($this->view->rs);
    		if($nb < 1)
	    		$this->view->message = $nb." livre a été trouvé";
	    	else
	    		$this->view->message = $nb." livres ont été trouvés";
    }

    public function venteAction()
    {
    		$this->initInstance();
    		
    		//echo __METHOD__;
    		$dbVente = new Model_DbTable_Iste_vente();
    		$rs = $dbVente->findId($this->_getParam('searchData'),$this->_getParam('bLivre'));
    		$this->view->rs = explode(",", $rs[0]["ids"]);
    		if(!count($rs[0]["ids"]))$nb=0;
    		else $nb = count($this->view->rs);    		    		
    		if($this->_getParam('bLivre')){
	    		if($nb > 1)
		    		$this->view->message = $nb." livre a été trouvé";
		    	else
		    		$this->view->message = $nb." livres ont été trouvés";
    		}else{
	    		if($nb > 1)
		    		$this->view->message = $nb." vente a été trouvée";
		    	else
		    		$this->view->message = $nb." ventes ont été trouvées";
    		}
    }
    
	function initInstance(){
    		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {						
			// l'identité existe ; on la récupère
		    $this->view->identite = $auth->getIdentity();
		    $ssUti = new Zend_Session_Namespace('uti');
		    $this->view->uti = json_encode($ssUti->uti);
		}else{			
		    //$this->view->uti = json_encode(array("login"=>"inconnu", "id_uti"=>0));
		    $this->_redirect('/auth/finsession');		    
		}
		    	
		$this->view->ajax = $this->_getParam('ajax');
		$this->view->idObj = $this->_getParam('idObj');
		$this->view->typeObj = $this->_getParam('typeObj');
    }     
}



