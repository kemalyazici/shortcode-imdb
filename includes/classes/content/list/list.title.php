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

$listarr['type'] = 'title';
$i=1;
$TitleList = json_decode($this->decrypt($ext_dom_key['TitleList'], $key));
$fistarr = array();
while($i<=$howmanypage) {
	if($i == 2){
		$lastID = $wpdb->insert_id;
	}
	$listarr['content'] = array();
	if($i>1){
		$pathx = $this->list_dom($id,$i);
		$xpath = $pathx['xpath'];
	}
	@$titleItem = $xpath->query($TitleList->titleItem);
	if(@$titleItem->length>0){
		foreach ($titleItem as $titlecount => $item){

			$xp = $this->html_dom($item,$pathx['dom']);
			@$poster = $xp->query($TitleList->poster);
			if(@$poster->length>0){
				$listarr['content'][$titlecount]['poster'] = $poster->item(0)->nodeValue;
			}else{
				$listarr['content'][$titlecount]['poster'] = "";
			}

			@$titleIMDB = $xp->query($TitleList->titleIMDB);
			if(@$titleIMDB->length>0){
				$listarr['content'][$titlecount]['title'] = mb_convert_encoding(utf8_decode($titleIMDB->item(0)->nodeValue), 'HTML-ENTITIES', 'UTF-8');
			}else{
				$listarr['content'][$titlecount]['title'] = "";
			}
			@$yearItem = $xp->query($TitleList->year);
			if(@$yearItem->length>0){
				$listarr['content'][$titlecount]['year'] = utf8_decode($yearItem->item(0)->nodeValue);
			}else{
				$listarr['content'][$titlecount]['year'] = "";
			}

			@$numItem = $xp->query($TitleList->num);
			if(@$numItem->length>0){
				$listarr['content'][$titlecount]['num'] = $numItem->item(0)->nodeValue;
			}else{
				$listarr['content'][$titlecount]['num'] = "";
			}


			@$imdbID = $xp->query($TitleList->imdbID);
			if(@$imdbID->length>0){
				$listarr['content'][$titlecount]['imdb_id']  = $imdbID->item(0)->nodeValue;
			}else{
				$listarr['content'][$titlecount]['imdb_id'] = "";
			}


			@$titleRating = $xp->query($TitleList->titleRating);
			if(@$titleRating->length>0){
				$listarr['content'][$titlecount]['rating'] = $titleRating->item(0)->nodeValue;
			}
			else{
				$listarr['content'][$titlecount]['rating'] = "";
			}

			@$certificate = $xp->query($TitleList->certificate);
			if(@$certificate->length>0){
				$listarr['content'][$titlecount]['certificate'] = $certificate->item(0)->nodeValue;
			}else{
				$listarr['content'][$titlecount]['certificate'] = "";
			}



			@$runtime = $xp->query($TitleList->runtime);
			if(@$runtime->length>0){
				$listarr['content'][$titlecount]['runtime'] =$runtime->item(0)->nodeValue;
			}else{
				$listarr['content'][$titlecount]['runtime'] = "";
			}



			@$genre = $xp->query($TitleList->genre);
			if(@$genre->length>0){
				$listarr['content'][$titlecount]['genre'] = $genre->item(0)->nodeValue;
			}else{
				$listarr['content'][$titlecount]['genre'] = "";
			}

			@$metascrore = $xp->query($TitleList->metascore);
			if(@$metascrore->length>0){
				$listarr['content'][$titlecount]['metascore'] = $metascrore->item(0)->nodeValue;
			}else{
				$listarr['content'][$titlecount]['metascore'] = "";
			}

			@$desc = $xp->query($TitleList->desc);
			if(@$desc->length>0){
				$listarr['content'][$titlecount]['desc'] = mb_convert_encoding(utf8_decode($desc->item(0)->nodeValue), 'HTML-ENTITIES', 'UTF-8');
			}else{
				$listarr['content'][$titlecount]['desc'] = "";
			}


			@$listDesc = $xp->query($TitleList->listDesc);
			if(@$listDesc->length>0){
				$listarr['content'][$titlecount]['list_desc'] = mb_convert_encoding(utf8_decode($listDesc->item(0)->nodeValue), 'HTML-ENTITIES', 'UTF-8');
			}else{
				$listarr['content'][$titlecount]['list_desc'] = "";
			}

			$dr = array();
			$st = array();
			@$crew = $xp->query($TitleList->crew);
			if(@$crew->length>0){
				foreach ($crew as $c){
					$pLink = $c->getAttribute('href');
					$pName = $c->nodeValue;
					$checkP = explode('li_dr',$pLink);
					if(count($checkP)>1){
						$dr[] = '<a href="https://imdb.com'.$pLink.'" target="_blank">'.$pName."</a>";
					}else{
						$st[] = '<a href="https://imdb.com'.$pLink.'" target="_blank">'.$pName."</a>";
					}
				}
				$directors = implode(', ',$dr);
				$stars = implode(', ',$st);
				$listarr['content'][$titlecount]['directors'] = mb_convert_encoding(utf8_decode($directors), 'HTML-ENTITIES', 'UTF-8');
				$listarr['content'][$titlecount]['stars'] = mb_convert_encoding(utf8_decode($stars), 'HTML-ENTITIES', 'UTF-8');
			}else{
				$listarr['content'][$titlecount]['directors'] = "";
				$listarr['content'][$titlecount]['stars'] = "";
			}
			@$stat = $xp->query($TitleList->stat);
			if(@$stat->length>0){
				$vote = $stat->item(0)->nodeValue;
				$gross = $stat->item(1)->nodeValue;
				$listarr['content'][$titlecount]['vote'] = $vote;
				$listarr['content'][$titlecount]['gross'] = $gross;
			}else{
				$listarr['content'][$titlecount]['vote'] = "";
				$listarr['content'][$titlecount]['gross'] = "";
			}

		}


	}
	if($i==1){
		$fistarr = $listarr;
	}
	$arr = base64_encode( json_encode( $listarr ) );
	$typeList  = $i==1 ? 'list' : "listpage";
	$listID  = $i==1 ? $id : $lastID.'-page';
	$wpdb->query( 'INSERT INTO ' . $wpdb->prefix . 'shortcode_imdb_cache (imdb_id,title,type,cache,page) VALUES ("' . $listID . '","' . $Title . '","'.$typeList.'","' . $arr . '",'.$i.')' );


	$i++;


}
$listarr = $fistarr;
header("location: " . $_SERVER['REQUEST_URI']);