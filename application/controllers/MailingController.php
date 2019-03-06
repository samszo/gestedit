<?php

class MailingController extends Zend_Controller_Action
{

    public function indexAction()
    {
        // Affichage nomenclature dans l'index mailing
        $dbNom = new Model_DbTable_Iste_nomenclature();
        $rs = json_encode($dbNom->getAll());
        $s = new Flux_Site();
        $s->bTrace = false;
        $s->trace($rs);
        $this->view->jsNomen = $rs;

        // Affichage prospects dans index mailing
        $dbProsp = new Model_DbTable_Iste_prospect();
        $rs = json_encode($dbProsp->getAll());
        $s = new Flux_Site();
        $s->bTrace = false;
        $s->trace($rs);
        $this->view->jsProsp = $rs;

        // Affichage établissement dans index mailing
        $dbEtab = new Model_DbTable_Iste_etab();
        $rs = json_encode($dbEtab->getAll());
        $s = new Flux_Site();
        $s->bTrace = false;
        $s->trace($rs);
        $this->view->jsEtab = $rs;
    }

}
