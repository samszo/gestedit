<?php

class CalculerController extends Zend_Controller_Action
{

    public function indexAction()
    {
    		$this->initInstance();
    }
	
    public function venteAction()
    {
    		$this->initInstance();    		
		switch ($this->_getParam('type',"")) {
			case "Wiley":
				$w = new Flux_Wiley(false,true);
				$w->calculerVentes($this->_getParam('idFic'));
				break;			
			case "NBN":
				$nbn = new Flux_Nbn(false,true);
				$nbn->calculerVentes($this->_getParam('idFic'));
				break;			
			case "global":
				$v = new Flux_Vente(false,true);
				//$v->calculerVentes($this->_getParam('idFic'));
				$v->calculerVentesNew($this->_getParam('idFic'));
				break;			
			default:
				echo "pas de processus de calcule pour ce type de fichier";
				break;			
		}
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

    public function paiementobsoleteAction()
    {
    	$this->initInstance();
    		
		$dbRap = new Model_DbTable_Iste_rapport();
		
		$rs = $dbRap->findObsoleteByIdsAuteur(implode(",", $this->_getParam('ids')));
		foreach ($rs as $r) {
			$dbRap->remove($r["id_rapport"]);
		}

		$this->view->message = "Les paiement obsolètes sont supprimés.";		
		
    }

    public function paiementAction()
    {
    		$this->initInstance();
    		$dbRoy = new Model_DbTable_Iste_royalty();
    		$dbRap = new Model_DbTable_Iste_rapport();
			$rapport = new Flux_Rapport($this->_getParam('idBase'),$this->_getParam('trace'));
			$rapport->bTraceFlush = $this->_getParam('trace');    		
    		$result = array();
    		
    		$type = $this->_getParam('type');
    		switch ($type) {
				case "rapport":
					//marque les ventes des rapport comme payée
    				$rs = $dbRoy->setDatePaiement(implode(",", $this->_getParam('ids')));
    				break;
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
					$rapport->setAll($this->_getParam('idAuteur',false));
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
	
	public function correctionsAction()
	{
        $this->initInstance();
        $db = new Model_DbTable_Iste_auteurxcontrat();
		$db->correctionsISBN();
		$this->view->message = "Corrections effectuées.";
	}

	public function contratpardefautAction()
	{
		$this->initInstance();
		$s = new Flux_Site();
		$s->bTrace = true;
		$s->bTraceFlush = true;
        $dbLA = new Model_DbTable_Iste_livrexauteur;
        $dbAC = new Model_DbTable_Iste_auteurxcontrat();
		$dbI = new Model_DbTable_Iste_isbn();
		$refContrat = array('resp. série'=>array(1,5),'directeur'=>array(3,2));
		//récupère tout les auteurs pour chaque livre
		$arrLA = $dbLA->getAll();
		foreach ($arrLA as $la) {
			if($la['role']=='resp. série' || $la['role']=='directeur'){
				//récupère les isbn du livre
				$arrI = $dbI->findById_livre($la['id_livre']);
				foreach ($arrI as $i) {
					$data = array(
					'id_auteur'=>$la['id_auteur'],
					'id_contrat'=>$refContrat[$la['role']][0],
					'id_isbn'=>$i['id_isbn'],
					'id_livre'=>$la['id_livre'],
					'pc_papier'=>$refContrat[$la['role']][1],
					'pc_ebook'=>$refContrat[$la['role']][1],
					'type_isbn'=>$i['type'],
					'commentaire'=>'contrat par défaut créer automatiquement'
					);			
					$dbAC->ajouter($data);	
					$s->trace('contrat traité pour :'.$la['id_livre'].' - '.$la['id_auteur'].' - '.$la['role'].' - '.$i['id_isbn'].' - '.$i['type']);						
				}
			}
		}


		$this->view->message = "création effectuée";
	}
	

}



