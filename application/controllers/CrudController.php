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
    		//ajoute la ligne
    		//traitement des sauvegardes
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
		}    		    		
    		$this->view->rs = $oBdd->ajouter($params,true,true);		
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
			case 'particulier':
			;
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
		$oBdd->remove($id);
    }    
}



