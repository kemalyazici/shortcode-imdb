<?php

function scimdb_admin_jquery_script(){



    wp_enqueue_script(
        'scimdb-admin-jquery-script',
        'https://code.jquery.com/jquery-3.3.1.min.js',
        array('jquery'),
        time()
    );



}


function scimdb_admin_script(){



        wp_enqueue_script(
            'scimdb-admin-script',
            SHIMDB_URL.'includes/assets/script.js',
            array('jquery'),
            time()
        );



}