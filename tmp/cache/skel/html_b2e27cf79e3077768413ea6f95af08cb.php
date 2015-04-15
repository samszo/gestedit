<?php

/*
 * Squelette : ../plugins-dist/revisions/prive/style_prive_plugin_revisions.html
 * Date :      Wed, 13 Aug 2014 15:06:04 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:25 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../plugins-dist/revisions/prive/style_prive_plugin_revisions.html
// Temps de compilation total: 1.127 ms
//

function html_b2e27cf79e3077768413ea6f95af08cb($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (
'
' .
'<?php header("X-Spip-Cache: 360000"); ?>'.'<?php header("Cache-Control: max-age=360000"); ?>'.'<?php header("X-Spip-Statique: oui"); ?>' .
'<'.'?php header("' . 'Content-Type: text/css; charset=iso-8859-15' . '"); ?'.'>' .
'<'.'?php header("' . 'Vary: Accept-Encoding' . '"); ?'.'>' .
vide($Pile['vars'][$_zzz=(string)'claire'] = (	'#' .
	interdire_scripts(entites_html(sinon(table_valeur(@$Pile[0], (string)'couleur_claire', null), 'edf3fe'),true)))) .
vide($Pile['vars'][$_zzz=(string)'foncee'] = (	'#' .
	interdire_scripts(entites_html(sinon(table_valeur(@$Pile[0], (string)'couleur_foncee', null), '3874b0'),true)))) .
vide($Pile['vars'][$_zzz=(string)'left'] = interdire_scripts(choixsiegal(entites_html(table_valeur(@$Pile[0], (string)'ltr', null),true),'left','left','right'))) .
vide($Pile['vars'][$_zzz=(string)'right'] = interdire_scripts(choixsiegal(entites_html(table_valeur(@$Pile[0], (string)'ltr', null),true),'left','right','left'))) .
vide($Pile['vars'][$_zzz=(string)'rtl'] = interdire_scripts(choixsiegal(entites_html(table_valeur(@$Pile[0], (string)'ltr', null),true),'left','','_rtl'))) .
'/* * Comparaison d articles */
.diff-para-deplace { background: #e8e8ff; }
.diff-para-ajoute { background: #d0ffc0; color: #000; }
.diff-para-supprime { background: #ffd0c0; color: #904040; text-decoration: line-through; }
p>.diff-para-deplace,p>.diff-para-ajoute,p>.diff-para-supprime {display:block;}

.diff-deplace { background: #e8e8ff; }
.diff-ajoute { background: #d0ffc0; }
.diff-supprime { background: #ffd0c0; color: #802020; text-decoration: line-through; }
.diff-para-deplace .diff-ajoute { background: #b8ffb8; border: 1px solid #808080; }
.diff-para-deplace .diff-supprime { background: #ffb8b8; border: 1px solid #808080; }
.diff-para-deplace .diff-deplace { background: #b8b8ff; border: 1px solid #808080; }

/* liste de versions */
.liste-objets.versions tr > .type {width:30px;}
.liste-objets.versions tr > .diff {width:30px;}
.liste-objets.versions blockquote {margin-left:0;margin-right:0;padding-left:0;padding-right:0;}
.liste-objets.versions .caption {background-image:url(' .
interdire_scripts(chemin_image('revision-24.png')) .
');padding-' .
table_valeur($Pile["vars"], (string)'left', null) .
':30px;}

.revision #wysiwyg .contenu_id_rubrique {display:none;}
.revision #wysiwyg .jointure {display:block;margin:1em 0;}
.revision #wysiwyg .jointure .label {display:block;font-weight:bold;}
.revision #wysiwyg .label{display:block;}

.formulaire_reviser .editer_id_version .choix {margin: 0 -5px;}
.formulaire_reviser table.spip.diff-versions {font-size: 0.85em;width: 100%;max-width: 100%;}
.formulaire_reviser table,.formulaire_reviser table tr,.formulaire_reviser table td {border-left:0;border-right:0;}
.formulaire_reviser table .version,.formulaire_reviser table .diff {padding:0;}
.fiche_objet_diff .hd {border-bottom:1px solid #ddd;}');

	return analyse_resultat_skel('html_b2e27cf79e3077768413ea6f95af08cb', $Cache, $page, '../plugins-dist/revisions/prive/style_prive_plugin_revisions.html');
}
?>