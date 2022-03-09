<?php
require_once("../../../../../wp-load.php");
if(isset($_POST['imdb_id'])){
	require_once ("../classes/class.imdb.php");
	$IMDB = new shimdb_imdb_grab();
	$imdb_id = $_POST['imdb_id'];
	if ( substr( $imdb_id, 0, 2 ) == "nm" ) {
		$type = "name";
	}else{
		$type = "title";
	}
	$c = $IMDB->grab_imdb($imdb_id,$type);

	if($type=="title") {
		$itemCrew = array();
		if ( $c->directors != "" ) {
			$itemCrew[] = "<b>".$IMDB->lang('Director').":</b> " . $c->directors;
		}
		if ( $c->stars != "" ) {
			$itemCrew[] = "<b>".$IMDB->lang('Stars').":</b> " . $c->stars;
		}
		$mycrew   = implode( ' <br/> <br/>', $itemCrew );
		$statItem = array();
		if ( $c->votes != "" ) {
			$statItem[] = "<b>".$IMDB->lang('Votes').":</b> " . $c->votes;
		}
		if ( $c->budget != "" ) {
			$statItem[] = "<b>".$IMDB->lang('Gross').":</b> " . str_replace("estimated",$IMDB->lang('estimated'),$c->budget);
		}
		$mystat    = implode( ' | ', $statItem );
		$met_color = '#ff0000';
		if ( $c->metascore != "" ) {
			if ( $c->metascore > 39 ) {
				$met_color = '#ffcc33';
			}
			if ( $c->metascore > 59 ) {
				$met_color = '#61c74f';
			}
			$metascore = '<span class="imdb-metascore" style="background: ' . $met_color . '"><b>' . $c->metascore . '</b></span>&nbsp;<b style="margin-right: 40px !important;">Metascore</b>';
		} else {
			$metascore = "&nbsp;&nbsp;&nbsp;";
		}
		if ( $c->rating != "" ) {
			$rating = '<div class="imdb-title-list-rating" style="margin-right: 40px!important;"><strong style="font-size:18px !important;"> ' . $c->rating . '</strong></div>';
		} else {
			$rating = "";
		}
	}
	if(isset($c->trailer->thumb)!="") {

			$vid = '<div class="imdb-p-trailer" style="background: url(' . $c->trailer->thumb . ') no-repeat center center;background-size:cover;">
				<a href="' . $c->trailer->link . '" target="_blank" >
					<img style="top: 50%; bottom: 50%;margin-left: auto !important; margin-right: auto  !important;" src="' . SHIMDB_URL . 'includes/assets/player.png">
				</a>	
		    </div>';

	}else{
		$vid="";
	}

	if($_POST['tube'] !=""){
		$youtube = $IMDB->get_youtube($_POST['tube']);
		$yhtml = '<iframe style="width:100%!important; height:100% !important" src="https://www.youtube.com/embed/'.$_POST['tube'].'?autoplay='.$_POST['autoplay'].'" frameborder="0" allowfullscreen></iframe>';
		$vid = '<div class="imdb-p-trailer" style="background: url(' . $youtube->thumbnail_url . ') no-repeat center center;background-size:cover;">
					'.$yhtml.'
		    </div>';
	}



	$arr = array();

	$arr['imdb_id'] = $imdb_id;
	$arr['position'] = "fixed";
	$arr['top'] = "30";
	$arr['source'] = $IMDB->lang('Source');
	global $wpdb;
	$check = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'options WHERE option_name="shortcode-imdb-ex-popups-settigs"');
	if(count($check)>0){
		foreach ($check as $ce) {
			$element = json_decode($ce->option_value);
			$arr['position'] = $element->position;
			$arr['top'] = $element->top;
		}
	}

	$arr['url'] = SHIMDB_URL;
	$api = $IMDB->api_exist();
	$key = $IMDB->get_secret_key( $api );
	$ext = $IMDB->ExtentionCheck();
	$arr['vid'] = $vid;

	if($type == "title"){
		$arr['title'] = $c->title.(isset($c->year) ? ' ('.$c->year.')': "");
		$Genres = array();
		$genre_arr = explode(',',$c->genres);
		foreach ($genre_arr as $g){
			$Genres[] = $IMDB->lang(trim($g));
		}
		$arr['genres'] = implode(', ',$Genres);
		$arr['rating'] = $rating;
		$arr['metascore'] = $metascore;
		$arr['stats'] = implode(' | ',$statItem);
		$arr['poster'] = $IMDB->perfect_image_converter($c->poster,180,290);
		$arr['crew'] = $mycrew;
		$arr['sum'] = $c->sum;
		$arr['country'] = $c->country;
		$arr['lang'] = $c->lang;
		$arr['summary_title'] = $IMDB->lang('Summary');
		$arr['country_title'] = $IMDB->lang('Countries');
		$arr['lang_title'] = $IMDB->lang('Languages');
		$pop_title   = $IMDB->decrypt( $ext['popups_title'], $key );
		$x = $IMDB->html_fetcher($arr,$pop_title);

	}else{
		$arr['name'] = $c->name;
		$myjobs = explode(',',$c->jobs);
		$job_tr = array();
		foreach ($myjobs as $j){
			$job_tr[] = $IMDB->lang(trim($j));
		}
		$arr['jobs'] = implode(', ',$job_tr);
		$arr['photo'] = $IMDB->perfect_image_converter($c->photo,180,290);
		$arr['born'] = str_replace(" in"," |",$IMDB->date_translator($c->born));
		$Death = str_replace(" in"," |",$IMDB->date_translator($c->death));
		$Death = str_replace('age ',$IMDB->lang('age').' ',$Death);
		$arr['death'] = ($c->death!="---" ? "<br/><br/><b>".$IMDB->lang('Died').":</b> ".$Death : "");
		$arr['bio'] = $c->bio;
		$arr['bio_title'] = $IMDB->lang('Biography');
		$arr['born_title'] = $IMDB->lang('Born');
		$pop_name   = $IMDB->decrypt( $ext['popups_name'], $key );
		$x = $IMDB->html_fetcher($arr,$pop_name);

	}

echo $x;

}
