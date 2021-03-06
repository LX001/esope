<?php
/**
 * Elgg bookmarks plugin everyone page
 *
 * @package ElggBookmarks
 */

global $CONFIG;

$owner = elgg_get_page_owner_entity();
if (!$owner) { forward('', '404'); }

elgg_push_context('ressources');

elgg_pop_breadcrumb();
elgg_push_breadcrumb($owner->name);


$owner = elgg_get_page_owner_entity();
if (!elgg_instanceof($owner, 'group')) {
	register_error('ressources:notingroup');
	forward();
}

$content = '';
$sidebar = '';

elgg_set_context('widgets');

// Add files if enabled
//if ($owner->file_enable == 'yes') {
if (elgg_is_active_plugin('file')) {
	$files = elgg_list_entities(array(
		'type' => 'object', 'subtype' => 'file',
		'full_view' => false, 'view_toggle_type' => false,
		'container_guid' => $owner->guid,
	));
	if (!$files) { $files = '<p>' . elgg_echo('files:none') . '</p>'; }
	
	$files = '<h3><a href="' . $CONFIG->url . 'file/group/' . $owner->guid . '/all">' . elgg_echo("file:user", array($owner->name)) . '</a></h3>' . $files;
	
	// Add link
	if ($owner->canWriteToContainer()) $files .= '<p class="elgg-widget-more">' . elgg_view('output/url', array(
		'href' => "file/add/$owner->guid",
		'text' => elgg_echo('file:add'),
		'is_trusted' => true,
	)) . '</p>';
	// Sidebar : not sure it adds anything but complexity
	//$sidebar .= file_get_type_cloud(elgg_get_page_owner_guid());
	//$sidebar .= elgg_view('file/sidebar');
}

// Add bookmarks if enabled
if ($owner->bookmarks_enable == 'yes') {
	$bookmarks = elgg_list_entities(array(
		'type' => 'object', 'subtype' => 'bookmarks',
		'full_view' => false, 'view_toggle_type' => false,
		'container_guid' => $owner->guid,
	));
	if (!$bookmarks) { $bookmarks = '<p>' . elgg_echo('bookmarks:none') . '</p>'; }
	
	// Add link
	$bookmarks = '<h3><a href="' . $CONFIG->url . 'bookmarks/group/' . $owner->guid . '/all">' . elgg_echo('bookmarks:owner', array($owner->name)) . '</a></h3>' . $bookmarks;
	if ($owner->canWriteToContainer()) $bookmarks .= '<p class="elgg-widget-more">' . elgg_view('output/url', array(
		'href' => "bookmarks/add/$owner->guid",
		'text' => elgg_echo('bookmarks:add'),
		'is_trusted' => true,
	)) . '</p>';

	// Sidebar : not sure it adds anything but complexity
	//$sidebar .= elgg_view('bookmarks/sidebar');
}

elgg_pop_context();



// Compose page content
$content .= '<div class="elgg-grid">';
if ($bookmarks && $files) {
	$content .= '<div style="width:48%; float:left;">' . $files . '</div>';
	$content .= '<div style="width:48%; float:right;">' . $bookmarks . '</div>';
} else if ($bookmarks) {
	$content .= '<div class="elgg-col elgg-col-1of1">' . $bookmarks . '</div>';
} else if ($files) {
	$content .= '<div class="elgg-col elgg-col-1of1">' . $files . '</div>';
}
$content .= '</div>';

if (!$content) { $content = elgg_echo('ressources:none'); }

$title = elgg_echo('ressources:group', array($owner->name));

$body = elgg_view_layout('content', array(
	//'filter_context' => 'all',
	'filter' => false,
	'content' => $content,
	'title' => $title,
	'sidebar' => $sidebar,
));

echo elgg_view_page($title, $body);

