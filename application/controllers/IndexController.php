<?php

class IndexController extends Zend_Controller_Action
{

    public function indexAction()
    {
    		$this->initInstance();
    		//calcule les alertes de prévisions
    		$bdA = new Model_DbTable_Iste_prevision();
    		$rsA = $bdA->getAlerteLivre();
        	for ($i = 0; $i < count($rsA); $i++) {
	    		if($rsA[$i]['nbJour']<-8)$rsA[$i]['style']='background-color: red';
	    		if($rsA[$i]['nbJour']>-8 && $rsA[$i]['nbJour']<0)$rsA[$i]['style']='background-color: orange';
	    		if($rsA[$i]['nbJour']>0 && $rsA[$i]['nbJour']<7)$rsA[$i]['style']='background-color: green';    			
	    		if($rsA[$i]['nbJour']>21)$rsA[$i]['style']='background-color: white';    			
    		}
    		$this->view->rsAlerteLivre = json_encode($rsA);
    	    	
    }
    public function auteurAction()
    {
    		$this->initInstance();

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
    		$this->initInstance();

    		//récupère les enregistrements
		$bdd = new Model_DbTable_Iste_livre();
		if($this->view->idObj){
			$rs = $bdd->getAll();			
		}else{
			$rs = $bdd->getAll();
		}
		$this->view->json = json_encode($rs);		
    }

    public function productionAction()
    {
    		$this->initInstance();

    		//récupère les enregistrements
		$bdd = new Model_DbTable_Iste_livre();
		$rs = $bdd->getProductionLivre();			
		$this->view->json = json_encode($rs);		
    }
    
    public function paramAction()
    {
    		$this->initInstance();

    }
    
    public function traductionAction()
    {
    	
    		$this->initInstance();

    		//récupère les enregistrements
		$bdd = new Model_DbTable_Iste_livre();
		$rs = $bdd->getTraductionLivre();
		$this->view->json = json_encode($rs);		
		$dbTrad = new Model_DbTable_Iste_traducteur();
		$this->view->rsTrad = json_encode($dbTrad->getAll(),JSON_NUMERIC_CHECK);
    }
    
    public function contratAction()
    {
    	
    		$this->initInstance();

    		//récupère les enregistrements
		$bdd = new Model_DbTable_Iste_contrat();
		$rs = $bdd->getAllContratAuteur();
		$this->view->json = json_encode($rs);		
		
		$rs = $bdd->getAllContratTraducteur();
		$this->view->jsonTrad = json_encode($rs);		
		
    }

	public function venteAction()
    {
    		$this->initInstance();
		//récupère les enregistrements
		//$bdd = new Model_DbTable_Iste_livre();
		$bdd = new Model_DbTable_Iste_auteur();
		$rs = $bdd->getAllVente(true);
		$this->view->json = json_encode($rs);		
		$dbD = new Model_DbTable_Iste_devise();
		$this->view->rsDev = json_encode($dbD->getAll());
    }    
	
	public function editionAction()
    {
    	$this->initInstance();
		//récupère les enregistrements
		//$bdd = new Model_DbTable_Iste_livre();
		// $bdd = new Model_DbTable_Iste_auteur();
		// $rs = $bdd->getAllVente(true);
		// $this->view->json = json_encode($rs);		
		// $dbD = new Model_DbTable_Iste_devise();
		// $this->view->rsDev = json_encode($dbD->getAll());
    }

    public function droitAction()
    {
        $this->initInstance();
        $bdd = new Model_DbTable_Iste_livre();
        $rs = $bdd->getAllVenteISBN(true);
        $this->view->jsonISBN = json_encode($rs);
        $bdd = new Model_DbTable_Iste_auteur();
        $rs = $bdd->getAllVente(true);
        $this->view->jsonAuteur = json_encode($rs);
        $dbD = new Model_DbTable_Iste_devise();
        $this->view->rsDev = json_encode($dbD->getAll('date_taux'));
        $dbC = new Model_DbTable_Iste_contrat;
        $this->view->rsDroitParam = json_encode($dbC->getParams());
		$dbPM = new Model_DbTable_Iste_parammail();		
		$this->view->rsParamMail = json_encode($dbPM->getListeForm());
        
    }
    
    function initInstance(){
		$this->view->ajax = $this->_getParam('ajax');
		$this->view->idObj = $this->_getParam('idObj');
		$this->view->typeObj = $this->_getParam('typeObj');
    		
		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {						
			// l'identité existe ; on la récupère
		    $this->view->identite = $auth->getIdentity();
		    $ssUti = new Zend_Session_Namespace('uti');
		    $this->view->uti = json_encode($ssUti->uti);
		}else{			
		    //$this->view->uti = json_encode(array("login"=>"inconnu", "id_uti"=>0));
		    if($this->view->ajax)$this->_redirect('/auth/finsession');		    
		    else $this->_redirect('/auth/login');
		}
		    	
    }
    
    public function institutionAction()
    {
    		$this->initInstance();
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
    		$this->initInstance();
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
				$this->view->rs = $oBdd->getListe();		
    }    

    public function testAction()
    {
    }    
    
    public function keshifAction()
    {
    		$this->initInstance();
    }    
    
}



