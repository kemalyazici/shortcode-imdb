<?php

function shimdb_imdb_settings_page(){
    $path_for_icon = __FILE__;

    //Main Menu
    add_menu_page(
        __( 'ShortCode IMDB', 'shortcode_imdb' ),
        __( 'ShortCode IMDB', 'shortcode_imdb' ),
        'manage_options',
        'shortcode_imdb',
        'shimdb_imdb_general_info',
        plugins_url( '../assets/si.png',$path_for_icon),
        11
    );

    //Cache List sub menu
    add_submenu_page(
        'shortcode_imdb',
        __( 'Manage Cache', 'shortcode_imdb' ),
        __( 'Manage Cache', 'shortcode_imdb' ),
        'manage_options',
        'shortcode_imdb_cache',
        'shimdb_imdb_cache_info'
    );


}



