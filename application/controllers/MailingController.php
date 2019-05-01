<?php

class MailingController extends Zend_Controller_Action
{

    public function indexAction()
    {
        $s = new Flux_Site();
        $s->bTrace = false;

        // Affichage nomenclature dans l'index mailing
        $dbNom = new Model_DbTable_Iste_nomenclature();
        $rs = json_encode($dbNom->getAllHistorique());
        $s->trace($rs);
        $this->view->jsNomen = $rs;

        // Affichage prospects dans index mailing
        $dbProsp = new Model_DbTable_Iste_prospect();
        $rs = json_encode($dbProsp->getAllHistorique());        
        $s->trace($rs);
        $this->view->jsProsp = $rs;
        
        // Affichage établissement dans index mailing
        $dbEtab = new Model_DbTable_Iste_etab();
        $rs = json_encode($dbEtab->getAllHistorique());
        $s = new Flux_Site();
        $s->bTrace = false;
        $s->trace($rs);
        $this->view->jsEtab = $rs;
/*
        // Affichage historique import dans index mailing
        $dbImp = new Model_DbTable_Iste_importdata();
        $rs = json_encode($dbImp->getAllData());
        $s = new Flux_Site();
        $s->bTrace = false;
        $s->trace($rs);
        $this->view->jsImp = $rs;
*/

        // Affichage historique import dans sidebar
        $dbImpfic = new Model_DbTable_Iste_importfic();
        $rs = json_encode($dbImpfic->findByType('Mailing'));
        $s = new Flux_Site();
        $s->bTrace = false;
        $s->trace($rs);
        $this->view->jsImpfic = $rs;
    }

    public function insertAction()
    {
        switch ($this->_getParam('obj')) {
            case 'prospect':
                $dbP = new Model_DbTable_Iste_prospect();
                $arr = array('nom_prenom'=>$this->_getParam('nom_prenom'),'email'=>$this->_getParam('email'),'email2'=>$this->_getParam('email2'),'clientIste'=>$this->_getParam('clientIste'),'membreEdito'=>$this->_getParam('membreEdito'),'unsub'=>$this->_getParam('unsub'),'origine'=>$this->_getParam('origine'));
                $rs = $dbP->ajouter($arr, true, true);
                break;
            case 'etab':
                $dbE = new Model_DbTable_Iste_etab();
                $arr = array('url_labo'=>$this->_getParam('url_labo'),'adresse'=>$this->_getParam('adresse'),'ville_cp'=>$this->_getParam('ville_cp'),'pays'=>$this->_getParam('pays'),'responsable'=>$this->_getParam('responsable'),'affiliation1'=>$this->_getParam('affiliation1'),'affiliation2'=>$this->_getParam('affiliation2'),'affiliation3'=>$this->_getParam('affiliation3'));
                $rs = $dbE->ajouter($arr, true, true);
                break;
            case 'nomenclature':
                $dbN = new Model_DbTable_Iste_nomenclature();
                $arr = array('label'=>$this->_getParam('label'),'code'=>$this->_getParam('code'), 'id_parent'=>$this->_getParam('id_parent'), 'label_parent'=>$this->_getParam('label_parent'));
                $rs = $dbN->ajouter($arr, true, true);
                break;
            case 'prospectxetab':
                $dbPE = new Model_DbTable_Iste_prospectxetab();
                $arrP = $this->_getParam('idsProspect');
                $arrE = $this->_getParam("idsEtab");
                foreach ($arrP as $p) {
                    foreach ($arrE as $e) {
                        $rs[] = array($p,$e,$dbPE->ajouter($p,$e));
                    }
                }
                break;
            case 'prospectxnomenclature':
                $dbPN = new Model_DbTable_Iste_prospectxnomenclature();
                //$arrN = array('id_nomenclature'=>$this->_getParam("id_nomenclature"), 'id_prospect'=>$this->_getParam("id_prospect"));
                //$arrP = $this->_getParam("id_prospect"));
                //$ids = $this->_getparam('ids');
                $arrN = $this->_getParam('idsNomen');
                $arrP = $this->_getParam('idsProspect');
                foreach($arrP as $p) {
                    foreach($arrN as $n)
                    $rs = $dbPN->ajouter(array('id_prospect'=>$p,'id_nomenclature'=>$n));
                }
                    break;
            case 'prospectxexport':
                $dbPE = new Model_DbTable_Iste_prospectxexport();
                $dbP = new Model_DbTable_Iste_prospect();
                $ids = $this->_getParam('ids');
                foreach ($ids as $id) {
                    $dbPE->ajouter(array('id_prospect'=>$id));
                }
                $rs = $dbP->getAllHistorique(implode(',',$ids));
                $this->view->message = "l'export est bien enregistré";
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
            $arrP = $this->_getParam('idsProspect');
            $arrE = $this->_getParam("idsEtab");
            foreach ($arrP as $p) {
                foreach ($arrE as $e) {
                    $r[] = array($p,$e,$oBdd->remove($p,$e));
                }
            }
            break;			
            case 'prospectxnomenclature':
                $arrP = $this->_getParam("idsProspect");
                $arrN = $this->_getParam("idsNomenclature");
                foreach ($arrP as $p) {
                    foreach ($arrN as $n) {
                        $r[] = array($p,$n,$oBdd->remove($p,$n));
                    }
                }
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
    // Gestion des grid 'details'
    // Grid details Prospect
    public function prospectnomAction(){
        // Affichage grille secondaire prospect -> nomenclature
        $db = new Model_DbTable_Iste_prospect();
        if ($this->_getParam('ids')){
            $ids = $this->_getParam('ids');
            $ids = implode(',',$ids);
            $rs = $db->getNomenclatureByIdProspect($this->_getParam('id_prospect'),$ids);
            $this->view->rs = $rs;
        }else{
            $rs = $db->getNomenclatureByIdProspect($this->_getParam('id_prospect'));
            $this->view->rs = $rs;
        }
    }

    public function prospectaffAction(){
        // Affichage grille secondaire prospect -> affiliations
        $db = new Model_DbTable_Iste_prospect();
        if ('id_prospect'!= null){
        $rs['pros'] = $db->getAffiliationByIdProspect($this->_getParam('id_prospect'));
        $rs['histo'] = $db->getExportByIdProsp($this->_getParam('id_prospect'));
        $this->view->rs = $rs;
        }
    }

    // Grid details etab
    public function affprospectAction(){
        // Affichage grille secondaire etab -> prospect
        $db = new Model_DbTable_Iste_etab();
        if ('id_etab'!= null){
        $rs['pros'] = $db->getProspectByIdEtab($this->_getParam('id_etab'));
        $rs['histo'] = $db->getExportByIdEtab($this->_getParam('id_etab'));
        $this->view->rs = $rs;
        }
    }

    public function affnomenAction(){
        // Affichage grille secondaire etab -> nomenclature
        $db = new Model_DbTable_Iste_etab();
        if ('id_etab'!= null){
        $rs = $db->getNomenByIdEtab($this->_getParam('id_etab'));
        $this->view->rs = $rs;
        }
    }

    // Grid details nomenclature
    public function nomenprospectAction(){
        // Affichage grille secondaire nomenclature -> prospect
        $db = new Model_DbTable_Iste_nomenclature();
        if ('id_nomenclature'!= null){
        $rs['pros'] = $db->getProspectByIdNomen($this->_getParam('id_nomenclature'));
        $rs['histo'] = $db->getExportByIdNomen($this->_getParam('id_nomenclature'));
        
        $this->view->rs = $rs;
        }
    }

    public function nomenaffAction(){
        // Affichage grille secondaire nomenclature -> etab
        $db = new Model_DbTable_Iste_nomenclature();
        if ('id_nomenclature'!= null){
        $rs = $db->getEtabByIdNomen($this->_getParam('id_nomenclature'));
        $this->view->rs = $rs;
        }
    }

    // Grid details import
    public function dataficAction(){
        // Affichage grille secondaire etab -> prospect
        $db = new Model_DbTable_Iste_importfic();
        if ('id_importfic'!= null){
        $rs = $db->getImportdataByIdImportfic($this->_getParam('id_importfic'));
        $this->view->rs = $rs;
        }
    }

}

