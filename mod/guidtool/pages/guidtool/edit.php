<?php
/**
 * Elgg GUID Tool
 * 
 * @package ElggGUIDTool
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Curverider Ltd
 * @copyright Curverider Ltd 2008-2010
 * @link http://elgg.com/
 */

admin_gatekeeper();
elgg_set_context('admin');

$entity_guid = get_input('entity_guid');

// Render the file upload page
$title = elgg_echo('guidtool:editguid', array($entity_guid));

access_show_hidden_entities(true);
$body = '<p>' . elgg_echo("guidtool:editguid:warning") . '</p>';
$body .= elgg_view_form("guidtool/edit", array('entity_guid' => $entity_guid));
access_show_hidden_entities(false);

$body = elgg_view_layout('admin', array('title' => $title, 'content' => $body));
echo elgg_view_page($title, $body);

