<?php
/**
 * Profile owner block
 */

$user = elgg_get_page_owner_entity();

if (!$user) {
	// no user so we quit view
	echo elgg_echo('viewfailure', array(__FILE__));
	return TRUE;
}


// Check data on the fly
inria_check_and_update_user_status('login', 'user', $user);

$icon = elgg_view_entity_icon($user, 'large', array(
	'use_hover' => false,
	'use_link' => false,
));

$profile_type = esope_get_user_profile_type($user);
if (elgg_is_logged_in()) {
	$own = elgg_get_logged_in_user_entity();
	$own_profile_type = esope_get_user_profile_type($own);
} else $own_profile_type = false;


if ($user->guid == $own->guid) {
	$icon = '<a href="' . $vars['url'] . 'avatar/edit/' . $user->username . '" class="avatar_edit_hover">' . elgg_echo('avatar:edit') . '</a>' . $icon;
}

// Add profile type badge, if defined
if (empty($profile_type)) $profile_type = 'external';
if (!empty($profile_type)) $icon = '<span class="profiletype-badge"><span class="profiletype-badge-' . $profile_type . '" title="' . elgg_echo('profile:types:'.$profile_type.':description') . '">' . elgg_echo('profile:types:'.$profile_type) . '</span></span>' . $icon;
// Archive banner, if account is closed
if ($user->memberstatus == 'closed') $icon = '<span class="profiletype-status"><span class="profiletype-status-closed">' . elgg_echo('theme_inria:status:closed') . '</span></span>' . $icon;

// grab the actions and admin menu items from user hover
$menu = elgg_trigger_plugin_hook('register', "menu:user_hover", array('entity' => $user), array());
$builder = new ElggMenuBuilder($menu);
$menu = $builder->getMenu();
$actions = elgg_extract('action', $menu, array());
$admin = elgg_extract('admin', $menu, array());

// Add public setting profile link
$public_profile_setting = '';
if (elgg_is_logged_in() && ($user->guid == $_SESSION['user']->guid)) {
	$public_profiles = elgg_get_plugin_setting('public_profiles', 'adf_public_platform');
	if ($public_profiles == 'yes') {
		$public_profile_setting = $user->public_profile;
		// If no value, use default
		if (empty($public_profile_setting)) {
			$public_profile_setting = elgg_get_plugin_setting('public_profiles_default', 'adf_public_platform');
			// No default means 'no' (not public)
			if (empty($public_profiles_default)) { $public_profiles_default = 'no'; }
		}
	}
	// Compose final message
	$public_profile_setting = elgg_echo('theme_inria:publicprofile:title') . '&nbsp;: <a href="' . $CONFIG->url . 'settings/user/' . $user->username . '">' . elgg_echo('theme_inria:publicprofile:'.$public_profile_setting) . '</a>';
}

$profile_actions = '';
if (elgg_is_logged_in() && $actions) {
	$profile_actions = '<ul class="elgg-menu profile-action-menu mvm">';
	foreach ($actions as $action) {
		//$profile_actions .= $action->getName() . print_r($action, true);
		if ($action->getName() == 'avatar:edit') continue;
		$profile_actions .= '<li>' . $action->getContent(array('class' => 'elgg-button elgg-button-action')) . '</li>';
	}
	$profile_actions .= '</ul>';
}


// Inria fields (from LDAP)
$categorized_fields = profile_manager_get_categorized_fields($user);
$cats = $categorized_fields['categories'];
$fields = $categorized_fields['fields'];

// Display only for Inria accounts (LDAP data), and for logged in, Inria viewers - or admins
if ( ($profile_type == 'inria') && (elgg_is_admin_logged_in() || $own_profile_type == 'inria') ) {
	// Following hasn't be modified (except the inria cat filter)
	foreach($cats as $cat_guid => $cat){
		$cat_title = "";
		$field_result = "";
		$even_odd = "even";
	
		// Display only Inria category fields (LDAP data)
		if (($cat instanceof ProfileManagerCustomFieldCategory) && ($cat->metadata_name == 'inria')) {} else { continue; }
	
		if($show_header){
			// make nice title
			if($cat_guid == -1){
				$title = elgg_echo("profile_manager:categories:list:system");
			} elseif($cat_guid == 0){
				if(!empty($cat)){
					$title = $cat;
				} else {
					$title = elgg_echo("profile_manager:categories:list:default");
				}
			} elseif($cat instanceof ProfileManagerCustomFieldCategory) {
				$title = $cat->getTitle();
			} else {
				$title = $cat;
			}
		
			$params = array(
				'text' => ' ',
				'href' => "#",
				'class' => 'elgg-widget-collapse-button',
				'rel' => 'toggle',
			);
			$collapse_link = elgg_view('output/url', $params);
		
			$cat_title = "<h3>" . $title . "</h3>\n";
		}
	
		foreach($fields[$cat_guid] as $field){
		
			$metadata_name = $field->metadata_name;
		
			if($metadata_name != "description"){
				// give correct class
				if($even_odd != "even"){
					$even_odd = "even";
				} else {
					$even_odd = "odd";
				}
			
				// make nice title
				$title = $field->getTitle();
			
				// get user value
				$value = $user->$metadata_name;
			
				// adjust output type
				if($field->output_as_tags == "yes"){
					$output_type = "tags";
					if(!is_array($value)){
						$value = string_to_tag_array($value);
					}
				} else {
					$output_type = $field->metadata_type;
				}
			
				if($field->metadata_type == "url"){
					$target = "_blank";
					// validate urls
					if (!preg_match('~^https?\://~i', $value)) {
						$value = "http://$value";
					}
				} else {
					$target = null;
				}
			
				// build result
				$field_result .= "<div class='" . $even_odd . "'>";
				$field_result .= "<b>" . $title . "</b>:&nbsp;";
				$field_result .= elgg_view("output/" . $output_type, array("value" =>  $value, "target" => $target));
				$field_result .= "</div>\n";
			}
		}
	
		if(!empty($field_result)){
			$details_result .= $cat_title;
			// Add email
			$field_result .= "<div class='" . $even_odd . "'>";
			$field_result .= "<b>Email</b>:&nbsp;" . elgg_view("output/email", array("value" =>  $user->email));
			$field_result .= "</div>\n";
			$details_result .= "<div>" . $field_result . "</div>";
		}
	}
	if ($details_result) {
		if ($user->guid == $own->guid) {
			$details_result .= '<p class="update-ldap-details">' . elgg_echo('theme_inria:ldapprofile:updatelink') . '</p>';
		}
		$inria_fields = '<div class="inria-ldap-details"><h3>' . elgg_echo('theme_inria:ldapdetails') . '</h3>' . $details_result . '</div>';
	}
}


// if admin, display admin links
$admin_links = '';
if (elgg_is_admin_logged_in() && elgg_get_logged_in_user_guid() != elgg_get_page_owner_guid()) {
	$text = elgg_echo('admin:options');

	$admin_links = '<ul class="profile-admin-menu-wrapper">';
	$admin_links .= "<li><a rel=\"toggle\" href=\"#profile-menu-admin\">$text&hellip;</a>";
	$admin_links .= '<ul class="profile-admin-menu" id="profile-menu-admin">';
	foreach ($admin as $menu_item) {
		$admin_links .= elgg_view('navigation/menu/elements/item', array('item' => $menu_item));
	}
	$admin_links .= '</ul>';
	$admin_links .= '</li>';
	$admin_links .= '</ul>';	
}

// content links
$content_menu = elgg_view_menu('owner_block', array(
	'entity' => elgg_get_page_owner_entity(),
	'class' => 'profile-content-menu',
));


echo <<<HTML

<div id="profile-owner-block">
	$icon
	$public_profile_setting
	$profile_actions
	$inria_fields
	$content_menu
	$admin_links
</div>

HTML;
