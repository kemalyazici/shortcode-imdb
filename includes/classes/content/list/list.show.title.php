<?php
/**
 * @var shimdb_imdb_grab $id
 * @var shimdb_imdb_grab $cache
 * @var shimdb_imdb_grab $image_size
 * @var shimdb_imdb_grab $args
 * @var shimdb_imdb_grab $my_return
 * @var shimdb_imdb_grab $this
 */
	global $wpdb;
	if(!isset($cache->howmanypage)){
		$check_load_more = $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE imdb_id="'.$cache->id.'-page"');
	}else{
		$check_load_more = $cache->howmanypage-1;
	}

	/************************** SHOW TYPE ************************************/
	$scType = "title-list";
	/**********************************  NORMAL *****************************************/
	$my_return .= '<div id="imdb-list-page">';
	$count_my_grid = 4;
	$count_my_grid_end = 7;
	foreach ($cache->content as  $c){
		//Mini info
		$arr_minis = array();
		if($c->certificate !=""){
			$arr_minis[] = $c->certificate;
		}


		if($c->runtime !=""){
			$arr_minis[] = str_replace("min",$this->lang("min"),$c->runtime);
		}
		if($c->genre !=""){
			$Genre_arr = explode(',',$c->genre);
			$Genres = array();
			foreach ($Genre_arr as $g){
				$Genres[] = $this->lang(trim($g));
			}
			$arr_minis[] = implode(', ',$Genres);
		}
		$mini = implode(' | ',$arr_minis);

		$met_color = '#ff0000';
		if($c->metascore !=""){
			if($c->metascore>39){
				$met_color = '#ffcc33';
			}
			if($c->metascore>59){
				$met_color = '#61c74f';
			}
			$metascore = '<span class="imdb-metascore" style="background: '.$met_color.'">'.$c->metascore.'</span>&nbsp;Metascore';
		}else{
			$metascore = "&nbsp;&nbsp;&nbsp;";
		}
		if($c->rating != ""){
			$rating = '<div class="imdb-title-list-rating"><strong>'.$c->rating.' IMDb</strong></div>';
		}else{
			$rating = "";
		}

		$itemCrew = array();
		if($c->directors!=""){
			$itemCrew[] = $this->lang('Director').": ".$c->directors;
		}
		if($c->stars!=""){
			$itemCrew[] = $this->lang('Stars').": ".$c->stars;
		}
		$mycrew = implode(' | ',$itemCrew);

		$statItem = array();
		if($c->vote!=""){
			$statItem[] = $this->lang('Votes').": ".$c->vote;
		}
		if($c->gross!=""){
			$statItem[] = $this->lang('Gross').": ".$c->gross;
		}

		$mystat = implode(' | ',$statItem);

		//Mini info
		$list_bg = "background:#f6f6f5;";
		$container ="";
		if(!isset($args['show'])) {
			if(isset($args['bg'])){
				$color_text = isset($args['text']) ? '#'.$args['text'] : "inherit";
				$list_bg = $args['bg']=="transparent" ? "color:inherit!important" : "background:#".$args['bg'].'!important;color:'.$color_text.'!important';
				$container = '-style';
			}
			//Default skin
			$my_return .= '<div class="imdb-list-title-container'.$container.'" style="'.$list_bg.'">';
			$my_return .= '<div class="imdb-list-title-wrap">';
			$my_return .= '<div class="imdb-title-list-poster"><a href="https://imdb.com/title/' . $c->imdb_id . '" target="_blank"><img src="' . $c->poster . '"/></a></div>';
			$my_return .= '<div class="imdb-title-list-content">';
			$my_return .= '<span class="imdb-list-title-small">' . $c->num . "</span> " .
			     '<span class="imdb-list-title-big"><a href="https://imdb.com/title/' .
			     $c->imdb_id . '" target="_blank">' . $c->title
			     . "</a></span> " .
			     '<span class="imdb-list-title-small"">' . $c->year . '</span>';
			$my_return .= '<span class="imdb-list-title-mini">' . $mini . '</span>';
			$my_return .= '<span class="imdb-list-title-medium">'.$rating.$metascore.'</span>';
			$my_return .= '<div class="imdb-list-title-desc">'.(trim($c->desc)=="Add a Plot" ? "No summary yet..." : $this->text_cleaner($c->desc)).'</div>';
			$my_return .= '<div class="imdb-list-title-medium">'.$mycrew.'</div>';
			$my_return .= '<div class="imdb-list-title-medium">'.$mystat.'</div>';
			$my_return .= '</div>';
			$my_return .= '</div>';
			$my_return .= '<div style="clear:both"></div>';
			$my_return .= '<div class="imdb-list-title-listdesc"><i>'.$c->list_desc.'</i></div>';
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
			$my_return .= '<a href="https://imdb.com/title/' . $c->imdb_id . '" target="_blank">
			<img src="' . $this->perfect_image_converter($c->poster,300,450) . '"/>			
			</a>';
			$my_return .= '<span class="imdb-grid-info'.$grid_position.'">
					<div class="imdb-grid-info-content">
						<div class="grid-info-title">'.$c->num .' <a href="https://imdb.com/title/' .
			     $c->imdb_id . '" target="_blank">'.$c->title.'</a> '.$c->year.'</div>
						<span class="imdb-list-title-mini">' . $mini . '</span>
						<span class="imdb-list-title-medium">'.$rating.$metascore.'</span>
						<br/><div class="imdb-list-title-desc">'.(trim($c->desc)=="Add a Plot" ? "No summary yet..." : $this->text_cleaner($c->desc)).'</div>
						<div class="imdb-list-title-medium">'.$mycrew.'</div>
						<div class="imdb-list-title-medium">'.$mystat.'</div>
					</div>
					<div style="clear:both"></div>
					<div class="imdb-list-title-listdesc"><i>'.$c->list_desc.'</i></div>					            			
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
					<input type="hidden" id="imdb-list-bg" value="'.$list_bg.'">
					<input type="hidden" id="shimdbURL" value="'.SHIMDB_URL.'">					
					<input type="hidden" id="imdb-arg-show" value="'.(isset($args['show']) ? $args['show'] : "yok").'">		
	    </div>';
	if($check_load_more>0){
		$my_return .= '<div class="imdb-load-more"><input type="button"  id="imdbLoadMore" value="Load More"></div>';
	}

$id_check = substr($cache->list_id,0,2);
if($id_check == "ls") {
	$my_return .= '<br/><div class="imdb-list-source" style="text-align: right">'.$this->lang('Source').': <a href="https://imdb.com/list/' . $cache->list_id . '" target="_blank">imdb.com</a></div>';
}

