<?php

/*
 * Squelette : ../prive/formulaires/editer_logo.html
 * Date :      Wed, 13 Aug 2014 14:20:06 GMT
 * Compile :   Wed, 08 Apr 2015 15:25:32 GMT
 * Boucles :   
 */ 
//
// Fonction principale du squelette ../prive/formulaires/editer_logo.html
// Temps de compilation total: 4.772 ms
//

function html_5588cadaaffb3bbe8382bb86f8514b11($Cache, $Pile, $doublons=array(), $Numrows=array(), $SP=0) {

	if (isset($Pile[0]["doublons"]) AND is_array($Pile[0]["doublons"]))
		$doublons = nettoyer_env_doublons($Pile[0]["doublons"]);

	$connect = '';
	$page = (
'<?php header("X-Spip-Cache: 0"); ?>'.'<?php header("Cache-Control: no-cache, must-revalidate"); ?><?php header("Pragma: no-cache"); ?>' .
(($t1 = strval(interdire_scripts(((((include_spip('inc/config')?lire_config('activer_logos',null,false):'') == 'oui')) ?' ' :''))))!=='' ?
		($t1 . (	'<div class=\'formulaire_spip formulaire_editer formulaire_editer_logo formulaire_editer_logo_' .
	interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'objet', null),true)) .
	'\'>
	' .
	(($t2 = strval(interdire_scripts(table_valeur(entites_html(table_valeur(@$Pile[0], (string)'_options', null),true),'titre'))))!=='' ?
			('<h3 class="titrem">' . $t2 . '</h3>') :
			'') .
	'
	' .
	(($t2 = strval(interdire_scripts(table_valeur(@$Pile[0], (string)'message_ok', null))))!=='' ?
			('<p class="reponse_formulaire reponse_formulaire_ok">' . $t2 . '</p>') :
			'') .
	'
	' .
	(($t2 = strval(interdire_scripts(table_valeur(@$Pile[0], (string)'message_erreur', null))))!=='' ?
			('<p class="reponse_formulaire reponse_formulaire_erreur">' . $t2 . '</p>') :
			'') .
	'
	' .
	(($t2 = strval(interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'editable', null),true))))!=='' ?
			($t2 . (	'
	' .
		vide($Pile['vars'][$_zzz=(string)'valider'] = '') .
		'<form method=\'post\' action=\'' .
		interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'action', null),true)) .
		'\' enctype=\'multipart/form-data\'><div>
		
		' .
			'<div>' .
	form_hidden(interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'action', null),true))) .
	'<input name=\'formulaire_action\' type=\'hidden\'
		value=\'' . @$Pile[0]['form'] . '\' />' .
	'<input name=\'formulaire_action_args\' type=\'hidden\'
		value=\'' . @$Pile[0]['formulaire_args']. '\' />' .
	(@$Pile[0]['_hidden']?@$Pile[0]['_hidden']:'') .
	'</div>' .
		'
	  <div style="display:none;"><input type=\'submit\' class=\'submit\' value=\'' .
		_T('public|spip|ecrire:bouton_upload') .
		'\' /></div>
	')) :
			'') .
	'
	  <ul>
	    <li class="editer editer_logo_on ' .
	((table_valeur(table_valeur(@$Pile[0], (string)'erreurs', null),'logo_on'))  ?
			(' ' . ' ' . 'erreur') :
			'') .
	'">
			' .
	(($t2 = strval(interdire_scripts(((entites_html(table_valeur(@$Pile[0], (string)'logo_on', null),true)) ?' ' :''))))!=='' ?
			($t2 . (	'
				' .
		recuperer_fond( 'formulaires/inc-apercu-logo' , array_merge($Pile[0],array('logo' => interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'logo_on', null),true)) ,
	'quoi' => 'logo_on' ,
	'editable' => interdire_scripts((((((entites_html(table_valeur(@$Pile[0], (string)'logo_off', null),true)) ?'' :' ')) AND (interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'editable', null),true)))) ?' ' :'')) )), array('compil'=>array('../prive/formulaires/editer_logo.html','html_5588cadaaffb3bbe8382bb86f8514b11','',17,$GLOBALS['spip_lang'])), '') .
		'
			')) :
			'') .
	(($t2 = strval(interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'editable', null),true))))!=='' ?
			($t2 . (	'
				' .
		(($t3 = strval(interdire_scripts(((entites_html(table_valeur(@$Pile[0], (string)'logo_on', null),true)) ?'' :' '))))!=='' ?
				($t3 . (	'
					<label for="logo_on_' .
			interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'objet', null),true)) .
			'_' .
			interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'id_objet', null),true)) .
			'">' .
			interdire_scripts(((($a = table_valeur(entites_html(table_valeur(@$Pile[0], (string)'_options', null),true),'label')) OR (is_string($a) AND strlen($a))) ? $a : _T('public|spip|ecrire:info_telecharger_nouveau_logo'))) .
			'</label>' .
			(($t4 = strval(table_valeur(table_valeur(@$Pile[0], (string)'erreurs', null),'logo_on')))!=='' ?
					('
					<span class=\'erreur_message\'>' . $t4 . '</span>
					') :
					'') .
			'<input type=\'file\' class=\'file\' name=\'logo_on\' size="' .
			interdire_scripts(((($a = table_valeur(entites_html(table_valeur(@$Pile[0], (string)'_options', null),true),'size_input')) OR (is_string($a) AND strlen($a))) ? $a : '12')) .
			'" id=\'logo_on_' .
			interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'objet', null),true)) .
			'_' .
			interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'id_objet', null),true)) .
			'\' value="" />
					' .
			vide($Pile['vars'][$_zzz=(string)'valider'] = ' '))) :
				'') .
		'
			')) :
			'') .
	'
	    </li>
		' .
	(($t2 = strval(interdire_scripts((((((entites_html(table_valeur(@$Pile[0], (string)'logo_survol', null),true)) OR (interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'logo_off', null),true)))) ?' ' :'')) ?' ' :''))))!=='' ?
			($t2 . (	'
	    <li class="editer editer_logo_off ' .
		((table_valeur(table_valeur(@$Pile[0], (string)'erreurs', null),'logo_off'))  ?
				(' ' . ' ' . 'erreur') :
				'') .
		'">
			' .
		(($t3 = strval(interdire_scripts(((entites_html(table_valeur(@$Pile[0], (string)'logo_off', null),true)) ?' ' :''))))!=='' ?
				($t3 . (	'
				' .
			recuperer_fond( 'formulaires/inc-apercu-logo' , array_merge($Pile[0],array('logo' => interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'logo_off', null),true)) ,
	'quoi' => 'logo_off' ,
	'editable' => interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'editable', null),true)) )), array('compil'=>array('../prive/formulaires/editer_logo.html','html_5588cadaaffb3bbe8382bb86f8514b11','',24,$GLOBALS['spip_lang'])), '') .
			'
			')) :
				'') .
		(($t3 = strval(interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'editable', null),true))))!=='' ?
				($t3 . (	'
				' .
			(($t4 = strval(interdire_scripts(((entites_html(table_valeur(@$Pile[0], (string)'logo_off', null),true)) ?'' :' '))))!=='' ?
					($t4 . (	'
					<div ' .
				(!(table_valeur(table_valeur(@$Pile[0], (string)'erreurs', null),'logo_off'))  ?
						(' ' . (	'
						class="ajouter_survol"><a href="#" onclick="jQuery(this).parent().siblings().show().parents(\'form\').find(\'.boutons\').show();return false;">' .
					_T('public|spip|ecrire:logo_survol') .
					'</a></div>
					<div ' .
					(($t6 = strval(interdire_scripts(((entites_html(table_valeur(@$Pile[0], (string)'_show_upload_off', null),true)) ?'' :' '))))!=='' ?
							($t6 . (	'style="display:none;" ' .
						vide($Pile['vars'][$_zzz=(string)'hide'] = ' '))) :
							''))) :
						'') .
				'>
					<label for="logo_off">' .
				_T('public|spip|ecrire:info_telecharger_nouveau_logo') .
				'</label>' .
				(($t5 = strval(table_valeur(table_valeur(@$Pile[0], (string)'erreurs', null),'logo_off')))!=='' ?
						('
					<span class=\'erreur_message\'>' . $t5 . '</span>
					') :
						'') .
				'<input type=\'file\' class=\'file\' name=\'logo_off\' size="' .
				interdire_scripts(((($a = table_valeur(entites_html(table_valeur(@$Pile[0], (string)'_options', null),true),'size_input')) OR (is_string($a) AND strlen($a))) ? $a : '12')) .
				'" id=\'logo_off_' .
				interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'objet', null),true)) .
				'_' .
				interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'id_objet', null),true)) .
				'\' value="" />
					' .
				vide($Pile['vars'][$_zzz=(string)'valider'] = ' ') .
				'</div>
				')) :
					'') .
			'
			')) :
				'') .
		'
	    </li>
		')) :
			'') .
	'
	  </ul>
	  
	  <!--extra-->
	' .
	(($t2 = strval(interdire_scripts(entites_html(table_valeur(@$Pile[0], (string)'editable', null),true))))!=='' ?
			($t2 . (	'
		' .
		(($t3 = strval(table_valeur($Pile["vars"], (string)'valider', null)))!=='' ?
				($t3 . (	'
	  <p class="boutons"' .
			(($t4 = strval(table_valeur($Pile["vars"], (string)'hide', null)))!=='' ?
					($t4 . 'style=\'display:none;\'') :
					'') .
			'><input type=\'submit\' class=\'submit\' value=\'' .
			_T('public|spip|ecrire:bouton_upload') .
			'\' /></p>
		')) :
				'') .
		'
	</div></form>
	')) :
			'') .
	'
</div>
')) :
		'') .
'
');

	return analyse_resultat_skel('html_5588cadaaffb3bbe8382bb86f8514b11', $Cache, $page, '../prive/formulaires/editer_logo.html');
}
?>