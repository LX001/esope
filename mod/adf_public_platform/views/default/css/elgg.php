<?php
/**
 * Elgg primary CSS view
 *
 * @package Elgg.Core
 * @subpackage UI
 */

/* 
 * Colors:
 *  #4690D6 - elgg light blue
 *  #0054A7 - elgg dark blue
 *  #e4ecf5 - elgg very light blue
 */

// check if there is a theme overriding the old css view and use it, if it exists
$old_css_view = elgg_get_view_location('css');
if ($old_css_view != elgg_get_config('viewpath')) {
	echo elgg_view('css', $vars);
	return true;
}

// Configurable elements : pass theme as $vars['theme-config-css']
// Image de fond du header
$headerimg = elgg_get_plugin_setting('headerimg', 'adf_public_platform');
if (!empty($headerimg)) $headerimg = $vars['url'] . $headerimg;
$backgroundcolor = elgg_get_plugin_setting('backgroundcolor', 'adf_public_platform');
$backgroundimg = elgg_get_plugin_setting('backgroundimg', 'adf_public_platform');
if (!empty($backgroundimg)) $backgroundimg = $vars['url'] . $backgroundimg;
// Couleur des titres
$titlecolor = elgg_get_plugin_setting('titlecolor', 'adf_public_platform');
$textcolor = elgg_get_plugin_setting('textcolor', 'adf_public_platform');
// Couleur des liens
$linkcolor = elgg_get_plugin_setting('linkcolor', 'adf_public_platform');
$linkhovercolor = elgg_get_plugin_setting('linkhovercolor', 'adf_public_platform');
// Couleur 1 : Haut dégradé header
$color1 = elgg_get_plugin_setting('color1', 'adf_public_platform');
// Couleur 4 : Bas dégradé header
$color4 = elgg_get_plugin_setting('color4', 'adf_public_platform');
// Couleur 2 : Haut dégradé widgets/modules
$color2 = elgg_get_plugin_setting('color2', 'adf_public_platform');
// Couleur 3 : Bas dégradé widgets/modules
$color3 = elgg_get_plugin_setting('color3', 'adf_public_platform');
// Couleur 5-8 : Dégradés des boutons + dégradé hover
$color5 = elgg_get_plugin_setting('color5', 'adf_public_platform');
$color6 = elgg_get_plugin_setting('color6', 'adf_public_platform');
$color7 = elgg_get_plugin_setting('color7', 'adf_public_platform');
$color8 = elgg_get_plugin_setting('color8', 'adf_public_platform');
// Divers tons de gris par défaut et éléments de l'interface
$color9 = elgg_get_plugin_setting('color9', 'adf_public_platform'); // #CCCCCC
$color10 = elgg_get_plugin_setting('color10', 'adf_public_platform'); // #999999
$color11 = elgg_get_plugin_setting('color11', 'adf_public_platform'); // #333333
$color12 = elgg_get_plugin_setting('color12', 'adf_public_platform'); // #DEDEDE
// Couleur de fond du sous-menu déroulant
$color13 = elgg_get_plugin_setting('color13', 'adf_public_platform');
// Module title
$color14 = elgg_get_plugin_setting('color14', 'adf_public_platform');
// Button title
$color15 = elgg_get_plugin_setting('color15', 'adf_public_platform');
// Couleur de fond du footer configurable
$footercolor = elgg_get_plugin_setting('footercolor', 'adf_public_platform');
// Fonts
$font1 = elgg_get_plugin_setting('font1', 'adf_public_platform');
$font2 = elgg_get_plugin_setting('font2', 'adf_public_platform');
$font3 = elgg_get_plugin_setting('font3', 'adf_public_platform');
$font4 = elgg_get_plugin_setting('font4', 'adf_public_platform');
$font5 = elgg_get_plugin_setting('font5', 'adf_public_platform');
$font6 = elgg_get_plugin_setting('font6', 'adf_public_platform');
// @TODO : Force set fonts, for the moment
/*
$font1 = 'Lato, sans-serif';
$font2 = 'Lato-bold, sans-serif';
$font3 = 'Puritan, sans-serif';
$font4 = 'Puritan, Arial, sans-serif';
$font5 = 'Monaco, "Courier New", Courier, monospace';
$font6 = 'Georgia, times, serif';
*/

$vars['theme-config-css'] = array(
  'urlicon' => $vars['url'] . 'mod/adf_public_platform/img/theme/',
  'headerimg' => $headerimg,
  'backgroundcolor' => $backgroundcolor,
  'backgroundimg' => $backgroundimg,
  'titlecolor' => $titlecolor,
  'linkcolor' => $linkcolor,
  'linkhovercolor' => $linkhovercolor,
  'textcolor' => $textcolor,
  'color1' => $color1,
  'color2' => $color2,
  'color3' => $color3,
  'color4' => $color4,
  'color5' => $color5,
  'color6' => $color6,
  'color7' => $color7,
  'color8' => $color8,
  'color9' => $color9,
  'color10' => $color10,
  'color11' => $color11,
  'color12' => $color12,
  'color13' => $color13,
  'color14' => $color14,
  'color15' => $color15,
  'footercolor' => $footercolor,
  'font1' => $font1,
  'font2' => $font2,
  'font3' => $font3,
  'font4' => $font4,
  'font5' => $font5,
  'font6' => $font6,
);
/* Use in subsequent CSS views like this :
  // Get all needed vars
  $css = elgg_extract('theme-config-css', $vars);
  $urlicon = $css['urlicon'];
  $titlecolor = $css['titlecolor'];
  $linkcolor = $css['linkcolor'];
  $color1 = $css['color1'];
  $color2 = $css['color2'];
  $color3 = $css['color3'];
*/
// Additional config CSS
//$config_css = elgg_get_plugin_setting('css', 'adf_public_platform');


/*******************************************************************************

Base CSS
 * CSS reset
 * core
 * helpers (moved to end to have a higher priority)
 * grid

*******************************************************************************/
echo elgg_view('css/elements/reset', $vars);
echo elgg_view('css/elements/core', $vars);
echo elgg_view('css/elements/grid', $vars);


/*******************************************************************************

Skin CSS
 * typography     - fonts, line spacing
 * forms          - forms, inputs
 * buttons        - action, cancel, delete, submit, dropdown, special
 * navigation     - menus, breadcrumbs, pagination
 * icons          - icons, sprites, graphics
 * modules        - modules, widgets
 * layout_objects - lists, content blocks, notifications, avatars
 * layout         - page layout
 * misc           - to be removed/redone

*******************************************************************************/
echo elgg_view('css/elements/typography', $vars);
echo elgg_view('css/elements/forms', $vars);
echo elgg_view('css/elements/buttons', $vars);
echo elgg_view('css/elements/icons', $vars);
echo elgg_view('css/elements/navigation', $vars);
echo elgg_view('css/elements/modules', $vars);
echo elgg_view('css/elements/components', $vars);
echo elgg_view('css/elements/layout', $vars);
echo elgg_view('css/elements/misc', $vars);


// included last to have higher priority
echo elgg_view('css/elements/helpers', $vars);


// in case plugins are still extending the old 'css' view, display it
echo elgg_view('css', $vars);


// CSS complémentaire configurable => directement chargé dans le page/elements/head
//if (!empty($config_css)) { echo $config_css; }


