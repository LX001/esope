<?php
/**
 * Elgg export embeddable content
 * 
 * @package Elggexport_embed
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2012
 * @link http://id.facyla.net/
*/

// Initialise log browser
elgg_register_event_handler('init','system','export_embed_init');


function export_embed_init() {
  global $CONFIG;
  
  //elgg_extend_view('css','export_embed/css');
  
  // Register a page handler, so we can have nice URLs
  elgg_register_page_handler('embed','export_embed_page_handler');
  
	// PUBLIC PAGES - les pages auxquelles on peut accéder hors connexion
	elgg_register_plugin_hook_handler('public_pages', 'walled_garden', 'export_embed_public_pages');
	
	// Widget : view an external Elgg widget
	elgg_register_widget_type('export_embed', "Widget autre site Elgg", "Permet d'afficher sur ce site des informations issues d'un autre site Elgg.");
	
}


function export_embed_page_handler($page) {
  global $CONFIG;
  switch ($page[0]) {
    //case "read":
    //set_input('pagetype',$page[1]);
    default:
      if (@include(dirname(__FILE__) . "/external_embed.php")) return true;
  }
  return true;
}


// Permet l'accès aux pages des blogs en mode "walled garden"
function export_embed_public_pages($hook, $type, $return_value, $params) {
  global $CONFIG;
  $return_value[] = 'embed'; // URL pour les embed externes
  //$ignore_access = elgg_get_ignore_access();
  //elgg_set_ignore_access(true);

  /*
  // Pages publiques seulement si le niveau d'accès est public (2) (on vérifie car override d'accès)
  if ($article->access_id == 2) {
    // On autorise l'URL complète, mais aussi courte (permalien)
    $return_value[] = $eblog->blogname . '/' . $article->guid; // Permalien
    $return_value[] = $eblog->blogname . '/' . $article->guid . '/' . friendly_title($article->title);
  }
  */
  //elgg_set_ignore_access($ignore_access);
  return $return_value;
}

