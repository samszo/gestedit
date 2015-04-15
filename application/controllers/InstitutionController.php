<?php

class InstitutionController extends Zend_Controller_Action
{

    public function indexAction()
    {
    			$this->view->ajax = $this->_getParam('ajax');
    			$this->view->idObj = $this->_getParam('idObj');
    			$this->view->typeObj = $this->_getParam('typeObj');
    }
    
    
}



