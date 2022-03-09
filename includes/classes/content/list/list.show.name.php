<?php
/**
 * @var shimdb_imdb_grab $id
 * @var shimdb_imdb_grab $cache
 * @var shimdb_imdb_grab $image_size
 * @var shimdb_imdb_grab $my_return
 * @var shimdb_imdb_grab $args
 */
global $wpdb;
if(!isset($cache->howmanypage)){
	$check_load_more = $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE imdb_id="'.$cache->id.'-page"');
}else{
	$check_load_more = $cache->howmanypage-1;
}

/************************** SHOW TYPE ************************************/
$scType = "name-list";
$my_return .= '<div id="imdb-list-page">';

$count_my_grid = 4;
$count_my_grid_end = 7;
foreach ($cache->content as  $c){

	$mini = $this->lang($c->gender). " | ".$c->bestTitle;
	$container ="";
	if(!isset($args['show'])) {
		$list_bg = "background:#f6f6f5;";
		if(isset($args['bg'])){
			$color_text = isset($args['text']) ? '#'.$args['text'] : "inherit";
			$list_bg = $args['bg']=="transparent" ? "color:inherit!important" : "background:#".$args['bg'].'!important;color:'.$color_text.'!important';
			$container = '-style';
		}

		//Default skin
		$my_return .= '<div class="imdb-list-title-container'.$container.'" style="'.$list_bg.'">';
		$my_return .= '<div class="imdb-list-title-wrap">';
		$my_return .= '<div class="imdb-title-list-poster"><a href="' . $c->name_link . '" target="_blank"><img src="' . $c->photo . '"/></a></div>';
		$my_return .= '<div class="imdb-title-list-content">';
		$my_return .= '<span class="imdb-list-title-small">' . $c->num . '</span>'  .
		     '<span class="imdb-list-title-big">' . $c->name. '</span>';
		$my_return .= '<span class="imdb-list-title-mini">' . $mini . '</span>';
		$my_return .= '<div class="imdb-list-title-desc">'.(trim($c->bio)=="Add a Plot" ? "No summary yet..." : $c->bio).'</div>';
		$my_return .= '</div>';
		$my_return .= '</div>';
		$my_return .= '<div style="clear:both"></div>';
		$my_return .= '<div class="imdb-list-title-listdesc"><i>'.$c->desc.'</i></div>';
		$my_return .= '</div>';
	}else if(@$args['show'] = "grid"){
		// Grid skin
		if($count_my_grid % 4==0){
			$my_return .= '<div class="imdb-list-title-grid-container">';
		}
		$grid_position = "";
		if(($count_my_grid ==  $count_my_grid_end-1) OR ($count_my_grid ==  $count_my_grid_end)){
			$grid_position = "-left";
		}
		$my_return .= '<div class="imdb-list-title-grid">';
		$my_return .= '<a href="' . $c->name_link . '" target="_blank">
			<img src="' . $this->perfect_image_converter($c->photo,300,450) . '"/>			
			</a>';
		$my_return .= '<span class="imdb-grid-info'.$grid_position.'">
					<div class="imdb-grid-info-content">
						<span class="imdb-list-title-small">' . $c->num . '</span>
		            	<span class="imdb-list-title-big">' . $c->name. '</span>
		            	<span class="imdb-list-title-mini">' . $mini . '</span>
		            	<div class="imdb-list-title-desc">'.(trim($c->bio)=="Add a Plot" ? "No summary yet..." : $c->bio).'</div>
		            	<div class="imdb-list-title-listdesc"><i>'.$c->desc.'</i></div>
					</div>
					<div style="clear:both"></div>
					<div class="imdb-list-title-listdesc"><i>'.isset($c->list_desc).'</i></div>					            			
        	</span>';


		$my_return .= '</div>';
		if($count_my_grid_end == $count_my_grid) {
			$count_my_grid_end = $count_my_grid+4;
			$my_return .= '</div>';
		}
	}
	$count_my_grid++;



}



$my_return .= '</div>';
$my_return .= '<div id="imdb-scroll-to">
					<input type="hidden" id="imdb-scroll-type" value="'.$scType.'">
					<input type="hidden" id="imdb-scroll-page" value="2">
					<input type="hidden" id="imdb-list-id" value="'.$cache->id.'">
					<input type="hidden" id="imdb-list-real-id" value="'.$cache->list_id.'">
					<input type="hidden" id="imdb-list-bg" value="'.isset($list_bg).'">
					<input type="hidden" id="shimdbURL" value="'.SHIMDB_URL.'">					
					<input type="hidden" id="imdb-arg-show" value="'.(isset($args['show']) ? $args['show'] : "yok").'">		
	    </div><br/>';
	if($check_load_more>0){
		$my_return .= '<div class="imdb-load-more"><input type="button"  id="imdbLoadMore" value="Load More"></div>';
	}
	$my_return .= '<br/><div class="imdb-list-source" style="text-align: right">Source: <a href="https://imdb.com/list/'.$cache->list_id.'" target="_blank">imdb.com</a></div>';