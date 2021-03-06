<?php
$sort_options = array(
		'relevance' => elgg_echo('search:sort:relevance'),
		'created' => elgg_echo('search:sort:created'),
		'updated' => elgg_echo('search:sort:updated'),
		'alpha' => elgg_echo('search:sort:alpha'),
		'action_on' => elgg_echo('search:sort:action_on'),
	);

$order_options = array(
		'desc' => elgg_echo('search:order:desc'),
		'asc' => elgg_echo('search:order:asc'),
	);

// Type & subtype filters
$type_options[ELGG_ENTITIES_ANY_VALUE] = elgg_echo('search:type:any');
$subtype_options[ELGG_ENTITIES_ANY_VALUE] = elgg_echo('search:type:any');
if ($vars['types_list']) foreach ($vars['types_list'] as $type => $subtypes) {
	$type_options[$type] = elgg_echo('search:type:' . $type);
	if (is_array($subtypes) && count($subtypes)) {
		foreach ($subtypes as $subtype) {
			$subtype_options[$subtype] = elgg_echo('search:subtype:' . $subtype);
		}
	}
}

// Custom search types
$searchtype_options = array(
		'all' => elgg_echo('search:searchtype:all'),
		'entities' => elgg_echo('search:searchtype:entities')
	);
if ($vars['custom_types_list']) foreach ($vars['custom_types_list'] as $searchtype) {
	$searchtype_options[$searchtype] = elgg_echo('search:searchtype:' . $searchtype);
}



// Convert time to timestamp if needed
if (strpos('-', $vars['created_time_lower'])) { $vars['created_time_lower'] = strtotime($vars['created_time_lower']); }
if (strpos('-', $vars['created_time_upper'])) { $vars['created_time_upper'] = strtotime($vars['created_time_upper']); }
if (strpos('-', $vars['modified_time_lower'])) { $vars['modified_time_lower'] = strtotime($vars['modified_time_lower']); }
if (strpos('-', $vars['modified_time_lower'])) { $vars['modified_time_upper'] = strtotime($vars['modified_time_upper']); }


/*
// ADVANCED SEARCH LINK MODE
// Build base URL
$base_search_url = elgg_get_site_url().'search?' . htmlspecialchars(http_build_query(array(
	'q' => $vars['query'],
	'offset' => $vars['offset'],
	'limit' => $vars['limit'],
	'sort' => $vars['sort'],
	'order' => $vars['order'],
	'search_type' => $vars['search_type'],
	'type' => $vars['type'],
	'subtype' => $vars['subtype'],
	'owner_guid' => $vars['owner_guid'],
	'container_guid' => $vars['container_guid'],
	'created_time_lower' => $vars['created_time_lower'],
	'created_time_upper' => $vars['created_time_upper'],
	'modified_time_lower' => $vars['modified_time_lower'],
	'modified_time_upper' => $vars['modified_time_upper'],
)));

echo '<div class="search-filter-menu">';
foreach($sort_options as $sort_opt => $sort_name) {
	foreach($order_options as $order_opt => $order_name) {
		$class = '';
		if (($sort_opt == $vars['sort']) && ($order_opt == $vars['order'])) $class = ' selected';
		echo '<a href="' . $vars['base_url'] . '&sort=' . $sort_opt . '&order=' . $order_opt . '"  class="' . $class . '"">' . $sort_opt . ' ' . $order_opt . '</a>';
	}
}
echo '</div>';
*/



// ADVANCED SEARCH FORM INTERFACE
// @TODO build an advanced seearch interface through a GET form
echo '<form method="GET" action="' . $vars['url'] . 'search" id="advanced-search-form">';
echo '<fieldset>';
echo '<legend>' . elgg_echo('adf_platform:advancedsearch'). '</legend>';
echo elgg_view('input/securitytokens');
echo elgg_view('input/hidden', array('name' => 'offset', 'value' => $vars['offset']));
echo elgg_view('input/hidden', array('name' => 'limit', 'value' => $vars['limit']));

// Search types, type & subtypes are not fully implemented yet, so keep it commented
/*
echo '<p><label>' . elgg_echo('search:field:searchtype') . ' ' . elgg_view('input/dropdown', array('name' => 'search_type', 'options_values' => $searchtype_options, 'value' => $vars['searchtype'])) . '</label> &nbsp; &nbsp; ';
echo '<label>' . elgg_echo('search:field:type') . ' ' . elgg_view('input/dropdown', array('name' => 'type', 'options_values' => $type_options, 'value' => $vars['type'])) . '</label> &nbsp; &nbsp; ';
echo '<label>' . elgg_echo('search:field:subtype') . ' ' . elgg_view('input/dropdown', array('name' => 'subtype', 'options_values' => $subtype_options, 'value' => $vars['subtype'])) . '</label></p>';
*/

// Hidden fields - could be revealed if we don't use sidebar anymore...
if (!empty($vars['search_type'])) echo elgg_view('input/hidden', array('name' => 'search_type', 'value' => $vars['search_type']));
if (!empty($vars['type'])) echo elgg_view('input/hidden', array('name' => 'entity_type', 'value' => $vars['type']));
if (!empty($vars['subtype'])) echo elgg_view('input/hidden', array('name' => 'entity_subtype', 'value' => $vars['subtype']));

// Hidden fields - could be revealed if implemented in a usable way
if (!empty($vars['owner_guid'])) echo elgg_view('input/hidden', array('name' => 'owner_guid', 'value' => $vars['owner_guid']));
if (!empty($vars['container_guid'])) echo elgg_view('input/hidden', array('name' => 'container_guid', 'value' => $vars['container_guid']));

// Sort & order
echo '<p><label>' . elgg_echo('search:field:sort') . ' ' . elgg_view('input/dropdown', array('name' => 'sort', 'options_values' => $sort_options, 'value' => $vars['sort'])) . '</label> &nbsp; &nbsp; ';
echo '<label>' . elgg_echo('search:field:order') . ' ' . elgg_view('input/dropdown', array('name' => 'order', 'options_values' => $order_options, 'value' => $vars['order'])) . '</label></p>';

// Date filters
/*
echo '<p><label>' . elgg_echo('search:field:createdtimelower') . '&nbsp;: ' . elgg_view('event_calendar/input/date_local', array('name' => 'created_time_lower', 'value' => $vars['created_time_lower'], 'timestamp' => true)) . '</label> &nbsp; &nbsp; ';
echo '<label>' . elgg_echo('search:field:createdtimeupper') . '&nbsp;: ' . elgg_view('event_calendar/input/date_local', array('name' => 'created_time_upper', 'value' => $vars['created_time_upper'], 'timestamp' => true)) . '</label></p>';
echo '<p><label>' . elgg_echo('search:field:modifiedtimelower') . '&nbsp;: ' . elgg_view('event_calendar/input/date_local', array('name' => 'modified_time_lower', 'value' => $vars['modified_time_lower'], 'timestamp' => true)) . '</label> &nbsp; &nbsp; ';
echo '<label>' . elgg_echo('search:field:modifiedtimeupper') . '&nbsp;: ' . elgg_view('event_calendar/input/date_local', array('name' => 'modified_time_upper', 'value' => $vars['modified_time_upper'], 'timestamp' => true)) . '</label></p>';
*/
echo '<p><strong>' . elgg_echo('search:field:createdtime') . '</strong> <label><i class="fa fa-calendar"></i> ' . elgg_view('input/date', array('name' => 'created_time_lower', 'value' => $vars['created_time_lower'])) . ' ' . elgg_echo('search:field:date:lower') . ' </label> &nbsp; &nbsp; ';
echo '<label><i class="fa fa-calendar"></i> ' . elgg_view('event_calendar/input/date_local', array('name' => 'created_time_upper', 'value' => $vars['created_time_upper'])) . ' ' . elgg_echo('search:field:date:upper') . '</label>';
//echo ' &nbsp; &nbsp; ';
echo '</p><p>';
echo '<strong>' . elgg_echo('search:field:modifiedtime') . '</strong> <label><i class="fa fa-calendar"></i> ' . elgg_view('event_calendar/input/date_local', array('name' => 'modified_time_lower', 'value' => $vars['modified_time_lower'])) . ' ' . elgg_echo('search:field:date:lower') . '</label> &nbsp; &nbsp; ';
echo '<label><i class="fa fa-calendar"></i> ' . elgg_view('event_calendar/input/date_local', array('name' => 'modified_time_upper', 'value' => $vars['modified_time_upper'])) . ' ' . elgg_echo('search:field:date:upper') . '</label></p>';

// Fulltext search
echo '<p><label>' . elgg_echo('search:field:fulltext') . ' ' . elgg_view('input/text', array('name' => 'q', 'value' => $vars['query'])) . '</label>';

echo elgg_view('input/submit', array('value' => elgg_echo('search'), 'style' => "float:right;"));

echo '</fieldset>';
echo '</form>';

