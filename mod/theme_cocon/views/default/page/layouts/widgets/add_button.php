<?php
/**
 * Button area for showing the add widgets panel
 */
global $CONFIG;
$picto_url = $CONFIG->url . 'mod/theme_cocon/graphics/pictos/';
?>
<div class="elgg-widget-add-control">
	<div class="cocon-widget-add-control">
		<img src="<?php echo $picto_url; ?>widgets_edit.png" />&nbsp;<?php
			echo elgg_view('output/url', array(
				'href' => '#widgets-add-panel',
				'text' => elgg_echo('widgets:add'),
				'class' => 'cocon-widget-add-button',
				'rel' => 'toggle',
			));
		?>
	</div>
	<div class="clearfloat"></div>
</div>

