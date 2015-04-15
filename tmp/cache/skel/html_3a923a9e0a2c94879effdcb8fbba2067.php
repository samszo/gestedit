<?php

/*
 * Squelette : ../prive/squelettes/navigation/configurer.html
 * Date :      Wed, 13 Aug 2014 14:20:06 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:32 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../prive/squelettes/navigation/configurer.html
// Temps de compilation total: 0.756 ms
//

function html_3a923a9e0a2c94879effdcb8fbba2067($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (
vide($Pile['vars'][$_zzz=(string)'nav'] = recuperer_fond( 'prive/squelettes/inclure/menu-navigation' , array_merge($Pile[0],array('menu' => 'menu_configuration' ,
	'bloc' => 'navigation' )), array('compil'=>array('../prive/squelettes/navigation/configurer.html','html_3a923a9e0a2c94879effdcb8fbba2067','',0,$GLOBALS['spip_lang'])), '')) .
((match(table_valeur($Pile["vars"], (string)'nav', null),'execfound'))  ?
		(' ' . (	'
' .
	table_valeur($Pile["vars"], (string)'nav', null) .
	boite_ouvrir(wrap(_T('avis_attention'),'<h4>'), 'info') .
	'
<p>' .
	_T('public|spip|ecrire:texte_inc_config') .
	'</p>
' .
	boite_fermer() .
	'
')) :
		''));

	return analyse_resultat_skel('html_3a923a9e0a2c94879effdcb8fbba2067', $Cache, $page, '../prive/squelettes/navigation/configurer.html');
}
?>