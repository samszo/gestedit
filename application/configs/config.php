<?php
date_default_timezone_set('Europe/Paris');
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 
ini_set("memory_limit",'1600M');
set_time_limit(36000);

$www = "/Applications/XAMPP/xamppfiles/htdocs";
define ("WEB_ROOT","http://localhost/gestedit");
define ("ROOT_PATH",$www."/gestedit");
define ("WEB_ROOT_AJAX",WEB_ROOT."/admin");
define ("SEP_PATH","/");

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', ROOT_PATH . '/application');

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));


set_include_path(ROOT_PATH.'/library');       

/** Zend_Application*/
set_include_path(get_include_path().PATH_SEPARATOR.$www."/Zend/library");
set_include_path(get_include_path().PATH_SEPARATOR.$www."/Zend/extras/library");

require_once 'Zend/Application.php';
require_once 'ExcelReader.php';
require_once 'OLERead.php';
require_once 'UploadHandler.php';
require_once 'CustomUploadHandler.php';
require_once 'odtphp/odf.php';
require_once 'ImageResize.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

?>