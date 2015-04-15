<?php

/*
 * Squelette : ../plugins-dist/compagnon/compagnon/accueil.html
 * Date :      Wed, 13 Aug 2014 15:02:44 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:26 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../plugins-dist/compagnon/compagnon/accueil.html
// Temps de compilation total: 1.285 ms
//

function html_635af40b1d9218ff7f3fad2279935425($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (
(($t1 = strval(interdire_scripts(((entites_html(table_valeur(@$Pile[0], (string)'fermer', null),true)) ?'' :' '))))!=='' ?
		($t1 . (	'
' .
	vide($Pile['vars'][$_zzz=(string)'titre'] = _T('compagnon:c_accueil_bienvenue',array('nom' => interdire_scripts(invalideur_session($Cache, table_valeur($GLOBALS["visiteur_session"], (string)'nom', null)))))) .
	'
' .
	boite_ouvrir(table_valeur($Pile["vars"], (string)'titre', null), 'compagnon') .
	'<p>' .
	_T('compagnon:c_accueil_texte') .
	'</p>
<p>' .
	_T('compagnon:c_accueil_texte_revenir') .
	'</p>
' .
	boite_pied() .
	'
	<span class="target" data-target="#bando1_menu_accueil"></span>
	' .
	bouton_action(filtre_ok_aleatoire_dist(''),invalideur_session($Cache, generer_action_auteur('compagnon',(	'compris/' .
			interdire_scripts(invalideur_session($Cache, @$Pile[0]['id']))),invalideur_session($Cache, parametre_url(self(),'fermer','oui')))),'ajax') .
	'
' .
	boite_fermer() .
	'
')) :
		'') .
'
');

	return analyse_resultat_skel('html_635af40b1d9218ff7f3fad2279935425', $Cache, $page, '../plugins-dist/compagnon/compagnon/accueil.html');
}
?>