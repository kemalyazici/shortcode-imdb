<?php
// Admin CSS style path
function si_imdb_admin_styles(){

    wp_enqueue_style(
        'imdb-admin-css',
        IMDB_URL.'includes/css/admin-style.css',
        array(),
        time()
    );
}


// Frontend CSS style path
function si_imdb_frontend_styles(){

    wp_enqueue_style(
        'mp-frontend-css',
        IMDB_URL.'includes/css/style.css',
        time()
    );
}

