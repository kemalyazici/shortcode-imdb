<?php
/**
 * @var shimdb_imdb_grab $id
 * @var shimdb_imdb_grab $listarr
 * @var shimdb_imdb_grab $type
 * @var shimdb_imdb_grab $ext_dom_key
 * @var shimdb_imdb_grab $key
 * * @var shimdb_imdb_grab $wpdb
 * * @var shimdb_imdb_grab $Title
 * @var shimdb_imdb_grab $howmanypage
 */
$listarr['type'] = 'name';
$i=1;
$NameList = json_decode($this->decrypt($ext_dom_key['NameList'], $key));
$firstarr= array();

while($i<=$howmanypage){
	if($i == 2){
		$lastID = $wpdb->insert_id;
	}
	$listarr['content'] = array();
	if($i>1){
		$pathx = $this->list_dom($id,$i);
		$xpath = $pathx['xpath'];
	}
	@$nameItem = $xpath->query($NameList->nameItem);
	if(@$nameItem->length>0){
		foreach ($nameItem as $k => $item){
			$xp = $this->html_dom($item,$pathx['dom']);
			@$photo = $xp->query($NameList->photo);
			if(@$photo->length>0){
				$listarr['content'][$k]['photo'] = $photo->item(0)->nodeValue;
			}else{
				$listarr['content'][$k]['photo'] = "";
			}
			@$nameIMDB = $xp->query($NameList->nameIMDB);
			if(@$nameIMDB->length>0){
				$name_link = $nameIMDB->item(0)->getAttribute('href');
				$listarr['content'][$k]['name_link'] = 'https://imdb.com'.$name_link;
				$listarr['content'][$k]['name'] = '<a href="https://imdb.com'.$name_link.'" target="_blank">'.mb_convert_encoding(utf8_decode($nameIMDB->item(0)->nodeValue), 'HTML-ENTITIES', 'UTF-8').'</a>';
			}else{
				$listarr['content'][$k]['name_link'] = "";
				$listarr['content'][$k]['name'] = "";
			}

			@$numItem = $xp->query($NameList->numItem);
			if(@$numItem->length>0){
				$listarr['content'][$k]['num'] = $numItem->item(0)->nodeValue;
			}else{
				$listarr['content'][$k]['num'] = "";
			}
			@$genderAc = $xp->query($NameList->genderAc);
			if(@$genderAc->length>0){
				$gender = explode('|',$genderAc->item(0)->nodeValue);
				$gender = trim($gender[0]);
				$listarr['content'][$k]['gender']  = $gender;
			}else{
				$listarr['content'][$k]['gender'] = "";
			}
			@$bestTitle = $xp->query($NameList->bestTitle);
			if(@$bestTitle->length>0){
				$bestT = mb_convert_encoding(utf8_decode($bestTitle->item(0)->nodeValue), 'HTML-ENTITIES', 'UTF-8');
				@$bestTLink =  $bestTitle->item(0)->getAttribute('href');
				$listarr['content'][$k]['bestTitle'] = '<a href="https://imdb.com'.$bestTLink.'" target="_blank">'.$bestT.'</a>';
			}else{
				$listarr['content'][$k]['bestTitle'] = "";
			}

			@$bio = $xp->query($NameList->bio);
			if(@$bio->length>0){
				$listarr['content'][$k]['bio'] =  mb_convert_encoding(utf8_decode($bio->item(1)->nodeValue), 'HTML-ENTITIES', 'UTF-8');
			}else{
				$listarr['content'][$k]['bio'] = "";
			}

			@$listDesc = $xp->query($NameList->listDesc);
			if(@$listDesc->length>0){
				$listarr['content'][$k]['desc'] =  mb_convert_encoding(utf8_decode($listDesc->item(0)->nodeValue), 'HTML-ENTITIES', 'UTF-8');
			}else{
				$listarr['content'][$k]['desc'] = "";
			}


		}

	}

	if($i==1){
		$firstarr = $listarr;
	}
	$arr = base64_encode( json_encode( $listarr ) );
	$typeList  = $i==1 ? 'list' : "listpage";
	$listID  = $i==1 ? $id : $lastID.'-page';
	$wpdb->query( 'INSERT INTO ' . $wpdb->prefix . 'shortcode_imdb_cache (imdb_id,title,type,cache,page) VALUES ("' . $listID . '","' . $Title . '","'.$typeList.'","' . $arr . '",'.$i.')' );

	$i++;
}
$listarr = $firstarr;
header("location: " . $_SERVER['REQUEST_URI']);
