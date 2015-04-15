<?php

/*
 * Squelette : ../plugins-dist/compagnon/prive/style_prive_plugin_compagnon.html
 * Date :      Wed, 13 Aug 2014 15:02:44 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:25 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../plugins-dist/compagnon/prive/style_prive_plugin_compagnon.html
// Temps de compilation total: 2.415 ms
//

function html_0543812b777101ecdf06889e5e2d0974($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (
'
' .
'<?php header("X-Spip-Cache: 360000"); ?>'.'<?php header("Cache-Control: max-age=360000"); ?>'.'<?php header("X-Spip-Statique: oui"); ?>' .
'<'.'?php header("' . 'Content-Type: text/css; charset=iso-8859-15' . '"); ?'.'>' .
'<'.'?php header("' . 'Vary: Accept-Encoding' . '"); ?'.'>' .
vide($Pile['vars'][$_zzz=(string)'claire'] = interdire_scripts(entites_html(sinon(table_valeur(@$Pile[0], (string)'couleur_claire', null), 'edf3fe'),true))) .
vide($Pile['vars'][$_zzz=(string)'foncee'] = interdire_scripts(entites_html(sinon(table_valeur(@$Pile[0], (string)'couleur_foncee', null), '3874b0'),true))) .
vide($Pile['vars'][$_zzz=(string)'left'] = interdire_scripts(choixsiegal(entites_html(table_valeur(@$Pile[0], (string)'ltr', null),true),'left','left','right'))) .
vide($Pile['vars'][$_zzz=(string)'right'] = interdire_scripts(choixsiegal(entites_html(table_valeur(@$Pile[0], (string)'ltr', null),true),'left','right','left'))) .
'/* ----- compagnon (extends box) ----- */
.compagnon {position:relative;}
.compagnon .inner {
	border:2px solid #' .
table_valeur($Pile["vars"], (string)'foncee', null) .
';
	border-radius:10px;
	color:#333;
	background:#fcfcfc url(' .
interdire_scripts(extraire_attribut(filtrer('image_graver', filtrer('image_sepia',chemin_image('compagnon_gris-64.png'),filtrer('couleur_eclaircir',table_valeur($Pile["vars"], (string)'foncee', null)))),'src')) .
') -10px -10px no-repeat;
	
}
.compagnon .inner .hd {padding-left:60px;}
.compagnon .inner .bd {padding-left:60px;}
.compagnon b{}
.compagnon .act {
	background-color: transparent;
	border-top: none;
}
.compagnon .ft {
	padding: 0;
}
.compagnon button.submit {
	font-size:100%;
	border:2px solid #' .
table_valeur($Pile["vars"], (string)'foncee', null) .
';
	border-width:2px 0 0 2px;
	border-radius:9px 0 9px 0;
	box-shadow:0 0 2px #' .
table_valeur($Pile["vars"], (string)'foncee', null) .
';
	background: ' .
(($t1 = strval(filtrer('couleur_eclaircir',filtrer('couleur_eclaircir',table_valeur($Pile["vars"], (string)'foncee', null)))))!=='' ?
		('#' . $t1) :
		'') .
';
	padding:3px 4px 4px 3px;
	cursor:pointer;
	margin:0;
	color: #444;
}
.compagnon button.submit:hover {
	box-shadow:none;
	background:#fcfcfc;
}
.compagnon .target {
	position:absolute; bottom:5px; left:5px;
	display:block; width:32px; height:32px;
	background:url(' .
interdire_scripts(extraire_attribut(filtrer('image_graver', filtrer('image_sepia',chemin_image('target-32.png'),filtrer('couleur_eclaircir',table_valeur($Pile["vars"], (string)'foncee', null)))),'src')) .
');
	cursor:crosshair;
}
#navigation .compagnon .inner .hd {min-height:2.5em;}
#navigation .compagnon .inner .bd {padding-left:10px;}
');

	return analyse_resultat_skel('html_0543812b777101ecdf06889e5e2d0974', $Cache, $page, '../plugins-dist/compagnon/prive/style_prive_plugin_compagnon.html');
}
?>