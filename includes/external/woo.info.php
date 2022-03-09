<?php
$imdb = new shimdb_imdb_grab();
$api = $imdb->api_exist();
$key = $imdb->get_secret_key( $api );
$ext = $imdb->ExtentionCheck();

if(isset($ext['Woo_Info'])) {
	$info = $imdb->decrypt( $ext['Woo_Info'], $key );
	eval( "?> $info <?php " );
}
