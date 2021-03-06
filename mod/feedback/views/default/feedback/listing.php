<?php
/**
 * Elgg Feedback plugin
 * Feedback interface for Elgg sites
 *
 * @package Feedback
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
 * @author Prashant Juvekar
 * @copyright Prashant Juvekar
 * @link http://www.linkedin.com/in/prashantjuvekar
 *
 * for Elgg 1.8 by iionly
 * iionly@gmx.de
 */

global $CONFIG;
if (elgg_get_context() == 'view') {
	elgg_set_context('feedback');
	elgg_pop_breadcrumb();
	elgg_push_breadcrumb('feedback', $CONFIG->url . 'feedback');
}

$about = $vars['entity']->about; if (empty($about)) { $about = "feedback"; }
$status = $vars['entity']->status; if (empty($status)) $status = "open";
$mood = $vars['entity']->mood; if (empty($mood)) $mood = "neutral";
if ($vars['full'] === true) $full = true; else $full = false;

$status_mark = elgg_echo ( "feedback:status:" . $status );
$mood_mark = elgg_echo ( "feedback:mood:" . $mood );
$about_mark = elgg_echo ( "feedback:about:" . $about );
if ($full) $access_mark = elgg_view('output/access', array('entity' => $vars['entity']));



$icon = elgg_view('icon/default', array('entity' => $vars['entity'], 'size' => 'small'));

$controls = '';
if ($full) $controls .= $access_mark;
switch ($status) {
	case 'closed':
		$controls .= '<span class="elgg-icon elgg-icon-round-checkmark" title="' . $status_mark . '"></span>';
		// Only admins can reopen feedbacks
		if (elgg_is_admin_logged_in) {
			$controls .= elgg_view("output/confirmlink",array('href' => $vars['url'] . "action/feedback/reopen?guid=" . $vars['entity']->guid, 'confirm' => elgg_echo('feedback:reopenconfirm'), 'class' => 'elgg-icon elgg-icon-redo'));
		}
		break;
		
	default:
		// Only admins can close feedbacks
		if (elgg_is_admin_logged_in) {
			$controls .= elgg_view("output/confirmlink",array('href' => $vars['url'] . "action/feedback/close?guid=" . $vars['entity']->guid, 'confirm' => elgg_echo('feedback:closeconfirm'), 'class' => 'elgg-icon elgg-icon-checkmark'));
		}
}
// Only admins can delete feedbacks
if (elgg_is_admin_logged_in) {
	$controls .= elgg_view("output/confirmlink",array('href' => $vars['url'] . "action/feedback/delete?guid=" . $vars['entity']->guid, 'confirm' => elgg_echo('deleteconfirm'), 'class' => 'elgg-icon elgg-icon-trash'));
}

$class = 'feedback-mood-' . $vars['entity']->mood . ' feedback-about-' . $vars['entity']->about . ' feedback-status-' . $status;

$page = elgg_echo('feedback:page:unknown');
if ( !empty($vars['entity']->page) ) {
	$page = $vars['entity']->page;
	$page = "<a href='" . $page . "'>" . $page . "</a>";
}


// Render view
$info .= "<div style='float:left;width:25%'><strong>".elgg_echo('feedback:list:mood').": </strong>" . $mood_mark . "</div>";
$info .= "<div style='float:left;width:40%'><strong>".elgg_echo('feedback:list:about').": </strong>" . $about_mark . "</div>";
$info .= '<div class="controls">' . $controls . "</div>";
$info .= '<div class="clearfloat"></div>';
$info .= "<strong>".elgg_echo('feedback:list:from').": </strong>" . $vars['entity']->id . '<span style="float:right;">' . elgg_view_friendly_time($vars['entity']->time_created) . "</span><br />";
$info .= "<strong>".elgg_echo('feedback:list:page').": </strong>" . $page . "<br />";
$info .= '<br /><blockquote>' . nl2br($vars['entity']->txt) . '</blockquote>';

// Commentaires
$comment = elgg_get_plugin_setting("comment", "feedback");
if (elgg_in_context('admin')) $full = false;
if ($comment == 'yes') {
	if (!$full) {
		$num_comments_feedback = $vars['entity']->countComments();
		$info .= '<div class="clearfloat"></div>';
		$info .= '<a href="' . $vars['entity']->getURL() . '">' . elgg_echo('feedback:viewfull') . '</a>';
		$info .= '<a href="javascript:void(0);" onClick="javascript:$(\'#feedback_'.$vars['entity']->getGUID().'\').toggle()" style="float:right;">' . elgg_echo('feedback:commentsreply', array($num_comments_feedback)) . '</a>';
	}
	$info .= '<div id="feedback_' . $vars['entity']->guid . '"';
	if (!$full) $info .= ' style="display:none;"';
	$info .= '>' . elgg_view_comments($vars['entity']) . '</div>';
}

echo elgg_view('page/components/image_block', array('image' => $icon, 'body' => $info, 'class' => 'submitted-feedback ' . $class));


if (!elgg_in_context('search')) {
} else {
}
// @TODO : revoir tout ce qui suit
/*
// Search listing view
$feedbacklink = '<a href="'.$vars['entity']->getURL().'" title="Afficher ce feedback et la discussion associée en pleine page">';
$icon = '<img src="'.$CONFIG->wwwroot.'mod/feedback/graphics/'.$section.'.png" />';
$icon = $feedbacklink . $icon . '</a>';

if (!empty($vars['entity']->section)) {
	$section = elgg_echo("feedback:section:" . $vars['entity']->section);
}
if (!empty($vars['entity']->categorie)) {
	$categorie 	= elgg_echo ( "feedback:categorie:" . $vars['entity']->categorie ); // Formavia 20120129 : more generic
}

// URL de la page concernée par le feedback
$feedbackurl = elgg_echo('unknown');
if (!empty($vars['entity']->page) ) {
	$www_root = $_SERVER["HTTP_HOST"];	// Facyla : handle subdirectory install
	// Suppression du slash final s'il y en a un
	if (substr($www_root, -1) == '/') { $www_root = substr($www_root, 0, -1); }
	$feedbackurl = 'http://' . $vars['entity']->page; // Facyla : correct URL (absolute)
	$page = '<a href="' . $feedbackurl . '">' . $feedbackurl . '</a>';
}

// Bloc d'informations
$info .= "$section concernant $page&nbsp;: ";
//$info .= "<div style='float:left;width:30%'><strong>".elgg_echo('feedback:list:categorie').": </strong>" . $categorie . "</div>";; // Formavia 20111122 : Unused
$txt = cut_string($vars['entity']->txt, 50, $needle = " ", true, true);
$info .= '&laquo;&nbsp;' . parse_urls(trim($txt[0])) . '...&nbsp;&raquo;';
$info .= '<p class="owner_timestamp">' . friendly_time($vars['entity']->time_created);
if ($vars['entity']->state == 'closed') $info .= '<span style="float:right; font-weight:bold;">' . elgg_echo('feedback:closed') . '</span>';
else $info .= '<span style="float:right; font-weight:bold;">' . elgg_echo('feedback:open') . '</span>';
$info .= '</p>';

// Affichage du feedback
echo elgg_view_listing($icon,$info);
*/


