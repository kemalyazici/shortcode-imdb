<?php
// Admin CSS style path
function shimdb_imdb_admin_styles(){

    wp_enqueue_style(
        'imdb-admin-sans-css',
        'https://fonts.googleapis.com/css?family=Open+Sans:400,600,700',
        array(),
        time()
    );

    wp_enqueue_style(
        'imdb-admin-awesome-css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
        array(),
        time()
    );


    wp_enqueue_style(
        'imdb-admin-css',
        SHIMDB_URL.'includes/css/admin-style.css?v=4.4',
        array(),
        time()
    );
}


// Frontend CSS style path
function shimdb_imdb_frontend_styles(){

    wp_enqueue_style(
        'mp-frontend-css',
        SHIMDB_URL.'includes/css/style.css?v=4.4',
        time()
    );
}

