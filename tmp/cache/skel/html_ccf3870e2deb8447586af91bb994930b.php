<?php

/*
 * Squelette : ../prive/squelettes/hierarchie/dist.html
 * Date :      Wed, 13 Aug 2014 14:20:06 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:26 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../prive/squelettes/hierarchie/dist.html
// Temps de compilation total: 3.682 ms
//

function html_ccf3870e2deb8447586af91bb994930b($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (
'<!-- hierarchie -->
' .
vide($Pile['vars'][$_zzz=(string)'objet_exec'] = interdire_scripts(trouver_objet_exec(entites_html(table_valeur(@$Pile[0], (string)'exec', null),true)))) .
((table_valeur($Pile["vars"], (string)'objet_exec', null))  ?
		(' ' . (	'
	' .
	vide($Pile['vars'][$_zzz=(string)'objet'] = table_valeur(table_valeur($Pile["vars"], (string)'objet_exec', null),'type')) .
	vide($Pile['vars'][$_zzz=(string)'id_objet'] = interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)table_valeur(table_valeur($Pile["vars"], (string)'objet_exec', null),'id_table_objet'), null),true))) .
	vide($Pile['vars'][$_zzz=(string)'id_parent'] = ((table_valeur($Pile["vars"], (string)'objet', null) == 'rubrique') ? interdire_scripts(entites_html(sinon(table_valeur(@$Pile[0], (string)'id_parent', null), interdire_scripts(generer_info_entite(table_valeur($Pile["vars"], (string)'id_objet', null), table_valeur($Pile["vars"], (string)'objet', null), 'id_parent'))),true)):interdire_scripts(entites_html(sinon(table_valeur(@$Pile[0], (string)'id_rubrique', null), interdire_scripts(generer_info_entite(table_valeur($Pile["vars"], (string)'id_objet', null), table_valeur($Pile["vars"], (string)'objet', null), 'id_rubrique'))),true)))) .
	(((((table_valeur($Pile["vars"], (string)'id_parent', null)) OR ((table_valeur($Pile["vars"], (string)'objet', null) == 'rubrique'))) ?' ' :''))  ?
			(' ' . (	'
		' .
		
'<'.'?php echo recuperer_fond( ' . argumenter_squelette('prive/echafaudage/hierarchie/objet') . ', array(\'objet\' => ' . argumenter_squelette(table_valeur($Pile["vars"], (string)'objet', null)) . ',
	\'id_objet\' => ' . argumenter_squelette(table_valeur($Pile["vars"], (string)'id_objet', null)) . ',
	\'id_parent\' => ' . argumenter_squelette(table_valeur($Pile["vars"], (string)'id_parent', null)) . ',
	\'id_secteur\' => ' . argumenter_squelette(interdire_scripts(generer_info_entite(table_valeur($Pile["vars"], (string)'id_objet', null), table_valeur($Pile["vars"], (string)'objet', null), 'id_secteur'))) . ',
	\'restreint\' => ' . argumenter_squelette(interdire_scripts((generer_info_entite(table_valeur($Pile["vars"], (string)'id_objet', null), table_valeur($Pile["vars"], (string)'objet', null), 'statut') == 'publie'))) . ',
	\'editable\' => ' . argumenter_squelette(invalideur_session($Cache, ((function_exists("autoriser")||include_spip("inc/autoriser"))&&autoriser('modifier', invalideur_session($Cache, table_valeur($Pile["vars"], (string)'objet', null)), invalideur_session($Cache, table_valeur($Pile["vars"], (string)'id_objet', null)))?" ":""))) . ',
	\'lang\' => ' . argumenter_squelette($GLOBALS["spip_lang"]) . '), array("compil"=>array(\'../prive/squelettes/hierarchie/dist.html\',\'html_ccf3870e2deb8447586af91bb994930b\',\'\',9,$GLOBALS[\'spip_lang\']),\'ajax\' => ($v=( ' . argumenter_squelette(@$Pile[0]['ajax']) . '))?$v:true), _request("connect"));
?'.'>
	')) :
			'') .
	'
	' .
	(!((((table_valeur($Pile["vars"], (string)'id_parent', null)) OR ((table_valeur($Pile["vars"], (string)'objet', null) == 'rubrique'))) ?' ' :''))  ?
			(' ' . (	'
		' .
		
'<'.'?php echo recuperer_fond( ' . argumenter_squelette('prive/echafaudage/hierarchie/objet.sans_rubrique') . ', array(\'objet\' => ' . argumenter_squelette(table_valeur($Pile["vars"], (string)'objet', null)) . ',
	\'id_objet\' => ' . argumenter_squelette(table_valeur($Pile["vars"], (string)'id_objet', null)) . ',
	\'lang\' => ' . argumenter_squelette($GLOBALS["spip_lang"]) . '), array("compil"=>array(\'../prive/squelettes/hierarchie/dist.html\',\'html_ccf3870e2deb8447586af91bb994930b\',\'\',10,$GLOBALS[\'spip_lang\']),\'ajax\' => ($v=( ' . argumenter_squelette(@$Pile[0]['ajax']) . '))?$v:true), _request("connect"));
?'.'>
	')) :
			'') .
	'
')) :
		''));

	return analyse_resultat_skel('html_ccf3870e2deb8447586af91bb994930b', $Cache, $page, '../prive/squelettes/hierarchie/dist.html');
}
?>