<?php

class CrudController extends Zend_Controller_Action
{

    public function indexAction()
    {
    		$this->initInstance();
    		$this->view->idObj = $this->_getParam('idObj');
    		$this->view->typeObj = $this->_getParam('typeObj');
    			
    }

    public function copierAction()
    {
    		$this->initInstance();
    		//récupère les paramètres
    		$params = $this->_request->getParams();
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();    		
	    	$this->view->rs = $oBdd->copier($this->_getParam('id'));
	    	$this->view->message="Les données ont été copiées.";
    		
    }    

    public function fusionAction()
    {
    		$this->initInstance();
    		//récupère les paramètres
    		$params = $this->_request->getParams();
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();    		
	    	$this->view->rs = $oBdd->fusion($this->_getParam('ids'));
	    	$this->view->message="Les données ont été fusionnées.";
    		
    }    
    
    public function insertAction()
    {
    		$this->initInstance();
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
			case 'auteurxcontrat':
				//création/récupération du contrat;
				$dbCont = new Model_DbTable_Iste_contrat();
				$idCont = $dbCont->ajouter(array("nom"=>$params["nom"],"type"=>$params["type"]));
				$params['id_contrat'] = $idCont;			
				//récupération de l'isbn
				if($params['isbn']){
					$dbI = new Model_DbTable_Iste_isbn();
					$rIsbn = $dbI->findByNum($params['isbn']);
					if($rIsbn)$params['id_isbn'] = $rIsbn['id_isbn'];	
					else $mess = "ISBN non trouvé !";
				}	
				unset($params['nom']);				
				unset($params['type']);				
				unset($params['isbn']);				
			break;
			case 'vente':
				$idLivre = $params['id_livre'];
				unset($params['id_livre']);						
			break;
			case 'prevision':
				//ajoute ou récupère la tache
				$dbTache = new Model_DbTable_Iste_tache();
				if($params['tache']){
					$params['id_tache']=$dbTache->ajouter(array("nom"=>$params['id_tache'],"id_processus"=>$params['id_processus']));
					unset($params['tache']);						
				}
				$params['obj']=$params["pxu_obj"];						
				unset($params['pxu_obj']);						
				unset($params['id_processus']);						
			break;
			case 'prix':
		    		if($params['pdf'])$params['pdf']=="true" ? $params['pdf']=1 : $params['pdf']=0;  
				
			break;
		}
		//print_r($params);
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
			case 'vente':
				//récupère les ventes
				$dbL = new Model_DbTable_Iste_livre();
				$result = $dbL->getIdLivreVente($idLivre);
			break;			
		}
		
		$this->view->message="Les données ont été ajoutées.".$mess;
		if(is_array($result))    		    		
	    		$this->view->rs = $result;
	    	else		
			$this->view->message="Les données existent déjà.".$mess;
    }

    public function updateAction()
    {
    		$this->initInstance();
    	
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
    		//traitement des boolean
    		if($params['pdf'])$params['pdf']=="true" ? $params['pdf']=1 : $params['pdf']=0;  
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
    		$this->initInstance();
    	
    		//récupère les paramètres
    		$id = $this->_getParam('id');
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
    		//traitement des supressions
		switch ($this->_getParam('obj')) {
			case 'coordination':
				$r = $oBdd->remove($this->_getParam("id_auteur"),$this->_getParam("id_serie"));
				break;			
			case 'comitexauteur':
				$r = $oBdd->remove($this->_getParam("id_auteur"),$this->_getParam("id_comite"));
				break;			
			case 'comitexlivre':
				$r = $oBdd->remove($this->_getParam("id_livre"),$this->_getParam("id_comite"));
				break;			
			case 'livrexcollection':
				$r = $oBdd->remove($this->_getParam("id_livre"),$this->_getParam("id_collection"));
				break;			
			case 'livrexserie':
				$r = $oBdd->remove($this->_getParam("id_livre"),$this->_getParam("id_serie"));
				break;			
			default:
				$r = $oBdd->remove($id);
				break;
		}    		    	
		$this->view->rs = $r;
		if($r["message"])$this->view->message = $r["message"]; 
		else $this->view->message = "Les données sont supprimées.";
    }    

	public function auteurdataAction()
    {
    		$this->initInstance();
    	
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
    	    //récupère les données
    		$rs = $oBdd->findLivreById_auteur($this->_getParam('id'));
		$this->view->rs = $rs;
    }    
	
    public function livredataAction()
    {
    		$this->initInstance();
    	
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
    	    //récupère les données
    		$rs = $oBdd->findById_livre($this->_getParam('id'));
		$this->view->rs = $rs;
    }    
    
    public function finduserAction()
    {
    		$this->initInstance();
    	
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
    	    //récupère les données
    		$rs = $oBdd->findUser($this->_getParam('id'));
		$this->view->rs = $rs;
    }    
    
    public function ventedataAction()
    {
    		$this->initInstance();
    	
    		//création de l'objet BDD
    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
    		$oBdd = new $oName();
    	    //récupère les données
    		$rs = $oBdd->findById_livre($this->_getParam('id'));
    		
		//ajoute les résumés
		$rsR = $oBdd->getTotaux($this->_getParam('id'));
		if($this->_getParam('obj')=="vente"){
			$i=1;
			foreach ($rsR as $r) {
				$rs[]= array(
					"summary"=>true
					,"recid"=>"S-".$i
					,"devise"=>'<span style="float: right;">Dates de vente</span>'
					,"licence"=>$r["dMin"]." / ".$r["dMax"]
					,"date_vente"=>'<span style="float: right;">Boutique</span>'
					,"boutique"=>$r["boutique"]
					,"nombre"=>$r["nb"]
					,"montant_euro"=>$r["tot_e"],"montant_livre"=>$r["tot_l"],"montant_dollar"=>$r["tot_d"]
					,'avec_droit'=>""
					,'prealable'=>'<span style="float: right;">Nb acheteur</span>'
					,'acheteur'=>$r["nb_a"]
					);
				$i++;
			}			
		}else{
			$i=1;
			foreach ($rsR as $r) {
				$rs[]= array(
					"summary"=>true
					,"recid"=>"S-".$i
					,"id_vente"=>""
					,"auteur"=>$r["auteur"]
					,"date_vente"=>$r["dMin"]." / ".$r["dMax"]
					,"montant_euro"=>$r["tot_e"],"montant_livre"=>$r["tot_l"],"montant_dollar"=>$r["tot_d"]
					,'taxe_taux'=>""
					,'taxe_deduction'=>''
					,'pourcentage'=>''
					);
				$i++;
			}			
		}  
		$this->view->json = json_encode($rs);		
		$this->view->rs = $rs;
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



