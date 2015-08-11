<?php

class ImportController extends Zend_Controller_Action
{
	var $s;
	var $arrMois = array("janvier"=>"01","février"=>"02","mars"=>"03","avril"=>"04","mai"=>"05","juin"=>"06",
		"juillet"=>"07","août"=>"08","septembre"=>"09","octobre"=>"10","novembre"=>"11","décembre"=>"12");
	
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
		    	
		$this->view->inc = $this->_getParam('inc');
		$this->view->ajax = $this->_getParam('ajax');
		$this->view->idObj = $this->_getParam('idObj');
		$this->view->typeObj = $this->_getParam('typeObj');
	}     
	
	
    public function indexAction()
    {
    		$this->initInstance();        						
		$ssUpload = new Zend_Session_Namespace('upload');
		$ssUpload->idObj = $this->view->idObj;
		$ssUpload->typeObj = $this->view->typeObj;
    		
    }
    
    public function venteAction()
    {
    		$this->initInstance();        						
    }

    public function setdataficventeAction()
    {
    		$this->initInstance();
		switch ($this->_getParam('type',"")) {
			case "Wiley":
				$w = new Flux_Wiley(false,true);
				$w->importer(null,$this->_getParam('idFic'));
				break;			
			case "NBN":
				$nbn = new Flux_Nbn(false,true);
				$nbn->importer(null,$this->_getParam('dateFin'),$this->_getParam('idFic'));
				break;			
			default:
				echo "pas de processus d'importation pour ce type de fichier";
				break;			
		}
    }
    
    public function calculerventeAction()
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
			default:
				echo "pas de processus de calcule pour ce type de fichier";
				break;			
		}
    }    
    
    public function getdataficventeAction()
    {
    		$this->initInstance();
    		$dbData = new Model_DbTable_Iste_importdata();
    		$dbFic = new Model_DbTable_Iste_importfic();
    		
    		//calcul les colonnes 
    		$rsFic = $dbFic->findById_importfic($this->_getParam('idFic'));
    		$cols = json_decode($rsFic["coldesc"]);
    		$arrC = array(
				array("field"=>"recid", "caption"=>"ID", "size"=>'50px', "sortable"=>1, "resizable"=>1)
				,array("field"=>"numrow", "caption"=>"n° lig.", "size"=>'50px', "sortable"=>1, "resizable"=>1)
				,array("field"=>"numsheet", "caption"=>"n° ong.", "size"=>'50px', "sortable"=>1, "resizable"=>1)
				,array("field"=>"commentaire", "caption"=>"commentaire", "size"=>'50px', "sortable"=>1, "resizable"=>1)
				,array("field"=>"id_livre", "caption"=>"Id. livre", "size"=>'50px', "sortable"=>1, "resizable"=>1)
				,array("field"=>"id_isbn", "caption"=>"Id. isbn", "size"=>'50px', "sortable"=>1, "resizable"=>1)
				);
    		$i=1;
    		foreach ($cols as $c) {
    			$arrC[]=array("field"=>"col".$i, "caption"=>$c, "size"=>'50px', "sortable"=>1, "resizable"=>1);
    			$i++;
    		}
    		
    		//récupère les données
    		$arrV = $dbData->findByIdFic($this->_getParam('idFic'));
    		
    		$this->view->json = json_encode(array("col"=>$arrC,"rs"=>$arrV));
    }    
    
    public function resultAction()
    {	
    		$this->initInstance();
    	
    }
    
    public function uploadAction()
    {
    		$this->initInstance();
    	
		if (($stream = fopen('php://delete', "r")) !== FALSE)
    			var_dump(stream_get_contents($stream));
        	
    		$auth = Zend_Auth::getInstance();
		if ($auth->hasIdentity()) {
			$aFic = new Zend_File_Transfer_Adapter_Http();   		
			$dbFic = new Model_DbTable_Iste_importfic();						
			$ssUpload = new Zend_Session_Namespace('upload');
			
			$path = "/data/".$ssUpload->typeObj."_".$ssUpload->idObj."/";
			$options = array('upload_dir' => ROOT_PATH.$path,'upload_url' => WEB_ROOT.$path
				,'print_response'=>false);
			//$upload_handler = new UploadHandler($options);
			$upload_handler = new CustomUploadHandler($options);
	    		$response = $upload_handler->get_response();
			/*
	    		foreach ($response['files'] as $f) {
	    			//on ajoute le fichier dans la base s'il n'est pas présent
	    			$rs = $dbFic->existe(array("nom"=>$f->name,"url"=>$f->url,"size"=>$f->size),true);
	    			if(!$rs){
	    				$ct = "inconu";//$aFic->getMimeType($f->url);
		    			$rs = $dbFic->ajouter(array("nom"=>$f->name,"url"=>$f->url,"size"=>$f->size
		    					,"content_type"=>$ct,"type"=>$this->_getParam('type',"inconu")),false,true);
	    			}
	    			$f->id = $rs["id_importfic"];
	    			$f->type = $rs["type"];
	    		}
	    		*/
	    		$this->view->json = json_encode($response);
		} 
    		/*
    		$dataDoc = array("type" => $this->_getParam('type'));
		$adapter = new Zend_File_Transfer_Adapter_Http();
		$rep = "/data/";
		$path = ROOT_PATH.$rep;
		$adapter->setDestination($path);
	    
		if (!$adapter->receive()) {
			$messages = $adapter->getMessages();
			$this->view->message = implode("Mauvaise réception\n", $messages);
	    }else{
			// Retourne toutes les informations connues sur le fichier
			$files = $adapter->getFileInfo();
			foreach ($files as $file => $info) {
				// Les validateurs sont-ils OK ?
				if (!$adapter->isValid($file)) {
					$this->view->message = "Désolé mais $file ne correspond pas à ce que nous attendons";
					continue;
				}
				//renomme le fichier pour éviter les doublons
				$tabDecomp = explode('.', $info["name"]);
				$extention = ".".strtolower($tabDecomp[sizeof($tabDecomp)-1]);
				
				//récupère les informations nécéssaires
				$dataDoc['nom'] = $prefix.uniqid().$extention;
		        $dataDoc['url'] = WEB_ROOT.$rep.$data['nom'];
		        $dataDoc["content_type"]=$adapter->getMimeType();
				rename(ROOT_PATH.$rep.$info["name"],ROOT_PATH.$rep.$dataDoc['nom']);			    	
	    		}
		}
		*/	      
    }
    
    public function historiqueAction()
    {
    		$this->initInstance();
    	
		$this->s = new Flux_Site();
		$this->s->bTrace = true;		
		$this->s->bTraceFlush = false;		
		$this->s->trace("DEBUT ".__METHOD__);		
		
		$this->dbA = new Model_DbTable_Iste_auteur();
		$this->dbCol = new Model_DbTable_Iste_collection();
		$this->dbCom = new Model_DbTable_Iste_comite();
		$this->dbSerie = new Model_DbTable_Iste_serie();
		$this->dbCoor = new Model_DbTable_Iste_coordination();
		$this->dbLivre = new Model_DbTable_Iste_livre();
		$this->dbLiAut = new Model_DbTable_Iste_livrexauteur();
		$this->dbLiCol = new Model_DbTable_Iste_livrexcollection();
		$this->dbLiSer = new Model_DbTable_Iste_livrexserie();
		$this->dbLiCom = new Model_DbTable_Iste_comitexlivre();
		$this->dbIsbn = new Model_DbTable_Iste_isbn();
		$this->dbPrix = new Model_DbTable_Iste_prix();
		$this->dbProp = new Model_DbTable_Iste_proposition();
		$this->dbProc = new Model_DbTable_Iste_processus();
		$this->dbPrev = new Model_DbTable_Iste_prevision();
		$this->dbCont = new Model_DbTable_Iste_contrat();
		$this->dbAutCont = new Model_DbTable_Iste_auteurxcontrat();
		
		/**TODO:
		 * comment attribuer à un isbn le type "papier" ou "pdf" ?
		 * 
		 */
		
		
		$arrType = array(0, 1, 2, 3, 4);
		$arrType = array(3);
		foreach ($arrType as $type) {
			$this->s->trace("TYPE ".$type);		
			if($type==0)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015SAMbd.csv");
			if($type==1)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015SAMWileyBase.csv");
			if($type==2)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015SAMIsteed.csv");
			if($type==3)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015SAMelsevier.csv");
			if($type==4)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015-DtsAuteursWiley.csv");			
			$i = 1;
			$this->s->trace("nb Ligne ".count($arr));		
			foreach ($arr as $r) {
				if($type==0)$this->importGlobalBD($r, $i);
				if($type==1)$this->importGlobalWileyBase($r, $i);
				if($type==2)$this->importGlobalIsteEdition($r, $i, 0);
				if($type==3)$this->importGlobalElsevier($r, $i);
				if($type==4)$this->importGlobalDtsAuteursWiley($r, $i);
				$i++;
				//if($i>1)return;
			}
		}

		$this->s->trace("FIN ".__METHOD__);		
    }

	function importGlobalDtsAuteursWiley($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);		
		//traitement des références sans auteur
    		if(!$r[2]){
	    		$this->s->trace($i." références sans auteur : ".$r[0]);			
    		}else{
	    		//recherche les références
	    		$rIsbn = $this->dbIsbn->findByNum($r[0]);
	    		$this->s->trace($i." recherche la référence isbn par num : ".$r[0]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
	    		if(!$rIsbn){
	    			$this->s->trace($i." référence isbn non trouvée : ".$r[0]);
	    		}else{
	    			$this->s->trace($i." recherche l'auteur : ".$r[2]);
				$arrId = $this->findAuteur($r[2]);
	    			//print_r($arrId);
				foreach ($arrId as $rAut) {
	    				$this->s->trace($i." recherche le contrat : ".$r[2]." ".$rAut);
	    				$idCont = 2;
	    				$rAutCont = $this->dbAutCont->findByIdAutIdContIdIsbn($rAut["id_auteur"], $idCont, $rIsbn["id_isbn"]);
	    				if(!$rAutCont){
		    				$this->s->trace($i." Pas de contrat pour : ".$rAut["id_auteur"]." ".$idCont." ".$rIsbn["id_isbn"]);	    					
	    				}else{
		    				$this->s->trace($i." vérifie si des droits sont accordés : ".$r[4]." à l'auteur : ".$rAut["id_auteur"]." ".$rAut["nom"]." ".$rAut["prenom"]);
		    				if($r[4]=="PAS DE DROITS" || $r[4]=="DECEDE" || $r[4]=="ABANDONNE"){
		    					$this->s->trace($i." mise à jour des commentaires : ".$r[4]);	    					
		    					$this->dbAutCont->edit($rAutCont["id_auteurxcontrat"], array("commentaire"=>$r[4]));
		    				}else{
		    					$this->dbAutCont->edit($rAutCont["id_auteurxcontrat"], array("pc_papier"=>$r[7], "pc_ebook"=>$r[8]));
		    					$this->s->trace($i." mise à jour des conditions : ".$r[7]." ".$r[8]);	
							$arrCPV = explode(" ", $r[5]);    					
		    					$this->dbA->edit($rAut["id_auteur"], array("adresse_1"=>$r[3],"adresse_2"=>$r[4], "code_postal"=>$arrCPV[0], "ville"=>$arrCPV[1], "pays"=>$r[6]));
		    					$this->s->trace($i." mise à jour des infos auteurs : ".$r[3]." ".$r[4]." code_postal:".$arrCPV[0]." ville:".$arrCPV[1]." ".$r[6]);	
		    				}		    				
	    				}
	    			}
	    		}
    		}
		$this->s->trace("FIN ".__METHOD__);		
	}     
    
	function importGlobalElsevier($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);		
		//traitement des références sans titre
    		if(!$r[1]){
			$idLivre = $this->dbLivre->ajouter(array("titre_en"=>"ISBN Elsevier sans titre","soustitre_en"=>$r[0]));
			$idIsbn = $this->dbIsbn->ajouter(array("id_livre"=>$idLivre,"id_editeur"=>4,"num"=>$r[0]));				
	    		$this->s->trace($i." ajoute les références sans titre : ".$r[0]." = ".$idIsbn);			
    		}else{
    			$dateParution = $this->formatDateExcelToSql($r[8]);
	    		//recherche les références
	    		$rIsbn = $this->dbIsbn->findByNum($r[0]);
	    		$this->s->trace($i." recherche la référence isbn par num : ".$r[0]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
	    		if(!$rIsbn){
	    			$rsIsbn = $this->dbIsbn->findByTitreEditeur($r[2], 4);
	    			foreach ($rsIsbn as $rIsbn) {
		    			$this->s->trace($i." référence isbn trouvée par titre éditeur : ".$r[2]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
		    			if($id==0){
			    			$this->dbIsbn->edit($rIsbn["id_isbn"],array("num"=>$r[0],"nb_page"=>$r[9],"date_parution"=>$dateParution));				
				    		$this->s->trace($i." ISBN modifié : ".$rIsbn["id_isbn"]);	
		    			}else{
		    				$rIsbn = $this->dbIsbn->ajouter(array("id_editeur"=>4,"num"=>$r[0],"id_livre"=>$rIsbn["id_livre"],"nb_page"=>$r[9],"date_parution"=>$dateParution));				
				    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);			    				
		    			}
		    			$idLivre = $rIsbn["id_livre"];						
	    			}
	    			if (!$rIsbn){
		    			$rsIsbn = $this->dbIsbn->findByTitre($r[2]);
		    			foreach ($rsIsbn as $rIsbn) {
			    			$this->s->trace($i." référence isbn trouvée par titre : ".$r[2]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
			    			if($id==0){
				    			$this->dbIsbn->edit($rIsbn["id_isbn"],array("id_editeur"=>4,"num"=>$r[0],"nb_page"=>$r[9],"date_parution"=>$dateParution));				
					    		$this->s->trace($i." ISBN modifié : ".$rIsbn["id_isbn"]);	
			    			}else{
			    				$rIsbn = $this->dbIsbn->ajouter(array("num"=>$r[0],"id_livre"=>$rIsbn["id_livre"],"nb_page"=>$r[9],"date_parution"=>$dateParution));				
					    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);			    				
			    			}
				    		$idLivre = $rIsbn["id_livre"];										    		
		    			}
		    			if(!$rIsbn){
		    				$rsLivre = $this->dbLivre->findByTitre_en($r[2]);
		    				foreach ($rsLivre as $rLivre) {
					    		$this->s->trace($i." livre trouvé par titre : ".$rLivre["titre_en"]." = ".$rLivre["id_livre"]);								    				
			    				$rIsbn = $this->dbIsbn->ajouter(array("num"=>$r[0],"id_livre"=>$rLivre["id_livre"],"nb_page"=>$r[9],"date_parution"=>$dateParution));				
					    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);
					    		$idLivre = $rLivre["id_livre"];											    		
		    				}
			    			if(!$rIsbn){
					    		$this->s->trace($i." livre non trouvé : ".$r[2]);
					    		$arrId = $this->ajoutLivre(array(
					    			"serie"=>array("titre_en"=>$r[6],"titre_fr"=>"")
					    			,"comite"=>array("titre_en"=>$r[13],"titre_fr"=>"")
					    			,"livre"=>array("type_1"=>$r[4],"type_2"=>$r[5]
									,"titre_en"=>$r[2],"soustitre_en"=>$r[3],"num_vol"=>$r[7])
					    			));
							$idLivre = $arrId[0];						    			
					    		$this->s->trace($i." livre crée : ".$idLivre);
					    									
			    				$rIsbn = $this->dbIsbn->ajouter(array("num"=>$r[0],"id_livre"=>$idLivre,"nb_page"=>$r[9],"date_parution"=>$dateParution));				
					    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);								    						    					
					    		
			    				
			    			}
		    				
		    			}	    			
	    			}
	    		}else{
			    	$this->s->trace($i." référence isbn trouvée par num : ".$r[0]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
	    			$this->dbIsbn->edit($rIsbn["id_isbn"],array("nb_page"=>$r[9],"date_parution"=>$dateParution));				
		    		$this->s->trace($i." ISBN modifié : ".$rIsbn["id_isbn"]);	
		    		$idLivre = $rIsbn["id_livre"];						
	    		}
	    		if($rIsbn["id_isbn"]){
		    		$this->s->trace($i." ajout des prix : ".$rIsbn["id_isbn"]);							
	    			//ajout des prix 
				if($r[15]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_dollar"=>$r[10],"type"=>"prix catalogue"));	    				
				if($r[15]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[15],"type"=>"cout total"));
				if($r[16]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[16],"type"=>"prix unitaire"));
	    		}
	    		if($idLivre){
	    			$this->s->trace($i."//import des auteurs");			
				$arrIdAut = $this->ajoutAuteur($r[1]);
				foreach ($arrIdAut as $idA) {
					if($r[11]){
						$idCont = $this->dbCont->ajouter(array("nom"=>"Contrat auteur","type"=>"auteur"));			
						$this->dbAutCont->ajouter(array("id_auteur"=>$idA, "id_livre"=>$idLivre, "id_isbn"=>$rIsbn["id_isbn"], "id_contrat"=>$idCont, "date_signature"=>$this->formatDateExcelToSql($r[11])));
					}												
					$this->dbLiAut->ajouter(array("id_auteur"=>$idA, "id_livre"=>$idLivre, "role"=>"auteur"));
				}

	    			$this->s->trace($i."//import du coordinateur");			
				$arrIdAut = $this->ajoutAuteur($r[12]);
				foreach ($arrIdAut as $idA) {
					$this->dbLiAut->ajouter(array("id_auteur"=>$idA, "id_livre"=>$idLivre, "role"=>"coordinateur"));
				}
	    		}
    		}
		$this->s->trace("FIN ".__METHOD__);		
	}     
    
	function importGlobalIsteEdition($r, $i, $id){
		$this->s->trace("DEBUT ".__METHOD__);		
		//traitement des références sans titre
    		if(!$r[2] && $id==0){
			$idLivre = $this->dbLivre->ajouter(array("titre_en"=>"ISBN papier ISTE Edition sans titre","soustitre_en"=>$r[0]));
			$idIsbn = $this->dbIsbn->ajouter(array("id_livre"=>$idLivre,"id_editeur"=>1,"num"=>$r[0], "type"=>"Papier FR"));				
	    		$this->s->trace($i." ajoute les références sans titre : ".$r[0]." = ".$idIsbn);			
			$idLivre = $this->dbLivre->ajouter(array("titre_en"=>"ISBN e-book ISTE Edition sans titre","soustitre_en"=>$r[1]));
			$idIsbn = $this->dbIsbn->ajouter(array("id_livre"=>$idLivre,"id_editeur"=>1,"num"=>$r[1], "type"=>"E-Book FR"));				
	    		$this->s->trace($i." ajoute les références sans titre : ".$r[1]." = ".$idIsbn);				    		
    		}else{
	    		//recherche les références
	    		$rIsbn = $this->dbIsbn->findByNum($r[$id]);
	    		$this->s->trace($i." recherche la référence isbn par num : ".$r[$id]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
	    		if(!$rIsbn){
	    			$rsIsbn = $this->dbIsbn->findByTitreEditeur($r[3], 1, "fr");
	    			foreach ($rsIsbn as $rIsbn) {
		    			$this->s->trace($i." référence isbn trouvée par titre éditeur : ".$r[3]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
		    			if($id==0){
			    			$this->dbIsbn->edit($rIsbn["id_isbn"],array("type"=>"Papier FR","num"=>$r[$id],"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11],"m")));				
				    		$this->s->trace($i." ISBN modifié : ".$rIsbn["id_isbn"]);	
		    			}else{
		    				$rIsbn = $this->dbIsbn->ajouter(array("type"=>"E-Book FR","id_editeur"=>1,"num"=>$r[$id],"id_livre"=>$rIsbn["id_livre"],"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11],"m")));				
				    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);			    				
		    			}
		    			$idLivre = $rIsbn["id_livre"];						
	    			}
	    			if (!$rIsbn){
		    			$rsIsbn = $this->dbIsbn->findByTitre($r[3], "fr");
		    			foreach ($rsIsbn as $rIsbn) {
			    			$this->s->trace($i." référence isbn trouvée par titre : ".$r[3]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
			    			if($id==0){
				    			$this->dbIsbn->edit($rIsbn["id_isbn"],array("type"=>"Papier FR","id_editeur"=>1,"num"=>$r[$id],"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11],"m")));				
					    		$this->s->trace($i." ISBN modifié : ".$rIsbn["id_isbn"]);	
			    			}else{
			    				$rIsbn = $this->dbIsbn->ajouter(array("type"=>"E-Book FR","num"=>$r[$id],"id_livre"=>$rIsbn["id_livre"],"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11],"m")));				
					    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);			    				
			    			}
				    		$idLivre = $rIsbn["id_livre"];										    		
		    			}
		    			if(!$rIsbn){
		    				$rsLivre = $this->dbLivre->findByTitre_fr($r[3]);
		    				foreach ($rsLivre as $rLivre) {
					    		$this->s->trace($i." livre trouvé par titre : ".$rLivre["titre_fr"]." = ".$rLivre["id_livre"]);								    				
			    				$rIsbn = $this->dbIsbn->ajouter(array("type"=>"Papier FR","num"=>$r[$id],"id_livre"=>$rLivre["id_livre"],"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11],"m")));				
					    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);
					    		$idLivre = $rLivre["id_livre"];											    		
		    				}
			    			if(!$rIsbn){
					    		$this->s->trace($i." livre non trouvé : ".$r[2]);
					    		$arrId = $this->ajoutLivre(array(
					    			"serie"=>array("titre_fr"=>$r[7],"titre_en"=>"")
					    			,"comite"=>array("titre_en"=>"","titre_fr"=>$r[9])
					    			,"livre"=>array("type_1"=>$r[5]
									,"titre_fr"=>$r[3],"soustitre_fr"=>$r[4],"num_vol"=>$r[7])
					    			));
							$idLivre = $arrId[0];						    			
					    		$this->s->trace($i." livre crée : ".$idLivre);
					    									
			    				$rIsbn = $this->dbIsbn->ajouter(array("num"=>$r[$id],"id_livre"=>$idLivre,"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11],"m")));				
					    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);								    						    					
					    		
			    				
			    			}
		    				
		    			}	    			
	    			}
	    		}else{
			    	$this->s->trace($i." référence isbn trouvée par num : ".$r[3]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
	    			$this->dbIsbn->edit($rIsbn["id_isbn"],array("tirage"=>$r[14],"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11],"m")));				
		    		$this->s->trace($i." ISBN modifié : ".$rIsbn["id_isbn"]);	
		    		$idLivre = $rIsbn["id_livre"];						
	    		}
	    		if($rIsbn["id_isbn"]){
		    		$this->s->trace($i." ajout des prix : ".$rIsbn["id_isbn"]);							
	    			//ajout des prix 
	    			if($id==0){
					if($r[15]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[15],"prix_euro"=>$r[16],"type"=>"prix catalogue"));	    				
	    			}else{
					if($r[17]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_euro"=>$r[17],"pdf"=>$id,"type"=>"prix catalogue"));	    				
	    			}
				if($r[15]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[13],"type"=>"cout total"));
				if($r[16]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[14],"type"=>"cout à la page"));
	    		}
	    		if($idLivre){
	    			$this->s->trace($i."//import des auteurs");			
				$arrIdAut = $this->ajoutAuteur($r[2]);
				foreach ($arrIdAut as $idA) {
					if($r[10]){
						$idCont = $this->dbCont->ajouter(array("nom"=>"Contrat auteur","type"=>"auteur"));			
						$this->dbAutCont->ajouter(array("id_auteur"=>$idA, "id_livre"=>$idLivre, "id_isbn"=>$rIsbn["id_isbn"], "id_contrat"=>$idCont, "date_signature"=>$this->formatDateExcelToSql($r[11])));
			    		}												
					$this->dbLiAut->ajouter(array("id_auteur"=>$idA, "id_livre"=>$idLivre, "role"=>"auteur"));
				}

	    			$this->s->trace($i."//import du coordinateur");			
				$arrIdAut = $this->ajoutAuteur($r[8]);
				foreach ($arrIdAut as $idA) {
					$this->dbLiAut->ajouter(array("id_auteur"=>$idA, "id_livre"=>$idLivre, "role"=>"coordinateur"));
				}
	    		}
	    		if($id==0) $this->importGlobalIsteEdition($r, $i, 1);	    	  		
    		}
		$this->s->trace("FIN ".__METHOD__);		
	}    
    
    function importGlobalWileyBase($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);		
    		//traitement des références sans titre
    		if(!$r[2]){
			$idLivre = $this->dbLivre->ajouter(array("titre_en"=>"ISBN Wiley sans titre","soustitre_en"=>$r[0]));
			$idIsbn = $this->dbIsbn->ajouter(array("id_livre"=>$idLivre,"id_editeur"=>5,"num"=>$r[0]));				
	    		$this->s->trace($i." ajoute les références sans titre : ".$r[0]." = ".$idIsbn);			
    		}else{
	    		//recherche les références
	    		$rIsbn = $this->dbIsbn->findByNum($r[0]);
	    		$this->s->trace($i." recherche la référence isbn par num : ".$r[0]." = ".$rsIsbn["id_isbn"]." - ".$rsIsbn["id_livre"]);
	    		if(!$rIsbn){
	    			$rsIsbn = $this->dbIsbn->findByTitreEditeur($r[2], 5);
	    			foreach ($rsIsbn as $rIsbn) {
		    			$this->s->trace($i." référence isbn trouvée par titre éditeur : ".$r[2]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
		    			$this->dbIsbn->edit($rIsbn["id_isbn"],array("num"=>$r[0],"tirage"=>$r[14],"nb_page"=>$r[9],"date_parution"=>$this->formatDateExcelToSql($r[8])));				
			    		$this->s->trace($i." ISBN modifié : ".$rIsbn["id_isbn"]);							
		    			$idLivre = $rIsbn["id_livre"];						
	    			}
	    			if (!$rIsbn){
		    			$rsIsbn = $this->dbIsbn->findByTitre($r[2]);
		    			foreach ($rsIsbn as $rIsbn) {
			    			$this->s->trace($i." référence isbn trouvée par titre : ".$r[2]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
			    			$this->dbIsbn->edit($rIsbn["id_isbn"],array("id_editeur"=>5,"num"=>$r[0],"tirage"=>$r[14],"nb_page"=>$r[9],"date_parution"=>$this->formatDateExcelToSql($r[8])));				
				    		$this->s->trace($i." ISBN modifié : ".$rIsbn["id_isbn"]);
				    		$idLivre = $rIsbn["id_livre"];										    		
		    			}
		    			if(!$rIsbn){
		    				$rsLivre = $this->dbLivre->findByTitre_en($r[2]);
		    				foreach ($rsLivre as $rLivre) {
					    		$this->s->trace($i." livre trouvé par titre : ".$rLivre["titre_en"]." = ".$rLivre["id_livre"]);								    				
			    				$rIsbn = $this->dbIsbn->ajouter(array("num"=>$r[0],"id_livre"=>$rLivre["id_livre"],"tirage"=>$r[14],"nb_page"=>$r[9],"date_parution"=>$this->formatDateExcelToSql($r[8])));				
					    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);
					    		$idLivre = $rLivre["id_livre"];						
					    		
		    				}
			    			if(!$rIsbn){
					    		$this->s->trace($i." livre non trouvé : ".$r[2]);
					    		$arrId = $this->ajoutLivre(array(
					    			"serie"=>array("titre_en"=>$r[6],"titre_fr"=>"")
					    			,"comite"=>array("titre_en"=>$r[13],"titre_fr"=>"")
					    			,"livre"=>array("type_1"=>$r[4],"type_2"=>$r[5]
									,"titre_en"=>$r[2],"soustitre_en"=>$r[3],"num_vol"=>$r[7])
					    			));
							$idLivre = $arrId[0];						    			
					    		$this->s->trace($i." livre crée : ".$idLivre);
					    									
			    				$rIsbn = $this->dbIsbn->ajouter(array("num"=>$r[0],"id_livre"=>$idLivre,"tirage"=>$r[14],"nb_page"=>$r[9],"date_parution"=>$this->formatDateExcelToSql($r[8])));				
					    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);								    						    					
					    		
			    				
			    			}
		    				
		    			}	    			
	    			}
	    		}else{
			    	$this->s->trace($i." référence isbn trouvée par num : ".$r[2]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
	    			$this->dbIsbn->edit($rIsbn["id_isbn"],array("tirage"=>$r[14],"nb_page"=>$r[9],"date_parution"=>$this->formatDateExcelToSql($r[8])));				
		    		$this->s->trace($i." ISBN modifié : ".$rIsbn["id_isbn"]);	
		    		$idLivre = $rIsbn["id_livre"];						
	    		}
	    		if($rIsbn["id_isbn"]){
		    		$this->s->trace($i." ajout des prix : ".$rIsbn["id_isbn"]);							
	    			//ajout des prix 
				if($r[10]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_dollar"=>$r[10],"type"=>"prix catalogue"));
				if($r[15]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[15],"type"=>"cout total"));
				if($r[16]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[16],"type"=>"cout unitaire"));
	    		}
	    		if($idLivre){
	    			$this->s->trace($i."//import des auteurs");			
				$arrIdAut = $this->ajoutAuteur($r[1]);
	    			$this->s->trace($i." auteurs trouvés = ".count($arrIdAut));			
				foreach ($arrIdAut as $id) {
					if($r[11]){
						$idCont = $this->dbCont->ajouter(array("nom"=>"Contrat auteur","type"=>"auteur"));
	    					$this->s->trace($i." contrat ajouté = ".$idCont." ".$rIsbn["id_isbn"]);
						$this->dbAutCont->ajouter(array("id_auteur"=>$id, "id_livre"=>$idLivre, "id_isbn"=>$rIsbn["id_isbn"], "id_contrat"=>$idCont, "date_signature"=>$this->formatDateExcelToSql($r[11])));
					}
					print_r(array("id_auteur"=>$id, "id_livre"=>$idLivre, "role"=>"auteur"));												
					$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$idLivre, "role"=>"auteur"));
				}

	    			$this->s->trace($i."//import du coordinateur");			
				$arrIdAut = $this->ajoutAuteur($r[12]);
				foreach ($arrIdAut as $id) {
					$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$idLivre, "role"=>"coordinateur"));
				}
	    		}
    		}
		$this->s->trace("FIN ".__METHOD__);		
    }
    
    function importGlobalBD($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);		
    	
    		$arrId = $this->ajoutLivre(array(
    			"serie"=>array("ref_racine"=>$r[0],"titre_en"=>$r[4],"titre_fr"=>$r[5])
    			,"collection"=>array("titre_en"=>$r[4],"titre_fr"=>$r[5])
    			,"comite"=>array("titre_en"=>$r[8],"titre_fr"=>"")
    			,"livre"=>array("reference"=>$r[1],"type_1"=>$r[18],"type_2"=>$r[9]
				,"titre_en"=>$r[11],"soustitre_en"=>$r[12],"titre_fr"=>$r[13],"soustitre_fr"=>$r[14]
				,"num_vol"=>$r[6])
    			));
		$idLivre = $arrId[0];
		$idSerie = $arrId[1];
		
		$this->s->trace($i."//import des directeurs de collection");			
			$arrIdAut = $this->ajoutAuteur($r[7]);
			//ajout des coordinations
			foreach ($arrIdAut as $id) {
				$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$idLivre, "role"=>"directeur"));
				$idCoor = $this->dbCoor->ajouter(array("id_serie"=>$idSerie, "id_auteur"=>$id));
				if($r[3]){
					$idCont = $this->dbCont->ajouter(array("nom"=>"Contrat de coordination","type"=>"coordination"));			
					$this->dbAutCont->ajouter(array("id_auteur"=>$id, "id_serie"=>$idSerie, "id_contrat"=>$idCont, "date_signature"=>$this->formatDateExcelToSql($r[3])));
				}				
			}
				
		$this->s->trace($i."//import des auteurs");			
			$arrIdAut = $this->ajoutAuteur($r[10]);
			foreach ($arrIdAut as $id) {
				$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$idLivre, "role"=>"auteur"));
			}			

			
		$this->s->trace($i."//import des isbn");	
			$idIsbn = false;		
			switch ($r[25]) {
				case 1:
					$idEditeur = 5;//'Wiley'
					break;
				case 2:
					$idEditeur = 4;//'Elsevier'
					break;
				case 3:
					$idEditeur = 2;//'ISTE International'
					break;
				default:
					$idEditeur = 3;//'ISTE Press'
					break;
			}
			//gestion de la date 
			$date_parution = null;
			if($r[19]=="GB") $date_parution = $r[37];
			if($r[19]=="FR") $date_parution = $r[40];
			//creation des data isbn;
			$dataIsbn = array("id_livre"=>$idLivre,"id_editeur"=>$idEditeur);
			if($r[33])$dataIsbn["nb_page"]=$r[33];
			if($date_parution)$dataIsbn["date_parution"]=$this->formatDateExcelToSql($date_parution);		
			
			//gestion de l'éditeur
			if($r[26]){//'Wiley'
				$dataIsbn["id_editeur"]=5;
				$dataIsbn["num"]=$r[26];
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);				
			}
			if($r[27]){//'Elsevier'
				$dataIsbn["id_editeur"]=4;
				$dataIsbn["num"]=$r[27];
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);				
			}
			if($r[28]){//'ISTE Editions'
				$dataIsbn["id_editeur"]=1;
				$dataIsbn["num"]=$r[28];
				$dataIsbn["type"]="Papier FR";
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);				
			}
			
			//vérifie si l'isbn est créé
			if(!$idIsbn)
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);	
			
			//gestion du prix
			if($r[34]) $this->dbPrix->ajouter(array("id_isbn"=>$idIsbn,"prix_dollar"=>$r[34],"type"=>"GB - suivi de la fabrication"));
			
		$this->s->trace($i."//import des propositions");	
			$dataProp = array('id_livre'=>$idLivre,"base_contrat"=>$r[17]
				,"publication_en"=>$r[20],"publication_fr"=>$r[21],"nb_page_fr"=>$r[23]);
			
			if($r[15]=="reçu")$dataProp['date_debut']=new Zend_Db_Expr('NOW()');
			elseif ($r[15])$dataProp['date_debut']=$this->formatDateExcelToSql($r[15]);
			
			if(substr($r[16], 0, 3)=="ENV")$dataProp['date_contrat']=$this->formatDateExcelToSql(substr($r[16], 4));
			elseif ($r[16])$dataProp['date_contrat']=$this->formatDateExcelToSql($r[16]);
			
			if($r[22])$dataProp['traduction']="français -> anglais";

			if($r[24])$dataProp['date_manuscrit']=$this->formatDateExcelToSql($r[24]);

			if($r[19]=="GB")$dataProp['langue']="anglais";
			if($r[19]=="FR")$dataProp['langue']="français";
			
			$this->dbProp->ajouter($dataProp);
					
			if($r[22]){
				$this->dbProc->setProcessusForLivre('Traduction livre', $idLivre, 1,false);	
				$this->s->trace($i." import des processus de traduction");	
			}     		    			
			$rsProc = $this->dbProc->setProcessusForLivre('Production livre', $idLivre, 1,false);    		    			
			$this->s->trace($i." import des processus de production = ".$rsProc);	
			
			if($r[29])$this->dbPrev->edit($id, array("fin"=>$this->formatDateExcelToSql($r[29])));
			if($r[30])$this->dbPrev->edit($id, array("fin"=>$this->formatDateExcelToSql($r[30])));
			if($r[31])$this->dbPrev->edit($id, array("prevision"=>$this->formatDateExcelToSql($r[31])));
			if($r[32])$this->dbPrev->edit($id, array("prevision"=>$this->formatDateExcelToSql($r[32])));			
		$this->s->trace("FIN ".__METHOD__);					
    }

    function ajoutLivre($data){

		$this->s->trace($i."//import des livres");			
		$idLivre = $this->dbLivre->ajouter($data["livre"]);
    		
		if($data["serie"]){
			$idSerie = $this->dbSerie->ajouter($data["serie"],true,false);
			$this->s->trace($i."//import des séries : ".$idSerie." ".$idLivre);
			$this->dbLiSer->ajouter(array("id_serie"=>$idSerie, "id_livre"=>$idLivre));
		}
			
		if($data["collection"]){
			$this->s->trace($i."//import des collections");			
			$idCol = $this->dbCol->ajouter($data["collection"]);
			$this->dbLiCol->ajouter(array("id_collection"=>$idCol, "id_livre"=>$idLivre));
		}	

		if($data["comite"]){
			$this->s->trace($i."//import des commités");			
			$idCom = $this->dbCom->ajouter($data["comite"]);			
			$this->dbLiCom->ajouter(array("id_comite"=>$idCom, "id_livre"=>$idLivre));
		}

		return array($idLivre,$idSerie,$idCol,$idCom);
    }
    
    function ajoutAuteur($r){
		$arrAuteur = explode(",", $r);
		$arrId = array();
		foreach ($arrAuteur as $a) {
			$np = explode(" ", trim($a));
			if(count($np)>2)
				$arrId[] = $this->dbA->ajouter(array("nom"=>$np[0].' '.$np[1], "prenom"=>$np[2]));
			else{
				if($np[0] && $np[1])$arrId[] = $this->dbA->ajouter(array("nom"=>$np[0], "prenom"=>$np[1]));
				if(!$np[0] && $np[1])$arrId[] = $this->dbA->ajouter(array("nom"=>$np[1]));
				if($np[0] && !$np[1])$arrId[] = $this->dbA->ajouter(array("nom"=>$np[0]));
			}
			$this->s->trace($i." - Nom : ".$np[0].", "."Prénom ".$np[1]);
		}
		return $arrId;
    }

    function findAuteur($r){
		$arrAuteur = explode(",", $r);
		//$arrId = array();
		$i=0;
		foreach ($arrAuteur as $a) {
			$np = explode(" ", trim($a));
			$this->s->trace($i." - Nom : ".$np[0].", "."Prénom ".$np[1]);
			if(count($np)>2){
				foreach ($np as $k => $v) {
					$this->s->trace($i." ".$k." : ".$v);
				}
				if((trim($np[2])=="et" || trim($np[2])=="and") && trim($np[3])!="al."){
					$arr = $this->dbA->findByNomPrenom($np[0], $np[1]);					
					if($arr){
						$arrId[$i]=$arr;
						$i++;	
					}
					$arr = $this->dbA->findByNomPrenom($np[3], $np[4]);					
				}else
					$arr = $this->dbA->findByNomPrenom($np[0].' '.$np[1], $np[2]);
			}else{
				if($np[0] && $np[1]){
					$arr = $this->dbA->findByNomPrenom($np[0], $np[1]);
				}	
				if(!$np[0] && $np[1]){
					$arr = $this->dbA->findByNomPrenom($np[1], "");
				}
				if($np[0] && !$np[1]){
					$arr = $this->dbA->findByNomPrenom($np[0], "");
				}
			}
			if($arr){
				$arrId[$i]=$arr;
				$i++;	
			}
			/*
			$this->s->trace($i." auteur trouvé");
			print_r($arr);
			$this->s->trace($i." auteur cumulé");
			print_r($arrId);
			*/
		}
		return $arrId;
    }
    
    function formatDateExcelToSql($d, $format="/"){
    		$strDate = "";
    		if($format=="/"){
	    		$arr = explode("/", $d);
	    		if(count($arr)==3) $strDate = $arr[2]."-".$arr[1]."-".$arr[0];
    		}
    		if($format=="m"){
	    		$arr = explode("-", $d);
    			$strDate = $arr[1]."-".$this->arrMois[$arr[0]]."-01";
    		}
    		
		//$this->s->trace($d." : ".$strDate);
    		return $strDate;
    	
    }
    
}



