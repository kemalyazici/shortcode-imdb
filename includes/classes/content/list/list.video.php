<?php
/**
 * @var shimdb_imdb_grab $id
 * * @var shimdb_imdb_grab $listarr
 * @var shimdb_imdb_grab $type
 * @var shimdb_imdb_grab $ext_dom_key
 * * @var shimdb_imdb_grab $Title
 * @var shimdb_imdb_grab $key
 * @var shimdb_imdb_grab $howmanypage
 */
$listarr['type'] = 'video';
$VideoList = json_decode($this->decrypt($ext_dom_key['VideoList'], $key));
$i=1;
$firstarr = array();
while($i<=$howmanypage) {
	//While=
	if($i == 2){
		$lastID = $wpdb->insert_id;
	}
	$listarr['content'] = array();
	if($i>1){
		$pathx = $this->list_dom($id,$i);
		$xpath = $pathx['xpath'];
	}
	@$videoList = $xpath->query($VideoList->main); //VideoList -main
	if ($videoList->length > 0) {
		foreach ($videoList as $videocount => $v) {
			//=Foreach Begins
			//Title
			$xpath2 = $this->html_dom($v,$pathx['dom']);
			@$title = $xpath2->query($VideoList->header); //VideoList -header
			if (@$title->length>0) {
				$titleLink = $xpath2->query($VideoList->header.'/@href');
				@$titleLink = $titleLink->length>0 ? $titleLink->item(0)->nodeValue : "#";
				$listarr['content'][$videocount]['title'] = mb_convert_encoding($title->item(0)->nodeValue, 'HTML-ENTITIES', 'UTF-8');
				$listarr['content'][$videocount]['titleLink'] = "https://imdb.com".$titleLink;
			}else{
				$listarr['content'][$videocount]['title'] = "";
				$listarr['content'][$videocount]['titleLink'] = "";


			}
			//Muted
			@$muted = $xpath2->query($VideoList->muted); // VideoList -muted
			if(@$muted->length>0){
				$listarr['content'][$videocount]['muted'] = $muted->item(0)->nodeValue;
			}else{
				$listarr['content'][$videocount]['muted'] = "";

			}
			//Video image link
			@$VideoImageLink = $xpath2->query($VideoList->VideoImageLink); //VideoList -VideoImageLink;
			if(@$VideoImageLink->length>0){
				$VideoImageLink = 'https://imdb.com'.$VideoImageLink->item(0)->nodeValue;
				$listarr['content'][$videocount]['VideoImageLink'] = $VideoImageLink;
			}else{
				$listarr['content'][$videocount]['VideoImageLink'] = "#";

			}
			//VideoImage
			@$VideoImage = $xpath2->query($VideoList->VideoImage); //VideoList -VideoImage;
			if(@$VideoImage->length){
				$VideoImage = $this->imdb_image_convertor($VideoImage->item(0)->nodeValue);
				$listarr['content'][$videocount]['VideoImage'] = $VideoImage;

			}else{
				$listarr['content'][$videocount]['VideoImage'] = "";

			}
			//Video Description
			@$VideoDesc = $xpath2->query($VideoList->VideoDesc); // VideoList -VideoDesc
			if(@$VideoDesc->length>0){
				$VideoDesc = mb_convert_encoding($VideoDesc->item(0)->nodeValue, 'HTML-ENTITIES', 'UTF-8');
				$listarr['content'][$videocount]['VideoDesc'] = $VideoDesc;
			}else{
				$listarr['content'][$videocount]['VideoDesc'] = "";

			}



			//=Foreach end
		}
	}
	if($i==1){
		$firstarr = $listarr;
	}
	$arr = base64_encode( json_encode( $listarr ) );
	$typeList  = $i==1 ? 'listvideo' : "listpage";
	$listID  = $i==1 ? $id : $lastID.'-page';
	$wpdb->query( 'INSERT INTO ' . $wpdb->prefix . 'shortcode_imdb_cache (imdb_id,title,type,cache,page) VALUES ("' . $listID . '","' . $Title . '","'.$typeList.'","' . $arr . '",'.$i.')' );

	$i++;
	//=While Ends
}
$listarr = $firstarr;
header("location: " . $_SERVER['REQUEST_URI']);