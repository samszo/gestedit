<?php
require_once( "../application/configs/config.php" );

try {
	$application->bootstrap();
	$s = new Flux_Site();
	$s->bTrace = true;		
	$s->trace("DEBUT TEST");		
	$arr = $s->csvToArray("../bdd/import/ISTEGlobal2015.csv");
	
	/*
	$dbProcess = new Model_DbTable_Iste_processus();
	$dbProcess->setProcessusForLivre('Traduction livre', 1, 1); 
    	$dbProcess->getTraductionByLivre(1);
	*/

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
	