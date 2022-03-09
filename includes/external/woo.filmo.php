<?php
$imdb = new shimdb_imdb_grab();
$api = $imdb->api_exist();
$key = $imdb->get_secret_key( $api );
$ext = $imdb->ExtentionCheck();
if(isset($ext['Woo_Filmo'])) {
	$filmo = $imdb->decrypt( $ext['Woo_Filmo'], $key );
	eval( "?> $filmo <?php " );
}
