<?php

/*
 * Squelette : ../prive/squelettes/structure.html
 * Date :      Wed, 13 Aug 2014 14:20:06 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:25 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../prive/squelettes/structure.html
// Temps de compilation total: 1.560 ms
//

function html_56529b38bf24f9e2d2e7470387bc3e68($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (
'<'.'?php header("' . 'Cache-Control: no-cache' . '"); ?'.'>' .
'<'.'?php header("' . 'Pragma: no-cache' . '"); ?'.'>' .
interdire_scripts(eval('return '.'_DOCTYPE_ECRIRE'.';')) .
'<!--[if lt IE 7 ]> <html class="' .
lang_dir(@$Pile[0]['lang'], 'ltr','rtl') .
(($t1 = strval(spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang'])))!=='' ?
		(' ' . $t1) :
		'') .
' no-js ie ie6 lte9 lte8 lte7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="' .
spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang']) .
'" lang="' .
spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang']) .
'" dir="' .
lang_dir(@$Pile[0]['lang'], 'ltr','rtl') .
'"> <![endif]-->
<!--[if IE 7 ]>    <html class="' .
lang_dir(@$Pile[0]['lang'], 'ltr','rtl') .
(($t1 = strval(spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang'])))!=='' ?
		(' ' . $t1) :
		'') .
' no-js ie ie7 lte9 lte8 lte7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="' .
spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang']) .
'" lang="' .
spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang']) .
'" dir="' .
lang_dir(@$Pile[0]['lang'], 'ltr','rtl') .
'"> <![endif]-->
<!--[if IE 8 ]>    <html class="' .
lang_dir(@$Pile[0]['lang'], 'ltr','rtl') .
(($t1 = strval(spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang'])))!=='' ?
		(' ' . $t1) :
		'') .
' no-js ie ie8 lte9 lte8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="' .
spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang']) .
'" lang="' .
spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang']) .
'" dir="' .
lang_dir(@$Pile[0]['lang'], 'ltr','rtl') .
'"> <![endif]-->
<!--[if IE 9 ]>    <html class="' .
lang_dir(@$Pile[0]['lang'], 'ltr','rtl') .
(($t1 = strval(spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang'])))!=='' ?
		(' ' . $t1) :
		'') .
' no-js ie ie9 lte9" xmlns="http://www.w3.org/1999/xhtml" xml:lang="' .
spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang']) .
'" lang="' .
spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang']) .
'" dir="' .
lang_dir(@$Pile[0]['lang'], 'ltr','rtl') .
'"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="' .
lang_dir(@$Pile[0]['lang'], 'ltr','rtl') .
(($t1 = strval(spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang'])))!=='' ?
		(' ' . $t1) :
		'') .
' no-js" xmlns="http://www.w3.org/1999/xhtml" xml:lang="' .
spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang']) .
'" lang="' .
spip_htmlentities(@$Pile[0]['lang'] ? @$Pile[0]['lang'] : $GLOBALS['spip_lang']) .
'" dir="' .
lang_dir(@$Pile[0]['lang'], 'ltr','rtl') .
'"> <!--<![endif]-->
<head>
' .

'<'.'?php echo recuperer_fond( ' . argumenter_squelette((	'prive/squelettes/head/' .
	interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'type-page', null),true)))) . ', array_merge('.var_export($Pile[0],1).',array(\'lang\' => ' . argumenter_squelette($GLOBALS["spip_lang"]) . ')), array("compil"=>array(\'../prive/squelettes/structure.html\',\'html_56529b38bf24f9e2d2e7470387bc3e68\',\'\',10,$GLOBALS[\'spip_lang\'])), _request("connect"));
?'.'>
</head>
' .

'<'.'?php echo recuperer_fond( ' . argumenter_squelette('prive/squelettes/body') . ', array_merge('.var_export($Pile[0],1).',array(\'lang\' => ' . argumenter_squelette($GLOBALS["spip_lang"]) . ')), array("compil"=>array(\'../prive/squelettes/structure.html\',\'html_56529b38bf24f9e2d2e7470387bc3e68\',\'\',12,$GLOBALS[\'spip_lang\'])), _request("connect"));
?'.'>
</html>
');

	return analyse_resultat_skel('html_56529b38bf24f9e2d2e7470387bc3e68', $Cache, $page, '../prive/squelettes/structure.html');
}
?>