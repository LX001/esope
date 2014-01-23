<?php
/**
* Profile widgets/tools
* 
* @package ElggGroups
*/ 
	
// tools widget area
echo '<ul id="groups-tools" class="elgg-gallery elgg-gallery-fluid mtl clearfix">';

// enable tools to extend this area
// Inria : disable widgets on group home
//echo elgg_view("groups/tool_latest", $vars);

// backward compatibility
$right = elgg_view('groups/right_column', $vars);
$left = elgg_view('groups/left_column', $vars);
if ($right || $left) {
	elgg_deprecated_notice('The views groups/right_column and groups/left_column have been replaced by groups/tool_latest', 1.8);
	echo $left;
	echo $right;
}

echo "</ul>";


// Add group activity
$group = $vars['entity'];
if (!$group) { return true; }

$all_link = elgg_view('output/url', array('href' => "groups/activity/$group->guid", 'text' => elgg_echo('groups:activity'), 'is_trusted' => true));

elgg_push_context('widgets');
$db_prefix = elgg_get_config('dbprefix');
$activity = elgg_list_river(array(
	'limit' => 10, 'pagination' => true,
	'joins' => array("JOIN {$db_prefix}entities e1 ON e1.guid = rv.object_guid"),
	'wheres' => array("(e1.container_guid = $group->guid)"),
));
elgg_pop_context();

if (!$activity) { $activity = '<p>' . elgg_echo('groups:activity:none') . '</p>'; }

echo '<h3>' . $all_link . '</h3>';
echo $activity;
