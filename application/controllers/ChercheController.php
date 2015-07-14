<?php

class ChercheController extends Zend_Controller_Action
{

    public function indexAction()
    {
    }
    
    public function livreAction()
    {
    		//echo __METHOD__;
    		$dbLivre = new Model_DbTable_Iste_livre();
    		$rs = $dbLivre->findId($this->_getParam('searchData'));
    		//$this->view->rs = $dbLivre->getAll(null,0,0,'l.id_livre IN ('.$rs[0]["ids"].')');
    		$this->view->rs = explode(",", $rs[0]["ids"]);
    		$this->view->message = count($this->view->rs)." livre(s) ont été trouvé(s)";
    }
    
}



