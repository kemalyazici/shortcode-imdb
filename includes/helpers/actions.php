<?php
// Add action of shortcodes
add_action('init', 'shimdb_imdb_register_shortcodes');
// Add action of admin css
add_action('admin_enqueue_scripts','shimdb_imdb_admin_styles');
// Add action of frontend css
add_action('wp_enqueue_scripts','shimdb_imdb_frontend_styles');
// Add admin menu
add_action('admin_menu','shimdb_imdb_settings_page');
// Add admin js
add_action('admin_enqueue_scripts','scimdb_admin_jquery_script');
add_action('admin_enqueue_scripts','scimdb_admin_script');