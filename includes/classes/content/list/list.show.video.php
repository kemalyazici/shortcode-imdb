<?php
/**
 * @var shimdb_imdb_grab $id
 * @var shimdb_imdb_grab $cache
 * @var shimdb_imdb_grab $image_size
 * @var shimdb_imdb_grab $my_return
 */
global $wpdb;
if(!isset($cache->howmanypage)){
	$check_load_more = $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE imdb_id="'.$cache->id.'-page"');
}else{
	$check_load_more = $cache->howmanypage-1;
}


$scType = "video-list";
$my_return .= '<div id="imdb-list-page">';

$count_my_grid = 4;
$count_my_grid_end = 7;
foreach ($cache->content as $c){
	$my_return .= "<div class='imdb-video-header'><a href='" . $c->titleLink . "' target='_blank'>" . $c->title . '</a></div>';
	$my_return .= '<small>'.$c->muted.'</small>';
	$my_return .= '<div class="imdb-list-image">
                                          <a href = "'.$c->VideoImageLink.'" target="_blank">
                                             <img src="'.$this->imdb_image_convertor($c->VideoImage,$image_size).'">
                                          </a>
                               <div class="centered">
                                          <a href = "'.$c->VideoImageLink.'" target="_blank">
                                             <img src="'.SHIMDB_URL.'includes/assets/player.png">
                                         </a>
                               </div>
                            </div>';
	$my_return .= '<p>'.$c->VideoDesc.'</p>';
	$my_return .= '<hr/>';
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
	$my_return .= '<div class="imdb-load-more"><input type="button"  id="imdbLoadMore" value="Load More"></div>';}



$id_check = substr($id,0,2);
if($id_check == "ls") {
	$my_return .= '<span style="text-align: right;display: block">Source:&nbsp;<a href="https://imdb.com/list/' . $id . '/" target="_blank">imdb.com</a></span>';
}
