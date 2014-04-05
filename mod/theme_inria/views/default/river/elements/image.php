<?php
/**
 * Elgg river image
 *
 * Displayed next to the body of each river item
 *
 * @uses $vars['item']
 */

$subject = $vars['item']->getSubjectEntity();

if (elgg_get_context() == 'digest') {
	echo '<a href="' .  $subject->getURL() . '"><img src="' . $subject->getIconUrl('small') .  '" /></a>';
} else {
	if (elgg_in_context('widgets')) {
		echo elgg_view_entity_icon($subject, 'tiny');
	} else {
		echo elgg_view_entity_icon($subject, 'small');
	}
}

