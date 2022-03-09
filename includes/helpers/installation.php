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
            `cache` LONGTEXT NOT NULL,
            `page` INT(3) NOT NULL,
            UNIQUE KEY id (id)
        ) ".$charset_collate.";";



    if ( ! function_exists('dbDelta') ) {

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    }

    dbDelta( $sql );
    update_option( 'simdb_plugin_version', SHIMDB_VS );

}

//Update Settings
$db_version = get_option( 'simdb_plugin_version' ) ? get_option( 'simdb_plugin_version' ) : "4.6";
if ( version_compare( $db_version, '4.8', '<' ) ) {
    global $wpdb;
    $wpdb->query($wpdb->prepare('ALTER TABLE '.$wpdb->prefix.'shortcode_imdb_cache MODIFY cache LONGTEXT'));
	$wpdb->query($wpdb->prepare('ALTER TABLE '.$wpdb->prefix.'shortcode_imdb_cache ADD page INT(3) NOT NULL AFTER cache'));
}
if(version_compare( $db_version, SHIMDB_VS, '<' )) {
    update_option('simdb_plugin_version', SHIMDB_VS);
}