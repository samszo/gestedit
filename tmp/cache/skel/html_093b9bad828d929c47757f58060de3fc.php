<?php

/*
 * Squelette : ../plugins-dist/sites/prive/style_prive_plugin_syndic.html
 * Date :      Wed, 13 Aug 2014 15:06:06 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:25 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../plugins-dist/sites/prive/style_prive_plugin_syndic.html
// Temps de compilation total: 1.343 ms
//

function html_093b9bad828d929c47757f58060de3fc($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (
'
' .
'<?php header("X-Spip-Cache: 360000"); ?>'.'<?php header("Cache-Control: max-age=360000"); ?>'.'<?php header("X-Spip-Statique: oui"); ?>' .
'<'.'?php header("' . 'Content-Type: text/css; charset=iso-8859-15' . '"); ?'.'>' .
'<'.'?php header("' . 'Vary: Accept-Encoding' . '"); ?'.'>.liste-objets.syndic_articles .action button {vertical-align: top;}

.onglets_simple ul.statut_syndic_articles li.publie strong,.onglets_simple ul.statut_syndic_articles li.publie a {background-image:url(' .
interdire_scripts(chemin_image('syndic-statut-publie-24.png')) .
');padding-' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'left', null),true)) .
':27px;}
.onglets_simple ul.statut_syndic_articles li.off strong,.onglets_simple ul.statut_syndic_articles li.off a {background-image:url(' .
interdire_scripts(chemin_image('syndic-statut-off-24.png')) .
');padding-' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'left', null),true)) .
':27px;}
.onglets_simple ul.statut_syndic_articles li.refuse strong,.onglets_simple ul.statut_syndic_articles li.refuse a {background-image:url(' .
interdire_scripts(chemin_image('syndic-statut-poubelle-24.png')) .
');padding-' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'left', null),true)) .
':27px;}
.onglets_simple ul.statut_syndic_articles li.dispo strong,.onglets_simple ul.statut_syndic_articles li.dispo a {background-image:url(' .
interdire_scripts(chemin_image('syndic-statut-dispo-24.png')) .
');padding-' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'left', null),true)) .
':27px;}


.controler_syndication .filtres.second {font-size:0.9em;border:0;padding-' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'left', null),true)) .
':0;}
.controler_syndication .filtres.second ul li strong,.controler_syndication .filtres.second ul li a {margin-' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'left', null),true)) .
':0px;margin-' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'right', null),true)) .
':5px;margin-bottom:5px;}
.controler_syndication .filtres.second ul li strong {border:1px solid ' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'foncee', null),true)) .
';}
.controler_syndication .filtres.second ul li strong,.controler_syndication .filtres.second ul li a:hover {background-color:#fff;}

.source {font-size:12px;font-weight:bold;background:#fff;padding:5px;border:1px solid ' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'foncee', null),true)) .
';}
.source .actions {font-weight:normal;}
.annule_filtre {float:' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'right', null),true)) .
';}


/**
 * formulaire_editer_site
 */

.formulaire_editer_site.withlogo .editer_nom_site,.formulaire_editer_site.withlogo .editer_url_site {padding-' .
interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'right', null),true)) .
':200px;}
.formulaire_editer_site .previsu_logo_site{height:1px;text-align: right;}

/* Inscription du flux RSS */
.formulaire_editer_site .editer_referencement_automatise fieldset,.formulaire_editer_site .editer_referencement_automatise .boutons{background-color:#E9E9E9;border:0;}');

	return analyse_resultat_skel('html_093b9bad828d929c47757f58060de3fc', $Cache, $page, '../plugins-dist/sites/prive/style_prive_plugin_syndic.html');
}
?>