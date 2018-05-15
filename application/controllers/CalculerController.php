<?php

class CalculerController extends Zend_Controller_Action
{

    public function indexAction()
    {
    		$this->initInstance();
    }
    
    public function prixventeAction()
    {
    		$this->initInstance();
    		$s = new Flux_Vente(false,$this->_getParam('trace'));
			//le taux des devises est mis à jour manuellement
			//$s->updateTauxDevise();
    		$dbD = new Model_DbTable_Iste_devise();
        	$dbD->setMontantSansDevise();
        	$this->view->message = "Les prix sont actualisés.";		
        	$bdd = new Model_DbTable_Iste_livre();
        	$this->view->rs = $bdd->getAllVente();		
    }

    public function royaltiesAction()
    {
    	$this->initInstance();
    		
    	//récupère les ventes
        $dbR = new Model_DbTable_Iste_royalty();    		
		$this->view->rs = $dbR->setForAuteur();	
		
		//$bdd = new Model_DbTable_Iste_livre();
		$bdd = new Model_DbTable_Iste_auteur();
		$this->view->rs = $bdd->getAllVente();
		
		$this->view->message = "Les royalties sont calculés.";		
		
    }

    public function paiementAction()
    {
    		$this->initInstance();
    		$dbRoy = new Model_DbTable_Iste_royalty();
    		$dbRap = new Model_DbTable_Iste_rapport();
    		$rapport = new Flux_Rapport();    		
    		$result = array();
    		
    		$type = $this->_getParam('type');
    		switch ($type) {
    			case "livre":
    				$rs = $dbRoy->paiementLivre(implode(",", $this->_getParam('ids')));
    				foreach ($rs as $r) {
    			    		$rapport->creaPaiement($r);
    				}
    				//$result = $dbRap->findByModeleLivre($this->_getParam('idMod'),$this->_getParam('idLivre'));				
    				break;
    			case "auteur":
    				$rs = $dbRoy->paiementAuteur(implode(",", $this->_getParam('ids')));
    				foreach ($rs as $r) {
    			    		$rapport->creaPaiement($r);
    				}
    				//$result = $dbRap->findByModeleLivre($this->_getParam('idMod'),$this->_getParam('idLivre'));				
					break;
				case "auteurFic":
    				$rs = $dbRoy->paiementAuteurFic(implode(",", $this->_getParam('ids')));
					foreach ($rs as $r) {
						  $rapport->creaPaiementFic($r);
						  $rapport->creaPaiementFic($r,"serie");
					}
					//$result = $dbRap->findByModeleLivre($this->_getParam('idMod'),$this->_getParam('idLivre'));				
					break;
    		}
    				
		$this->view->rs = $result;
    		$this->view->message = "Les paiements sont édités.";		
		
    }
    
	public function rapportAction()
    {
    		$this->initInstance();
    		$dbRap = new Model_DbTable_Iste_rapport();
    		$rapport = new Flux_Rapport();    		
    		$result = array();
    		
    		$type = $this->_getParam('type');
    		switch ($type) {
    			case "etatSerie":
		    		$result = $rapport->creaEtatSeries($this->_getParam('ids'));
		    		$this->view->message = "L'état est disponible.";		
    				break;
    			case "auteur":
    				$rs = $dbRoy->paiementAuteur(implode(",", $this->_getParam('ids')));
				foreach ($rs as $r) {
			    		$rapport->creaPaiement($r);
				}
		    		$this->view->message = "Les paiements sont édités.";		
				//$result = $dbRap->findByModeleLivre($this->_getParam('idMod'),$this->_getParam('idLivre'));				
    				break;
    		}
    				
		$this->view->rs = $result;
		
    }    
    
    public function tauxdeviseAction()
    {
    		$this->initInstance();    		
    		$s = new Flux_Vente(false,$this->_getParam('trace'));    		
    		$s->updateTauxDevise();    		
    }  

	public function problemesAction()
    {
        $this->initInstance();
        $s = new Flux_Vente(false,$this->_getParam('trace'));
        $this->view->rs =  $s->getProblemes($this->_getParam('idFic'));
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



