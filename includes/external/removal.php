<?php
if(isset($_POST['imdb-id'])){
	$id = $_POST['imdb-id'];
	$all = $_POST['ids'];
	$ids = explode(',',$all);
	foreach ($ids  as $k => $i){
		if($i == $id){
			unset($ids[$k]);
		}
	}
	echo implode(',',$ids);
}