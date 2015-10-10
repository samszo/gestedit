<?php
//header('Content-Type: text/html; charset=utf-8');
require_once( "../application/configs/config.php" );
try {
	$application->bootstrap();
	$s = new Flux_Site(false,false);
	$s->trace("DEBUT TEST");		

	/*
	$bdA = new Model_DbTable_Iste_prevision();
    	$rsA = $bdA->getAlerteLivre();
    	for ($i = 0; $i < count($rsA); $i++) {
    		if($rsA[$i]['nbJour']<7)$rsA[$i]['style']='background-color: red';
    		if($rsA[$i]['nbJour']>7 && $rsA[$i]['nbJour']<14)$rsA[$i]['style']='background-color: orange';
    		if($rsA[$i]['nbJour']>14 && $rsA[$i]['nbJour']<21)$rsA[$i]['style']='background-color: green';    			
    		if($rsA[$i]['nbJour']>21)$rsA[$i]['style']='background-color: white';    			
    	}
    	*/		
	/*
    	$oBdd = new Model_DbTable_Iste_serie();
	$rs = $oBdd->copier(132);
	*/
	
	/*
	$dbL = new Model_DbTable_Iste_livre();
	$arr = $dbL->remove(2);
	*/
	
	/*
	$dbR = new Model_DbTable_Iste_royalty();    		
	$rs = $dbR->setForAuteur();	
	*/

	/*
	$path = "/data/livre_1/";
	$options = array('upload_dir' => ROOT_PATH.$path,'upload_url' => WEB_ROOT.$path);
	@$_SERVER["REQUEST_METHOD"]="GET";
	//$upload_handler = new UploadHandler($options);
	$upload_handler = new CustomUploadHandler($options);
	*/
	/*
	$w = new Flux_Wiley(false,true);
	$w->importer('../bdd/import/146169_1409.XLS');
	//$w->calculerVentes(3);
	*/

	/*
	$nbn = new Flux_Nbn(false,true);
	//$nbn->importer('../bdd/import/NBNEXPORT.CSV',"2015-03-30");
	$nbn->calculerVentes(4);
	*/
	
	//$dbFic = new Model_DbTable_Iste_importfic();
	//supprime un fichier et ses données
	//$dbFic->remove(43);
	//$rsFic = $dbFic->findById_importfic(48);
	/*calcul les colonnes 	
    	$cols = json_decode($rsFic["coldesc"]);
	*/
	
	/*
    	$dbData = new Model_DbTable_Iste_importdata();
    	$rs = $dbData->exportByIdFic(46);
	$arr = $s->csvToArray("../bdd/import/ISTEGlobal2015SAMbd.csv");
	*/
	
	/*
	$dbProcess = new Model_DbTable_Iste_processus();
	$dbProcess->setProcessusForLivre('Production livre', 1, 1); 
    	$dbProcess->getTraductionByLivre(1);
	*/
	
	/*
	$s = new Flux_Spip("spip_iste",true);
	$dbAut = new Model_DbTable_Iste_auteur();	
	//charge la liste des auteurs
	$arrAuteur = $dbAut->getAll("a.id_auteur");	
	$nbM = count($arrAuteur);
	for ($i = 0; $i < $nbM; $i++) {			
			//if($arrAuteur[$i]["id_auteur"]==200)
				$s->creaAuteurFromIste($arrAuteur[$i]);
	}		
	*/
	
	//
	$result = array();
    	$dbR = new Model_DbTable_Iste_royalty();
	//$rs = $dbR->paiementLivre("1249");
	$rs = $dbR->paiementAuteur("206");
	$rapport = new Flux_Rapport();    		
	foreach ($rs as $r) {
    		$result[] = $rapport->creaPaiement($r);
	}
	//

	$s->trace("FIN TEST");		
	
}catch (Zend_Exception $e) {
	 echo "<h1>Erreur d'exécution</h1>
  <h2>".$e->message."</h2>
  <h3>Exception information:</h3>
  <p><b>Message:</b>".$e->exception->getMessage()."</p>
  <h3>Stack trace:</h3>
  <pre>".$e->exception->getTraceAsString()."</pre>
  <h3>Request Parameters:</h3>
  <pre>".var_export($e->request->getParams(), true)."</pre>";
}
