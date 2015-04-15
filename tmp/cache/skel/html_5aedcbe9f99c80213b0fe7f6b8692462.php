<?php

/*
 * Squelette : ../prive/squelettes/extra/dist.html
 * Date :      Wed, 13 Aug 2014 14:20:06 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:26 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../prive/squelettes/extra/dist.html
// Temps de compilation total: 0.111 ms
//

function html_5aedcbe9f99c80213b0fe7f6b8692462($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = '
<!-- extra -->';

	return analyse_resultat_skel('html_5aedcbe9f99c80213b0fe7f6b8692462', $Cache, $page, '../prive/squelettes/extra/dist.html');
}
?>