<?php

class ExportController extends Zend_Controller_Action
{

    public function indexAction()
    {
    		$this->initInstance();
    	
    		switch ($this->_getParam('obj')) {
    			case "contrat":
		    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
		    		$oBdd = new $oName();
    				if($this->_getParam('type')=="traduction") $rs = $oBdd->getAllContratTraducteur();
    				else $rs = $oBdd->getAllContratAuteur(false,$this->_getParam('type'));    					
    				break;    			
    			case "traduction":
				$bdd = new Model_DbTable_Iste_livre();
				$rs = $bdd->getTraductionLivre();
    				break;    			
    			case "keshifLivre":
				$bdd = new Model_DbTable_Iste_livre();
				$rs = $bdd->getKeshif();
    				break;    			
    			case "tresor":
				$bdd = new Model_DbTable_Iste_livre();
				$rs = $bdd->getTresorie();
    				break;    			
    			default:
		    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
		    		$oBdd = new $oName();
    				$rs = $oBdd->getAll();
    	    			break;
    		}
    		if($this->_getParam('json')){
    			$this->view->rs = $rs;
    		}else{
			$this->_helper->viewRenderer->setNoRender(true);		
			$this->printExcel($rs, "gestedit-".$this->_getParam('obj'));
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
    
    public function royaltyAction()
    {
	
		$this->bTrace = false;
		$this->temps_debut = microtime(true);
				
		//initialisation des objets	
		$dbR = new Model_DbTable_Iste_royalty();
				
		//récupère l'auteur
		$this->idExi = $idExi; 
		$this->arrExi = $this->dbE->findById_exi($idExi);
				
		//récupère le Modele
		$rm = $this->dbDoc->findByIdDoc($idModele);
		//vérifie le type de rapport
		$typeRapport = $rm['branche'];
		$this->trace("typeRapport=".$typeRapport);
		
		//récupère les mots clefs
		$this->arrMC = $this->dbMC->getAll();
		
		//charge le modèle
		//pour le debugage
		if($this->pathDebug)$ps = str_replace("/home/gevu/www", $this->pathDebug, $rm['path_source']);
		else $ps = $rm['path_source'];
		$this->trace($ps);
		$config = array(
    	'ZIP_PROXY' => 'PclZipProxy',
    	'DELIMITER_LEFT' => '{',
    	'DELIMITER_RIGHT' => '}',
		'PATH_TO_TMP' => ROOT_PATH.'/tmp'
   		);
		$this->odf = new odf($ps, $config);		
		/*dégugage du contenu xml
		header("Content-Type:text/xml");
		echo $this->odf->getContentXml();
		return;
		*/
		
		//récupération de l'état des lieux
		$this->arrEtatLieux = $this->oDiag->getNodeRelatedData($idLieu, $idExi, $idBase);
		
		//récupère le fil d'ariane du lieu
		$this->arrAriane = $this->arrEtatLieux["ariane"];
		$this->ariane = "";
		foreach ($this->arrAriane as $l) {
			$this->ariane .= $l['lib']." - ";			
		}
		$this->trace($this->ariane);
		
		/*
		[{"id_type_doc": 8,"lib": "Rapport bâtiment"}, {"id_type_doc": 9,"lib": "Rapport espace"}, {"id_type_doc": 10,"lib": "Rapport niveau"}
		, {"id_type_doc": 11,"lib": "Rapport objet"}, {"id_type_doc": 12,"lib": "Fiche logement"}, {"id_type_doc": 13,"lib": "Rapport logement"}];
		*/
		switch ($typeRapport) {
			case 8:
				$this->creaRapportBat();
				break;			
			case 9:
				$this->creaRapportEspace();
				break;			
			case 10:
				$this->creaRapportNiv();
				break;			
			case 11:
				$this->creaRapportEspace();
				break;			
			case 12:
				$this->creaFicheLog();
				break;			
			case 13:
				$this->creaRapportLog();
				break;			
			default:
				$this->creaRapportDefaut();
				break;
		}
				
		//on enregistre le fichier
		$idInst = $this->dbInst->ajouter(array("id_exi"=>$idExi,"nom"=>"Création rapport"));
		
		$nomFic = preg_replace('/[^a-zA-Z0-9-_\.]/','', $nomEtab);
		$nomFic = $idModele."_".$idLieu."_".$nomFic."_".$idInst.".odt";
		//copie le fichier dans le répertoire data
		$newfile = ROOT_PATH."/data/rapports/documents/".$nomFic;
		copy($this->odf->tmpfile, $newfile);
		
		//on enregistre le doc dans la base
		$idDoc = $this->dbDoc->ajouter(array("id_instant"=>$idInst,"url"=>WEB_ROOT."/data/rapports/documents/".$nomFic,"titre"=>$nomFic,"path_source"=>$newfile,"content_type"=>"application/vnd.oasis.opendocument.text"));
		$this->trace("idDoc =".$idDoc);
		$idRap = $this->dbRapport->ajouter(array("id_lieu"=>$idLieu, "id_exi"=>$idExi, "lib"=>$nomFic));
		$this->trace("idRap =".$idRap);
		$this->dbDocRapport->ajouter(array("id_doc"=>$idDoc,"id_rapport"=>$idRap));
		$this->trace("Association du doc et du rapport");
		
		$this->trace("on propose de télécharger le rapport : ".$nomFic);
		$this->odf->exportAsAttachedFile($nomFic);
		
		$this->trace("FIN");
		    	
    }
    
	/**
   * array via fputcsv() zu csv
   * http://blog.abmeier.de/zend-csv-action-helper
   * @param  array $aryData
   * @param  string $strName
   * @param  bool $bolCols
   * @return void
   */
  function printExcel($aryData = array(), $strName = "csv", $bolCols = true)
  {
 
    if (!is_array($aryData) || empty($aryData))
    {
      exit(1);
    }
 
    // header
    header('Content-Description: File Transfer');
    header('Content-Type: text/csv; charset=utf-8');
    header("Content-Disposition: attachment; filename=" . $strName . "-export.csv");
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-control: private, must-revalidate');
    header("Pragma: public");
 
    // Spaltenüberschriften
    if ($bolCols)
    {
      $aryCols = array_keys($aryData[0]);
      array_unshift($aryData, $aryCols);
    }
 
    // Ausgabepuffer für fputcsv
    ob_start();
 
    // output Stream für fputcsv
    $fp = fopen("php://output", "w");
    if (is_resource($fp))
    {
      foreach ($aryData as $aryLine)
      {
        // ";" für Excel
        fputcsv($fp, $aryLine, ';', '"');
      }
 
      $strContent = ob_get_clean();
       
      // Excel SYLK-Bug
      // http://support.microsoft.com/kb/323626/de
      $strContent = preg_replace('/^ID/', 'id', $strContent);
       
      $strContent = utf8_decode($strContent);
      $intLength = mb_strlen($strContent, 'utf-8');
 
      // length
      header('Content-Length: ' . $intLength);
 
      // kein fclose($fp);
 
      echo $strContent;
      exit(0);
    }
    ob_end_clean();
    exit(1);
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



