<?php
/**
 * Page Layout
 ************Changed for EasyTheme (line 25)****************
 * Contains CSS for the page shell and page layout
 *
 * Default layout: 990px wide, centered. Used in default page shell
 *
 * @package Elgg.Core
 * @subpackage UI
 */

// Get all needed vars
$css = elgg_extract('theme-config-css', $vars);
$headerimg = $css['headerimg'];
$urlicon = $css['urlicon'];
$linkcolor = $css['linkcolor'];
$textcolor = $css['textcolor'];
$linkhovercolor = $css['linkhovercolor'];
$color1 = $css['color1'];
$color2 = $css['color2'];
$color3 = $css['color3'];
$color4 = $css['color4'];
$color9 = $css['color9']; // #CCCCCC
$color10 = $css['color10']; // #999999
$color11 = $css['color11']; // #333333
$color12 = $css['color12']; // #DEDEDE
?>

/* ***************************************
	PAGE LAYOUT
*************************************** */
/***** DEFAULT LAYOUT ******/
<?php // the width is on the page rather than topbar to handle small viewports ?>
.elgg-page-default {
	min-width: 998px;
}
.elgg-page-default .elgg-page-header > .elgg-inner {
	width: 990px;
	margin: 0 auto;
	/*
	height: 437px;
	*/
	height: auto;
	
}
.elgg-page-default .elgg-page-body > .elgg-inner {
	width: 990px;
	margin: 0 auto;
	
}
.elgg-page-default .elgg-page-footer > .elgg-inner {
	width: 990px;
	margin: 0 auto;
	padding: 5px 0;
	border-top: 1px solid #DEDEDE;
	
}

/***** TOPBAR ******/
.elgg-page-topbar {
	background: #333333 url(<?php echo elgg_get_site_url(); ?>_graphics/toptoolbar_background.gif) repeat-x top left;
	border-bottom: 1px solid #000000;
	position: relative;
	height: 24px;
	z-index: 9000;
}
.elgg-page-topbar > .elgg-inner {
	padding: 0 10px;
}

/***** PAGE MESSAGES ******/
.elgg-system-messages {
	position: fixed;
	top: 24px;
	right: 20px;
	max-width: 500px;
	z-index: 2000;
}
.elgg-system-messages li {
	margin-top: 10px;
}
.elgg-system-messages li p {
	margin: 0;
}

/***** PAGE HEADER ******/
.elgg-page-header {
	position: relative;
	background: #fff url(<?php echo elgg_get_site_url(); ?>_graphics/header_shadow.png) repeat-x bottom left;
}
.elgg-page-header > .elgg-inner {
	position: relative;
}

/***** PAGE BODY LAYOUT ******/
.elgg-layout {
	min-height: 360px;
}
.elgg-layout-one-sidebar {
  /* background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/sidebar_background.gif) repeat-y right top; */
	/* modifs Urbilog */
}
.elgg-layout-two-sidebar {
	background: transparent url(<?php echo elgg_get_site_url(); ?>_graphics/two_sidebar_background.gif) repeat-y right top;
}

/****** Change colour of sidebar here */
.elgg-sidebar {
	position: relative;
	padding: 20px 10px;
	float: right;
	width: 210px;
	margin: 0 0 0 10px;
	background:transparent;
	padding:0;
	
}
.elgg-sidebar-alt {
	position: relative;
	padding: 20px 10px;
	float: left;
	width: 160px;
	margin: 0 10px 0 0;
}

.elgg-menu-extras {
	background:transparent;
	float: right;
	margin:0;
	/* padding:6px 4px 0 4px; */
}
.elgg-owner-block { clear:both; }
.elgg-owner-block .elgg-head { background:#e5e7f6; margin:0; padding:0 4px 2px 4px;  }
.elgg-owner-block .elgg-menu { background:white; margin:0; padding: 0; }
.elgg-sidebar .elgg-module-aside {
	background:transparent; 
	float: left;
	margin: 20px 0 0 0;
	padding:6px 4px 2px 4px;
}

/****** Change colour of main white content area here */
.elgg-main	{
	position: relative;
	padding: 13px;
	float: left;
	background: #fff;
	min-height:500px;
	height:auto;
}
.elgg-layout-one-sidebar .elgg-main	{
	width: 717px;
}

.elgg-main > .elgg-head {
	padding-bottom: 3px;
	border-bottom: 1px solid #CCCCCC;
	margin-bottom: 10px;
}

/***** PAGE FOOTER ******/
/***** Change footer background colour here */
.elgg-page-footer {
	position: relative;
	height:100px;
}
.elgg-page-footer {
	color: #999;
	background:#333;
}
.elgg-page-footer a:hover, 
.elgg-page-footer a:focus, 
.elgg-page-footer a:active {
	color: #666;
}


/* Theme ADF : bandeau */
header {
	background-image: url("<?php echo $headerimg; ?>"), linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: url("<?php echo $headerimg; ?>"), -o-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: url("<?php echo $headerimg; ?>"), -moz-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: url("<?php echo $headerimg; ?>"), -webkit-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: url("<?php echo $headerimg; ?>"), -ms-linear-gradient(top, <?php echo $color1; ?> 25%, <?php echo $color4; ?> 75%);
	background-image: url("<?php echo $headerimg; ?>"), -webkit-gradient(linear, left top, left bottom, color-stop(0.25, <?php echo $color1; ?>), color-stop(0.75, <?php echo $color4; ?>));
	background-position: left 30px, left top;
	background-repeat: repeat-x, repeat;
	background-color: <?php echo $color4; ?>;
	color: #fff;
	height: 115px;
	border-top: 2px solid <?php echo $color1; ?>;
}
/* Couleur texte normal pour les header dans le contenu de la page */
section header, header .intro { color: <?php echo $textcolor; ?>; }



