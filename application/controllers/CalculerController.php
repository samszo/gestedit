<?php

class CalculerController extends Zend_Controller_Action
{

    public function indexAction()
    {
    }
    
    public function prixventeAction()
    {
		$this->updateTauxDevise(false);    		
    		$dbD = new Model_DbTable_Iste_devise();
		$dbD->setMontantSansDevise();
		$this->view->message = "Les prix sont actualisés.";		
		$bdd = new Model_DbTable_Iste_livre();
		$this->view->rs = $bdd->getAllVente();		
    }

    public function royaltiesAction()
    {
    		//récupère les ventes
    		$dbR = new Model_DbTable_Iste_royalty();    		
		$this->view->rs = $dbR->setForAuteur();	
		
		$bdd = new Model_DbTable_Iste_livre();
		$this->view->rs = $bdd->getAllVente();
		
		$this->view->message = "Les royalties sont calculés.";		
		
    }
    
    public function tauxdeviseAction()
    {
		$this->updateTauxDevise(true);    		
    }

    public function updateTauxDevise($trace)
    {
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
    
}



