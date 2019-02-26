<?php

class ExportController extends Zend_Controller_Action
{

    public function indexAction()
    {
    		$this->initInstance();
    		$nomFic = $this->_getParam('obj');
    		switch ($this->_getParam('obj')) {
    			case "contrat":
		    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
		    		$oBdd = new $oName();
    				if($this->_getParam('type')=="traduction") $rs = $oBdd->getAllContratTraducteur();
    				else $rs = $oBdd->getAllContratAuteur(false,$this->_getParam('type'));    					
    				break;    			
    			case "venteISBN":
    			    $bdd = new Model_DbTable_Iste_vente();
    			    $rs = $bdd->getAllISBN(null, 0, 0, null,$this->_getParam('ids'));
    			    break;
    			case "venteAuteur":
    			    $bdd = new Model_DbTable_Iste_vente();
    			    $rs = $bdd->getAll(null, 0, 0, null,$this->_getParam('ids'));
    			    break;
    			case "traduction":
    				$bdd = new Model_DbTable_Iste_livre();
    				$rs = $bdd->getTraductionLivre($this->_getParam('ids'));
    				break;    			
    			case "keshifLivre":
    				$bdd = new Model_DbTable_Iste_livre();
    				$rs = $bdd->getKeshif();
    				break;    			
    			case "tresor":
    				$bdd = new Model_DbTable_Iste_livre();
    				$rs = $bdd->getTresorie();
    				break;    			
    			case "etatEditeur":
    				$bdd = new Model_DbTable_Iste_livre();
    				$rs = $bdd->getEtatEditeur($this->_getParam('idEditeur'));
    				if($this->_getParam('idEditeur')==5) $nomFic .= "_wiley"; 
    				if($this->_getParam('idEditeur')==4) $nomFic .= "_elsevier"; 
    				break;
    			case "suivi":
    				$bdd = new Model_DbTable_Iste_livre();
    				$rs = $bdd->getEtatSuivi($this->_getParam('ids'));
    				break;				    			
    			default:
		    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
		    		$oBdd = new $oName();
    				$rs = $oBdd->getAll(null, 0, 0, null,$this->_getParam('ids'));
    	    			break;
    		}
    		if($this->_getParam('json')){
    			$this->view->rs = $rs;
    		}else{
			$this->_helper->viewRenderer->setNoRender(true);		    			
			$this->printExcel($rs, $nomFic);
    		}
    }
    
    public function dataventeAction()
    {
    		$this->initInstance();
    	
    		$dbData = new Model_DbTable_Iste_importdata();
    		$rs = $dbData->exportByIdFic($this->_getParam('idFic'));
    		$this->_helper->viewRenderer->setNoRender(true);		
    		$this->printExcel($rs, "gestedit");
    }
    
	/**
	* array via fputcsv() zu csv
	* http://blog.abmeier.de/zend-csv-action-helper
	* @param  array $aryData
	* @param  string $strName
	* @param  bool $bolCols
	* @return void
	*/
	function printExcel($aryData = array(), $strName = "csv", $bolCols = true, $flux = false, $unique=true)
	{
		$erreur = "no";
		if (!is_array($aryData) || empty($aryData)){
			exit(1);
    		}
 
	    // header
	    if($flux){
		    header('Content-Description: File Transfer');
		    header('Content-Type: text/csv; charset=utf-8');
		    header("Content-Disposition: attachment; filename=" . $strName . "-export.csv");
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-control: private, must-revalidate');
		    header("Pragma: public");
	    }
     
	    // Spaltenüberschriften
	    if ($bolCols)
	    {
	      $aryCols = array_keys($aryData[0]);
	      array_unshift($aryData, $aryCols);
	    }
 
	    // Ausgabepuffer für fputcsv
	    ob_start();
 
	    // output Stream für fputcsv
	    
	    if($flux){
	    		$fp = fopen("php://output", "w");
	    }else{
	    		if($unique)$strName.="_".uniqid().".csv";
	    		$ficPath = "/data/export/".$strName;
	    		$fp = fopen(ROOT_PATH.$ficPath, "w");
	    }
	    if (is_resource($fp))
	    {
			foreach ($aryData as $aryLine){
		        // ";" für Excel
		        fputcsv($fp, $aryLine, ';', '"');
			}
 
		    if($flux){
			    $strContent = ob_get_clean();
			       
			    // Excel SYLK-Bug
			    // http://support.microsoft.com/kb/323626/de
			    $strContent = preg_replace('/^ID/', 'id', $strContent);
			       
			    $strContent = utf8_decode($strContent);
			    $intLength = mb_strlen($strContent, 'utf-8');
			 
			    // length
			    header('Content-Length: ' . $intLength);		 
			    echo $strContent;
		    		exit(0);
		    }
		    fclose($fp);
    		}else{
    			$erreur = "Erreur d'exportation";
    		}
    		
	    ob_end_clean();
		if($flux){	    
		    exit(1);
		}elseif($erreur=="no"){			
		    header("Content-Disposition: attachment; filename=".$strName);
			header('Content-type: application/octetstream'); 			
			readfile(ROOT_PATH.$ficPath);			
		}else{
			echo "ERREUR d'exportation";
		}
	    
	}  


	function zipAction(){

		if($this->_getParam('ids')){
			$dbFic = new Model_DbTable_Iste_rapport();
			$arrFic = $dbFic->findByIdsRapport(implode(",", $this->_getParam('ids')));
			$this->view->nomFicZip = 'iste'.uniqid().'.zip';
			$this->view->zipname = ROOT_PATH.'/data/export/'.$this->view->nomFicZip;
			$this->view->zipurl = WEB_ROOT.'/data/export/'.$this->view->nomFicZip;
			$zip = new ZipArchive;
			$message = "Le fichier zip est crée.";
			if ($zip->open($this->view->zipname, ZipArchive::CREATE)!==TRUE) {
				$message = "Impossible d'ouvrir le fichier : ".$this->view->zipname;
			}
			foreach ($arrFic as $key => $fic) {			
				$path = str_replace(WEB_ROOT,ROOT_PATH,$fic['url']);
				$localName = basename($path);
				$zip->addFile($path, $localName);
			}
			$zip->close();			
		}
		$this->view->data = array("message"=>$message,"lien"=>$this->view->zipurl);
		//pour renvoyer directement le zip commenter la ligne ci-dessous
		$this->view->zipname = false;
	}

	function odttopdfAction(){

		$this->initInstance();
		$rapport = new Flux_Rapport($this->_getParam('idBase'),$this->_getParam('trace'));
		$rapport->convertOdtToPdf($this->_getParam('odt'), $this->_getParam('pdf'));
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
  
}



