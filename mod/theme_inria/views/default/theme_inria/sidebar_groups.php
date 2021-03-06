<?php $groups = elgg_get_entities_from_metadata(array(
		'metadata_name' => 'featured_group',
		'metadata_value' => 'yes',
		'types' => 'group',
		'limit' => 12,
	));

if ($groups) {
	elgg_push_context('widgets');
	$body = '';
	foreach ($groups as $group) {
		//$body .= elgg_view_entity_icon($group, 'small');
		$body .= '<a href="' . $group->getURL() . '" title="' . $group->title . '"><img src="' . $group->getIconURL('small') . '" style="margin:1px 6px 3px 0;" /></a>';
	}
	elgg_pop_context();

	echo '<div id="sidebar-featured-groups"><h3><a href="' . $vars['url'] . 'groups/all?filter=featured">' . elgg_echo("inria:groups:featured") . '</a></h3>' . $body . '</div>';
}

