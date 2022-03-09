<?php
/*
Plugin Name: ShortCode IMDB
Description: This is a Wordpress plugin to display movie information in a content to users such as title, cast and plot via grabbing the data from imdb. You will be able to show movie or actor/actress information in your articles.
Version: 6.0.2
Author: Kemal YAZICI - PluginPress
Author URI: https://pluginpress.net
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: shortcode-imdb
*/

// If this file calls directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
wp_enqueue_editor();
define('SHIMDB_VS','6.0.2');
define('SHIMDB_URL',plugin_dir_url(__FILE__));
define('SHIMDB_FILE', __FILE__);
define('SHIMDB_ROOT',plugin_dir_path(__FILE__));

/******************CLASSES******************/
/* General */
require_once  SHIMDB_ROOT.'includes/classes/class.general.php';
/* Api */
require_once  SHIMDB_ROOT.'includes/classes/class.api.php';
/* IMDB Fetch Class */
require_once SHIMDB_ROOT.'includes/classes/class.imdb.php';
/* Theme Class */
require_once  SHIMDB_ROOT.'includes/classes/class.skins.php';
$SHIMB_Api = new shimb_imdb_api();
$SHIMB_Ex = $SHIMB_Api->ExtentionCheck();



/************** HELPERS ******************/
/* Class Variables */
require_once  SHIMDB_ROOT.'includes/helpers/classes.php';
//HOOKS
include SHIMDB_ROOT.'includes/helpers/hooks.php';
// ACTIONS
include SHIMDB_ROOT.'includes/helpers/actions.php';
// SHORTCODES
include SHIMDB_ROOT.'includes/helpers/shortcodes.php';
// CACHE ADMIN TABLES
require_once  SHIMDB_ROOT.'includes/helpers/cachelist.php';
//MENU SETTINGS
include SHIMDB_ROOT.'includes/helpers/menus.php';
//ADMIN MENU CONTENT
include SHIMDB_ROOT.'includes/helpers/content.php';
// ADD FRONTEND AND ADMIN STYLES
include SHIMDB_ROOT.'includes/helpers/style.php';

// PLUGIN INSTALLATION CONFIGURES
include SHIMDB_ROOT.'includes/helpers/installation.php';
session_write_close();