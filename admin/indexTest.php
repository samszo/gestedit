<?php
require_once( "../application/configs/configTest.php" );

try {

	$application->bootstrap()->run();

}catch (Zend_Exception $e) {
	echo "Récupère exception: " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
}
