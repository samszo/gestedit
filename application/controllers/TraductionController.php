<?php

class TraductionController extends Zend_Controller_Action
{

    public function indexAction()
    {
    }
    
    public function getprocessAction()
    {
    		//echo __METHOD__;
    		$dbProcess = new Model_DbTable_Iste_processus();
    		switch ($this->_getParam('process')) {
    			case 'Traduction livre':
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
    		}
    }
    
}



