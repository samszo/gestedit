<?php

class MailingController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $s = new Flux_Site();
        $s->bTrace = false;

        // Affichage nomenclature dans l'index mailing
        $dbNom = new Model_DbTable_Iste_nomenclature();
        $rs = json_encode($dbNom->getAll());
        $s->trace($rs);
        $this->view->jsNomen = $rs;

        // Affichage prospects dans index mailing
        $dbProsp = new Model_DbTable_Iste_prospect();
        $rs = json_encode($dbProsp->getAll());
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

    public function insertAction()
    {
        switch ($this->_getParam('obj')) {
            case 'prospect':
                $dbP = new Model_DbTable_Iste_prospect();
                $arr = array('nom_prenom'=>$this->_getParam('nom_prenom'),'email'=>$this->_getParam('email'),'email2'=>$this->_getParam('email2'), 'affiliation1'=>$this->_getParam('affiliation1'),'affiliation2'=>$this->_getParam('affiliation2'),'affiliation3'=>$this->_getParam('affiliation3'),'code_nomen1'=>$this->_getParam('code_nomen1'),'code_nomen2'=>$this->_getParam('code_nomen2'),'code_nomen3'=>$this->_getParam('code_nomen3'), 'langue'=>$this->_getParam('langue'),'clientIste'=>$this->_getParam('clientIste'),'membreEdito'=>$this->_getParam('membreEdito'),'unsub'=>$this->_getParam('unsub'));
                $rs = $dbP->ajouter($arr, true, true);
                break;
            case 'etab':
                $dbE = new Model_DbTable_Iste_etab();
                $arr = array('url_labo'=>$this->_getParam('url_labo'),'adresse'=>$this->_getParam('adresse'),'ville'=>$this->_getParam('ville'),'cp'=>$this->_getParam('cp'),'pays'=>$this->_getParam('pays'),'responsableLabo'=>$this->_getParam('responsableLabo'),'affiliation1'=>$this->_getParam('affiliation1'),'origine'=>$this->_getParam('origine'));
                $rs = $dbE->ajouter($arr, true, true);
                break;
            case 'nomenclature':
                $dbN = new Model_DbTable_Iste_nomenclature();
                $arr = array('label'=>$this->_getParam('label'),'code'=>$this->_getParam('code'), 'id_parent'=>$this->_getParam('id_parent'), 'label_parent'=>$this->_getParam('label_parent'));
                $rs = $dbN->ajouter($arr, true, true);
                break;
            default:
                # code...
                break;
        }

        $this->view->rs = $rs;
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
            case 'prospectxetab':
                $r = $oBdd->remove($this->_getParam("id_etab"),$this->_getParam("id_prospect"));
            break;			
            case 'prospectxnomenclature':
                $r = $oBdd->remove($this->_getParam("id_nomenclature"),$this->_getParam("id_prospect"));
            break;
            case 'nomenclature':
                 foreach ($id as $ids){
                    $r = $oBdd->remove($ids);
                };
            break;
            case 'prospect':
            foreach ($id as $ids){
                $r = $oBdd->remove($ids);
            };
            break;
            case 'etab':
            foreach ($id as $ids){
                $r = $oBdd->remove($ids);
            };
            break;						
            default:
                $r = $oBdd->remove($id);
            break;
            }    		    	
            $this->view->rs = $r;
            if($r["message"])$this->view->message = $r["message"]; 
            else $this->view->message = "Les données sont supprimées.";
            $dbHM = new Model_DbTable_Iste_histomodif();
            $dbHM->ajouter(array("id_uti"=>$this->ssUti->uti["id_uti"],"action"=>__METHOD__,"obj"=>$this->_getParam('obj'),"id_obj"=>$id));   		
            
    }
    
    public function updateAction()
    {
    	
    		//récupère les paramètres
    		$params = $this->_request->getParams();
    		$id = $this->_getParam('recid');
    		$obj = $this->_getParam('obj');
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$obj;
    		$oBdd = new $oName();
    		//enlève les paramètres Zend
    		unset($params['controller']);
    		unset($params['action']);
    		unset($params['module']);
    		//et les paramètres de l'ajout
    		unset($params['obj']);
    		unset($params['recid']);
    		//traitement des boolean
    		if($params['pdf'])$params['pdf']=="true" ? $params['pdf']=1 : $params['pdf']=0;  				    			
    		//traitement des sauvegardes
		switch ($this->_getParam('obj')) {
			case 'prospectxetab':
				$oBdd->edit($params["id_prospect"],$params["id_etab"]);
			break;			
			case 'prospectxnomenclature':
                $oBdd->edit($params["id_prospect"],$params["id_etab"]);
			break;								
			default:
				$this->view->rs = $oBdd->edit($id,$params);
			break;
		} 
		if(!$this->view->message)$this->view->message = "Les modifications ont été effectuées.";
		$dbHM = new Model_DbTable_Iste_histomodif();
		$dbHM->ajouter(array("id_uti"=>$this->ssUti->uti["id_uti"],"action"=>__METHOD__,"obj"=>$this->_getParam('obj'),"id_obj"=>$id,"data"=>json_encode($params)));   		
    }
    public function importAction()
    {
        $this->initInstance();
    }

    public function insertdataAction()
    {
        $this->initInstance();
        $m = new Flux_Mailing();
        $m->insertData($this->_getParam('idFic'));
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
    }
}

