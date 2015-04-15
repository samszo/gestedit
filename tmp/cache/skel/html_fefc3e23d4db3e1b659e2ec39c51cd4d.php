<?php

/*
 * Squelette : ../prive/squelettes/contenu/navigation.html
 * Date :      Wed, 13 Aug 2014 14:20:06 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:30 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../prive/squelettes/contenu/navigation.html
// Temps de compilation total: 0.188 ms
//

function html_fefc3e23d4db3e1b659e2ec39c51cd4d($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (

'<'.'?php echo recuperer_fond( ' . argumenter_squelette('prive/squelettes/inclure/menu-navigation') . ', array_merge('.var_export($Pile[0],1).',array(\'menu\' => ' . argumenter_squelette(@$Pile[0]['menu']) . ',
	\'bloc\' => ' . argumenter_squelette('contenu') . ',
	\'lang\' => ' . argumenter_squelette($GLOBALS["spip_lang"]) . ')), array("compil"=>array(\'../prive/squelettes/contenu/navigation.html\',\'html_fefc3e23d4db3e1b659e2ec39c51cd4d\',\'\',1,$GLOBALS[\'spip_lang\'])), _request("connect"));
?'.'>
');

	return analyse_resultat_skel('html_fefc3e23d4db3e1b659e2ec39c51cd4d', $Cache, $page, '../prive/squelettes/contenu/navigation.html');
}
?>