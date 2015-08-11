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
    		$this->view->message = count($this->view->rs)." livre(s) ont été trouvé(s)";
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
		    $this->_redirect('/auth/login');		    
		}
		    	
		$this->view->ajax = $this->_getParam('ajax');
		$this->view->idObj = $this->_getParam('idObj');
		$this->view->typeObj = $this->_getParam('typeObj');
    }     
}



