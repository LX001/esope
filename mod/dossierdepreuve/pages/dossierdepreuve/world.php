<?php
/**
 * Elgg dossierdepreuve global browser
 * 
 * @package Elggdossierdepreuve
 * @author Facyla ~ Florian DANIEL
 * @copyright Items International 2010-2013
 * @link http://items.fr/
 */

//require_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
global $CONFIG;
dossierdepreuve_gatekeeper();

$limit = get_input("limit", 30);
$offset = get_input("offset", 0);
$tags = get_input("q", false);


// Affiche tous les dossiers de preuve - filtrage par OF / groupe / formateur de ratachement => à définir

// Get the current page's owner to the site
elgg_set_page_owner_guid(0);

// Get objects ($tagstring = displayable query, $tags = search tags array)
if ($tags != "") {
  if(is_array($tags)) { $tagstring = implode(", ", $tags); } else { $tagstring = $tags; $tags = array($tags); }
  $title = "Les dossiers de preuve correspondant à \"$tagstring\"";
} else { $title = elgg_echo('dossierdepreuve:all'); }

$cloudtags = array();

$content = '';

$sidebar = elgg_view('dossierdepreuve/search', array('search' => str_replace(',', '', $tagstring)));
// Menu latéral pour les dossiers
$sidebar .= '<br />';
$sidebar .= '<div class="elgg-module elgg-owner-block"><div class="elgg-menu">';
$sidebar .= '<ul class="elgg-menu elgg-menu-page elgg-menu-page-default">';
$sidebar .= '<li><a href="' . $CONFIG->url . 'dossierdepreuve/autopositionnement">Tester mon niveau</a></li>';
$sidebar .= '</ul>';
$sidebar .= '</div></div>';



elgg_set_context('search');
$params = array(
    'type_subtype_pairs' => array('object' => 'dossierdepreuve'),
    'order_by' => 'time_updated DESC', 'count' => true,
  );
// Tous les dossiers
$dossiers_count = elgg_get_entities($params);
$params['count'] = false;
$params['limit'] = $dossiers_count;
$dossiers = elgg_get_entities($params);
if ($dossiers) {
	foreach ($dossiers as $dossier) {
		$content .= elgg_view('object/dossierdepreuve', array('entity' => $dossier));
	}
} else {
	$content .= '<p>' . elgg_echo('dossierdepreuve:none') . '</p>';
}

elgg_push_context('dossierdepreuve');


// Compose page
$body = elgg_view_layout('content', array('content' => $content, 'sidebar' => $sidebar, 'title' => $title, 'filter' => ''));

$title = elgg_echo("dossierdepreuve:all");

echo elgg_view_page($title, $body);

