<?php

class ProcessusController extends Zend_Controller_Action
{

    public function indexAction()
    {
    		$this->initInstance();
    }
    
    public function getprocessAction()
    {
    		$this->initInstance();
    		//echo __METHOD__;
    		$dbProcess = new Model_DbTable_Iste_processus();
    		switch ($this->_getParam('process')) {
    			case 'Traduction livre' || 'Projet livre':
		    		$this->view->rs = $dbProcess->getProcessusByLivre($this->_getParam('process'), $this->_getParam('id'));
		    		//vérifie que le processus est créé
		    		if(!count($this->view->rs)){
		    			//echo "création du processus de traduction";
					$this->view->rs = $dbProcess->setProcessusForLivre($this->_getParam('process'), $this->_getParam('id'), 1);    		    			
		    		}
    			break;
    			case 'Traduction chapitre':
		    		$this->view->rs = $dbProcess->getProcessusTradChapitreForLivre($this->_getParam('process'), $this->_getParam('id'));
    			break;
    			case 'All':
		    		$this->view->rs = $dbProcess->getProcessusByLivre($this->_getParam('process'), $this->_getParam('id'));
    			break;
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
		    $this->_redirect('/auth/login');		    
		}
		    	
		$this->view->ajax = $this->_getParam('ajax');
		$this->view->idObj = $this->_getParam('idObj');
		$this->view->typeObj = $this->_getParam('typeObj');
    }     
    
    
}



