<?php

class AuteurController extends Zend_Controller_Action
{

    public function indexAction()
    {
    			$this->view->ajax = $this->_getParam('ajax');
    }
    
    
}



