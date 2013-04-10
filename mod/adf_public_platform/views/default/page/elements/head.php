<?php
/**
 * The standard HTML head
 *
 * @uses $vars['title'] The page title
 */

// Set title
if (empty($vars['title'])) {
	$title = elgg_get_config('sitename');
} else {
	$title = elgg_get_config('sitename') . ": " . $vars['title'];
}

global $autofeed;
if (isset($autofeed) && $autofeed == true) {
	$url = full_url();
	if (substr_count($url,'?')) {
		$url .= "&view=rss";
	} else {
		$url .= "?view=rss";
	}
	$url = elgg_format_url($url);
	$feedref = <<<END

	<link rel="alternate" type="application/rss+xml" title="RSS" href="{$url}" />

END;
} else {
	$feedref = "";
}

$js = elgg_get_loaded_js('head');
$css = elgg_get_loaded_css();

?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title; ?></title>
	<?php echo elgg_view('page/elements/shortcut_icon', $vars); ?>
	
  <!-- START IPhone meta //-->
	<meta name="viewport" content="initial-scale=1.0, minimum-scale=0.1, maximum-scale=8.0" />
	<link rel="apple-touch-icon" href="<?php echo $vars['url']; ?>iphone_touch.png" />
	<!-- END IPhone meta //-->
	
<?php foreach ($css as $link) { ?>
	<link rel="stylesheet" href="<?php echo $link; ?>" type="text/css" />
<?php } ?>
	<link rel="stylesheet" href="<?php echo $CONFIG->url; ?>mod/adf_public_platform/print.css" type="text/css" media="print" />
	
<?php
	$ie_url = elgg_get_simplecache_url('css', 'ie');
	$ie6_url = elgg_get_simplecache_url('css', 'ie6');
?>
	<!--[if gt IE 6]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie_url; ?>" />
	<![endif]-->
	<!--[if IE 6]>
		<link rel="stylesheet" type="text/css" href="<?php echo $ie6_url; ?>" />
	<![endif]-->
	<?php // Pure CSS menu integration : a piece of CSS + a JS script in 'page/elements/foot' for IE6 ?>
	<!--[if lt IE 7]>
    <style type="text/css">#menu li { width:164px; }</style>
  <![endif]-->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo $CONFIG->url; ?>mod/adf_public_platform/views/default/adf_platform/js/html5-ie.php"></script>
	<![endif]-->
			
	<?php echo $feedref; ?>

<?php foreach ($js as $script) { ?>
	<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>

<script type="text/javascript">
	<?php echo elgg_view('js/initialize_elgg'); ?>
</script>

<?php
echo $feedref;

$metatags = elgg_view('metatags', $vars);
if ($metatags) {
	elgg_deprecated_notice("The metatags view has been deprecated. Extend page/elements/head instead", 1.8);
	echo $metatags;
}
