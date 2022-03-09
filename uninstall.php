<?php
// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

$option_name = 'shortcode-imdb-api';

delete_option($option_name);

// for site options in Multisite
delete_site_option($option_name);

// drop a custom database table

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}shortcode_imdb_cache");
$wpdb->delete($wpdb->prefix . 'options', array('option_name' => "shortcode-imdb-api"));