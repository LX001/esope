<?php

// Activation des plugins
$widget_blog = elgg_get_plugin_setting('widget_blog', 'adf_public_platform');
$widget_bookmarks = elgg_get_plugin_setting('widget_bookmarks', 'adf_public_platform');
$widget_brainstorm = elgg_get_plugin_setting('widget_brainstorm', 'adf_public_platform');
$widget_event_calendar = elgg_get_plugin_setting('widget_event_calendar', 'adf_public_platform');
$widget_file = elgg_get_plugin_setting('widget_file', 'adf_public_platform');
$widget_file_folder = elgg_get_plugin_setting('widget_file_folder', 'adf_public_platform');
$widget_groups = elgg_get_plugin_setting('widget_groups', 'adf_public_platform');
$widget_pages = elgg_get_plugin_setting('widget_pages', 'adf_public_platform');
$widget_friends = elgg_get_plugin_setting('widget_friends', 'adf_public_platform');
$widget_group_activity = elgg_get_plugin_setting('widget_group_activity', 'adf_public_platform');
$widget_messages = elgg_get_plugin_setting('widget_messages', 'adf_public_platform');
$widget_webprofiles = elgg_get_plugin_setting('widget_webprofiles', 'adf_public_platform');
$widget_river_widget = elgg_get_plugin_setting('widget_river_widget', 'adf_public_platform');
$widget_twitter = elgg_get_plugin_setting('widget_twitter', 'adf_public_platform');
$widget_thewire = elgg_get_plugin_setting('widget_thewire', 'adf_public_platform');
$widget_tagcloud = elgg_get_plugin_setting('widget_tagcloud', 'adf_public_platform');
$widget_videos = elgg_get_plugin_setting('widget_videos', 'adf_public_platform');
$widget_webprofiles = elgg_get_plugin_setting('widget_webprofiles', 'adf_public_platform');
$widget_export_embed = elgg_get_plugin_setting('widget_export_embed', 'adf_public_platform');
$widget_freehtml = elgg_get_plugin_setting('widget_freehtml', 'adf_public_platform');
$widget_searchresults = elgg_get_plugin_setting('widget_searchresults', 'adf_public_platform');


elgg_unregister_widget_type('blog');
if (elgg_is_active_plugin('blog')) {
	if ($widget_blog != 'no') elgg_register_widget_type('blog', elgg_echo('adf_platform:widget:blog:title'), elgg_echo('blog:widget:description'));
}

elgg_unregister_widget_type('bookmarks');
if (elgg_is_active_plugin('bookmarks')) {
	if ($widget_bookmarks != 'no') elgg_register_widget_type('bookmarks', elgg_echo('adf_platform:widget:bookmark:title'), elgg_echo('bookmarks:widget:description'));
}

elgg_unregister_widget_type('brainstorm');
if (elgg_is_active_plugin('brainstorm')) {
	if ($widget_brainstorm != 'no') elgg_register_widget_type('brainstorm', elgg_echo('adf_platform:widget:brainstorm:title'), elgg_echo('brainstorm:widget:description'));
}

elgg_unregister_widget_type('event_calendar');
if (elgg_is_active_plugin('event_calendar')) {
	if ($widget_event_calendar != 'no') elgg_register_widget_type('event_calendar',elgg_echo("adf_platform:widget:event_calendar:title"),elgg_echo('event_calendar:widget:description'));
}

elgg_unregister_widget_type('filerepo');
if (elgg_is_active_plugin('file')) {
	if ($widget_file != 'no') elgg_register_widget_type('filerepo', elgg_echo('adf_platform:widget:file:title'), elgg_echo("file:widget:description"));
}

elgg_unregister_widget_type('file_tree');
	if (elgg_is_active_plugin('file_tools')) {
		// Réactive widget des dossiers si demandé (et Dossiers activés)
		$is_folder_enabled = elgg_get_plugin_setting('user_folder_structure', 'file_tools');
		if (($widget_file_folder != 'no') && ($is_folder_enabled == 'yes')) elgg_register_widget_type ("file_tree", elgg_echo("widgets:file_tree:title"), elgg_echo("widgets:file_tree:description"), "dashboard,profile,groups", true);
	}


if ($widget_friends == 'no') elgg_unregister_widget_type('friends');

if ($widget_river_widget == 'no') elgg_unregister_widget_type('river_widget');
if ($widget_river_widget != 'no') {
	elgg_unregister_widget_type('river_widget');
	elgg_register_widget_type('river_widget', elgg_echo('adf_platform:widget:site_activity:title'), elgg_echo('adf_platform:widget:site_activity:description'), "dashboard");
	elgg_register_widget_type('river_widget', elgg_echo('adf_platform:widget:user_activity:title'), elgg_echo('adf_platform:widget:user_activity:description'), "profile");
}

if (elgg_is_active_plugin('twitter')) {
	if ($widget_twitter == 'no') elgg_unregister_widget_type('twitter');
}

if (elgg_is_active_plugin('thewire')) {
	if ($widget_thewire == 'no') elgg_unregister_widget_type('thewire');
}

if (elgg_is_active_plugin('tagcloud')) {
	if ($widget_tagcloud == 'no') elgg_unregister_widget_type('tagcloud');
}

if (elgg_is_active_plugin('videos')) {
	if ($widget_videos == 'no') elgg_unregister_widget_type('videos');
}

elgg_unregister_widget_type('a_users_groups');
if (elgg_is_active_plugin('groups')) {
	if ($widget_group_activity == 'no') elgg_unregister_widget_type('group_activity');
	if ($widget_groups != 'no') elgg_register_widget_type('a_users_groups', elgg_echo('adf_platform:widget:group:title'), elgg_echo('groups:widgets:description'));
}

elgg_unregister_widget_type('pages');
if (elgg_is_active_plugin('pages')) {
	if ($widget_pages != 'no') elgg_register_widget_type('pages', elgg_echo('adf_platform:widget:page:title'), elgg_echo('pages:widget:description'));
}

elgg_unregister_widget_type('profile_completeness');
if (elgg_is_active_plugin('profile_manager')) {
	if (elgg_get_plugin_setting("enable_profile_completeness_widget", "profile_manager") == "yes") {
		elgg_register_widget_type('profile_completeness', elgg_echo("widgets:profile_completeness:title"), elgg_echo("widgets:profile_completeness:description"), "profile,dashboard");
	}
}

if (elgg_is_active_plugin('export_embed')) {
	if ($widget_export_embed == 'no') elgg_unregister_widget_type('export_embed');
}


// Nouveaux widgets

if (elgg_is_active_plugin('messages')) {
	if ($widget_messages != 'no') elgg_register_widget_type('messages', elgg_echo('messages:widget:title'), elgg_echo('messages:widget:description'), 'dashboard');
}

if (elgg_is_active_plugin('webprofiles')) {
	if ($widget_webprofiles != 'no') elgg_register_widget_type('webprofiles', elgg_echo('webprofiles:widget:title'), elgg_echo('webprofiles:widget:description'), 'profile');
}


// Widgets intégrés

if ($widget_freehtml != 'no') elgg_register_widget_type('freehtml', elgg_echo('esope:widget:freehtml'), elgg_echo('esope:widget:freehtml:description'), 'all', true);

if ($widget_searchresults != 'no') elgg_register_widget_type('searchresults', elgg_echo('esope:widget:searchresults'), elgg_echo('esope:widget:searchresults:description'), 'all', true);

