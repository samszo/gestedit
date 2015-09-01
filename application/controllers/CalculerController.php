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
    		$this->updateTauxDevise(false);    		
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
		
		$bdd = new Model_DbTable_Iste_livre();
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
			    		$rapport->creaPaiement($this->_getParam('idMod'),$r);
				}
				$result = $dbRap->findByModeleLivre($this->_getParam('idMod'),$this->_getParam('idLivre'));				
    				break;
    		}
    				
		$this->view->rs = $result;
    		$this->view->message = "Les paiements sont édités.";		
		
    }
    
    
    public function tauxdeviseAction()
    {
    		$this->initInstance();
    		$this->updateTauxDevise(true);    		
    }

    public function updateTauxDevise($trace)
    {
    		$this->initInstance();
    		
    		$s = new Flux_Site(false,$trace);
    		$dbD = new Model_DbTable_Iste_devise();
    		
		//récupère les dates de ventes    		
    		$rsDV = $dbD->getDateSansDevise();
    		$arrC = array(
    			array("url"=>'/usd/eur',"sql"=>"taux_dollar_euro")
    			,array("url"=>'/eur/usd',"sql"=>"taux_euro_dollar")
    			,array("url"=>'/gbp/usd',"sql"=>"taux_livre_dollar")
    			,array("url"=>'/usd/gbp',"sql"=>"taux_dollar_livre")
    			,array("url"=>'/eur/gbp',"sql"=>"taux_euro_livre")
    			,array("url"=>'/gbp/eur',"sql"=>"taux_livre_euro")
    			);
    		//pour chaque date
    		foreach ($rsDV as $d) {
    			$s->trace($d['dv']);
    			$data = array("date_taux"=>$d['dv']);
    			foreach ($arrC as $c) {
	    			//récupère les taux de conversion pour la date
	    			$url = 'http://currencies.apps.grandtrunk.net/getrate/'.$d['dv'].$c["url"];
	    			$t = $s->getUrlBodyContent($url);	
    				$data[$c["sql"]] = $t;
	    			$s->trace($c["sql"].' = '.$t);
    			}
			//Enregistre le taux
	    		$dbD->ajouter($data);	    			    				
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



