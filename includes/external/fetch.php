<?php
require_once("../../../../../wp-load.php");
if(isset($_POST['imdb-id'])){
    require_once ("../classes/class.imdb.php");
    $data = array();
    $IMDB = new shimdb_imdb_grab();
    $imdbID = trim($_POST['imdb-id']);
	$Type = $_POST['imdb-type'];
	$Added = $_POST['imdb-added'];
	$data['addedCheck'] = "true";
	if($Added !=""){
		$added = explode(',',$Added);
		if(!in_array($imdbID,$added)){
			$added[] = $imdbID;
		}else{
			$data['addedCheck'] = "false";
		}
		$Added = implode(',',$added);
	}else{
		$Added = $imdbID;
	}
	$data['added'] = $Added;
	if($Type == "title" OR $Type == "name"){
		$output = $IMDB->grab_imdb($imdbID,$Type);
		$data['content']              = $output;
		if($Type=="title") {
			$data['title']['imdb_id']     = $imdbID;
			$data['title']['poster']      = $output->poster;
			$data['title']['title']       = $output->title;
			$data['title']['year']        = $output->year;
			$data['title']['certificate'] = $output->certificate;
			$data['title']['runtime']     = $output->runtime;
			$data['title']['genre']       = $output->genres;
			$data['title']['metascore']   = $output->metascore;
			$data['title']['rating']      = $output->rating;
			$data['title']['vote']        = $output->votes;
			$data['title']['gross']       = $output->gross;
			$data['title']['director']    = $output->directors;
			$data['title']['stars']       = $output->stars;
			$data['enc']                  = base64_encode( json_encode( $data['title'] ) );
		}else{
			$data['name']['imdb_id'] = $imdbID;
			$data['name']['bestTitle'] = $output->bestTitle;
			$data['name']['photo'] = $output->photo;
			$data['name']['name'] = '<a href="https://imdb.com/name/'.$imdbID.'/" target="_blank">'.mb_convert_encoding($output->name, 'HTML-ENTITIES', 'UTF-8').'</a>';
			$data['name']['name2'] = mb_convert_encoding($output->name, 'HTML-ENTITIES', 'UTF-8');
			$data['name']['name_link'] = 'https://imdb.com/name/'.$imdbID.'/';
			$jobs = explode(',',$output->jobs);
			$gender = trim($jobs[0]);
			$data['name']['gender'] = $gender;
			$data['enc']                  = base64_encode( json_encode( $data['name'] ) );
		}


		echo json_encode($data);
	}


}
