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
		$this->view->nameObj = $this->_getParam('nameObj');
	}     
	
	
    public function indexAction()
    {
    		$this->initInstance();        						
		$ssUpload = new Zend_Session_Namespace('upload');
		$ssUpload->idObj = $this->view->idObj;
		$ssUpload->typeObj = $this->view->typeObj;
		$ssUpload->nameObj = $this->view->nameObj;
		
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
	    		$this->view->json = json_encode($response);
		} 
    			      
    }
    
    public function historiqueAction()
    {
    		$this->initInstance();
    	
		$this->s = new Flux_Site();
		$this->s->bTrace = true;		
		$this->s->bTraceFlush = true;		
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
		$this->dbLic = new Model_DbTable_Iste_licence();
		
		/**TODO:
		 * comment attribuer à un isbn le type "papier" ou "pdf" ?
		 * 
		 */
		
		
		$arrType = array(0, 1, 2, 3, 4);
		$arrType = array(6);
		foreach ($arrType as $type) {
			$this->s->trace("TYPE ".$type);		
			if($type==0)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015BD.csv");
			if($type==1)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015WileyBase.csv");
			if($type==2)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015ISTEedition.csv");
			if($type==3)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015Elsevier.csv");
			if($type==4)$arr = $this->s->csvToArray("../bdd/import/DtsAuteursWiley.csv");
			if($type==5)$arr = $this->s->csvToArray("../bdd/import/ISTE-EDITIONS-AUTEURS.csv");
			if($type==6)$arr = $this->s->csvToArray("../bdd/import/ISTEPourcentageDroitsN.csv");
			
			$i = 1;
			$this->s->trace("nb Ligne ".count($arr));		
			foreach ($arr as $r) {
				if($type==0)$this->importGlobalBD($r, $i);
				if($type==1)$this->importGlobalWileyBase($r, $i);
				if($type==2)$this->importGlobalIsteEdition($r, $i, 0);
				if($type==3)$this->importGlobalElsevier($r, $i);
				if($type==4)$this->importGlobalDtsAuteursWiley($r, $i);
				if($type==5)$this->importAuteurs($r, $i);
				if($type==6)$this->importDroitsAuteurs($r, $i);
				$i++;
				//if($i>20)return;
			}
		}

		$this->s->trace("FIN ".__METHOD__);		
    }

	function importAuteurs($r, $i){
		//gestion des lignes vides
		if(!$r[0]){$this->s->trace($i." ligne vide");return;}
		
		$this->s->trace("DEBUT ".__METHOD__);		
		$noms = explode(" ", $r[1]);
		$nom = str_replace("_", " ", $noms[0]);
		$prenom = str_replace("_", " ", $noms[1]);
		if($r[0]=="Mme") $civil = $r[0]; else $civil = "Mr";
		$this->s->trace($i." recherche l'auteur : ".$nom." ".$prenom);
		$arrA = $this->dbA->findByNomPrenom($nom, $prenom);
		
		$data = array("nom"=>$nom, "prenom"=>$prenom, "civilite"=>$civil, "adresse_1"=>$r[2], "adresse_2"=>$r[3]
			, "ville"=>$r[5], "code_postal"=>$r[4], "pays"=>$r[6]
			, "telephone_mobile"=>$r[7], "telephone_fixe_bureau"=>$r[8], "telephone_fixe_dom"=>$r[9]
			, "mail_1"=>$r[10], "mail_2"=>$r[11]);
		if(!isset($arrA["id_auteur"])){
			$arrA = $this->dbA->ajouter($data);		
			$this->s->trace($i." Auteur ajouté : ".$arrA["id_auteur"], $data);
		}else{
			$this->dbA->edit($arrA["id_auteur"], $data);		
			$this->s->trace($i." Auteur mis à jour : ".$arrA["id_auteur"], $data);
		}

		$this->s->trace("FIN ".__METHOD__);		
	}     
    
	function importDroitsAuteurs($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);		
		//gestion des lignes vides
		if(!$r[0]){$this->s->trace($i." ligne vide");return;}
		
    		//recherche les références
    		$rIsbn = $this->dbIsbn->findByNum($r[0]);
		if($rIsbn["id_isbn"])
	    		$this->s->trace($i." référence isbn par num : ".$r[0]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
		else{
			$this->s->trace($i." références ISBN non trouvées : ".$r[0]);
			return;			
		}
		
		$idContAut = $this->dbCont->ajouter(array("nom"=>"Contrat auteur","type"=>"auteur"));			
		$idContDir = $this->dbCont->ajouter(array("nom"=>"Contrat directeur","type"=>"directeur"));			
		
		$noms = explode(" ", $r[1]);
		$nom = str_replace("_", " ", $noms[0]);
		$prenom = str_replace("_", " ", $noms[1]);
		$arrA = $this->dbA->findByNomPrenom($nom, $prenom);

		if($arrA["id_auteur"]){
			$this->s->trace($i." recherche l'auteur : ".$nom." ".$prenom." = ".$arrA["id_auteur"]);
			$data = array("id_auteur"=>$arrA["id_auteur"], "id_livre"=>$rIsbn["id_livre"], "id_isbn"=>$rIsbn["id_isbn"]
				,"pc_ebook"=>$r[4], "pc_papier"=>$r[3], "id_contrat"=>$idContAut);
    			$this->s->trace($i." ajouter un contrat auteur ",$data);
			$this->dbAutCont->ajouter($data, true, false, true);
		}else{
			$this->s->trace($i." références Auteur non trouvées : ".$nom." ".$prenom);
			return;			
		}    		
    		
		$arrColl = explode(",", $r[6]);
		foreach ($arrColl as $c) {
			$arrDroit = explode(" ", $c);	
			$this->s->trace($i." récupère les droits : ", $arrDroit);
			$nom = str_replace("_", " ", $arrDroit[1]);
			$prenom = str_replace("_", " ", $arrDroit[2]);
			$arrA = $this->dbA->findByNomPrenom($nom, $prenom);
			$this->s->trace($i." recherche du directeur : ".$nom." ".$prenom." = ".$arrA["id_auteur"]);
			if(isset($arrA["id_auteur"])){
				$data = array("id_auteur"=>$arrA["id_auteur"], "id_livre"=>$rIsbn["id_livre"], "id_isbn"=>$rIsbn["id_isbn"]
					,"pc_ebook"=>$arrDroit[0], "pc_papier"=>$arrDroit[0], "id_contrat"=>$idContDir);
	    			$this->s->trace($i." contrat directeur ajouté ", $data);
				$this->dbAutCont->ajouter($data, true, false, true);
			}else
	    			$this->s->trace($i." directeur non trouvé");
		}
		
		$this->s->trace("FIN ".__METHOD__);		
	}
	
	function importGlobalElsevier($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);		
		//gestion des lignes vides
		if(!$r[0]){$this->s->trace($i." ligne vide");return;}
		
		//traitement des références sans titre
    		if(!$r[1]){
			$idLivre = $this->dbLivre->ajouter(array("titre_en"=>"ISBN Elsevier sans titre","soustitre_en"=>$r[0]));
			$idIsbn = $this->dbIsbn->ajouter(array("id_livre"=>$idLivre,"id_editeur"=>4,"num"=>$r[0]));				
	    		$this->s->trace($i." ajoute les références sans titre : ".$r[0]." = ".$idIsbn);			
    		}else{
    			$dateParution = $this->formatDateExcelToSql($r[8]);
	    		//recherche les références
			$rIsbn = $this->getReference(array(
	    		 "titre"=>$r[2],"langue"=>"en"
			 ,"dataSerie"=>array("titre_en"=>$r[6], "titre_fr"=>"")
			 ,"dataComite"=>array("titre_en"=>$r[13], "titre_fr"=>"")
			 ,"dataISBN"=>array("id_editeur"=>4,"num"=>$r[0],"nb_page"=>$r[9],"date_parution"=>$dateParution)
			 ,"dataLivre"=>array("type_1"=>$r[4],"type_2"=>$r[5],"titre_en"=>$r[2],"soustitre_en"=>$r[3],"num_vol"=>$r[7])		  
	    		));	    		
    				    		
	    		if($rIsbn["id_isbn"]){
		    		$this->s->trace($i." ajout des prix : ".$rIsbn["id_isbn"]);							
	    			//ajout des prix 
				if($r[15]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_dollar"=>$r[10],"type"=>"prix catalogue"));	    				
				if($r[15]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[15],"type"=>"cout total"));
				if($r[16]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[16],"type"=>"prix unitaire"));

				//ajout licence
				$idLic = $this->dbLic->ajouter(array("licence_unitaire"=>$r[10], "nom"=>"Catalogue"));
				$this->s->trace("ajout licence : ".$idLic."=".$r[10]." Catalogue");
				
				$this->s->trace($i."//import des auteurs");			
				$arrIdAut = $this->ajoutAuteur($r[1]);
				foreach ($arrIdAut as $idA) {
					if($idA){
						if($r[11]){
							$idCont = $this->dbCont->ajouter(array("nom"=>"Contrat auteur","type"=>"auteur"));			
							$this->dbAutCont->ajouter(array("id_auteur"=>$idA, "id_livre"=>$rIsbn["id_livre"], "id_isbn"=>$rIsbn["id_isbn"], "id_contrat"=>$idCont, "date_signature"=>$this->formatDateExcelToSql($r[11])));
						}												
						$this->dbLiAut->ajouter(array("id_auteur"=>$idA, "id_livre"=>$rIsbn["id_livre"], "role"=>"auteur"));
					}
				}

	    			$this->s->trace($i."//import du coordinateur");			
				$arrIdAut = $this->ajoutAuteur($r[12]);
				foreach ($arrIdAut as $idA) {
					if($idA)$this->dbLiAut->ajouter(array("id_auteur"=>$idA, "id_livre"=>$rIsbn["id_livre"], "role"=>"coordinateur"));
				}
	    		}
    		}
		$this->s->trace("FIN ".__METHOD__);		
	}     
    
	function importGlobalIsteEdition($r, $i, $id){
		$this->s->trace("DEBUT ".__METHOD__);	
		//gestion des lignes vides
		if(!$r[0]){$this->s->trace($i." ligne vide");return;}
				
		//traitement des références sans titre
    		if(!$r[2] && $id==0){
			$idLivre = $this->dbLivre->ajouter(array("titre_en"=>"ISBN papier ISTE Edition sans titre","soustitre_en"=>$r[0]));
			$idIsbn = $this->dbIsbn->ajouter(array("id_livre"=>$idLivre,"id_editeur"=>1,"num"=>$r[0], "type"=>"Papier FR"));				
	    		$this->s->trace($i." ajoute les références sans titre : ".$r[0]." = ".$idIsbn);			
			$idLivre = $this->dbLivre->ajouter(array("titre_en"=>"ISBN e-book ISTE Edition sans titre","soustitre_en"=>$r[1]));
			$idIsbn = $this->dbIsbn->ajouter(array("id_livre"=>$idLivre,"id_editeur"=>1,"num"=>$r[1], "type"=>"E-Book FR"));				
	    		$this->s->trace($i." ajoute les références sans titre : ".$r[1]." = ".$idIsbn);				    		
    		}else{
			$rIsbn = $this->getReference(array(
	    		 "titre"=>$r[3],"langue"=>"fr"
			 ,"dataSerie"=>array("titre_fr"=>$r[7], "titre_en"=>"")
			 ,"dataComite"=>array("titre_fr"=>$r[9], "titre_en"=>"")
			 ,"dataISBN"=>array("id_editeur"=>1,"type"=>"Papier FR","num"=>$r[0],"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11]))
			 ,"dataLivre"=>array("type_1"=>$r[5],"titre_fr"=>$r[3],"soustitre_fr"=>$r[4],"num_vol"=>$r[7])		  
	    		));	    		
			$rIsbn1 = $this->getReference(array(
	    		 "titre"=>$r[3],"langue"=>"fr"
			 ,"dataSerie"=>array("titre_fr"=>$r[7], "titre_en"=>"")
			 ,"dataComite"=>array("titre_fr"=>$r[9], "titre_en"=>"")
			 ,"dataISBN"=>array("id_editeur"=>1,"type"=>"Ebook FR","num"=>$r[1],"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11]))
			 ,"dataLivre"=>array("type_1"=>$r[5],"titre_fr"=>$r[3],"soustitre_fr"=>$r[4],"num_vol"=>$r[7])		  
	    		));	    		
	    		
	    		if($rIsbn["id_isbn"]){
		    		$this->s->trace($i." ajout des prix : ".$rIsbn["id_isbn"]);							
	    			//ajout des prix 
				if($r[15]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[15],"prix_euro"=>$r[16],"type"=>"prix catalogue"));	    				
				if($r[15]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[13],"type"=>"cout total"));
				if($r[16]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[14],"type"=>"cout à la page"));
	    		}
			if($rIsbn1["id_isbn"] && $r[17]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn1["id_isbn"],"prix_euro"=>$r[17],"pdf"=>$id,"type"=>"prix catalogue"));	    				
	    		
	    		if($rIsbn["id_livre"]){
	    			$this->s->trace($i."//import des auteurs");			
				$arrIdAut = $this->ajoutAuteur($r[2]);
				foreach ($arrIdAut as $idA) {
					if($idA){
						if($r[10]){
							$idCont = $this->dbCont->ajouter(array("nom"=>"Contrat auteur","type"=>"auteur"));			
							$this->dbAutCont->ajouter(array("id_auteur"=>$idA, "id_livre"=>$rIsbn["id_livre"], "id_isbn"=>$rIsbn["id_isbn"], "id_contrat"=>$idCont, "date_signature"=>$this->formatDateExcelToSql($r[11])));
				    		}												
						$this->dbLiAut->ajouter(array("id_auteur"=>$idA, "id_livre"=>$rIsbn["id_livre"], "role"=>"auteur"));
					}
				}

	    			$this->s->trace($i."//import du coordinateur");			
				$arrIdAut = $this->ajoutAuteur($r[8]);
				foreach ($arrIdAut as $idA) {
					if($idA)$this->dbLiAut->ajouter(array("id_auteur"=>$idA, "id_livre"=>$rIsbn["id_livre"], "role"=>"coordinateur"));
				}
	    		}
    		}
		$this->s->trace("FIN ".__METHOD__);		
	}    
    
    function importGlobalWileyBase($r, $i){
		$this->s->trace($i." DEBUT ".__METHOD__);		
		//gestion des lignes vides
		if(!$r[0]){$this->s->trace($i." ligne vide");return;}
		//traitement des références sans titre
    		if(!$r[2]){
			$idLivre = $this->dbLivre->ajouter(array("titre_en"=>"ISBN Wiley sans titre","soustitre_en"=>$r[0]));
			$idIsbn = $this->dbIsbn->ajouter(array("id_livre"=>$idLivre,"id_editeur"=>5,"num"=>$r[0]));				
	    		$this->s->trace($i." ajoute les références sans titre : ".$r[0]." = ".$idIsbn);			
    		}else{
	    		//recherche les références
			$rIsbn = $this->getReference(array(
	    		 "titre"=>$r[2],"langue"=>"en"
			 ,"dataSerie"=>array("titre_fr"=>"", "titre_en"=>$r[6])
			 ,"dataComite"=>array("titre_fr"=>"", "titre_en"=>$r[13])
			 ,"dataISBN"=>array("id_editeur"=>5,"num"=>$r[0],"tirage"=>$r[14],"nb_page"=>$r[9],"date_parution"=>$this->formatDateExcelToSql($r[8]))
			 ,"dataLivre"=>array("type_1"=>$r[4],"type_2"=>$r[5],"titre_en"=>$r[2],"soustitre_en"=>$r[3],"num_vol"=>$r[7])		  
	    		));	    		
	    		if($rIsbn["id_isbn"]){
		    		$this->s->trace($i." ajout des prix : ".$rIsbn["id_isbn"]);							
	    			//ajout des prix 
				if($r[10]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_dollar"=>$r[10],"type"=>"prix catalogue"));
				if($r[15]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[15],"type"=>"cout total"));
				if($r[16]) $this->dbPrix->ajouter(array("id_isbn"=>$rIsbn["id_isbn"],"prix_livre"=>$r[16],"type"=>"cout unitaire"));

				//ajout licence
				$idLic = $this->dbLic->ajouter(array("licence_unitaire"=>$r[10], "nom"=>"Catalogue"));
				$this->s->trace("ajout licence : ".$idLic."=".$r[10]." Catalogue");
				
				
				$this->s->trace($i."//import des auteurs");			
				$arrIdAut = $this->ajoutAuteur($r[1]);
	    			$this->s->trace($i." auteurs trouvés = ".count($arrIdAut),$arrIdAut);			
				foreach ($arrIdAut as $id) {
					if($r[11]){
						$idCont = $this->dbCont->ajouter(array("nom"=>"Contrat auteur","type"=>"auteur"));
	    					$this->s->trace($i." contrat ajouté = ".$idCont." ".$rIsbn["id_isbn"]);
						$this->dbAutCont->ajouter(array("id_auteur"=>$id, "id_livre"=>$rIsbn["id_livre"], "id_isbn"=>$rIsbn["id_isbn"], "id_contrat"=>$idCont, "date_signature"=>$this->formatDateExcelToSql($r[11])));
					}
					$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$rIsbn["id_livre"], "role"=>"auteur"));
	    				$this->s->trace($i." lien auteur ajouté = id_auteur=".$id." id_livre=".$rIsbn["id_livre"]);
				}

	    			$this->s->trace($i."//import du coordinateur");			
				$arrIdAut = $this->ajoutAuteur($r[12]);
				foreach ($arrIdAut as $id) {
					if($id)$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$rIsbn["id_livre"], "role"=>"coordinateur"));
				}
	    		}
    		}
		$this->s->trace("FIN ".__METHOD__);		
    }
    
	function importGlobalDtsAuteursWiley($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);
		
		//gestion des lignes vides
		if(!$r[0]){$this->s->trace($i." ligne vide");return;}

		$idCont = $this->dbCont->ajouter(array("nom"=>"Contrat auteur","type"=>"auteur"));
		
    		//traitement des références sans titre
    		if(!$r[2]){
			$idLivre = $this->dbLivre->ajouter(array("titre_en"=>"ISBN Wiley sans titre","soustitre_en"=>$r[0]));
			$idIsbn = $this->dbIsbn->ajouter(array("id_livre"=>$idLivre,"id_editeur"=>5,"num"=>$r[0]));				
	    		$this->s->trace($i." ajoute les références sans titre : ".$r[0]." = ".$idIsbn);			
    		}else{
	    		//recherche les références
			$rIsbn = $this->getReference(array(
	    		 "titre"=>$r[2],"langue"=>"en"
			 ,"dataSerie"=>false
			 ,"dataComite"=>false
			 ,"dataISBN"=>array("id_editeur"=>5,"num"=>$r[0],"date_parution"=>$this->formatDateExcelToSql($r[9]))
			 ,"dataLivre"=>array("titre_en"=>"référence ISBN non trouvé","titre_fr"=>"référence ISBN non trouvé")		  
	    		));	    		
	    		if($rIsbn){
	    			$this->s->trace($i."//import des auteurs");			
				$arrIdAut = $this->ajoutAuteur($r[2]);
	    			$this->s->trace($i." auteurs trouvés = ".count($arrIdAut));			
				foreach ($arrIdAut as $id) {
					if($r[7] && $r[7]!="00%" && $r[8]!="00%"){
						$this->dbAutCont->ajouter(array("id_auteur"=>$id, "id_livre"=>$rIsbn["id_livre"], "id_isbn"=>$rIsbn["id_isbn"], "id_contrat"=>$idCont
							, "date_signature"=>$this->formatDateExcelToSql($r[9])
							, "pc_papier"=>$r[7], "pc_ebook"=>$r[8]));
	    					$this->s->trace($i." contrat ajouté = ".$idCont." ".$rIsbn["id_isbn"]);
					}
					$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$rIsbn["id_livre"], "role"=>"auteur"));
				}
	    		}
    		}
		$this->s->trace("FIN ".__METHOD__);		
    }    
    
    function importGlobalBD($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);		
		//gestion des lignes vides
		if(!$r[0]){$this->s->trace($i." ligne vide");return;}
		
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
		$idPropo = $arrId[4];
		$idPlu = $arrId[5];
		
		$this->s->trace($i."//import des directeurs de collection");			
			$arrIdAut = $this->ajoutAuteur($r[7]);
			//ajout des coordinations
			foreach ($arrIdAut as $id) {
				if($id){
					$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$idLivre, "role"=>"directeur"));
					$idCoor = $this->dbCoor->ajouter(array("id_serie"=>$idSerie, "id_auteur"=>$id));
					if($r[3]){
						$idCont = $this->dbCont->ajouter(array("nom"=>"Contrat de coordination","type"=>"coordination"));			
						$this->dbAutCont->ajouter(array("id_auteur"=>$id, "id_serie"=>$idSerie, "id_contrat"=>$idCont, "date_signature"=>$this->formatDateExcelToSql($r[3])));
					}				
				}
			}
				
		$this->s->trace($i."//import des auteurs");			
			$arrIdAut = $this->ajoutAuteur($r[10]);
			foreach ($arrIdAut as $id) {
				if($id)$this->dbLiAut->ajouter(array("id_auteur"=>$id, "id_livre"=>$idLivre, "role"=>"auteur"));
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
			
			$this->s->trace($i."//gestion de l'éditeur ".$r[26]." - ".$r[27]." - ".$r[28]);	
			if($r[26]){//'Wiley'
				$dataIsbn["id_editeur"]=5;
				$dataIsbn["num"]=$r[26];
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);				
				$this->s->trace($i."//création ISBN ",$dataIsbn);	
			}
			if($r[27]){//'Elsevier'
				$dataIsbn["id_editeur"]=4;
				$dataIsbn["num"]=$r[27];
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);				
				$this->s->trace($i."//création ISBN ",$dataIsbn);	
			}
			if($r[28]){//'ISTE Editions'
				$dataIsbn["id_editeur"]=1;
				$dataIsbn["num"]=$r[28];
				$dataIsbn["type"]="Papier FR";
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);				
				$this->s->trace($i."//création ISBN ",$dataIsbn);	
			}
			
			//vérifie si l'isbn est créé
			if(!$idIsbn)
				$idIsbn = $this->dbIsbn->ajouter($dataIsbn);	
			
			//gestion du prix
			if($r[34]) $this->dbPrix->ajouter(array("id_isbn"=>$idIsbn,"prix_dollar"=>$r[34],"type"=>"GB - suivi de la fabrication"));
			
		$this->s->trace($i."//import des propositions = ".$idPropo);	
			$dataProp = array('id_livre'=>$idLivre,"base_contrat"=>$r[17]
				,"publication_en"=>$r[20],"publication_fr"=>$r[21],"nb_page_fr"=>$r[23]);
			
			if($r[15]=="reçu")$dataProp['date_debut']=new Zend_Db_Expr('NOW()');
			elseif ($r[15])$dataProp['date_debut']=$this->formatDateExcelToSql($r[15]);
			
			if(substr($r[16], 0, 3)=="ENV")$dataProp['date_contrat']=$this->formatDateExcelToSql(substr($r[16], 4));
			elseif ($r[16])$dataProp['date_contrat']=$this->formatDateExcelToSql($r[16]);
			
			if($r[22])$dataProp['traduction']="français -> anglais";

			if($r[19]=="GB")$dataProp['langue']="anglais";
			if($r[19]=="FR")$dataProp['langue']="français";
			
			$this->dbProp->edit($idPropo, $dataProp);
					
			if($r[22]){
				$this->dbProc->setProcessusForLivre('Traduction livre', $idLivre, 1,false);	
				$this->s->trace($i." import des processus de traduction");	
			}     		    			
			$this->s->trace($i." import des processus de production = ".$idPlu);	
			/*			
			$iste_tache = array(
			  array('id_tache' => '15','id_processus' => '3','nom' => 'Réception manuscrit','ordre' => '1'),
			  array('id_tache' => '16','id_processus' => '3','nom' => 'Réception traduction anglaise','ordre' => '2'),
			  array('id_tache' => '17','id_processus' => '3','nom' => 'Prévision parution GB','ordre' => '3'),
			  array('id_tache' => '18','id_processus' => '3','nom' => 'Prévision parution FR','ordre' => '4'),
			  array('id_tache' => '23','id_processus' => '3','nom' => 'vérification orthographe','ordre' => '5'),
			  array('id_tache' => '24','id_processus' => '3','nom' => 'vérification état civil','ordre' => '6'),
			  array('id_tache' => '25','id_processus' => '3','nom' => 'Envoi proposal','ordre' => '7'),
			  array('id_tache' => '26','id_processus' => '3','nom' => 'reception proposal','ordre' => '8')
			);
			*/						
			if($r[24])$this->dbPrev->editLivreTache($idPlu, 15, array("prevision"=>$this->formatDateExcelToSql($r[24])));
			if($r[29])$this->dbPrev->editLivreTache($idPlu, 15, array("fin"=>$this->formatDateExcelToSql($r[29])));
			if($r[30])$this->dbPrev->editLivreTache($idPlu, 16, array("fin"=>$this->formatDateExcelToSql($r[30])));
			if($r[31])$this->dbPrev->editLivreTache($idPlu, 17, array("prevision"=>$this->formatDateExcelToSql($r[31])));
			if($r[32])$this->dbPrev->editLivreTache($idPlu, 18, array("prevision"=>$this->formatDateExcelToSql($r[32])));			
		$this->s->trace("FIN ".__METHOD__);					
    }

    function ajoutLivre($data){

		$this->s->trace($i."//import des livres");			
		$idLivre = $this->dbLivre->ajouter($data["livre"]);

		//création de la proposition
		$idPropo = $this->dbProp->ajouter(array("id_livre"=>$idLivre), true, false);
		
		//création du processus
		$idProces = $this->dbProc->setProcessusForLivre('Projet livre', $idLivre, 1, false);
		
    		
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

		return array($idLivre,$idSerie,$idCol,$idCom,$idPropo,$idProces);
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

    function getReference($r){
    		/*
    		 array(
    		 "titre"=>$r[3],"langue"=>"fr",
		 ,"dataSerie"=>array("titre_fr"=>$r[7], "titre_en"=>"")
		 ,"dataComite"=>array("titre_fr"=>$r[9], "titre_en"=>"")
		 ,"dataISBN"=>array("num"=>$r[0],"editeur"=>1,"nbPage"=>$r[12],"dateParu"=>$r[11],"type"=>"Papier FR"/"E-Book FR")
		 ,"dataLivre"=>array("type_1"=>$r[5]
			"titre_fr"=>$r["titre_fr"],"soustitre_fr"=>$r["soustitre_fr"]
			"titre_en"=>$r["titre_en"],"soustitre_en"=>$r["soustitre_en"]
			,"num_vol"=>$r["num_vol"])		  
    		)
    		*/
	    //recherche les références
	    $idLivre = false;
	    $rIsbn = $this->dbIsbn->findByNum($r["dataISBN"]["num"]);
	    $this->s->trace($i." recherche la référence isbn par num : ".$r["dataISBN"]["num"]);
	    if(!$rIsbn){
	    		$rsIsbn = $this->dbIsbn->findByTitreEditeur($r["titre"], $r["dataISBN"]["id_editeur"], $r["langue"]);
    			if($rsIsbn[0]) {
    				$rIsbn = $rsIsbn[0];
	    			$this->s->trace($i." référence isbn trouvée par titre éditeur : ".$r["titre"]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
	    			$r["dataISBN"]["id_livre"]=$rIsbn["id_livre"];
	    			$this->dbIsbn->ajouter($r["dataISBN"]);				
	    			$this->s->trace($i." ISBN ajouté : ".$rIsbn["id_isbn"]);	
	    			$idLivre = $rIsbn["id_livre"];						
    			}
	    		if(!$idLivre){
	    			$rsIsbn = $this->dbIsbn->findByTitre($r["titre"], $r["langue"]);
	    			if($rsIsbn[0]) {
	    				$rIsbn = $rsIsbn[0];
	    				$this->s->trace($i." référence isbn trouvée par titre : ".$r["titre"]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
	    				$r["dataISBN"]["id_livre"]=$rIsbn["id_livre"];
		    			$this->dbIsbn->ajouter($r["dataISBN"]);				
		    			$this->s->trace($i." ISBN ajouter : ".$rIsbn["id_isbn"]);	
		    			$idLivre = $rIsbn["id_livre"];										    		
	    			}
	    		}
    			if(!$idLivre){
    				$rsLivre = $this->dbLivre->findByTitre($r["titre"], $r["langue"]);
	    			if($rsLivre[0]) {
	    				$rLivre = $rsLivre[0];
			    		$this->s->trace($i." livre trouvé par titre : ".$rLivre["titre_".$r["langue"]]." = ".$rLivre["id_livre"]);								    				
	    				$r["dataISBN"]["id_livre"]=$rLivre["id_livre"];										    		
	    				$rIsbn = $this->dbIsbn->ajouter($r["dataISBN"],true, true);				
			    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]);
			    		$idLivre = $rLivre["id_livre"];											    		
    				}
    			}
    			if(!$idLivre){
    				if(!$rIsbn){
					$this->s->trace($i." livre non trouvé : ".$r["titre"]);
			    		$arrId = $this->ajoutLivre(array(
			    			"serie"=>$r["dataSerie"]
			    			,"comite"=>$r["dataComite"]
			    			,"livre"=>$r["dataLivre"]
			    			));
					$idLivre = $arrId[0];						    			
			    		$this->s->trace($i." livre crée : ".$idLivre);
			    		$r["dataISBN"]["id_livre"]=$idLivre;							
	    				$rIsbn = $this->dbIsbn->ajouter($r["dataISBN"],true, true);				
			    		$this->s->trace($i." ISBN créé : ".$rIsbn["id_isbn"]." ".$rIsbn["id_livre"]);								    						    					
		    		}
	    		}
	    }else{
	    		$r["dataISBN"]["id_livre"]=$rIsbn["id_livre"];
		    	$this->s->trace($i." référence isbn trouvée par num : ".$r["num"]." = ".$rIsbn["id_isbn"]." - ".$rIsbn["id_livre"]);
    			$this->dbIsbn->edit($rIsbn["id_isbn"],$r["dataISBN"]);				
	    		$this->s->trace($i." ISBN modifié : ".$rIsbn["id_isbn"]);	
    		}
    		return $rIsbn;
    }
    
    
}



