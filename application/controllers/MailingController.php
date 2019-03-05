<?php

class MailingController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $dbNom = new Model_DbTable_Iste_nomenclature();
        $rs = json_encode($dbNom->getAll());
        $s = new Flux_Site();
        $s->bTrace = false;
        $s->trace($rs);
        $this->view->jsNomen = $rs;
    }

}
