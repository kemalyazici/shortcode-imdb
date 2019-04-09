<?php
// Admin CSS style path
function shimdb_imdb_admin_styles(){

    wp_enqueue_style(
        'imdb-admin-css',
        SHIMDB_URL.'includes/css/admin-style.css?v=4.2',
        array(),
        time()
    );
}


// Frontend CSS style path
function shimdb_imdb_frontend_styles(){

    wp_enqueue_style(
        'mp-frontend-css',
        SHIMDB_URL.'includes/css/style.css?v=4.2',
        time()
    );
}

