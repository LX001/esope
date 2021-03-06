<?php
/**
 * Elgg external pages: add/edit
 * 
 * @package Elggcmspages
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Facyla
 * @copyright Facyla 2010
 * @link http://id.facyla.net/
 */

gatekeeper();
action_gatekeeper(); // Make sure action is secure

// Facyla : this tool is rather for local admins and webmasters than main admins, so we use also custom access rights
// OK if custom rights match, or use default behaviour
if (in_array(elgg_get_logged_in_user_guid(), explode(',', elgg_get_plugin_setting('editors', 'cmspages')))) {
} else {
  if (elgg_is_active_plugin('multisite')) { multisite_admin_gatekeeper(); } else { admin_gatekeeper(); }
}

// Cache to the session
elgg_make_sticky_form('cmspages');

/* Get input data */
$contents = get_input('cmspage_content', '', false); // We do *not want to filter HTML
$cmspage_title = get_input('cmspage_title');
$pagetype = elgg_get_friendly_title(get_input('pagetype')); // Needs to be URL-friendly
// Empty or very short pagetypes are not allowed
if (empty($pagetype) || strlen($pagetype) < 3 ) {
  register_error(elgg_echo('cmspages:unsettooshort'));
  forward("mod/cmspages/index.php");
}
$tags = get_input('cmspage_tags');
//$cmspage_guid = (int)get_input('cmspage_guid'); // not really used (pagetype are unique, as URL rely on them rather than GUID)
$access = get_input('access_id', ACCESS_DEFAULT);
// These are for future developments/features, such as page hierarchy, conditional display based on container
$container_guid = get_input('container_guid');
$parent_guid = get_input('parent_guid');
$sibling_guid = get_input('sibling_guid');
// Externalblog/templating system integration
$content_type = get_input('content_type');
$contexts = get_input('contexts');
$module = get_input('module');
$module_config = get_input('module_config');
$display = get_input('display');
$template = get_input('template');
$page_css = get_input('page_css');
$page_js = get_input('page_js');

// Cache to the session - @todo handle by sticky form
$_SESSION['cmspage_title'] = $cmspage_title;
$_SESSION['cmspage_content'] = $contents;
$_SESSION['cmspage_pagetype'] = $pagetype;
$_SESSION['cmspage_tags'] = $tags;
$_SESSION['cmspage_access'] = $access;
$_SESSION['cmspage_container_guid'] = $container_guid;
$_SESSION['cmspage_$parent_guid'] = $$parent_guid;
$_SESSION['cmspage_sibling_guid'] = $sibling_guid;
$_SESSION['cmspage_content_type'] = $content_type;
$_SESSION['cmspage_contexts'] = $contexts;
$_SESSION['cmspage_module'] = $module;
$_SESSION['cmspage_module_config'] = $module_config;
$_SESSION['cmspage_display'] = $display;
$_SESSION['cmspage_template'] = $template;
$_SESSION['cmspage_page_css'] = $page_css;
$_SESSION['cmspage_page_js'] = $page_js;

// Facyla 20110214 : following bypass is necessary when using Private access level, which causes objects not to be saved correctly (+doubles), depending on author
elgg_set_ignore_access(true);

// Get existing object, or create it
$cmspage = NULL;
if (strlen($pagetype)>0) {
  //$cmspages = get_entities_from_metadata('pagetype', $pagetype, "object", "cmspage", 0, 1, 0, "", 0, false); // 1.6
  $options = array(
      'metadata_names' => 'pagetype', 'metadata_values' => $pagetype, 'types' => 'object', 'subtypes' => 'cmspage',
      //'owner_guid' => 0, 'site_guid' => 0, 
      'limit' => 1, 'offset' => 0, 'order_by' => '', 'count' => false,
    );
  $cmspages = elgg_get_entities_from_metadata($options);
  $cmspage = $cmspages[0];
}

// Check existing object, or create a new one
if ($cmspage && ($cmspage instanceof ElggObject)) {
  $cmspage_guid = $cmspage->getGUID();
} else {
  // @todo
  $cmspage = new ElggObject;
  $cmspage->subtype = 'cmspage';
  $cmspage->owner_guid = $CONFIG->site->guid; // Set owner to the current site (nothing personal, hey !)
  $cmspage->pagetype = $pagetype;
  $new = true;
}


// Edition de l'objet existant ou nouvellement créé
//$cmspage->id = $cmspage_guid;
$cmspage->pagetitle = $cmspage_title;
$cmspage->description = $contents;
$cmspage->access_id = $access;
// Modules & templates integration
$cmspage->content_type = $content_type;
$cmspage->module = $module;
$cmspage->module_config = $module_config;
$tagarray = string_to_tag_array($tags); // Convert string of tags into a preformatted array
$cmspage->tags = $tagarray;
$cmspage->contexts = $contexts;
$cmspage->display = $display;
$cmspage->template = $template;
$cmspage->css = $page_css;
$cmspage->js = $page_js;
// @todo unused yet
$cmspage->container_guid = $CONFIG->site->guid;  // Set container to the current site (nothing personal, hey !)
$cmspage->parent_guid = $parent_guid;
$cmspage->sibling_guid = $sibling_guid;


// Save new/updated content
if ($cmspage->save()) {
  system_message(elgg_echo("cmspages:posted")); // Success message
  /*
  if ($new) add_to_river('river/cmspages/create','create',$_SESSION['user']->guid, $cmspages->guid); // add to river - not really useful here, but who knows..
  else add_to_river('river/cmspages/update','update',$_SESSION['user']->guid, $cmspages->guid); // add to river - not really useful here, but who knows..
  */
  elgg_clear_sticky_form('cmspages'); // Remove the cache
  unset($_SESSION['cmspage_content']); unset($_SESSION['cmspage_title']); unset($_SESSION['cmspage_pagetype']); unset($_SESSION['cmspage_tags']); unset($_SESSION['cmspage_access']); unset($_SESSION['cmspage_container_guid']); unset($_SESSION['cmspage_$parent_guid']); unset($_SESSION['cmspage_sibling_guid']); unset($_SESSION['cmspage_content_type']); unset($_SESSION['cmspage_contexts']); unset($_SESSION['cmspage_module']); unset($_SESSION['cmspage_module_config']); unset($_SESSION['cmspage_display']); unset($_SESSION['cmspage_template']); unset($_SESSION['cmspage_page_css']); unset($_SESSION['cmspage_page_js']);
} else {
  register_error(elgg_echo("cmspages:error") . elgg_get_logged_in_user_guid() . '=> ' . elgg_get_plugin_setting('editors', 'cmspages'));
  
}

elgg_set_ignore_access(false);
// Forward back to the page
 forward("cmspages/index.php?pagetype=$pagetype");

