<?php

// Initialise log browser
elgg_register_event_handler('init','system','theme_inria_init');


/* Initialise the theme */
function theme_inria_init(){
	global $CONFIG;
	$action_url = dirname(__FILE__) . "/actions/";
	
	// HTML export action
	elgg_register_action("pages/html_export", $action_url . "pages/html_export.php", "public");
	// Inria members user add
	elgg_register_action("inria_useradd", $action_url . "inria_useradd.php", "logged_in");
	// Inria members admin tools
	elgg_register_action("inria_remove_user_email", $action_url . "inria_remove_user_email.php", "logged_in");
	elgg_register_action("inria_archive_user", $action_url . "inria_archive_user.php", "logged_in");
	elgg_register_action("inria_unarchive_user", $action_url . "inria_unarchive_user.php", "logged_in");
	
	// Modified to make pages top_level / sub-pages
	elgg_register_action("pages/edit", $action_url . "pages/edit.php");
	
	// Rewrite friends and friends request to remove river entries
	elgg_unregister_action('friends/add');
	elgg_unregister_action('friend_request/approve');
	elgg_register_action("friends/add", $action_url . "friends/add.php", "logged_in");
	elgg_register_action("friend_request/approve", $action_url . "friend_request/approve.php", "logged_in");
	
	
	elgg_extend_view('css', 'theme_inria/css');
	elgg_extend_view('css/admin', 'theme_inria/admin_css');
	elgg_extend_view('css/digest/core', 'css/digest/site/theme_inria');
	
	// Extend group owner block
	elgg_extend_view('page/elements/owner_block', 'theme_inria/extend_user_owner_block', 501);
	
	// Extend group owner block
	elgg_extend_view('page/elements/owner_block', 'theme_inria/extend_group_owner_block', 501);
	elgg_unextend_view('groups/sidebar/members', 'au_subgroups/sidebar/subgroups');
	elgg_extend_view('groups/sidebar/search', 'au_subgroups/sidebar/subgroups', 300);
	//elgg_extend_view('groups/sidebar/search', 'theme_inria/extend_group_my_status', 600);
	
	// Rewritten in a more specific way for Iris theme
	elgg_unextend_view('forms/login', 'elgg_cas/login_extend');
	
	elgg_extend_view('forms/profile/edit', 'theme_inria/profile_linkedin_import', 200);
	
	// Add RSS feed option
	//add_group_tool_option('rss_feed', elgg_echo('theme_inria:group_option:cmisfolder'), false);
	// Extend group with RSS feed reader
	// Note : directly integrated in groups/profile/widgets
	//elgg_extend_view('groups/tool_latest', 'simplepie/group_simplepie_module', 501);
	//elgg_extend_view('groups/profile/summary', 'simplepie/group_simplepie_module', 501);
	//elgg_extend_view('page/elements/sidebar', 'simplepie/sidebar_simplepie_module', 501);
	
	// Supprimer le suivi de l'activité (toujours activé)
	remove_group_tool_option('activity');
	
	// Add CMIS folder option
	//add_group_tool_option('cmis_folder', elgg_echo('theme_inria:group_option:cmisfolder'), false);
	// Extend group with CMIS folder
	//elgg_extend_view('groups/tool_latest', 'elgg_cmis/group_cmisfolder_module', 501);
	// Displays only if ->cmisfolder is set
	//elgg_extend_view('page/elements/sidebar', 'elgg_cmis/group_cmisfolder_sidebar', 501);
	
	// Extend public profile settings
	elgg_extend_view('core/settings/account', 'theme_inria/usersettings_extend', 100);
	//elgg_extend_view('adf_platform/account/public_profile', 'theme_inria/usersettings_extend', 501);
	
	// Export HTML des pages wiki (dans le menu de la page - cf. object/page_top pour chaque entité)
	//elgg_extend_view('page/elements/owner_block', 'theme_inria/html_export_extend', 200);
	
	// Add all groups excerpt to digest
	elgg_extend_view('digest/elements/site', 'digest/elements/site/thewire', 503);
	elgg_extend_view('digest/elements/site', 'digest/elements/site/allgroups', 600);
	
	// WIDGETS
	/// Widget thewire : liste tous les messages (et pas juste ceux de l'user connecté)
	if (elgg_is_active_plugin('thewire')) {
		$widget_thewire = elgg_get_plugin_setting('widget_thewire', 'adf_public_platform');
		elgg_unregister_widget_type('thewire');
		if ($widget_thewire != 'no') {
			elgg_register_widget_type('thewire', elgg_echo('thewire'), elgg_echo("thewire:widgetesc"));
		}
	}
	// Inria universe : liens vers d'autres 
	elgg_register_widget_type('inria_universe', elgg_echo('theme_inria:widgets:tools'), elgg_echo('theme_inria:widgets:tools:details'), 'dashboard', false);
	//elgg_register_widget_type('inria_partage', "Partage", "Accès à Partage", 'dashboard');
	
	// HOMEPAGE
	// Remplacement de la page d'accueil
	if (elgg_is_logged_in()) {
		elgg_unregister_plugin_hook_handler('index','system','adf_platform_index');
		elgg_register_plugin_hook_handler('index','system','theme_inria_index');
	} else {
		if (!$CONFIG->walled_garden) {
			elgg_unregister_plugin_hook_handler('index','system','adf_platform_public_index');
			elgg_register_plugin_hook_handler('index','system','theme_inria_public_index');
		}
	}
	
	// Menus
	elgg_register_event_handler('pagesetup', 'system', 'theme_inria_setup_menu');
	elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'theme_inria_user_hover_menu');
	
	// Ajout niveau d'accès sur TheWire
	if (elgg_is_active_plugin('thewire')) {
		elgg_unregister_action('thewire/add');
		elgg_register_action("thewire/add", elgg_get_plugins_path() . 'theme_inria/actions/thewire/add.php');
	}
	
	// Remplacement du modèle d'event_calendar
	elgg_register_library('elgg:event_calendar', elgg_get_plugins_path() . 'theme_inria/lib/event_calendar/model.php');
	
	// Check access validity and update meta fields (inria/external, active/closed)
	elgg_register_event_handler('login','user', 'inria_check_and_update_user_status', 900);
	
	// Remove unwanted widgets
	//elgg_unregister_widget_type('river_widget');
	
	elgg_register_page_handler("inria", "inria_page_handler");
	
	// Add a "ressources" page handler for groups
	elgg_register_page_handler("ressources", "inria_ressources_page_handler");
	
	// Add link to longtext menu
	//elgg_register_plugin_hook_handler('register', 'menu:longtext', 'shortcodes_longtext_menu');	
	
	// Modification des menus standards des widgets
	elgg_unregister_plugin_hook_handler('register', 'menu:widget', 'adf_platform_elgg_widget_menu_setup');
	elgg_register_plugin_hook_handler('register', 'menu:widget', 'theme_inria_widget_menu_setup');
	
	// Add Etherpad (and iframes) embed
	elgg_register_plugin_hook_handler('register', 'menu:embed', 'theme_inria_select_tab', 801);
	
	
	// Modify message and add attachments to event notifications
	if (elgg_is_active_plugin('html_email_handler')) {
		// Modify default events notification message
		elgg_register_plugin_hook_handler('notify:entity:message', 'object', 'event_calendar_ics_notify_message');
		// Use hook to add attachments
		elgg_register_plugin_hook_handler('notify:entity:params', 'object', 'event_calendar_ics_notify_attachment');
	}
	// Interception création event pour ajouter l'auteur aux personnes notifiées
	elgg_register_event_handler('create','object', 'theme_inria_notify_event_owner', 900);
	
	// Filtrage des contenus saisis
	if (elgg_is_active_plugin('htmlawed')) {
		elgg_unregister_plugin_hook_handler('validate', 'input', 'adf_platform_htmlawed_filter_tags');
		elgg_register_plugin_hook_handler('validate', 'input', 'theme_inria_htmlawed_filter_tags', 1);
	}
	
	if (elgg_is_active_plugin('ldap_auth')) {
		elgg_register_plugin_hook_handler('check_profile', 'ldap_auth', 'theme_inria_ldap_check_profile');
		elgg_register_plugin_hook_handler('update_profile', 'ldap_auth', 'theme_inria_ldap_update_profile');
		elgg_register_plugin_hook_handler('clean_group_name', 'ldap_auth', 'theme_inria_ldap_clean_group_name');
	}
	
}

// Include Inria functions
require_once(dirname(__FILE__) . '/lib/theme_inria/functions.php');
// Include events handlers
require_once(dirname(__FILE__) . '/lib/theme_inria/events.php');
// Include core and plugins hooks
require_once(dirname(__FILE__) . '/lib/theme_inria/hooks.php');



// New "inria/" page handler
function inria_page_handler($page){
	switch($page[0]){
		case "userimage":
			include(dirname(__FILE__) . '/pages/theme_inria/userimage.php');
			break;
		case "userprofile":
			include(dirname(__FILE__) . '/pages/theme_inria/userprofile.php');
			break;
		case "usergroups":
			include(dirname(__FILE__) . '/pages/theme_inria/usergroups.php');
			break;
		case "linkedin":
			include(dirname(__FILE__) . '/pages/theme_inria/linkedin_profile_update.php');
			break;
		case "invite":
			include(dirname(__FILE__) . '/pages/theme_inria/invite_external.php');
			break;
		case "animation":
			include(dirname(__FILE__) . '/pages/theme_inria/admin_tools.php');
			break;
		default:
			include(dirname(__FILE__) . '/pages/theme_inria/index.php');
	}
	return true;
}

// New "ressources/" page handler
function inria_ressources_page_handler($page) {
	//elgg_load_library('elgg:groups');
	$base_dir = elgg_get_plugins_path() . 'theme_inria/pages/ressources';
	$page_type = $page[0];
	// Only valid URL model : ressources/group/GUID/all (or without 'all')
	if (isset($page[1])) set_input('guid', $page[2]);
	switch ($page_type) {
		case 'group':
			include "$base_dir/group_ressources.php";
			break;
		default:
			return false;
	}
	return true;
}



