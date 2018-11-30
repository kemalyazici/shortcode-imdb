<?php
// Add action of shortcodes
add_action('init', 'imdb_register_shortcodes');
// Add action of admin css
add_action('admin_enqueue_scripts','imdb_admin_styles');
// Add action of frontend css
add_action('wp_enqueue_scripts','imdb_frontend_styles');
// Add admin menu
add_action('admin_menu','is_settings_page');