<?php
/**
 * Elgg Simple editing of CMS "static" pages
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2008-2011
 * @link http://id.facyla.net/
*/


// Hooks
elgg_register_plugin_hook_handler('permissions_check', 'object', 'cmspages_permissions_check');

// Initialise log browser
elgg_register_event_handler('init','system','cmspages_init');
elgg_register_event_handler('pagesetup','system','cmspages_pagesetup');

// Register actions
global $CONFIG;
$actions_path = elgg_get_plugins_path() . 'cmspages/actions/';
elgg_register_action("cmspages/edit", $actions_path . 'edit.php');
elgg_register_action("cmspages/delete", $actions_path . 'delete.php');



function cmspages_init() {
	global $CONFIG;
	elgg_extend_view('css','cmspages/css');
	
	// Register entity type
	elgg_register_entity_type('object','cmspage');
	
	// Register a URL handler for CMS pages
	elgg_register_entity_url_handler('cmspage','object','cmspage_url');
	
	elgg_register_page_handler('cmspages','cmspages_page_handler'); // Register a page handler, so we can have nice URLs
	
	// PUBLIC PAGES - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'cmspages_public_pages');
	
}


/* Populates the ->getUrl() method for cmspage objects */
function cmspage_url($cmspage) {
	global $CONFIG;
	return $CONFIG->url . "cmspages/read/" . $cmspage->pagetype;
}


function cmspages_page_handler($page) {
	global $CONFIG;
	$include_path = $CONFIG->pluginspath . 'cmspages/pages/cmspages/';
	if (!isset($page[0])) { $page[0] = 'admin'; }
	if ($page[1]) { set_input('pagetype', $page[1]); }
	switch ($page[0]) {
		case "read":
			if (!include($include_path . 'read.php')) return false;
			break;
			
		/* It was a test, better in a specific plugin instead (export_embed)
		case "embed";
			if (@include(dirname(__FILE__) . "/external_embed.php")) return true;
			break;
		case "template";
			if (@include(dirname(__FILE__) . "/template.php")) return true;
			break;
		*/
		case 'admin':
		default:
			if (!include($include_path . 'index.php')) return false;
	}
	return true;
}

/* Page setup. Adds admin controls */
function cmspages_pagesetup() {
	global $CONFIG;
	// Facyla: allow main & local admins to use this tool
	// and also a custom editor list
	if ( (elgg_in_context('admin') || elgg_is_admin_logged_in())
		|| ((elgg_in_context('cmspages_admin')) && in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages'))))
		) {
		$item = new ElggMenuItem('cmspages', elgg_echo('cmspages'), 'cmspages/'); elgg_register_menu_item('topbar', $item);
	}
	return true;
}

/* Permissions for the cmspages context */
function cmspages_permissions_check($hook, $type, $returnval, $params) {
	if (elgg_in_context('admin') && elgg_is_admin_logged_in()) return true;
	if (elgg_in_context('localmultisite'))	return true;
	if ( (elgg_in_context('cmspages_admin')) || in_array($_SESSION['guid'], explode(',', elgg_get_plugin_setting('editors', 'cmspages'))) )	return true;
	return NULL;
}

// Renvoie un tableau de configuration du module à partir d'une chaîne de configuration
// 2 utilisation : soit avec module_name?param1=xx&param2=yy, soit avec (module_name, param1=xx&param2=yy)
function cmspages_extract_module_config($module_name = '', $module_config) {
	$module_config = html_entity_decode($module_config);
	$return = array();
	// Gestion cas où on a les 2 ensemble (module_name?param1=xx&param2=yy)
	if (empty($module_name) && strpos('?', $module_config)) {
		// module?param1=xx&param2=yy
		$module_config = explode("?", $module_string);
		$module_name = $module_config[0];
		$module_params = explode("&", $module_config[1]);
	} else {
		// param1=xx&param2=yy =>	param1=xx, param2=yy
		$module_params = explode("&", $module_config);
	}
	// module1
	if (!$module_params) $return[$module_name] = false; else 
	foreach ($module_params as $module_param) {
		$module_param = explode('=', $module_param);
		$param_name = $module_param[0];
		$param_value = $module_param[1];
		// Composition du tableau de retour : $config[module][param1] = valeur param
		$return[$module_name][$param_name] = $param_value;
	}
	return $return;
}


// Affiche le contenu d'un module paramétré
function cmspages_compose_module($module_name, $module_config = false) {
	// Attention : toute entité non affichable renvoie sur la home
	switch($module_name) {
		case 'title':
			$return .= "<h3>" . $module_config['text'] . "</h3>";
			break;
			
		case 'listing':
			// Affichage d'un listing d'entités
			$type = $module_config['type'];
			$subtype = $module_config['subtype'];
			$limit = $module_config['limit']; if (!isset($limit)) $limit = 5;
			$sort = $module_config['sort']; if (!isset($sort)) $sort = "time_created desc";
			$type = explode(',', $type);
			$subtype = explode(',', $subtype);
			if ($subtype == 'all') $subtype = get_registered_entity_types($type);
			if (!$subtype) $subtype = '';
			//$ents = elgg_get_entities(array('type_subtype_pairs' => array($type => $subtype), 'limit' => $limit, 'order_by' => $sort));
			$ents = elgg_get_entities(array('types' => $type, 'subtypes' => $subtype, 'limit' => $limit, 'order' => $sort));
			// Rendu
			if (in_array($module_config['type'], array('group', 'user'))) foreach ($ents as $ent ) $return = '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->name . '</a><br />';
			else if (is_array($ents)) foreach ($ents as $ent ) $return = '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->title . '</a><br />';
			break;
			
		case 'search':
			// Affichage des résultats d'une rechrche (par type d'entité)
			$return = '<h3>' . elgg_echo('cmspages:searchresults') . '</h3>';
			// @todo : améliorer la recherche, mais sans tout réécrire..
			switch($module_config['type']) {
				case 'object': $ents = search_for_object($module_config['criteria']); break;
				case 'group': $ents = search_for_group($module_config['criteria']); break;
				case 'user': $ents = search_for_user($module_config['criteria']); break;
				case 'site': $ents = search_for_site($module_config['criteria']); break;
			}
			if (in_array($module_config['type'], array('group', 'user'))) foreach ($ents as $ent ) $return .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->name . '</a><br />';
			else foreach ($ents as $ent ) $return .= '<a href="' . $ent->getURL() . '">' . $ent->guid . ' : ' . $ent->title . '</a><br />';
			break;
			
		case 'entity':
			// Affichage d'une entité : celle-ci doit exister
			// champs ou template au choix ? autres paramètres ?
			$return = '<h3>' . elgg_echo('cmspages:chosenentity') . '</h3>';
			if ($module_config['guid'] && ($ent = get_entity($module_config['guid']))) $return .= $ent->guid . ' : ' . $ent->title . $ent->name . '<br />' . $ent->description;
			break;
			
		case 'view':
			// Affichage d'une vue configurée : la vue doit exister, paramètres au choix
			$return = '<h3>' . elgg_echo('cmspages:configuredview') . '</h3>';
			$view_name = $module_config['view'];
			if (elgg_view_exists($view_name)) {
				unset($module_config['view']);
				$return .= elgg_view($view_name, $module_config);
			}
			break;
			
		default:
			// Pour le développement
			$return = '<h3>' . elgg_echo('cmspages:module', array($module_name)) . '</h3>' . print_r($module_config, true) . "<br />";
			break;
	}
	return $return;
}

/* Utilisation d'un template : remplacement (non récursif ?) des blocs par les pages correspondantes
 * {{pagetype}} => HTML ou template ou module
 * si on utilise un autre template, rendre les boucles impossibles (l'appelant ne peut être appelé)
 * @TODO : permettre plus de champs de base, genre :
 		- {{pagetype}} : pages CMS
 		- {{%VARS%}} : infos issues d'Elgg, listings configurables, etc.
 		- {{[[shortcode]]}} : shortcodes
*/
function cmspages_render_template($template, $body = null) {
	$temp1 = explode('}}', $template);
	foreach ($temp1 as $temp) {
		$temp2 = explode('{{', $temp);
		$rendered_template .= $temp2[0]; // Toujours du texte
		if (isset($temp2[1]) && !empty($temp2[1])) {
			if ($temp2[1] == '%CONTENT%') $rendered_template .= $body;
			else $rendered_template .= elgg_view('cmspages/view', array('pagetype'=>$temp2[1]));
		}
	}
	return $rendered_template;
}

// Permet l'accès aux pages des blogs en mode "walled garden"
// Allows public visibility of public cmspages which allow fullview page rendering
function cmspages_public_pages($hook, $type, $return_value, $params) {
	global $CONFIG;
	
	$ignore_access = elgg_get_ignore_access();
	elgg_set_ignore_access(true);
	
	$params = array('types' => 'object', 'subtypes' => 'cmspage', 'order_by' => 'time_created asc', 'count' => true);
	$cmspages_count = elgg_get_entities($params);
	$params['limit'] = $cmspages_count;
	$params['count'] = false;
	$cmspages = elgg_get_entities($params);
	foreach ($cmspages as $ent) {
		// Pages publiques seulement si le niveau d'accès est public = 2 (on vérifie car override d'accès)
		// Et autorisé en pleine page
		if (($ent->access_id == 2) && ($ent->display != 'no')) {
			$return_value[] = 'cmspages/read/' . $ent->pagetype;
		}
	}
	
	/* Export embeddable content : was a test, now use a specific plugin instead
	// $return_value[] = 'cmspages/embed'; // URL pour les embed externes
	*/
	
	elgg_set_ignore_access($ignore_access);
	
	return $return_value;
}

