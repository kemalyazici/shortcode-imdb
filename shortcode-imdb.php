<?php
/*
Plugin Name: ShortCode IMDB
Description: This is a Wordpress plugin to display movie information in a content to users such as title, cast and plot via grabbing the data from imdb. You will be able to show movie or actor/actress information in your articles.
Version: 3.1
Author: Kemal YAZICI - PluginPress
Author URI: http://pluginpress.net
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: shortcode-imdb
*/

// If this file calls directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}


// PLUGIN DEFINES
define('SHIMDB_URL',plugin_dir_url(__FILE__));
define('SHIMDB_FILE', __FILE__);



/************** INCLUDES ******************/
//HOOKS
include plugin_dir_path(__FILE__).'includes/helpers/hooks.php';

// ACTIONS
include plugin_dir_path(__FILE__).'includes/helpers/actions.php';

// SHORTCODES
include plugin_dir_path(__FILE__).'includes/helpers/shortcodes.php';


// PLUGIN INSTALLATION CONFIGURES
include plugin_dir_path(__FILE__).'includes/helpers/installation.php';


//CLASSES
/* IMDB Fetch Class */
require_once plugin_dir_path(__FILE__).'includes/classes/class.imdb.php';
/* Theme Class */
require_once  plugin_dir_path(__FILE__).'includes/classes/class.skins.php';


/* Class Variables */
require_once  plugin_dir_path(__FILE__).'includes/helpers/classes.php';



// CACHE ADMIN TABLES
require_once  plugin_dir_path(__FILE__).'includes/helpers/cachelist.php';


// ADD FRONTEND AND ADMIN STYLES
include plugin_dir_path(__FILE__).'includes/helpers/style.php';

//MENU SETTINGS
include plugin_dir_path(__FILE__).'includes/helpers/menus.php';


//ADMIN MENU CONTENT
include plugin_dir_path(__FILE__).'includes/helpers/content.php';



/************** INCLUDES END HERE ******************/


