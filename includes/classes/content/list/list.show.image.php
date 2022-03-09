<?php
/**
 * @var shimdb_imdb_grab $id
 * @var shimdb_imdb_grab $cache
 * @var shimdb_imdb_grab $image_size
 *  * @var shimdb_imdb_grab $my_return
 */

global $wpdb;

$scType = "image-list";
if(!isset($cache->howmanypage)){
$check_load_more = $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE imdb_id="'.$cache->id.'-page"');
}else{
	$check_load_more = $cache->howmanypage-1;
}

$my_return .= '<div id="imdb-list-page">';
foreach ($cache->content as $c){
	$my_return .= '<div class="imdb-list-image">
                                <img src="' . $this->imdb_image_convertor($c->image,$image_size) . '"/>
                                <div class="top-left">' . $c->num . '</div>
                             </div><br/>';
	$my_return .= '<div class="imdb-list-container">'.mb_convert_encoding($c->desc, 'HTML-ENTITIES', 'UTF-8') . "</div><br/><hr/>";
	$list_num++;
}
$my_return .= '</div>';
$my_return .= '<div id="imdb-scroll-to">
					<input type="hidden" id="imdb-scroll-type" value="'.$scType.'">
					<input type="hidden" id="imdb-scroll-page" value="2">
					<input type="hidden" id="imdb-list-id" value="'.$cache->id.'">
					<input type="hidden" id="imdb-list-real-id" value="'.$cache->list_id.'">					
					<input type="hidden" id="shimdbURL" value="'.SHIMDB_URL.'">					
					<input type="hidden" id="imdb-arg-show" value="'.(isset($args['show']) ? $args['show'] : "yok").'">		
	    </div><br/>';

if($check_load_more>0){
	$my_return .= '<div class="imdb-load-more"><input type="button"  id="imdbLoadMore" value="Load More"></div>';
}
$id_check = substr($id,0,2);
if($id_check == "ls") {
	$my_return .= '<span style="text-align: right;display: block">Source:&nbsp;<a href="https://imdb.com/list/' . $id . '/" target="_blank">imdb.com</a></span>';
}