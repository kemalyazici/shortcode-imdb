<?php

function si_imdb_settings_page(){
    $path_for_icon = __FILE__;

    //Main Menu
    add_menu_page(
        __( 'IMDB ShortCode Plugin', 'imdb_shortcode' ),
        __( 'IMDB ShortCode', 'imdb_shortcode' ),
        'manage_options',
        'shortcode_imdb',
        'shimdb_imdb_general_info',
        plugins_url( '../assets/is.ico',$path_for_icon),
        11
    );

    //Cache List sub menu
    add_submenu_page(
        'shortcode_imdb',
        __( 'Manage Cache', 'imdb_shortcode' ),
        __( 'Manage Cache', 'imdb_shortcode' ),
        'manage_options',
        'shortcode_imdb_cache',
        'shimdb_imdb_cache_info'
    );


}



