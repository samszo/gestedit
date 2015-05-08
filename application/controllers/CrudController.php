<?php

class CrudController extends Zend_Controller_Action
{

    public function indexAction()
    {
    			$this->view->idObj = $this->_getParam('idObj');
    			$this->view->typeObj = $this->_getParam('typeObj');
    			
    }
    
    public function insertAction()
    {
    		//récupère les paramètres
    		$params = $this->_request->getParams();
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
    		//enlève les paramètres Zend
    		unset($params['controller']);
    		unset($params['action']);
    		unset($params['module']);
    		//et les paramètres de l'ajout
    		unset($params['obj']);
    		//pré traitement de l'ajout
		switch ($this->_getParam('obj')) {
			case 'auteur':
				//création des jointures;
				if($params["institution"]){
					$dbInst = new Model_DbTable_Iste_institution();
					$idInst = $dbInst->ajouter(array("nom"=>$params["institution"]));
					$params['id_institution'] = $idInst;				
				}
				unset($params['institution']);				
			break;			
			case 'processusxchapitre':
				//création du chapitre;
				$dbChap = new Model_DbTable_Iste_chapitre();
				$idChap = $dbChap->ajouter(array("id_livre"=>$params["id_livre"],"id_traducteur"=>$params["id_traducteur"]
					,"num"=>$params["num"],"titre_fr"=>$params["titre_fr"],"titre_en"=>$params["titre_en"]
					,"resume_fr"=>$params["resume_fr"],"resume_en"=>$params["resume_en"]
					));
				$params['id_chapitre'] = $idChap;				
				unset($params['id_livre']);				
				unset($params['id_traducteur']);				
				unset($params['num']);				
				unset($params['titre_fr']);				
				unset($params['titre_en']);				
				unset($params['resume_fr']);				
				unset($params['resume_en']);				
			break;			
		}
		
		//ajout de la donnée
		$result = $oBdd->ajouter($params,true,true);
    		
		//post traitement de l'ajout
		switch ($this->_getParam('obj')) {
			case 'livre':
				//création de la proposition
				$dbPropo = new Model_DbTable_Iste_proposition();
				$rsPropo = $dbPropo->ajouter(array("id_livre"=>$result[0]["id_livre"]),false,true);
				$result = array("rsLivre"=>$result,"rsPropo"=>$rsPropo);
			break;
			case 'processusxchapitre':
				//création des prévisions
				$dbProce = new Model_DbTable_Iste_processus();
				$result = $dbProce->setProcessusForChapitre("Traduction chapitre",$idChap, $params["id_uti"]);
			break;
			
		}
		
		$this->view->message="Les données ont été ajoutées.";
		if(is_array($result))    		    		
	    		$this->view->rs = $result;
	    	else		
			$this->view->message="Les données existent déjà.";
    }

    public function updateAction()
    {
    		//récupère les paramètres
    		$params = $this->_request->getParams();
    		$id = $this->_getParam('recid');
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
    		//enlève les paramètres Zend
    		unset($params['controller']);
    		unset($params['action']);
    		unset($params['module']);
    		//et les paramètres de l'ajout
    		unset($params['obj']);
    		unset($params['recid']);
    		//traitement des données liées
    		if($params['instNom']){
			$dbInst = new Model_DbTable_Iste_institution();
			$idInst = $dbInst->ajouter(array("nom"=>$params["instNom"]));
			$params['id_institution'] = $idInst;				
			unset($params['instNom']);				    			
    		}
    		//traitement des sauvegardes
		switch ($this->_getParam('obj')) {
			case 'coordination':
				$oBdd->edit($params["id_auteur"],$params["id_collection"],array("prime"=>$params["prime"]));
			break;			
			default:
				$oBdd->edit($id,$params);
			break;
		}    		
    }
    
	public function deleteAction()
    {
    		//récupère les paramètres
    		$id = $this->_getParam('id');
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
    		//traitement des supressions
		switch ($this->_getParam('obj')) {
			case 'coordination':
				$oBdd->remove($this->_getParam("id_auteur"),$this->_getParam("id_collection"));
				break;			
			case 'comitexauteur':
				$oBdd->remove($this->_getParam("id_auteur"),$this->_getParam("id_comite"));
				break;			
			case 'comitexlivre':
				$oBdd->remove($this->_getParam("id_livre"),$this->_getParam("id_comite"));
				break;			
			case 'livrexcollection':
				$oBdd->remove($this->_getParam("id_livre"),$this->_getParam("id_collection"));
				break;			
			case 'livrexserie':
				$oBdd->remove($this->_getParam("id_livre"),$this->_getParam("id_serie"));
				break;			
			default:
				$oBdd->remove($id);
				break;
		}    		    		
    }    

	public function auteurdataAction()
    {
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
    	    //récupère les données
    		$rs = $oBdd->findById_auteur($this->_getParam('id'));
		$this->view->rs = $rs;
    }    
	
    public function livredataAction()
    {
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
    	    //récupère les données
    		$rs = $oBdd->findById_livre($this->_getParam('id'));
		$this->view->rs = $rs;
    }    
    
    
}



