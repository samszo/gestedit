<?php

/*
 * Squelette : ../plugins-dist/compagnon/compagnon/_boite.html
 * Date :      Wed, 13 Aug 2014 15:02:44 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:26 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../plugins-dist/compagnon/compagnon/_boite.html
// Temps de compilation total: 1.083 ms
//

function html_99cc267ace9648a49380c8ce647bb928($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (
(($t1 = strval(interdire_scripts(((entites_html(table_valeur(@$Pile[0], (string)'fermer', null),true)) ?'' :' '))))!=='' ?
		($t1 . (	'
' .
	boite_ouvrir(interdire_scripts(table_valeur(@$Pile[0], (string)'titre', null)), 'compagnon') .
	interdire_scripts(table_valeur(@$Pile[0], (string)'texte', null)) .
	boite_pied() .
	'
	' .
	(($t2 = strval(interdire_scripts(entites_html(sinon(table_valeur(@$Pile[0], (string)'target', null), ''),true))))!=='' ?
			('<span class="target" data-target="' . $t2 . '"></span>') :
			'') .
	'
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

	return analyse_resultat_skel('html_99cc267ace9648a49380c8ce647bb928', $Cache, $page, '../plugins-dist/compagnon/compagnon/_boite.html');
}
?>