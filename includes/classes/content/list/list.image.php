<?php
/**
 * @var shimdb_imdb_grab $id
 * @var shimdb_imdb_grab $listarr
 * @var shimdb_imdb_grab $type
 * @var shimdb_imdb_grab $ext_dom_key
 * @var shimdb_imdb_grab $key
 * @var shimdb_imdb_grab $count
 * @var shimdb_imdb_grab $ext_dom_key
 * @var shimdb_imdb_grab $wpdb
 * @var shimdb_imdb_grab $Title
 * @var shimdb_imdb_grab $howmanypage
 */
$listarr['type'] = 'image';
$listarr['imdbid'] = $id;
$list = $this->list_image_excel($id);
$list_num = 1;
$page = 1;
$firstarr = array();
$icount = 0;

foreach ($list as $k => $l) {
	$now = ceil(($k + 1) / 100);
	if ($now > $page) {
		$listarr['content'] = array();
		$page++;
		$icount = 0;
		$pathx = $this->list_dom($id,$page);
		$xpath = $pathx['xpath'];
	}
	if($page==2){
		$lastID = $wpdb->insert_id;
	}
	$imageListLinks = $this->decrypt($ext_dom_key['imageListLinks'], $key);
	$imageListLinks = str_replace('{id}', $l['id'], $imageListLinks);
	@$img = $xpath->query($imageListLinks); //imageListLinks
	if (@$img->length > 0) {
		$listarr['content'][$icount]['thumb'] = $img->item(0)->nodeValue;
		$image = $this->imdb_image_convertor($img->item(0)->nodeValue);
		$listarr['content'][$icount]['image'] = $image;
	}
	$desc = $this->str_replace_first("</strong>", "</strong><br/>", $this->bbc2html($l['desc']));
	$listarr['content'][$icount]['desc']= $desc;
	$listarr['content'][$icount]['num'] = $list_num;

	$list_num++;
	$icount++;
	if($k+1 == 100){
		$firstarr  = $listarr;
	}
	if((($k+1)%100 == 0) OR $count == $k+1){
		$arr = base64_encode( json_encode( $listarr ) );
		$typeList  = $page==1 ? 'listimage' : "listpage";
		$listID  = $page==1 ? $id : $lastID.'-page';
		$wpdb->query( 'INSERT INTO ' . $wpdb->prefix . 'shortcode_imdb_cache (imdb_id,title,type,cache,page) VALUES ("' . $listID . '","' . $Title . '","'.$typeList.'","' . $arr . '",'.$page.')' );
	}

}

$listarr = $firstarr;
header("location: " . $_SERVER['REQUEST_URI']);
