<?php

class ImportController extends Zend_Controller_Action
{
	var $s;
	var $arrMois = array("janvier"=>"01","février"=>"02","mars"=>"03","avril"=>"04","mai"=>"05","juin"=>"06",
		"juillet"=>"07","août"=>"08","septembre"=>"09","octobre"=>"10","novembre"=>"11","décembre"=>"12");
	var $arrMoisCourt = array("janv."=>"01","fév."=>"02","mars"=>"03","avr."=>"04","mai"=>"05","juin"=>"06",
		"juil."=>"07","août"=>"08","sept."=>"09","oct."=>"10","nov."=>"11","déc."=>"12");
	
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
		    	
		$this->view->inc = $this->_getParam('inc');
		$this->view->ajax = $this->_getParam('ajax');
		$this->view->idObj = $this->_getParam('idObj',-1);
		$this->view->obj = $this->_getParam('obj','vente');
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

    public function droitAction()
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
			case "global":
				$v = new Flux_Vente(false,true);
				//$v->importer(null,$this->_getParam('idFic'));
				$v->importerNew($this->_getParam('idFic'));
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
    
    public function getdataficventeAction()
    {
    		$this->initInstance();
    		$dbData = new Model_DbTable_Iste_importdata();
			$dbFic = new Model_DbTable_Iste_importfic();
			
			//récupère les problèmes
			$v = new Flux_Vente(false,$this->_getParam('trace'));
			$arrP =  $v->getProblemesFic($this->_getParam('idFic'));
				
    		//calcul les colonnes 
    		$rsFic = $dbFic->findById_importfic($this->_getParam('idFic'));
    		$cols = json_decode($rsFic["coldesc"]);
    		$arrC = array(
				array("field"=>"recid", "caption"=>"ID", "hidden"=>'true', "size"=>'50px', "sortable"=>1, "resizable"=>1)
				,array("field"=>"numrow", "caption"=>"n° lig.", "size"=>'50px', "sortable"=>1, "resizable"=>1)
				,array("field"=>"numsheet", "caption"=>"n° ong.", "hidden"=>'true', "size"=>'50px', "sortable"=>1, "resizable"=>1)
				,array("field"=>"commentaire", "caption"=>"commentaire", "size"=>'100%', "sortable"=>1, "resizable"=>1,"editable"=>array("type"=>'text'))
				,array("field"=>"id_livre", "caption"=>"Id. livre","hidden"=>'true', "size"=>'50px', "sortable"=>1, "resizable"=>1)
				,array("field"=>"id_isbn", "caption"=>"Id. isbn","hidden"=>'true', "size"=>'50px', "sortable"=>1, "resizable"=>1)
				);
    		$i=1;
    		foreach ($cols as $k=>$c) {
    			$arrC[]=array("caption"=>$k, "field"=>$c, "size"=>'100px', "sortable"=>1, "resizable"=>1,"editable"=>array("type"=>'text'));
    			$i++;
    		}
    		
    		//récupère les données
			$arrV = $dbData->findByIdFic($this->_getParam('idFic'));
			
			//calcul les résumés
			$rsR = $dbData->getResumeByIdFic($this->_getParam('idFic'));
			$i=1;
			foreach ($rsR as $r) {
				$arrV[]= array("summary"=>true,"recid"=>"S-".$i,"numrow"=>""
					,"numsheet"=>"","commentaire"=>""
					,"id_livre"=>$r["nbLivre"],"id_isbn"=>$r["nbIsbn"]
					,"col1"=>$r["nbIsbn"],"col2"=>$r["nbAuteur"]
					,"col3"=>$r["qtyPaper"],"col4"=>$r["sumPaper"],"col5"=>$r["sumEbook"]
					);
				$i++;
			}
    		$this->view->json = json_encode(array("col"=>$arrC,"rs"=>$arrV,"prob"=>$arrP));
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
            $options = array('print_response'=>false);
            if($this->_getParam('dir')){
                $path = "/data/".$this->_getParam('obj')."_".$this->_getParam('type')."/";
                $options['upload_dir'] = ROOT_PATH.$path;
                $options['upload_url'] = WEB_ROOT.$path;                    
            }
			$upload_handler = new CustomUploadHandler($options);
    		$response = $upload_handler->get_response();
    		$this->view->json = json_encode($response);
		} 
    			      
    }
    
    public function oldsiteAction()
    {
    		$this->initInstance();
    	
		$this->s = new Flux_Site();
		$this->s->bTrace = true;		
		$this->s->bTraceFlush = true;		
		$this->s->trace("DEBUT ".__METHOD__);		
		
		$this->dbLivre = new Model_DbTable_Iste_livre();
		$this->dbIsbn = new Model_DbTable_Iste_isbn();
		$this->dbWeb = new Model_DbTable_Iste_web();
		
		require_once '../bdd/hrm_books.php';
		$oldPath	 = "http://www.iste.co.uk/data/";

		$iL = 0;
		$supRep = false;
		foreach ($hrm_books as $book) {
			$this->s->trace(" isbn ".$book["isbn"]);		
	    		$rIsbn = $this->dbIsbn->findByNum($book["isbn"]);
	    		$arrDoc = array();
	    		if($rIsbn){
				$this->s->trace($iL." isbn trouvé id_livre =".$rIsbn["id_livre"]);		
	    			//mis à jour des informations du livre
	    			$ct = str_replace(array("\r\n","\n"),'<br />',$book["description_EN"]);				
	    			$tdm = str_replace(array("\r\n","\n"),'<br />',$book["content"]);
	    			$bio = str_replace(array("\r\n","\n"),'<br />',$book["authorsbio"]);					    							
	    			$this->dbLivre->edit($rIsbn["id_livre"]
	    				, array("contexte_en"=>$ct,"tdm_en"=>$tdm,"bio_en"=>$bio));
	    			//supprime le répertoire
	    			if($supRep)$this->s->removeRep(ROOT_PATH."/data/livre_".$rIsbn["id_livre"]);
	    			//enregistre les documents
				//$arrDoc['nom'] = pathinfo($url, PATHINFO_FILENAME);
		  		$arrDoc['obj'] = 'livre';
		  		$arrDoc['id_obj'] = $rIsbn["id_livre"];
		  		$arrDoc['type'] = "Couverture en.";
		  		if($book["thumbnailbase"])
		  			$idFic = $this->sauveImage($arrDoc, $oldPath.$book["thumbnailbase"], ROOT_PATH."/data/livre_".$rIsbn["id_livre"]);

		  		$arrDoc['type'] = "Couverture en. petite";
		  		if($book["thumbnailsmall"] && $book["thumbnailsmall"]!="_small.")
		  			$idFic = $this->sauveImage($arrDoc, $oldPath.$book["thumbnailsmall"], ROOT_PATH."/data/livre_".$rIsbn["id_livre"]);

		  		$arrDoc['type'] = "Couverture en. medium";
		  		if($book["thumbnailmedium"] && $book["thumbnailmedium"]!="_medium.")
		  			$idFic = $this->sauveImage($arrDoc, $oldPath.$book["thumbnailmedium"], ROOT_PATH."/data/livre_".$rIsbn["id_livre"]);

		  		$arrDoc['type'] = $book["binary1title"];
		  		if($book["binary1file"])
		  			$idFic = $this->sauveImage($arrDoc, $oldPath.$book["binary1file"], ROOT_PATH."/data/livre_".$rIsbn["id_livre"]);

		  		$arrDoc['type'] = $book["binary2title"];
		  		if($book["binary2file"])
		  			$idFic = $this->sauveImage($arrDoc, $oldPath.$book["binary2file"], ROOT_PATH."/data/livre_".$rIsbn["id_livre"]);

		  		$arrDoc['type'] = $book["binary3title"];
		  		if($book["binary3file"])
		  			$idFic = $this->sauveImage($arrDoc, $oldPath.$book["binary3file"], ROOT_PATH."/data/livre_".$rIsbn["id_livre"]);
  			    			
		  		//enregistre les liens web	
		  		for ($i = 0; $i < 6; $i++) {
			  		$this->s->trace("enregistre le lien ".$book["ebook_".$i]. " ".$rIsbn["id_livre"]);
		  			if($book["ebook_".$i]){
		  				switch ($i) {
		  					case 1:
			  					$type = "WileyOnLine";
			  					break;
		  					case 2:
			  					$type = "WileyOnLine";
			  					break;
		  					case 3:
			  					$type = "NetLibrary";
			  					break;
			  				case 4:
			  					$type = "Elsevier";
			  					break;
		  					default:
			  					$type = "aucun";
			  					break;
		  				}
		  				$this->dbWeb->ajouter(array("id_livre"=>$rIsbn["id_livre"],"type"=>$type,"url"=>$book["ebook_".$i]));	
		  			}	  			
		  		}
		  		
	    		}else $this->s->trace("isbn ABSCENT ");
	    		//if($iL>1)break;
	    		$iL ++;
		}

		$this->s->trace("FIN ".__METHOD__);		
    }    
    
	public function shopifyAction()
    {
    		$this->initInstance();
    	
		$this->s = new Flux_Site();
		$this->s->bTrace = true;		
		$this->s->bTraceFlush = true;		
		$this->s->trace("DEBUT ".__METHOD__);		
		
		$this->dbLivre = new Model_DbTable_Iste_livre();
		$this->dbIsbn = new Model_DbTable_Iste_isbn();
		$this->dbWeb = new Model_DbTable_Iste_web();
		
		$arr = $this->s->csvToArray("../bdd/import/products_export.csv",0,",");
		$arrIsbn = array(16=>"9781784050795",25=>"9781784050757",26=>"9781784050764",26=>"9781784050740");
		//,92=>"9781784050009");
		$nb = count($arr);
		$nbKO = 0;
		$nbOK = 0;
		
		for ($i = 10; $i < $nb; $i++) {
			$p = $arr[$i];
			$this->s->trace($i." PRODUIT : ".$p[0]);		

			//vérifie si l'isbn est explicite
			if($arrIsbn[$i]){
		    		$rIsbn = $this->dbIsbn->findByNum($arrIsbn[$i]);
		    		if($rIsbn){
					$this->s->trace(" isbn TROUVé id_livre =".$rIsbn["id_livre"]);		
		    		}else{
					$this->s->trace(" isbn ABSCENT DE LA BASE ". $arrIsbn[$i]);				    									
		    		} 				
			}else{
				//charge le document
				$dom = new Zend_Dom_Query($p[2]);
				$arrISBNQuery = array('//span[2]','//p[2]/text()[3]','//p[3]/text()[3]');
				foreach ($arrISBNQuery as $q) {
					//récupère l'isbn
					$results = $dom->query($q);			
					foreach ($results as $r) {
						$nv = $r->nodeValue;
						$this->s->trace("//recherche l'isbn papier '".$r->nodeValue."'");							
						//cas = 'ISBN : 978-1-78405-024-5 (papier)' 
						if(substr($nv, 0, 7)=='ISBN : ')$nv = substr($nv, 7, 17);
						//cas = 'ISBN:Â 978-1-78405-071-9 (print)'
						if(substr($nv, 0, 7)=='ISBN:Â ')$nv = substr($nv, 7, 17);
						//cas = 'ISBN: 978-1-78405-071-9 (print)'
						if(substr($nv, 0, 6)=='ISBN: ')$nv = substr($nv, 6, 17);
						$nv = str_replace("-", "", $nv);
				    		$rIsbn = $this->dbIsbn->findByNum($nv);
						break;	
					}
				    	if($rIsbn)break;				
				}
			}
			if(!$rIsbn){
				//$this->s->trace("PAS ISBN ".$p[2]);
				$nbKO ++;
				$this->s->trace(" isbn ABSCENT '". $nv."'<br/>".$p[2]);				    									
				//return false;
			}else{
				$this->s->trace(" isbn TROUVé id_livre =".$rIsbn["id_livre"]);		
				$nbOK ++;
				//ajoute le site web
			  	$this->dbWeb->ajouter(array("id_livre"=>$rIsbn["id_livre"],"type"=>"Shopify","url"=>"http://iste-editions.fr/products/".$p[0]));		  			
				//mis à jour du contexte
				$this->dbLivre->edit($rIsbn["id_livre"], array("contexte_fr"=>$p[2]));
				//enregistre l'image
		  		$arrDoc = array();
				$arrDoc['obj'] = 'livre';
		  		$arrDoc['id_obj'] = $rIsbn["id_livre"];
		  		$arrDoc['type'] = "Couverture fr.";	
		  		$fic = substr($p[24], 0, - (strlen($p[24]) - strrpos($p[24], "?")));
		  		$fic = str_replace("https", "http", $fic);			
		  		$idFic = $this->sauveImage($arrDoc, $fic, ROOT_PATH."/data/livre_".$rIsbn["id_livre"]);
				
			} 
			
			
			/*
			$isbn = $this->dbIsbn->findIsbn($p[2]);
			$this->s->trace("//recherche l'isbn ".$isbn);		
			*/
			
	    		//if($i>0)break;
		}

		$this->s->trace("FIN ".__METHOD__." OK=".$nbOK." KO=".$nbKO );		
    }      
    
	/**
     * sauveImage
     *
     * enregistre l'image du document
     * 
     * @param int $idLivre
     * @param string $url
     * @param string $titre
     * @param string $chemin
     * 
     * @return int
     */
	function sauveImage($arrDoc, $url, $chemin){

		$this->s->trace("DEBUT ".__METHOD__);		
		$this->dbImpFic = new Model_DbTable_Iste_importfic();
		
	    	//création du répertoire de stockage de l'image
		if(!is_dir($chemin)) @mkdir($chemin,0775,true);
    			
	    	//ajoute le document
	    	if(!$arrDoc['nom'])$arrDoc['nom']=$arrDoc['type'];
	    	$idFic = $this->dbImpFic->ajouter($arrDoc);
		
	    	$extension = pathinfo($url, PATHINFO_EXTENSION);	    	
		//$path = $chemin."/".preg_replace("#^[a-z0-9]+\.[a-z]+$#", "-", $arrDoc["type"])."_".$idFic.".".$extension;
		$path = $chemin."/".$idFic.".".$extension;
		$urlLocal = str_replace(ROOT_PATH, WEB_ROOT, $path);     	
		
		if(!is_file($path)){
    		//enregistre l'image sur le disque local
			if(!$img = file_get_contents($url)) { 
			  $this->s->trace( 'pas de fichier : "'.$url.'"<br/>');
			}else{
				if(!$f = fopen($path, 'w')) { 
				  $this->s->trace( 'Ouverture du fichier impossible '.$path."<br/>");
				}elseif (fwrite($f, $img) === FALSE) { 
				  $this->s->trace( 'Ecriture impossible '.$path."<br/>");
				}else{
					$this->s->trace( 'Image '.$arrDoc["nom"].' enregistrée : <a href="'.$urlLocal.'">local</a> -> <a href="'.$url.'">En ligne</a><br/>');
					//création de la vignette
					if(!is_dir($chemin."/thumbnail")) @mkdir($chemin."/thumbnail",0775,true);
					$image = new ImageResize($urlLocal);
					if($image){
						$image->scale(50);
						$image->save($chemin."/thumbnail/".$idFic.".".$extension);
					}
				} 				
			}				
		}else{
			$this->s->trace( 'Image '.$arrDoc["nom"].' déjà enregistrée : <a href="'.$urlLocal.'">local</a> -> <a href="'.$url.'">En ligne</a><br/>');
		} 	    
		$this->dbImpFic->edit($idFic, array("url"=>$urlLocal,"size"=>filesize($path)));					
		
		$this->s->trace("FIN ".__METHOD__);		
		return $idFic;   	
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
		$this->dbComAut = new Model_DbTable_Iste_comitexauteur();
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
		
		
		//max 20
		$arrType = array(0, 1, 2, 3, 4, 5, 6);
		$arrType = array(20);
		foreach ($arrType as $type) {
			$this->s->trace("TYPE ".$type);		
			if($type==0 || $type == 11)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015BD.csv");
			if($type==1 || $type == 13 || $type == 16 || $type == 17)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015WileyBase.csv");
			if($type==2)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015ISTEedition.csv");
			if($type==3)$arr = $this->s->csvToArray("../bdd/import/ISTEGlobal2015Elsevier.csv");
			if($type==4)$arr = $this->s->csvToArray("../bdd/import/DtsAuteursWiley.csv");
			if($type==5)$arr = $this->s->csvToArray("../bdd/import/ISTE-EDITIONS-AUTEURS.csv");
			if($type==6)$arr = $this->s->csvToArray("../bdd/import/ISTEPourcentageDroitsN.csv");
			if($type==19)$arr = $this->s->csvToArray("../bdd/import/correctionISBN.csv");
			if($type==20)$arr = $this->s->csvToArray("../bdd/import/FichierDroits.csv",0,",");
			
			$i = 1;
			$this->s->trace("nb Ligne ".count($arr));		
			foreach ($arr as $r) {
				if($type==0)$this->importGlobalBD($r, $i);
				if($type==11)$this->updateGlobalBD($r, $i);				
				if($type==1)$this->importGlobalWileyBase($r, $i);
				if($type==13)$this->importGlobalIsteEdition($r, $i, 0);
				if($type==2)$this->updateIsteEdition($r, $i);
				if($type==3)$this->importGlobalElsevier($r, $i);
				if($type==4)$this->importGlobalDtsAuteursWiley($r, $i);
				if($type==5)$this->importAuteurs($r, $i);
				if($type==6)$this->importDroitsAuteurs($r, $i);
				if($type==16)$this->updateNbPage($r, $i);
				if($type==17)$this->verifWileyISBN($r, $i);
				if($type==19)$this->corrigeISBN($r, $i);
				if($type==20)$this->updateAuteurContrat($r, $i);
				$i++;
				//if($i>3)break;
			}
			
			if($type==7)$this->updateManquesLivre();
			if($type==8)$this->updateManquesAuteur();
			if($type==9)$this->nettoyerIsbn();
			if($type==10)$this->updateManquesIsbn();
			if($type==14)$this->updateByBase();
			if($type==15)$this->updateNbPage();
			if($type==18)$this->deleteLivreIsbnSansTitre();
		}		
		
		$this->s->trace("FIN ".__METHOD__);		
    }

	public function deleteAction()
    {
    		$this->initInstance();
    	
		$this->s = new Flux_Site();
		$this->s->bTrace = true;		
		$this->s->bTraceFlush = true;		
		$this->s->trace("DEBUT ".__METHOD__);		
		
		$this->dbLivre = new Model_DbTable_Iste_livre();
		
		//max 0
		$arrType = array(0);
		foreach ($arrType as $type) {
			$this->s->trace("TYPE ".$type);		
			if($type==0)$arr = $this->s->csvToArray("../bdd/export/exportblancs.csv");
			
			$deb = 1;
			$nb = count($arr);
			$this->s->trace("nb Ligne ".$nb);		
			for ($i = $deb; $i < $nb; $i++) {
				$r = $arr[$i];
				if($type==0){
					//$this->s->trace("data=",$r);		
					$result = $this->dbLivre->remove($r[1]);
					$this->s->trace("id_livre =".$r[1],$result);	
				}
				
				//if($i>3)break;
			}
		}				
		$this->s->trace("FIN ".__METHOD__);		
    }
    
	public function updateAction()
    {
    		$this->initInstance();
    	
		$this->s = new Flux_Site();
		$this->s->bTrace = true;		
		$this->s->bTraceFlush = false;		
		$this->s->trace("DEBUT ".__METHOD__);		
		
		$this->dbHM = new Model_DbTable_Iste_histomodif();
		
		//récupère les modification suivant les critère
		$arr = $this->dbHM->findByIdObjDate($this->_getParam('obj'),$this->_getParam('dateDeb'));
		
		foreach ($arr as $p) {
			$this->s->trace("modif",$p);
			$oData = json_decode($p["data"]);
			$data=array();
			foreach ($oData as $k => $v) {
				$data[$k]=$v;
			}
			$this->s->trace("data",$data);
	    		$oName = "Model_DbTable_Iste_".$p['obj'];
	    		$oBdd = new $oName();
			//$this->s->trace("oBdd",$oBdd);
	    		switch ($p['action']) {
				case "CrudController::updateAction":
					$oBdd->edit($p['id_obj'],$data);
					$this->s->trace($p['action'].":".$p['obj']."=".$p['id']);
					break;
			}
	    							
		}				
		$this->s->trace("FIN ".__METHOD__);		
    }    

    function importAuteurs($r, $i){
		//gestion des lignes vides
		if(!$r[1]){$this->s->trace($i." ligne vide");return;}
		
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
			 ,"dataISBN"=>array("id_editeur"=>1,"type"=>"Papier FR","num"=>$r[0],"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11],"m"))
			 ,"dataLivre"=>array("type_1"=>$r[5],"titre_fr"=>$r[3],"soustitre_fr"=>$r[4],"num_vol"=>$r[7])		  
	    		));	    		
			$rIsbn1 = $this->getReference(array(
	    		 "titre"=>$r[3],"langue"=>"fr"
			 ,"dataSerie"=>array("titre_fr"=>$r[7], "titre_en"=>"")
			 ,"dataComite"=>array("titre_fr"=>$r[9], "titre_en"=>"")
			 ,"dataISBN"=>array("id_editeur"=>1,"type"=>"Ebook FR","num"=>$r[1],"nb_page"=>$r[12],"date_parution"=>$this->formatDateExcelToSql($r[11],"m"))
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
							$this->dbAutCont->ajouter(array("id_auteur"=>$idA, "id_livre"=>$rIsbn["id_livre"], "id_isbn"=>$rIsbn["id_isbn"], "id_contrat"=>$idCont, "date_signature"=>$this->formatDateExcelToSql($r[10])));
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
		if(!$r[1]){$this->s->trace($i." ligne vide");return;}
		
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

    function updateGlobalBD($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);		
		//gestion des lignes vides
		if(!$r[1]){$this->s->trace($i." ligne vide");return;}
			    
		if($r[26]){//'Wiley'
			$this->s->trace($i." WILEY = ".$r[26]);	
			$rIsbn = $this->dbIsbn->findByNum($r[26]);
		}
		if($r[27] && !$rIsbn){//'Elsevier'
			$this->s->trace($i." Elsevier = ".$r[27]);	
			$rIsbn = $this->dbIsbn->findByNum($r[27]);
		}
		if($r[28] && !$rIsbn){//'Elsevier'
			$this->s->trace($i." ISTE = ".$r[28]);	
			$rIsbn = $this->dbIsbn->findByNum($r[28]);
		}
		
		if(!$rIsbn){
			$this->s->trace($i." ISBN INTROUVABLE ".$r[26]." ".$r[27]." ".$r[28]." ");	
			$rIsbn = $this->dbLivre->findByAllTitre($r[13], $r[11]);
			if($rIsbn)
				$rIsbn = $rIsbn[0];
			else
				$this->s->trace($i." LIVRE INTROUVABLE ".$r[13]." ".$r[11]);	
		}
				
		//vérifie si l'isbn est créé
		if($rIsbn){
			$this->s->trace($i." LIVRE ".$rIsbn["id_livre"]);	
			
			$idPlu = $this->dbProc->setProcessusForLivre('Projet livre', $rIsbn["id_livre"], 1, false);
			
			$this->s->trace($i." mise à jour des processus de production = ".$idPlu);	
			if($r[24])$this->dbPrev->editLivreTache($idPlu, 15, array("prevision"=>$this->formatDateExcelToSql($r[24])));
			if($r[29])$this->dbPrev->editLivreTache($idPlu, 15, array("fin"=>$this->formatDateExcelToSql($r[29])));
			if($r[30])$this->dbPrev->editLivreTache($idPlu, 16, array("fin"=>$this->formatDateExcelToSql($r[30])));
			if($r[31])$this->dbPrev->editLivreTache($idPlu, 17, array("prevision"=>$this->formatDateExcelToSql($r[31])));
			if($r[32])$this->dbPrev->editLivreTache($idPlu, 18, array("prevision"=>$this->formatDateExcelToSql($r[32])));			
			//						
			$this->s->trace($i." mise à jour date entrée base ".$r[2]);	
			if($r[2])
				$this->dbProp->editByLivre($rIsbn["id_livre"], array("date_debut"=>$this->formatDateExcelToSql($r[2],"mc")));

			$this->s->trace($i." mise à jour date proposal :".$r[15]);	
			if($r[15]=="reçu")
				$this->dbPrev->editLivreTache($idPlu, 25, array("fin"=>new Zend_Db_Expr('NOW()')));
			elseif ($r[15] && $r[15]!=" "){
				$d = $this->formatDateExcelToSql($r[15],"mc");
				$vals = " debut = '".$d."' , prevision = DATE_ADD('".$d."', INTERVAL 30 DAY), alerte = DATE_ADD('".$d."', INTERVAL 25 DAY)";
				$this->dbPrev->editLivreTacheSql($vals, $idPlu, 25);
				return;								
			}
							
			$this->s->trace($i." mise à jour des dates de contrat ".$r[16]);	
			if(substr($r[16], 0, 3)=="ENV")
				$this->dbPrev->editLivreTache($idPlu, 37, array("debut"=>$this->formatDateExcelToSql(substr($r[16], 4))));							
			elseif($r[16]){
				$d = $this->formatDateExcelToSql($r[16]);
				$this->dbPrev->editLivreTache($idPlu, 37, array("debut"=>null
					,"fin"=>$d
					,"prevision"=>null
					,"alerte"=>null
					));										
			}
		}
		$this->s->trace("FIN ".__METHOD__);					
    } 
    
    
	function updateAuteurContrat($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);		
		//gestion des lignes vides
		if($r[0]=="nb" || $r[0]=="0"){$this->s->trace($i." ligne vide");return;}

		//traitement de l'action 1
		$this->actionUpdateAuteurContrat(0, $r, $i);
		//traitement de l'action 2
		$this->actionUpdateAuteurContrat(1, $r, $i);
		//traitement de l'action 3
		$this->actionUpdateAuteurContrat(2, $r, $i);
		
		$this->s->trace("FIN ".__METHOD__);					
    } 
    
    function actionUpdateAuteurContrat($num, $r, $i){

    		$this->s->trace($i." traitement de l'action ".($num+1)." = ".$r[2+$num]);
    		if(!$r[5+$num]){$this->s->trace($i." pas d'identifiant ");return;}
    				
		switch (strtolower($r[2+$num])) {
			case "s":
				//supprime le contrat;
				$this->dbAutCont->remove($r[5+$num], true);
				$this->s->trace($i." Contrat supprimé ".$r[5+$num]);		
				break;			
			case "u":
				//formate la date
				$arrDate = explode("/", $r[8+$num]);
				if(count($arrDate)==1)$strDate = $r[8+$num];
				else $strDate = $arrDate[2]."-".$arrDate[1]."-".$arrDate[0];
				//modifie le contrat;				
				$data = array("commentaire"=>"correction Excel 14-02-16 : corriger","date_signature"=>$strDate,"pc_papier"=>$r[11+$num],"pc_ebook"=>$r[14+$num]);
				$this->dbAutCont->edit($r[5+$num], $data);
				$this->s->trace($i." Contrat modifié ".$r[5+$num],$data);		
				break;			
			default:
				$this->dbAutCont->edit($r[5+$num], array("commentaire"=>"correction Excel 2016-02-14 : laisser"));
				$this->s->trace($i." Contrat laissé ".$r[5+$num]);		
				break;
		}
    	
    }
    
    
	function updateIsteEdition($r, $i){
		$this->s->trace("DEBUT ".__METHOD__);		
		//gestion des lignes vides
		if(!$r[1]){$this->s->trace($i." ligne vide");return;}
			    
		
    		$rIsbn = $this->dbIsbn->findByNum($r[0]);
		//vérifie si l'isbn est créé
		if($rIsbn){
			$data = array("date_parution"=>$this->formatDateExcelToSql($r[11],"m")
				,"type"=>"Ouvrage papier fr");
			$this->dbIsbn->edit($rIsbn["id_isbn"], $data);			
			$this->s->trace($i." mise à jour ISBN Papier : ".$rIsbn["id_isbn"]." = ".$r[0], $data);	
			$data = array("date_signature"=>$this->formatDateExcelToSql($r[10]));
			$nb = $this->dbAutCont->editByISBN($rIsbn["id_isbn"],$data);
			$this->s->trace($i." mise à jour $nb contrat ", $data);	
		}else 
			$this->s->trace($i." ABSENCE ISBN Papier = ".$r[0]);	
			
    		$rIsbn = $this->dbIsbn->findByNum($r[1]);
		//vérifie si l'isbn est créé
		if($rIsbn){
			$data = array("date_parution"=>$this->formatDateExcelToSql($r[11],"m")
				,"type"=>"E-Book fr");
			$this->dbIsbn->edit($rIsbn["id_isbn"], $data);			
			$this->s->trace($i." mise à jour ISBN E-book : ".$rIsbn["id_isbn"]." = ".$r[1], $data);	
		}else 
			$this->s->trace($i." ABSENCE ISBN E-book = ".$r[1]);	
		
			
			
			
		$this->s->trace("FIN ".__METHOD__);					
    }     
    
    function updateManquesLivre(){
		$this->s->trace("DEBUT ".__METHOD__);		
    	
		$arrL = $this->dbLivre->findIsbnManques();
		$i = 0;
		$nb = count($arrL);
    		$this->s->trace($i." ISBNManques nb=".$nb);
    		for ($i = 0; $i < $nb; $i++) {
    			$l = $arrL[$i];
			$idIsbn = $this->dbIsbn->ajouter(array("id_livre"=>$l["id_livre"],"id_editeur"=>6,"num"=>"17671"));
			$this->s->trace($l["id_livre"]." ajout isbn = ".$idIsbn);			
    		}
    		$this->s->trace("lignes traitées ".$i);		
		
		$arrL = $this->dbLivre->findPropManques();
		$i = 0;
		$nb = count($arrL);
    		$this->s->trace($i." PropManques nb=".$nb);
    		for ($i = 0; $i < $nb; $i++) {
    			$l = $arrL[$i];
			$this->dbProp->ajouter(array("id_livre"=>$l["id_livre"]), true, false);
			$this->s->trace($l["id_livre"]." ajout proposition");			
    		}
    		$this->s->trace("lignes traitées ".$i);		
    		
    		$arrL = $this->dbLivre->findProcessManques();
		$i = 0;
		$nb = count($arrL);
    		$this->s->trace($i." ProcessManques nb=".$nb);
    		for ($i = 0; $i < $nb; $i++) {
    			$l = $arrL[$i];
			//$this->s->trace(" Livre Process ",$l);			
    			if(!$l["pid"]){
    				$idPlu = $this->dbProc->setProcessusForLivre('Traduction livre', $l["id_livre"],1, false);
				$this->s->trace($l["id_livre"]." ajout Traduction livre ".$idPlu);			
    				$idPlu = $this->dbProc->setProcessusForLivre('Projet livre', $l["id_livre"],1, false);
				$this->s->trace($l["id_livre"]." ajout Projet livre ".$idPlu);			
    				$idPlu = $this->dbProc->setProcessusForLivre('Production FR', $l["id_livre"],1, false);
				$this->s->trace($l["id_livre"]." ajout Production FR ".$idPlu);			
    				$idPlu = $this->dbProc->setProcessusForLivre('Production GB', $l["id_livre"],1, false);
				$this->s->trace($l["id_livre"]." ajout Production GB ".$idPlu);			
    			}else{
	    			if(strrpos($l["pid"], "3")===false){
	    				$idPlu = $this->dbProc->setProcessusForLivre('Projet livre', $l["id_livre"],1, false);
					$this->s->trace($l["id_livre"]." ajout Projet livre ".$idPlu);			
	    			}
	    			if(strrpos($l["pid"], "1")===false){
	    				$idPlu = $this->dbProc->setProcessusForLivre('Traduction livre', $l["id_livre"],1, false);
					$this->s->trace($l["id_livre"]." ajout Traduction livre ".$idPlu);			
	    			}
	    			if(strrpos($l["pid"], "4")===false){
	    				$idPlu = $this->dbProc->setProcessusForLivre('Production FR', $l["id_livre"],1, false);
					$this->s->trace($l["id_livre"]." ajout Production FR ".$idPlu);			
	    			}
	    			if(strrpos($l["pid"], "5")===false){
	    				$idPlu = $this->dbProc->setProcessusForLivre('Production GB', $l["id_livre"],1, false);
					$this->s->trace($l["id_livre"]." ajout Production GB ".$idPlu);			
	    			}
	    		}
			//if($i>1)break;    			
    		}    	
    		$this->s->trace("lignes traitées ".$i);		

    		$this->s->trace("FIN ".__METHOD__);		
    		
    }
    
    function nettoyerIsbn(){
		$this->s->trace("DEBUT ".__METHOD__);		
    	
		$arrL = $this->dbIsbn->findDoublons();
		$i = 0;
		$nb = count($arrL);
    		$this->s->trace($i." Doublons ISBN nb=".$nb);
    		for ($i = 0; $i < $nb; $i++) {
    			$l = $arrL[$i];
			$this->s->trace(" ligne en doublon ", $l);			
    			//récupère le tableaux des titres EN
    			$arrTitreEn = explode(" --- ", $l["titresEN"]);
    			$arrIdLivre = explode(",", $l["idsLivre"]);
    			foreach ($arrTitreEn as $k => $ten) {
    				//vérifie s'il faut supprimer des livres
    				if($ten=="ISBN Wiley sans titre"){
    					$this->dbLivre->remove($arrIdLivre[$k]);
					$this->s->trace(" livre supprimé ".$arrIdLivre[$k]." ".$ten);			
    				}
    			}
    			/*
    			$arrDate = explode(",", $l["dates"]);
    			$arrIsbn = explode(",", $l["ids"]);
    			//vérifie s'il faut supprimer les isbn sans date
    			$avecDate = false;
			foreach ($arrDate as $k => $d){
				if($d!="0" || $d!="0000-00-00"){
					$avecDate = $k;
				}
			}
			if($avecDate){
				foreach ($arrDate as $k => $d){
					if($avecDate!=$k){
	    					$this->dbIsbn->remove($arrIsbn[$k]);
						$this->s->trace(" ISBN supprimé ".$arrIsbn[$k]);			
					}
				}				
			}
			*/
    		}
    		$this->s->trace("lignes traitées ".$i);		

    		$this->s->trace("FIN ".__METHOD__);		
    		
    }    
	function updateManquesAuteur(){
		$this->s->trace("DEBUT ".__METHOD__);		

		$arrL = $this->dbA->findRoleCoorDir();
		$i = 0;
		$nb = count($arrL);
    		$this->s->trace($i." RoleCoorDir nb=".$nb);
    		for ($i = 0; $i < $nb; $i++) {
    			$l = $arrL[$i];
    			if($l["role"]=="coordinateur"){
    				$this->dbCoor->ajouter(array("id_auteur"=>$l["id_auteur"],"id_serie"=>$l["id_serie"]));		
				$this->s->trace($l["id_livre"]." ajout coordination");			
    			}
    			if($l["role"]=="directeur"){
    				$this->dbComAut->ajouter(array("id_auteur"=>$l["id_auteur"],"id_comite"=>$l["id_comite"]));		
				$this->s->trace($l["id_livre"]." ajout comite");			
    			}
    		}
    		$this->s->trace("lignes traitées ".$i);		

    		$this->s->trace("FIN ".__METHOD__);		
    		
    }    

	function updateNbPage($r=false, $i=false){
		$this->s->trace("DEBUT ".__METHOD__);		

		$dbP = new Model_DbTable_Iste_page();
		
		if($r && $i){
			
	    		if($r[2]){
		    		//recherche les références
	    			$l = $this->dbIsbn->findByNum($r[0]);
	    			if($r[9] && $l["id_livre"])$dbP->ajouter(array("id_livre"=>$l["id_livre"],"type"=>"final GB","nombre"=>$r[9]));
	    		}
	    		$this->s->trace($i." ".$l["id_livre"]." (".$l["type"].") : ".$r[9]);		
		}else{
			$arrL = $this->dbLivre->getNbPage();		
			$i = 0;
			$nb = count($arrL);
	    		$this->s->trace($i." nb=".$nb);
	    		for ($i = 0; $i < $nb; $i++) {
	    			$l = $arrL[$i];
	    			if($l["nb_page_fr"])$dbP->ajouter(array("id_livre"=>$l["id_livre"],"type"=>"prévu FR","nombre"=>$l["nb_page_fr"]));
	    			if($l["nb_page_en"])$dbP->ajouter(array("id_livre"=>$l["id_livre"],"type"=>"prévu GB","nombre"=>$l["nb_page_en"]));
	    			if($l["nb_page"])$dbP->ajouter(array("id_livre"=>$l["id_livre"],"type"=>"final ".substr($l["type"], -2),"nombre"=>$l["nb_page"]));
		    		$this->s->trace($i." ".$l["id_livre"]." (".$l["type"]." ".substr($l["type"], -2).") : ".$l["nb_page_fr"]." ".$l["nb_page_en"]." ".$l["nb_page"]);		
	    		}
		}    		
    		
    		$this->s->trace("FIN ".__METHOD__);		
    		
    }    
    
	function verifWileyISBN($r=false, $i=false){
		//$this->s->trace("DEBUT ".__METHOD__);		
		
    		if($r[2]){
	    		//recherche les références
    			$rsIsbn = $this->dbIsbn->findByNum($r[0]);
			if($rsIsbn["titre_en"] && $rsIsbn["titre_en"]!=$r[2]){
    				$this->s->trace($i." ".$rsIsbn["id_livre"]." ".$rsIsbn["titre_en"]." != ".$r[2]);
    				$rsLivre = $this->dbLivre->findByTitre($r[2], "en");
    				$this->dbIsbn->edit($rsIsbn["id_isbn"],array("id_livre"=>$rsLivre[0]["id_livre"]));
    				$this->s->trace($i." ".$rsIsbn["id_livre"]." => ".$rsLivre[0]["id_livre"]);   						    					
    			}else{
    				$this->s->trace($i." OK ".$rsIsbn["id_livre"]);		    					    					
    			}
		} 		
    		
    		//$this->s->trace("FIN ".__METHOD__);		
    		
    }    

	function corrigeISBN($r=false, $i=false){
		$this->s->trace("DEBUT ".__METHOD__." ".$r[0]);		
		if($r[0]=="updateISBN"){
			$rsIsbn = $this->dbIsbn->findById_livre($r[1]);
			if($rsIsbn){
				$arrISBN = explode("-", $r[10]);
				$arrEditeur = explode("-", $r[11]);
				$j = 0;
				foreach ($arrISBN as $m) {
					if($j==0){
						$this->dbIsbn->edit($rsIsbn[0]["id_isbn"],array("id_livre"=>$r[1],"num"=>$arrISBN[$j],"id_editeur"=>$arrEditeur[$j]));
				    		$this->s->trace($i." ".$rsIsbn[0]["id_isbn"]." : ".$arrISBN[$j]." => modifié");   						    									
					}else{
						$this->dbIsbn->ajouter(array("id_livre"=>$r[1],"num"=>$arrISBN[$j],"id_editeur"=>$arrEditeur[$j]));				
				    		$this->s->trace($i." ".$arrISBN[$j]." => ajout");   						    									
					}
					$i++;
				}
			}else{
				$this->s->trace($i." référence non trouvée ".$r[1]." ".$r[3]." ".$r[5]);   						    													
			}
		}
    		$this->s->trace("FIN ".__METHOD__);		
    		
    }    
    
    
    function updateManquesIsbn(){

		require_once '../bdd/isbnSansLivre.php';
		$oIsbn = 0;
		foreach ($iste_isbn as $i) {
			if($oIsbn!=$i["num"]){
				$this->dbIsbn->edit($i["idIsbnVide"], array("id_livre"=>$i["idLivreRef"]));						
				$this->s->trace($i."isbn mis à jour ".$i["idIsbnVide"]." ".$i["idLivreRef"]);			
				$oIsbn=$i["num"];
			}
		}
    	
    }

    function deleteLivreIsbnSansTitre($titreEn=false){

    		if(!$titreEn){
    			$this->deleteLivreIsbnSansTitre("ISBN Elsevier sans titre");
			$this->deleteLivreIsbnSansTitre("ISBN e-book ISTE Edition sans titre");
			$this->deleteLivreIsbnSansTitre("ISBN papier ISTE Edition sans titre");
			$this->deleteLivreIsbnSansTitre("ISBN Wiley sans titre");
	    	}else{
			$this->s->trace($i." supprime les livre ".$titreEn);			
    			$arrIsbn = $this->dbLivre->findByTitre_en($titreEn);
			$i = 0;
			foreach ($arrIsbn as $l) {
				$n = $this->dbLivre->remove($l["id_livre"]);
				$this->s->trace($i." livre supprimé ".$l["titre_en"]." ".$l["id_livre"],$n);			
				$i++;
			}
	    }		    	
    }
    
    
    function updateByBase(){
    	
		//met à jour la date de parution dans le planning		
    		$rs = $this->dbIsbn->findParu();
		foreach ($rs as $r) {
			if($r["id_editeur"]==1)$idT = 18; else $idT = 17;
			$rPrev = $this->dbPrev->findByProcessLivreTache(3, $r["id_livre"], $idT);
			if($rPrev && (!$rPrev["fin"] || $rPrev["fin"]!="0000-00-00")){
				$this->dbPrev->edit($rPrev['id_prevision'], array("fin"=>$r["date_parution"]));
				$this->s->trace("Date fin mis à jour ".$r["id_livre"]." ".$r["date_parution"]);			
			}else{
				$this->s->trace("Prévision introuvable ".$r["id_livre"]." ".$idT);							
			}	
		}
		
		//met à jour les ordres d'affichage d'auteurs		
    		$rs = $this->dbLiAut->getAll(array("id_livre","role DESC","ordre"));
    		$oIdL = 0;
    		$ordre = 1;
		foreach ($rs as $r) {
			if($oIdL != 0 && $oIdL!= $r["id_livre"])$ordre = 1;
			// if(!$r["ordre"]){
				$this->dbLiAut->edit($r["id_livrexauteur"], array("ordre"=>$ordre));
				$this->s->trace("Ordre auteur mis à jour ".$r["id_livre"]." ".$r["id_auteur"]." ".$r["role"]." ".$ordre);							
				$ordre ++;	
			// }else $ordre = $r["ordre"];	
			$oIdL = $r["id_livre"]; 
		}
		
    	
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
			$this->s->trace("Mois:".$d." : ".$strDate);
    		}
    		if($format=="mc"){
	    		$arr = explode("-", $d);
    			$strDate = $arr[1]."-".$this->arrMoisCourt[$arr[0]]."-01";
			$this->s->trace("MoisCourt:".$d." : ".$strDate);
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
    
	public function envoimailAction(){
		
		$this->initInstance();
		$dbAut = new Model_DbTable_Iste_auteur();
		$dbr = new Model_DbTable_Iste_royalty();
		$dbP = new Model_DbTable_Iste_parammail();

		//récupérer les données de sélection {recid(rapport_id), idAuteur}
		$data = $this->_getParam("data");

		//config mail
		function recipientFilename($transport)
		{
			return $transport->recipients . '_' . mt_rand() . '.eml';
		}
		//log
		$log = array();

		//envoi de mail pour chaque sélection 
		foreach ($data as $ligne ) {
		
			//récupérer mail auteur 
			$auteur = $dbAut->findById_auteur($ligne["idAuteur"]);
			//si mail valide (simple check au cas où pas de mail)
			if (strpos($auteur["mail_1"],"@") !== false){
				
				//récupérer odt
				$filePath = ROOT_PATH.substr($ligne["url"],strpos($ligne["url"],"/data"));
				$fileName = substr($ligne["url"],strpos($ligne["url"],"editions/")+strlen("editions/"));
				//conversion odt en pdf
				
				//conversion qui marche (avec trace)
				// $cmd= shell_exec("export HOME=/tmp && strace -f -o trace.txt soffice --headless -convert-to pdf --outdir ../data/editions ".$filePath);
				//conversion qui marche (sans trace)
				$cmd= shell_exec("export HOME=/tmp && soffice --headless -convert-to pdf --outdir ../data/editions ".$filePath);

				if (file_exists(substr($filePath,0,(strlen($filePath)-3))."pdf")){
					
					$mail = new Zend_Mail();
					//construire le mail avec les informations nécessaires (texte, mail envoyeur)

					$royalties = $dbr->findById_rapport($ligne["recid"]);
					$textmail = "";
					if ($royalties[0]["montant_euro"] > 100){
						$textmail = $dbP->findByChamp_parammail("avec_redevance");
					}
					else{
						$textmail = $dbP->findByChamp_parammail("sans_redevance");
					}

					//remplacer les % dans le texte par ce qui correspond (nom,civilité...)
					if ($auteur["civilite"] == "M." || $auteur["civilite"] == "Mr"){
						$textmail = str_replace("%Cher%","Cher Monsieur", $textmail);
						$textmail = str_replace("%Agreer%", "Monsieur", $textmail);
					}
					else if ($auteur["civilite"] == "Mme" ){
						$textmail = str_replace("%Cher%","Chère Madame", $textmail);
						$textmail = str_replace("%Agreer%", "Madame", $textmail);
					}
					else{
						$textmail = str_replace("%Cher%","Cher(e)", $textmail);
						$textmail = str_replace("%Agreer%", "Madame, Monsieur", $textmail);
					}
					$textmail = str_replace("%Auteur%",$auteur["nom"]." ".$auteur["prenom"],$textmail);
					$textmail = str_replace("%periode1%",$dbP->findByChamp_parammail("periode1"),$textmail);
					$textmail = str_replace("%periode2%",$dbP->findByChamp_parammail("periode2"),$textmail);
					
					//TODO: problème d'encodage !!! 
					$mail->setBodyText($textmail);
					// $mail->setBodyText(mb_convert_encoding(htmlspecialchars($textmail, ENT_QUOTES), 'ISO-8859-1', 'UTF-8'),
										// null,
										// Zend_Mime::ENCODING_BASE64
										// );
					$mail->setFrom($dbP->findByChamp_parammail('email'), $dbP->findByChamp_parammail('nom'));
					$mail->addTo($auteur["mail_1"], $auteur["nom"]." ".$auteur["prenom"]);
					$mail->setSubject('Royalties');
					$filePath = substr($filePath,0,(strlen($filePath)-3))."pdf";
					//attacher le pdf
					$content = file_get_contents($filePath); // e.g. ("attachment/abc.pdf")
					$attachment = new Zend_Mime_Part($content);
					$attachment->type = 'application/pdf';
					$attachment->disposition = Zend_Mime::DISPOSITION_ATTACHMENT;
					$attachment->encoding = Zend_Mime::ENCODING_BASE64;
					$attachment->filename = substr($fileName,0,(strlen($fileName)-3))."pdf"; // name of file
	
					$mail->addAttachment($attachment); 
	
	
					$tr = new Zend_Mail_Transport_File(array("path" => ROOT_PATH."/tmp",'callback' => 'recipientFilename'));
					$mail->send($tr);
	
					//si mail envoyé màj bdd
					if ($mail){
						array_push($log,array("recid"=>$ligne["recid"],"nom"=>$auteur["nom"],"prenom"=>$auteur["prenom"],"etat"=>"Email préparé !"));
						//ajouter date envoi à la bdd 
						
						foreach ($royalties as $roy ) {
							$dbr->edit($roy["id_royalty"],array("date_envoi"=>date("Y-m-d")));
						}
					}
					else{
						array_push($log,array("recid"=>$ligne["recid"],"nom"=>$auteur["nom"],"prenom"=>$auteur["prenom"],"etat"=>"Problème envoi email "));
					}
				}
				else{ //pdf non crée ou inaccessible
					array_push($log,array("recid"=>$ligne["recid"],"nom"=>$auteur["nom"],"prenom"=>$auteur["prenom"],"etat"=>"Problème création rapport pdf"));
				}
			}
			//si il y a un problème avec le mail de l'auteur 
			else{
				array_push($log,array("recid"=>$ligne["recid"],"nom"=>$auteur["nom"],"prenom"=>$auteur["prenom"],"etat"=>"Problème avec l'email de l'auteur"));
			}
		}
		$this->view->json = json_encode($log);
	}


	public function grouperpdfAction(){
		$this->initInstance();
		$dbr = new Model_DbTable_Iste_rapport();

		$data = explode(".",$this->_getParam("data"));


		$pdf = new \setasign\Fpdi\Fpdi();

		foreach ($data as $id ) {
			$url = $dbr->findById_rapport($id);
			$filePath = ROOT_PATH.substr($url["url"],strpos($url["url"],"/data"));
			$this->ajouteFichier($pdf,$filePath);

		}
		$fileName = '/data/editions/fichier'.mt_rand().'.pdf';
		
		$pdf->Output('I','nouveau_fichier.pdf');
	}
    
	function ajouteFichier($pdf,$file)
	{
		$pageCount = $pdf->setSourceFile($file);
		for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
			$pageId = $pdf->ImportPage($pageNo);
			$s = $pdf->getTemplatesize($pageId);
			$pdf->AddPage($s['orientation'], $s);
			$pdf->useImportedPage($pageId);
		}
	}

	public function paiementAction(){
		$this->initInstance();
		$dbr = new Model_DbTable_Iste_royalty();
		$data = $this->_getParam("data");
		$date = $this->_getParam("date");
		foreach ($data as $ligne) {
			$royalties = $dbr->findById_rapport($ligne["recid"]);
			foreach ($royalties as $roy ) {
				$dbr->edit($roy["id_royalty"],array("date_paiement"=>$date));
			}
		}
		$this->view->json = json_encode("Date de paiement enregistrée avec succès");
		
	}

	public function encaissementAction(){
		$this->initInstance();
		$dbr = new Model_DbTable_Iste_royalty();
		$data = $this->_getParam("data");
		$date = $this->_getParam("date");
		foreach ($data as $ligne) {
			$royalties = $dbr->findById_rapport($ligne["recid"]);
			foreach ($royalties as $roy ) {
				$dbr->edit($roy["id_royalty"],array("date_encaissement"=>$date));
			}
		}
		$this->view->json = json_encode("Date d'encaissement enregistrée avec succès");
	}
}




