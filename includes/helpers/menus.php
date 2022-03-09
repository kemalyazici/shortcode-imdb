<?php

function shimdb_imdb_settings_page(){
    $path_for_icon = __FILE__;
    $Api = new shimb_imdb_api();
    $ex = $Api->ExtentionCheck();

    //Main Menu
    add_menu_page(
        __( 'ShortCode IMDB', 'shortcode_imdb' ),
        __( 'ShortCode IMDB', 'shortcode_imdb' ),
        'manage_options',
        'shortcode_imdb',
        'shimdb_imdb_general_info',
        plugins_url( '../assets/smi.png',$path_for_icon),
        999
    );

    //Cache List sub menu
    add_submenu_page(
        'shortcode_imdb',
        __( 'Titles', 'shortcode_imdb' ),
        __( 'Titles', 'shortcode_imdb' ),
        'manage_options',
        'shortcode_imdb_titles',
        'shimdb_imdb_titles_info'
    );

    //Cache List sub menu
    add_submenu_page(
        'shortcode_imdb',
        __( 'Names', 'shortcode_imdb' ),
        __( 'Names', 'shortcode_imdb' ),
        'manage_options',
        'shortcode_imdb_names',
        'shimdb_imdb_names_info'
    );

    //Cache List sub menu
    add_submenu_page(
        'shortcode_imdb',
        __( 'Quotes', 'shortcode_imdb' ),
        __( 'Quotes', 'shortcode_imdb' ),
        'manage_options',
        'shortcode_imdb_quotes',
        'shimdb_imdb_quotes_info'
    );

    if(isset($ex['checkList'])){
        //Cache List sub menu
        add_submenu_page(
            'shortcode_imdb',
            __( 'Lists', 'shortcode_imdb' ),
            __( 'Lists', 'shortcode_imdb' ),
            'manage_options',
            'shortcode_imdb_lists',
            'shimdb_imdb_lists_info'
        );

    }

	if(isset($ex['popups'])){
		//Cache List sub menu
		add_submenu_page(
			'shortcode_imdb',
			__( 'Popup Settings', 'shortcode_imdb' ),
			__( 'Popup Settings', 'shortcode_imdb' ),
			'manage_options',
			'shortcode_imdb_popups',
			'shimdb_imdb_popups_info'
		);

	}
	if(isset($ex['imdb_tabs'])){
		//Cache List sub menu
		add_submenu_page(
			'shortcode_imdb',
			__( 'Tab Panel', 'shortcode_imdb' ),
			__( 'Tab Panel', 'shortcode_imdb' ),
			'manage_options',
			'shortcode_imdb_tabs',
			'shimdb_imdb_tabs_info'
		);

	}

	add_submenu_page(
		'shortcode_imdb',
		__( 'Language Settings', 'shortcode_imdb' ),
		__( 'Language Settings', 'shortcode_imdb' ),
		'manage_options',
		'shortcode_imdb_lang',
		'shimdb_imdb_lang_info'
	);


}



