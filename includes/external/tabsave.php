<?php
require_once("../../../../../wp-load.php");
if(@$_POST['save'] == "yes"){
	global $wpdb;
	$data = array();
	$check = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE type="tabs" AND imdb_id="'.$_POST['id'].'"');
	if(count($check)==0 || @$_POST['secret'] !="new") {
		if(@$_POST['secret'] == "new") {
			$wpdb->insert(
				$wpdb->prefix . 'shortcode_imdb_cache',
				array(
					'imdb_id' => $_POST['id'],
					'title'   => esc_sql( $_POST['title'] ),
					'type'    => 'tabs'

				)
			);
			$lastid = $wpdb->insert_id;
		}else{
			$lastid = $_POST['secret'];
			$wpdb->delete(
				"{$wpdb->prefix}shortcode_imdb_cache",
				array( 'imdb_id' => $lastid."-tab" )
			);
		}
		$arr = $_POST['arr'];
		if(count($arr)>0){
			foreach ($arr as $k => $a){
				$ar = base64_encode( json_encode( $a ) );
				$wpdb->insert(
					$wpdb->prefix . 'shortcode_imdb_cache',
					array(
						'imdb_id' => $lastid.'-tab',
						'title'   => esc_sql( $a[0]['main'] ),
						'type'    => esc_sql( $a[0]['tabType'] ),
						'cache' => esc_sql($ar),
						'page' => $k+1

					)
				);
			}
		}


		$data['state'] = "ok";
	}else{
		$data['state'] = "no";
	}

	echo json_encode($data);
}