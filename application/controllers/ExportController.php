<?php

class ExportController extends Zend_Controller_Action
{

    public function indexAction()
    {
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
    			default:
		    		$oName = "Model_DbTable_Iste_".$this->_getParam('obj');
		    		$oBdd = new $oName();
    				$rs = $oBdd->getAll();
    	    			break;
    		}
		$this->_helper->viewRenderer->setNoRender(true);		
		$this->printExcel($rs, "gestedit-".$this->_getParam('obj'));
    }
    
    public function dataventeAction()
    {
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
    
    
}



