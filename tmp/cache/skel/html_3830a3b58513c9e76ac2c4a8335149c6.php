<?php

/*
 * Squelette : ../prive/squelettes/top/dist.html
 * Date :      Wed, 13 Aug 2014 14:20:06 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:26 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../prive/squelettes/top/dist.html
// Temps de compilation total: 0.058 ms
//

function html_3830a3b58513c9e76ac2c4a8335149c6($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = '<!-- top -->';

	return analyse_resultat_skel('html_3830a3b58513c9e76ac2c4a8335149c6', $Cache, $page, '../prive/squelettes/top/dist.html');
}
?>