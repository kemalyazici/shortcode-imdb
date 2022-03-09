<?php
/**
 * @var shimdb_imdb_grab $id
 * * @var shimdb_imdb_grab $listarr
 * @var shimdb_imdb_grab $type
 * @var shimdb_imdb_grab $ext_dom_key
 * @var shimdb_imdb_grab $key
 * @var shimdb_imdb_grab $howmanypage
 */
/********************** START ********************************/

//IMAGE LIST
if ($type == "images") {

	include SHIMDB_ROOT."includes/classes/content/list/list.image.php";

}
// VIDEO LIST
else if($type=="videos"){

	include SHIMDB_ROOT."includes/classes/content/list/list.video.php";

}
//TITLE LIST
else if($type=="titles"){

	include SHIMDB_ROOT."includes/classes/content/list/list.title.php";

}
else if($type=="names"){
	include SHIMDB_ROOT."includes/classes/content/list/list.name.php";
}

/********************** END********************************/