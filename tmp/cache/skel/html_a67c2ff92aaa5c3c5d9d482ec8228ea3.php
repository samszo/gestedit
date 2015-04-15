<?php

/*
 * Squelette : ../prive/squelettes/page.html
 * Date :      Wed, 13 Aug 2014 14:20:06 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:25 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../prive/squelettes/page.html
// Temps de compilation total: 0.423 ms
//

function html_a67c2ff92aaa5c3c5d9d482ec8228ea3($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = 
'<'.'?php echo recuperer_fond( ' . argumenter_squelette('prive/squelettes/structure') . ', array_merge('.var_export($Pile[0],1).',array(\'type-page\' => ' . argumenter_squelette(interdire_scripts(entites_html(sinon(table_valeur(@$Pile[0], (string)'type-page', null), interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'exec', null),true))),true))) . ',
	\'composition\' => ' . argumenter_squelette(interdire_scripts(entites_html(sinon(table_valeur(@$Pile[0], (string)'composition', null), ''),true))) . ',
	\'lang\' => ' . argumenter_squelette($GLOBALS["spip_lang"]) . ')), array("compil"=>array(\'../prive/squelettes/page.html\',\'html_a67c2ff92aaa5c3c5d9d482ec8228ea3\',\'\',1,$GLOBALS[\'spip_lang\'])), _request("connect"));
?'.'>';

	return analyse_resultat_skel('html_a67c2ff92aaa5c3c5d9d482ec8228ea3', $Cache, $page, '../prive/squelettes/page.html');
}
?>