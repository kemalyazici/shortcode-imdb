<?php
require_once("../../../../../wp-load.php");
if(isset($_POST['imdb_scroll_type'])){
	$scType = $_POST['imdb_scroll_type'];
	$svPage = $_POST['imdb_page'];
	$show_args = $_POST['arg_show'];
	$imdbID = $_POST['imdb_id'];
	$IMDB = new shimdb_imdb_grab();

	$listID = $_POST['list_id'].'-page';


	$mcache = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE imdb_id="'.esc_sql($listID).'" AND page='.absint($svPage));
	@$chech_last_page = $wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE imdb_id="'.esc_sql($listID).'" AND page='.absint($svPage+1));
	if(count($mcache)>0) {
		//List Çeşitleri
		$cache= "";
		$count_my_grid = 4;
		$count_my_grid_end = 7;
		foreach ($mcache as $c) {
			$cache = json_decode(base64_decode($c->cache));
		}
		/************************************************** TITLE **********************************************/
		if ( $scType == "title-list" ) {
			foreach ($cache->content as $c){

				$list_poster = file_exists($c->poster) ? $c->poster : SHIMDB_URL.'includes/assets/noposter.png';
				//Mini info
				$arr_minis = array();
				if($c->certificate !=""){
					$arr_minis[] = $c->certificate;
				}
				if($c->runtime !=""){
					$arr_minis[] = str_replace("min",$IMDB->lang("min"),$c->runtime);;
				}
				if($c->genre !=""){
					$Genre_arr = explode(',',$c->genre);
					$Genres = array();
					foreach ($Genre_arr as $g){
						$Genres[] = $IMDB->lang(trim($g));
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
					$itemCrew[] = $IMDB->lang('Director').": ".$c->directors;
				}
				if($c->stars!=""){
					$itemCrew[] = $IMDB->lang('Stars').": ".$c->stars;
				}
				$mycrew = implode(' | ',$itemCrew);

				$statItem = array();
				if($c->vote!=""){
					$statItem[] = $IMDB->lang('Votes').": ".$c->vote;
				}
				if($c->gross!=""){
					$statItem[] = $IMDB->lang('Gross').": ".$c->gross;
				}

				$mystat = implode(' | ',$statItem);

				//Mini info
				if($show_args=="yok") {
					$list_bg = $_POST['list_bg'];
					//Default skin
					echo '<div class="imdb-list-title-container" style="'.$list_bg.'">';
					echo '<div class="imdb-list-title-wrap">';
					echo '<div class="imdb-title-list-poster"><a href="https://imdb.com/title/' . $c->imdb_id . '" target="_blank"><img src="' . $c->poster . '"/></a></div>';
					echo '<div class="imdb-title-list-content">';
					echo '<span class="imdb-list-title-small">' . $c->num . "</span> " .
					     '<span class="imdb-list-title-big"><a href="https://imdb.com/title/' .
					     $c->imdb_id . '" target="_blank">' . $c->title
					     . "</span></a> " .
					     '<span class="imdb-list-title-small"">' . $c->year . '</span><br/>';
					echo '<span class="imdb-list-title-mini">' . $mini . '</span>';
					echo '<span class="imdb-list-title-medium">'.$rating.$metascore.'</span>';
					echo '<div class="imdb-list-title-desc">'.(trim($c->desc)=="Add a Plot" ? "No summary yet..." : $c->desc).'</div>';
					echo '<div class="imdb-list-title-medium">'.$mycrew.'</div>';
					echo '<div class="imdb-list-title-medium">'.$mystat.'</div>';
					echo '</div>';
					echo '</div>';
					echo '<div style="clear:both"></div>';
					echo '<div class="imdb-list-title-listdesc"><i>'.$c->list_desc.'</i></div>';
					echo '</div>';
					echo '<input type="hidden" class="hidden-imdb-page" value="'.($svPage+1).'">';
					if($chech_last_page==0) {
						echo '<div id="imdb-list-end-here"></div>';
					}
				}
				else if($show_args == "grid"){
					// Grid skin
					if($count_my_grid % 4==0){
						echo '<div class="imdb-list-title-grid-container">';
					}
					$grid_position = "";
					if(($count_my_grid ==  $count_my_grid_end-1) OR ($count_my_grid ==  $count_my_grid_end)){
						$grid_position = "-left";
					}
					echo '<div class="imdb-list-title-grid">';
					echo '<a href="https://imdb.com/title/' . $c->imdb_id . '" target="_blank">
			<img src="' . $IMDB->perfect_image_converter($c->poster,300,450). '"/>		
			</a>';
					echo '<span class="imdb-grid-info'.$grid_position.'">
					<div class="imdb-grid-info-content">
						<div class="grid-info-title">'.$c->num .' <a href="https://imdb.com/title/' .
					     $c->imdb_id . '" target="_blank">'.$c->title.'</a> '.$c->year.'</div>
						<span class="imdb-list-title-mini">' . $mini . '</span>
						<span class="imdb-list-title-medium">'.$rating.$metascore.'</span>
						<br/><div class="imdb-list-title-desc">'.(trim($c->desc)=="Add a Plot" ? "No summary yet..." : $c->desc).'</div>
						<div class="imdb-list-title-medium">'.$mycrew.'</div>
						<div class="imdb-list-title-medium">'.$mystat.'</div>
						<div style="clear:both"></div>
						<div class="imdb-list-title-listdesc"><i>'.$c->list_desc.'</i></div>	
					</div>
            			
        	</span>';

					echo '</div>';
					if($count_my_grid_end == $count_my_grid) {
						$count_my_grid_end = $count_my_grid+4;
						echo '</div>';
					}
				}
				if($chech_last_page==0) {
					echo '<div id="imdb-list-end-here"></div>';
				}

				$count_my_grid++;

			}
		}
		/******************************** NAME ***********************************************************/
		else if($scType == "name-list" ){
			$count_my_grid = 4;
			$count_my_grid_end = 7;
			foreach ($cache->content as  $c){

				$mini = $IMDB->lang($c->gender). " | ".$c->bestTitle;
				if($show_args == "yok") {
					$list_bg = "background:#f6f6f5;";
					if(isset($args['style'])){
						$list_bg = $args['style']=="transparent" ? "" : "background:#".$args['style'];
					}

					//Default skin
					echo '<div class="imdb-list-title-container" style="'.$list_bg.'">';
					echo '<div class="imdb-list-title-wrap">';
					echo '<div class="imdb-title-list-poster"><a href="' . $c->name_link . '" target="_blank"><img src="' . $c->photo . '"/></a></div>';
					echo '<div class="imdb-title-list-content">';
					echo '<span class="imdb-list-title-small">' . $c->num . "</span> " .
					     '<span class="imdb-list-title-big">' . $c->name
					     . '</span>';
					echo '<span class="imdb-list-title-mini">' . $mini . '</span>';
					echo '<div class="imdb-list-title-desc">'.(trim($c->bio)=="Add a Plot" ? "No summary yet..." : $c->bio).'</div>';
					echo '</div>';
					echo '</div>';
					echo '<div style="clear:both"></div>';
					echo '<div class="imdb-list-title-listdesc"><i>'.$c->desc.'</i></div>';
					echo '</div>';
				}else if($show_args == "grid"){
					if($count_my_grid % 4==0){
						echo '<div class="imdb-list-title-grid-container">';
					}
					$grid_position = "";
					if(($count_my_grid ==  $count_my_grid_end-1) OR ($count_my_grid ==  $count_my_grid_end)){
						$grid_position = "-left";
					}
					echo '<div class="imdb-list-title-grid">';
					echo '<a href="' . $c->name_link . '" target="_blank">
							<img src="' . $IMDB->perfect_image_converter($c->photo,300,450) . '"/>			
							</a>';
					echo '<span class="imdb-grid-info'.$grid_position.'">
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


					echo '</div>';
					if($count_my_grid_end == $count_my_grid) {
						$count_my_grid_end = $count_my_grid+4;
						echo '</div>';
					}
				}
				$count_my_grid++;

			}
			if($chech_last_page==0) {
				echo '<div id="imdb-list-end-here"></div>';
			}


		}
		/************************     IMAGE  **********************************/
		else if($scType=="image-list"){

			foreach ($cache->content as $c){
				echo '<div class="imdb-list-image">
                                <img src="' . $IMDB->imdb_image_convertor($c->image,'x:660') . '"/>
                                <div class="top-left">' . $c->num . '</div>
                             </div><br/>';
				echo '<div class="imdb-list-container">'.mb_convert_encoding($c->desc, 'HTML-ENTITIES', 'UTF-8') . "</div><br/><hr/>";
			}

			if($chech_last_page==0) {
				echo '<div id="imdb-list-end-here"></div>';
			}
		}
		/*****************************  VIDEO LIST ***********************************/
		else if($scType=="video-list"){
			echo "<div class='imdb-video-header'><a href='" . $c->titleLink . "' target='_blank'>" . $c->title . '</a></div>';
			echo '<small>'.$c->muted.'</small>';
			echo '<div class="imdb-list-image">
                                          <a href = "'.$c->VideoImageLink.'" target="_blank">
                                             <img src="'.$this->imdb_image_convertor($c->VideoImage,"x:660").'">
                                          </a>
                               <div class="centered">
                                          <a href = "'.$c->VideoImageLink.'" target="_blank">
                                             <img src="'.SHIMDB_URL.'includes/assets/player.png">
                                         </a>
                               </div>
                            </div>';
			echo '<p>'.$c->VideoDesc.'</p>';
			echo '<hr/>';
		}




	}

}