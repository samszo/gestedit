<?php
/**
* Class pour gérer les propriétés et méthode d'une site Web
*
*
* @author     Samuel Szoniecky <samuel.szoniecky@univ-paris8.fr>
* @license    CC0 1.0 Universal (CC0 1.0) Public Domain Dedication http://creativecommons.org/publicdomain/zero/1.0/ 
*/
class Flux_Site{
    
    var $cache;
	var $idBase;
    var $idExi;
	var $login;
	var $pwd;
    var $user;
	var $db;
    //pour l'optimisation
    var $bTrace = false;
    var $bTraceFlush = false;//mettre false pour les traces de debuggage
    var $echoTrace = false;
    var $temps_debut;
    var $temps_inter;
    var $temps_nb=0;
    
    function __construct($idBase=false, $bTrace=false){    	
    	
    		if($bTrace){
				$this->bTrace = true;		
				$this->bTraceFlush = true;		
    		}
    	    	
    		$this->getDb($idBase);
    	
        $frontendOptions = array(
            'lifetime' => 30000000, // temps de vie du cache en seconde
            'automatic_serialization' => true,
        		'caching' => true //active ou desactive le cache
        );  
        $backendOptions = array(
            // Répertoire où stocker les fichiers de cache
            'cache_dir' => '../tmp/flux/'
        ); 
        // créer un objet Zend_Cache_Core
        $this->cache = Zend_Cache::factory('Core',
                                     'File',
                                     $frontendOptions,
                                     $backendOptions); 
        
    }

	/**
	* fonction pour tracer l'éxécution du code
	*
    * @param string 	$message
    * @param array 	$data
    * 
    */
	public function trace($message, $data=false){
		if($this->bTrace){
			$temps_fin = microtime(true);
			$tG = str_replace(".",",",round($temps_fin - $this->temps_debut, 4));
			$tI = str_replace(".",",",round($temps_fin - $this->temps_inter, 4));
			$mess = $this->temps_nb." | ".$message." | ".$tG." | ".$tI."<br/>";
			if($this->echoTrace)
				$this->echoTrace .= $mess;
			else{
				echo $mess;
				if($data){print_r($data); echo "<br/>";}
				if($this->bTraceFlush){
					ob_flush();
			        flush();				
				}
		        //
			}
			$this->temps_inter = $temps_fin;
			$this->temps_nb ++;
		}		
	}
    
    
    /**
    * @param string $c
    */
    function removeCache($c){
        $res = $this->manager->remove($c);
    }
    
    /**
    * supprime un répertoire sur le serveur
    * @param string $dir
    * @return Zend_Db_Table
    */
    public function removeRep($dir) { 
   		$files = array_diff(scandir($dir), array('.','..')); 
	    foreach ($files as $file) { 
	      (is_dir("$dir/$file")) ? $this->removeRep("$dir/$file") : unlink("$dir/$file"); 
	    } 
	    return rmdir($dir); 
	} 
    
    /**
     * retourne une connexion à une base de donnée suivant son nom
    * @param string $idBase
    * @return Zend_Db_Table
    */
    public function getDb($idBase){
    	
 		$db = Zend_Db_Table::getDefaultAdapter();
	    	if($idBase){
	    		//change la connexion à la base
	    		$arr = $db->getConfig();
				$arr['dbname']=$idBase;
				$db = Zend_Db::factory('PDO_MYSQL', $arr);	
	    	}
	      	
	    	$this->db = $db;
	    	$this->idBase = $idBase;
	    	return $db;
    }
    

    /**
     * Récupère le contenu body d'une url
     *
     * @param string $url
     * @param array $param
     * @param boolean $cache
     *   
     * @return string
     */
	function getUrlBodyContent($url, $param=false, $cache=true, $method=null) {
		$html = false;
		if(substr($url, 0, 7)!="http://")$url = urldecode($url);
		if($cache){
			$c = str_replace("::", "_", __METHOD__)."_".md5($url); 
			if($param)$c .= "_".$this->getParamString($param);
		   	$html = $this->cache->load($c);
		}
        if(!$html){
		    	$client = new Zend_Http_Client($url,array('timeout' => 30));
		    	if($param && !$method)$client->setParameterGet($param);
		    	if($param && $method==Zend_Http_Client::POST)$client->setParameterPost($param);
		    	try {
					$response = $client->request($method);
					$html = $response->getBody();
				}catch (Zend_Exception $e) {
					echo "Récupère exception: " . get_class($e) . "\n";
				    echo "Message: " . $e->getMessage() . "\n";
				}				
	        	if($cache)$this->cache->save($html, $c);
        }
		return $html;
	}

	/**
     * création d'un tableau à partir d'un csv
     *
     * @param string $file = adresse du fichier
     * 
     */
    public function csvToArray($file, $tailleCol="0", $sep=";"){
		ini_set("memory_limit",'1024M');
			$this->trace("DEBUT ".__METHOD__);  
			$file = urldecode($file);   	
	    if (($handle = fopen($file, "rb")) !== FALSE) {
    		$this->trace("Traitement des lignes : ".ini_get("memory_limit"));     	
	    	$i=0;
	    	$csvarray = array();
    		while (($data = fgetcsv($handle, $tailleCol, $sep)) !== FALSE) {
    			$num = count($data);
 				$numTot = count($csvarray);
 				//$this->trace("$numTot -> $num fields in line $i:");
        		$csvarray[] = $data;
    			$i++;
	    	}
	    	$this->trace("FIN Traitement des lignes");     	
	        fclose($handle);
	    }
    	
    	$this->trace("FIN ".__METHOD__." nb=".count($csvarray));     	
		return $csvarray;		
	}	
	
    /**
     * récupère le contenu HTML d'un DOMElement
     *
     * @param DOMElement $node
     *   
     * @return string
     */
	function getInnerHtml( $node ) { 
	    $innerHTML= ''; 
	    $children = $node->childNodes; 
	    foreach ($children as $child) { 
	        $innerHTML .= $child->ownerDocument->saveXML( $child ); 
	    } 
	
	    return $innerHTML; 
	} 
	
		
	function getParamString($params, $md5=false){
		$s="";
		foreach ($params as $k=>$v){
			if($md5) $s .= "_".md5($v);
			else $s .= "_".$v;
		}
		return $s;	
	}
	

	

	/**
     * Récupère le contenu d'une page html avec des argument POST
     * @param string $url
     * @param array $args
     * 
     * @return string
     */
	function getUrlPostContent($url, $args){

		/* Here we build the data we want to POST */
		$data = "";
		foreach($args as $key=>$value)
		{
			$data .= ($data != "")?"&":"";
			$data .= urlencode($key)."=".urlencode($value);
		}
		
		/* Here we build the POST request */
		$params = array('http' => array(
			'method' => 'POST',
			'Content-type'=> 'application/x-www-form-urlencoded',
			'Content-length' =>strlen($data),
			'content' => $data
		));
		
		/* Here we send the post request */
		$ctx = stream_context_create($params); // We build the POST context of the request
		$fp = @fopen($url, 'rb', false, $ctx); // We open a stream and send the	   request
		if ($fp){
			/* Finaly, herewe get the response of Zementa */
			$response = @stream_get_contents($fp);
			if ($response === false){
				$response = "Problem reading data from ".$url.", ".$php_errormsg;
			}
			fclose($fp); // We close the stream
		}else{
			$response = "Problem reading data from ".$url.", ".$php_errormsg;
		}
		return $response;		
	}
	

	
    /**
     * sauveImage
     *
     * enregistre l'image du document
     * 
     * @param int $idDoc
     * @param string $url
     * @param string $titre
     * @param string $chemin
     * 
     * @return int
     */
	function sauveImage($idDoc, $url, $titre, $chemin){

    	if(!$this->dbD)$this->dbD = new Model_DbTable_Flux_Doc($this->db);
    	if(!$this->dbDT)$this->dbDT = new Model_DbTable_Flux_DocTypes($this->db);
    	if(!$this->dbUD)$this->dbUD = new Model_DbTable_flux_utidoc($this->db);
    	
    	//création du répertoire de stockage de l'image
		if(!is_dir($chemin)) @mkdir($chemin,0777,true);
    	
		//création des données du document
		$extension = pathinfo($url, PATHINFO_EXTENSION);
    	$type = $this->dbDT->getIdByExtension($extension);
    	$arrDoc['type']=$type;
		$path = $chemin."/".$this->idBase."_".$idDoc.".".$extension;
		$urlLocal = str_replace(ROOT_PATH, WEB_ROOT, $path);     	
    	$arrDoc['url']=$urlLocal;
    	$arrDoc['titre']=$titre;
    	$arrDoc['tronc']=$idDoc;
    	
    	//ajoute le document
    	$idDoc = $this->dbD->ajouter($arrDoc);

    	//création des liens avec le flux
    	$this->dbUD->ajouter(array("doc_id"=>$idDoc,"uti_id"=>$this->user));
    	    	    	
		if(!is_file($path)){
    		//enregistre l'image sur le disque local
			if(!$img = file_get_contents($url)) { 
			  echo 'pas de fichier : '.$url."<br/>";
			}else{
				if(!$f = fopen($path, 'w')) { 
				  echo 'Ouverture du fichier impossible '.$path."<br/>";
				}elseif (fwrite($f, $img) === FALSE) { 
				  echo 'Ecriture impossible '.$path."<br/>";
				}else{
					echo 'Image '.$titre.' enregistrée : <a href="'.$urlLocal.'">local</a> -> <a href="'.$url.'">En ligne</a><br/>';
				} 				
			}				
		} 
		return $idDoc;   	
	} 	


	function objectToObject($instance, $className) {
	    //merci à http://stackoverflow.com/questions/3243900/convert-cast-an-stdclass-object-to-another-class
		return unserialize(sprintf(
	        'O:%d:"%s"%s',
	        strlen($className),
	        $className,
	        strstr(strstr(serialize($instance), '"'), ':')
	    ));
	}

	
	/**
	 * Removes invalid XML
	 *
	 * @access public
	 * @param string $value
	 * @return string
	 */
	function stripInvalidXml($value)
	{
	    $ret = "";
	    $current;
	    if (empty($value)) 
	    {
	        return $ret;
	    }
	
	    $length = strlen($value);
	    for ($i=0; $i < $length; $i++)
	    {
	        $current = ord($value{$i});
	        if (($current == 0x9) ||
	            ($current == 0xA) ||
	            ($current == 0xD) ||
	            (($current >= 0x20) && ($current <= 0xD7FF)) ||
	            (($current >= 0xE000) && ($current <= 0xFFFD)) ||
	            (($current >= 0x10000) && ($current <= 0x10FFFF)))
	        {
	            $ret .= chr($current);
	        }
	        else
	        {
	            $ret .= " ";
	        }
	    }
	    return $ret;
	}

		
	/**
	 * tri un tableau par une de ces clefs
	 *
	 * @param array $array
	 * @param string $on
	 * @param string $order
	 * 
	 * @return array
	 */
	function array_sort($array, $on, $order=SORT_ASC)
	{
	    $new_array = array();
	    $sortable_array = array();
	
	    if (count($array) > 0) {
	        foreach ($array as $k => $v) {
	            if (is_array($v)) {
	                foreach ($v as $k2 => $v2) {
	                    if ($k2 == $on) {
	                        $sortable_array[$k] = $v2;
	                    }
	                }
	            } else {
	                $sortable_array[$k] = $v;
	            }
	        }
	
	        switch ($order) {
	            case SORT_ASC:
	                asort($sortable_array);
	            break;
	            case SORT_DESC:
	                arsort($sortable_array);
	            break;
	        }
	
	        foreach ($sortable_array as $k => $v) {
	            $new_array[$k] = $array[$k];
	        }
	    }
	
	    return $new_array;
	}	
	  
    
    /** 
     * Copy file or folder from source to destination, it can do 
     * recursive copy as well and is very smart 
     * It recursively creates the dest file or directory path if there weren't exists 
     * Situtaions : 
     * - Src:/home/test/file.txt ,Dst:/home/test/b ,Result:/home/test/b -> If source was file copy file.txt name with b as name to destination 
     * - Src:/home/test/file.txt ,Dst:/home/test/b/ ,Result:/home/test/b/file.txt -> If source was file Creates b directory if does not exsits and copy file.txt into it 
     * - Src:/home/test ,Dst:/home/ ,Result:/home/test/** -> If source was directory copy test directory and all of its content into dest      
     * - Src:/home/test/ ,Dst:/home/ ,Result:/home/**-> if source was direcotry copy its content to dest 
     * - Src:/home/test ,Dst:/home/test2 ,Result:/home/test2/** -> if source was directoy copy it and its content to dest with test2 as name 
     * - Src:/home/test/ ,Dst:/home/test2 ,Result:->/home/test2/** if source was directoy copy it and its content to dest with test2 as name 
     * @todo 
     *     - Should have rollback technique so it can undo the copy when it wasn't successful 
     *  - Auto destination technique should be possible to turn off 
     *  - Supporting callback function 
     *  - May prevent some issues on shared enviroments : http://us3.php.net/umask 
     * @param $source //file or folder 
     * @param $dest ///file or folder 
     * @param $options //folderPermission,filePermission 
     * @return boolean 
     */ 
    function smartCopy($source, $dest, $options=array('folderPermission'=>0755,'filePermission'=>0755)) 
    { 
        $result=false; 
        
        if (is_file($source)) { 
            if ($dest[strlen($dest)-1]=='/') { 
                if (!file_exists($dest)) { 
                    cmfcDirectory::makeAll($dest,$options['folderPermission'],true); 
                } 
                $__dest=$dest."/".basename($source); 
            } else { 
                $__dest=$dest; 
            } 
            $result=copy($source, $__dest); 
            chmod($__dest,$options['filePermission']); 
            
        } elseif(is_dir($source)) { 
            if ($dest[strlen($dest)-1]=='/') { 
                if ($source[strlen($source)-1]=='/') { 
                    //Copy only contents 
                } else { 
                    //Change parent itself and its contents 
                    $dest=$dest.basename($source); 
                    @mkdir($dest); 
                    chmod($dest,$options['filePermission']); 
                } 
            } else { 
                if ($source[strlen($source)-1]=='/') { 
                    //Copy parent directory with new name and all its content 
                    @mkdir($dest,$options['folderPermission']); 
                    chmod($dest,$options['filePermission']); 
                } else { 
                    //Copy parent directory with new name and all its content 
                    @mkdir($dest,$options['folderPermission']); 
                    chmod($dest,$options['filePermission']); 
                } 
            } 

            $dirHandle=opendir($source); 
            while($file=readdir($dirHandle)) 
            { 
                if($file!="." && $file!="..") 
                { 
                     if(!is_dir($source."/".$file)) { 
                        $__dest=$dest."/".$file; 
                    } else { 
                        $__dest=$dest."/".$file; 
                    } 
                    //echo "$source/$file ||| $__dest<br />"; 
                    $result=$this->smartCopy($source."/".$file, $__dest, $options); 
                } 
            } 
            closedir($dirHandle); 
            
        } else { 
            $result=false; 
        } 
        return $result; 
    } 	
    /**
     * This function takes the last comma or dot (if any) to make a clean float, 
     * ignoring thousand separator, currency or any other letter
     * http://php.net/manual/fr/function.floatval.php#114486
     * @param string $num
     * @return decimal
     */    
	function tofloat($num) {
	    $dotPos = strrpos($num, '.');
	    $commaPos = strrpos($num, ',');
	    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : 
	        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
	   
	    if (!$sep) {
	        return floatval(preg_replace("/[^0-9]/", "", $num));
	    } 
	
	    return floatval(
	        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
	        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
	    );
	}    



}