<?php


//CREATING TABLE
function shimdb_imdb_create_table() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE ".$wpdb->base_prefix."shortcode_imdb_cache (
            `id` BIGINT(20) NOT NULL AUTO_INCREMENT , 
            `imdb_id` VARCHAR(255) NOT NULL ,
            `title` VARCHAR(255) NOT NULL , 
            `type` VARCHAR(255) NOT NULL DEFAULT 'normal' , 
            `cache` TEXT NOT NULL,
            UNIQUE KEY id (id)
        ) $charset_collate;";

    if ( ! function_exists('dbDelta') ) {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    }

    dbDelta( $sql );

}
