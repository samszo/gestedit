<?php
require 'zip/PclZipProxy.php';
require 'zip/PhpZipProxy.php';
require 'Segment.php';
class OdfException extends Exception
{}
/**
 * Templating class for odt file
 * You need PHP 5.2 at least
 * You need Zip Extension or PclZip library
 * Encoding : ISO-8859-1
 * Last commit by $Author: neveldo $
 * Date - $Date: 2009-06-17 11:11:57 +0200 (mer., 17 juin 2009) $
 * SVN Revision - $Rev: 42 $
 * Id : $Id: odf.php 42 2009-06-17 09:11:57Z neveldo $
 *
 * modifié par samszo : 07/04/2013

 * @copyright  GPL License 2008 - Julien Pauli - Cyril PIERRE de GEYER - Anaska (http://www.anaska.com)
 * @license    http://www.gnu.org/copyleft/gpl.html  GPL License
 * @version 1.3
 * 
 */
class Odf 
{
    protected $config = array(
    	'ZIP_PROXY' => 'PhpZipProxy',
    	'DELIMITER_LEFT' => '{',
    	'DELIMITER_RIGHT' => '}',
		'PATH_TO_TMP' => "../../tmp"
   	);
    protected $file;
    protected $contentXml;
    public $tmpfile;
    public $images = array();
    protected $vars = array();
    protected $segments = array();
    protected $manifestXml;
    const PIXEL_TO_CM = 0.026458333;
    
    //ajout samszo pour optimiser le traitement des images
    public $imagesVerif = array();
    public $oSite;
    
    /**
     * renvoie le contentXml pour debugger
     *
     * @throws OdfException
     */
    public function getContentXml()
    {
    		return $this->contentXml;
    }
    //fin ajout samszo
    
    /**
     * Class constructor
     *
     * @param string $filename the name of the odt file
     * @throws OdfException
     */
    public function __construct($filename, $config = array(), $oSite=false)
    {
    	$this->oSite = $oSite;
    	if (! is_array($config)) {
    		throw new OdfException('Configuration data must be provided as array');
    	}
    	foreach ($config as $configKey => $configValue) {
    		if (array_key_exists($configKey, $this->config)) {
    			$this->config[$configKey] = $configValue;
    		}
    	}
        if (! class_exists($this->config['ZIP_PROXY'])) {
            throw new OdfException($this->config['ZIP_PROXY'] . ' class not found - check your php settings');
        }
        $zipHandler = $this->config['ZIP_PROXY'];
        $this->file = new $zipHandler();
        if ($this->file->open($filename) !== true) {
            throw new OdfException("Error while Opening the file '$filename' - Check your odt file");
        }
        if (($this->contentXml = $this->file->getFromName('content.xml')) === false) {
            throw new OdfException("Nothing to parse - check that the content.xml file is correctly formed");
        }

	    if (($this->manifestXml = $this->file->getFromName('META-INF/manifest.xml')) === false) {
	      throw new OdfException("Something is wrong with META-INF/manifest.xml");
	    }
        
        $this->file->close();
        
        $tmp = tempnam($this->config['PATH_TO_TMP'], md5(uniqid()));
        copy($filename, $tmp);
        $this->tmpfile = $tmp;
        $this->_moveRowSegments();
    }
    /**
     * Assing a template variable
     *
     * @param string $key name of the variable within the template
     * @param string $value replacement value
     * @param bool $encode if true, special XML characters are encoded
     * @throws OdfException
     * @return odf
     */
    public function setVars($key, $value, $encode = true, $charset = 'UTF-8')
    {
        if (strpos($this->contentXml, $this->config['DELIMITER_LEFT'] . $key . $this->config['DELIMITER_RIGHT']) === false) {
            throw new OdfException("var $key not found in the document");
        }
        if($this->oSite)$this->oSite->trace($key." setVars 1");
        
        $value = $encode ? htmlspecialchars($value) : $value;
        if($this->oSite)$this->oSite->trace($key." setVars 2");
        
        $value = ($charset == 'ISO-8859') ? utf8_encode($value) : $value;
        if($this->oSite)$this->oSite->trace($key." setVars 3");
        
        $this->vars[$this->config['DELIMITER_LEFT'] . $key . $this->config['DELIMITER_RIGHT']] = str_replace("\n", "<text:line-break/>", $value);
        if($this->oSite)$this->oSite->trace($key." setVars 4");
        
        return $this;
    }
    /**
     * Assign a template variable as a picture
     *
     * @param string $key name of the variable within the template
     * @param string $value path to the picture
     * @throws OdfException
     * @return odf
     */
public function setImage($key, $value, $width=0, $height=0)
    {
        $filename = strtok(strrchr($value, '/'), '/.');
        $file = substr(strrchr($value, '/'), 1);
        //modif samszo pour optimiser l'ajout multiple d'une même image
        if(!isset($this->imagesVerif[$file])){
	        $size = @getimagesize($value);
	        if ($size === false) {
	            throw new OdfException("Invalid image");
	        }
	        if (($width==0)&&($height==0)){
	            list ($width, $height) = $size;
	            $width *= Odf::PIXEL_TO_CM;
	            $height *= Odf::PIXEL_TO_CM;
	        } else {
	            list ($owidth, $oheight) = $size;
	            if (($width > 0) && ($height == 0)){
	                $height = $width * ($oheight/$owidth);
	            }
	            if (($width == 0) && ($height > 0)){
	                $width = $height * ($owidth/$oheight);
	            }
	            /*Remove this section if no GD/temp directory
	            $widthp = round($width / Odf::PIXEL_TO_CM, 0);
	            $heightp = round($height / Odf::PIXEL_TO_CM, 0);
	            $save = $yourtempdirectory . date("Y-m-d_H-i-s") . rand() . '.jpg';
	            $tn = imagecreatetruecolor($widthp, $heightp) ;   
	            $image = imagecreatefromjpeg($value);
	            imagecopyresampled($tn, $image, 0, 0, 0, 0, $widthp, $heightp, $owidth, $oheight) ;
	            imagejpeg($tn, $save, 100);
	            $value = $save;
	            $filename = strtok(strrchr($value, '/'), '/.');
	            $file = substr(strrchr($value, '/'), 1);
	           Remove to here*/
	        }
	       
        	$xml = <<<IMG
<draw:frame draw:style-name="fr1" draw:name="$filename" text:anchor-type="as-char" svg:width="{$width}cm" svg:height="{$height}cm" draw:z-index="3"><draw:image xlink:href="Pictures/$file" xlink:type="simple" xlink:show="embed" xlink:actuate="onLoad"/></draw:frame>
IMG;
	        $this->imagesVerif[$file]=$xml;
	    	$this->images[$value] = $file;
        	if($this->oSite)$this->oSite->trace($key.":".$file." size");
        }else{
			$xml = $this->imagesVerif[$file];
        	if($this->oSite)$this->oSite->trace($key.":".$file." direct");
        }
	    $this->setVars($key, $xml, false);
        return $this;
    }    
    
/**
     * Move segment tags for lines of tables
     * Called automatically within the constructor
     *
     * @return void
     */    
    private function _moveRowSegments()
    {
    	// Search all possible rows in the document
    	$reg1 = "#<table:table-row[^>]*>(.*)</table:table-row>#smU";
		preg_match_all($reg1, $this->contentXml, $matches);
		for ($i = 0, $size = count($matches[0]); $i < $size; $i++) {
			// Check if the current row contains a segment row.*
			$reg2 = '#\[!--\sBEGIN\s(row.[\S]*)\s--\](.*)\[!--\sEND\s\\1\s--\]#sm';
			if (preg_match($reg2, $matches[0][$i], $matches2)) {
				$balise = str_replace('row.', '', $matches2[1]);
				// Move segment tags around the row
				$replace = array(
					'[!-- BEGIN ' . $matches2[1] . ' --]'	=> '',
					'[!-- END ' . $matches2[1] . ' --]'		=> '',
					'<table:table-row'							=> '[!-- BEGIN ' . $balise . ' --]<table:table-row',
					'</table:table-row>'						=> '</table:table-row>[!-- END ' . $balise . ' --]'
				);
				$replacedXML = str_replace(array_keys($replace), array_values($replace), $matches[0][$i]);
				$this->contentXml = str_replace($matches[0][$i], $replacedXML, $this->contentXml);
			}
		}
    }
    /**
     * Merge template variables
     * Called automatically for a save
     *
     * @return void
     */
    private function _parse()
    {
        $this->contentXml = str_replace(array_keys($this->vars), array_values($this->vars), $this->contentXml);
    }
    /**
     * Add the merged segment to the document
     *
     * @param Segment $segment
     * @throws OdfException
     * @return odf
     */
    public function mergeSegment(Segment $segment)
    {
        if (! array_key_exists($segment->getName(), $this->segments)) {
            throw new OdfException($segment->getName() . 'cannot be parsed, has it been set yet ?');
        }
        $string = $segment->getName();
		// $reg = '@<text:p[^>]*>\[!--\sBEGIN\s' . $string . '\s--\](.*)\[!--.+END\s' . $string . '\s--\]<\/text:p>@smU';
		$reg = '@\[!--\sBEGIN\s' . $string . '\s--\](.*)\[!--.+END\s' . $string . '\s--\]@smU';
        $this->contentXml = preg_replace($reg, $segment->getXmlParsed(), $this->contentXml);
        return $this;
    }
    /**
     * Display all the current template variables
     * 
     * @return string
     */
    public function printVars()
    {
        return print_r('<pre>' . print_r($this->vars, true) . '</pre>', true);
    }
    /**
     * Display the XML content of the file from odt document
     * as it is at the moment
     *
     * @return string
     */
    public function __toString()
    {
        return $this->contentXml;
    }
    /**
     * Display loop segments declared with setSegment()
     * 
     * @return string
     */
    public function printDeclaredSegments()
    {
        return '<pre>' . print_r(implode(' ', array_keys($this->segments)), true) . '</pre>';
    }
    /**
     * Declare a segment in order to use it in a loop
     *
     * @param string $segment
     * @throws OdfException
     * @return Segment
     */
    public function setSegment($segment)
    {
        if (array_key_exists($segment, $this->segments)) {
            return $this->segments[$segment];
        }
        // $reg = "#\[!--\sBEGIN\s$segment\s--\]<\/text:p>(.*)<text:p\s.*>\[!--\sEND\s$segment\s--\]#sm";
        $reg = "#\[!--\sBEGIN\s$segment\s--\](.*)\[!--\sEND\s$segment\s--\]#sm";
        if (preg_match($reg, html_entity_decode($this->contentXml), $m) == 0) {
            throw new OdfException("'$segment' segment not found in the document");
        }
        $this->segments[$segment] = new Segment($segment, $m[1], $this);
        return $this->segments[$segment];
    }
    /**
     * Save the odt file on the disk
     * 
     * @param string $file name of the desired file
     * @throws OdfException
     * @return void
     */
    public function saveToDisk($file = null)
    {
        if ($file !== null && is_string($file)) {
        	if (file_exists($file) && !(is_file($file) && is_writable($file))) {
            	throw new OdfException('Permission denied : can\'t create ' . $file);
        	}
            $this->_save();
            copy($this->tmpfile, $file);     
        } else {
            $this->_save();
        }
    }
    /**
     * Internal save
     *
     * @throws OdfException
     * @return void
     */
        private function _save()
        {
           $this->file->open($this->tmpfile);
           $this->_parse();
           $this->file->addFromString('content.xml', $this->contentXml);
           /*
           if (! $this->file->addFromString('content.xml', $this->contentXml)) {
                throw new OdfException('Error during file export');
            }
            */
            foreach ($this->images as $imageKey => $imageValue) {
                $this->file->addFile($imageKey, 'Pictures/' . $imageValue);
                $this->addImageToManifest($imageValue);
            }            
           $this->file->addFromString('META-INF/manifest.xml', $this->manifestXml);
           /*
            if (! $this->file->addFromString('META-INF/manifest.xml', $this->manifestXml)) {
                throw new OdfException('Error during file export: manifest.xml');
            }
          */
           $this->file->close(); // seems to bug on windows CLI sometimes
        }
        
    public function addImageToManifest($file) {
            $extension = explode('.', $file);
            $replace = '<manifest:file-entry manifest:media-type="image/'.$extension[1].'" manifest:full-path="Pictures/'.$file.'"/></manifest:manifest>';
           
            $this->manifestXml = str_replace('</manifest:manifest>', $replace, $this->manifestXml);       
    }
    public function setImageReplace($key, $value)
        {
            $filename = strtok(strrchr($value, '/'), '/.');
            $file = substr(strrchr($value, '/'), 1);
            $size = @getimagesize($value);
            if ($size === false) {
                throw new OdfException("Invalid image");
            }
            $this->images[$value] = $file;
            $this->vars[$key] = $file;
            return $this;
        }            
     /**
     * Export the file as attached file by HTTP
     *
     * @param string $name (optionnal)
     * @throws OdfException
     * @return void
     */
    public function exportAsAttachedFile($name="")
    {
    	$this->_save();
    	
        if (headers_sent($filename, $linenum)) {
            throw new OdfException("headers already sent ($filename at $linenum)");
        }
        
        if( $name == "" )
        {
        		$name = md5(uniqid()) . ".odt";
        }
        
                
        header('Content-type: application/vnd.oasis.opendocument.text');
        header('Content-Disposition: attachment; filename="'.$name.'"');

        readfile($this->tmpfile);
    }
    /**
     * Returns a variable of configuration 
     * 
     * @return string The requested variable of configuration
     */
    public function getConfig($configKey)
    {
    	if (array_key_exists($configKey, $this->config)) {
    		return $this->config[$configKey];
    	}
    	return false;
    }
    /**
     * Returns the temporary working file
     * 
     * @return string le chemin vers le fichier temporaire de travail
     */
    public function getTmpfile()
    {
    	return $this->tmpfile;
    }
    /**
     * Delete the temporary file when the object is destroyed
     */    
    public function __destruct() {
          if (file_exists($this->tmpfile)) {
        	unlink($this->tmpfile);
        }
    }
}
