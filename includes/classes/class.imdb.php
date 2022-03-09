<?php
class shimdb_imdb_grab extends shimb_imdb_api {

	/***************************     CURL   ********************************************/

	/****************** 1.Name *******************/
    function curl_name($id){
        $lang = $this->location();
        $headers[]  = "User-Agent:Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13";
        $headers[]  = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $headers[]  = "Accept-Language:".$lang["local"].",".$lang["lang"].";q=0.5";
        $headers[]  = "Accept-Encoding:gzip,deflate";
        $headers[]  = "Accept-Charset:utf-8,ISO-8859-1;q=0.7,*;q=0.7";
        $headers[]  = "Keep-Alive:115";
        $headers[]  = "Connection:keep-alive";
        $headers[]  = "Cache-Control:max-age=0";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://www.imdb.com/name/'.$id);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
//	    $response = wp_remote_get(
//		    esc_url_raw( 'https://www.imdb.com/name/'.$id),
//		    array(
//			    'headers' => array(
//				    'Accept-Language' => $lang["local"].','.$lang["lang"]
//			    )
//		    )
//	    );
//	    return $response['body'];

    }

	/****************** 2.Title *******************/
    function curl_title($id){
//
        $lang = $this->location();
        $headers[]  = "User-Agent:Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13";
        $headers[]  = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $headers[]  = "Accept-Language:".$lang["local"].",".$lang["lang"];
        $headers[]  = "Accept-Encoding:gzip,deflate";
        $headers[]  = "Accept-Charset:utf-8,ISO-8859-1;q=0.7,*;q=0.7";
        $headers[]  = "Keep-Alive:115";
        $headers[]  = "Connection:keep-alive";
        $headers[]  = "Cache-Control:max-age=0";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://www.imdb.com/title/'.$id);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
//	    $response = wp_remote_get(
//		    esc_url_raw( 'https://www.imdb.com/title/'.$id),
//		    array(
//			    'headers' => array(
//				    'Accept-Language' => $lang["local"].','.$lang["lang"],
//				    'Accept-Charset' => 'utf-8,ISO-8859-1;q=0.7,*;q=0.7'
//			    )
//		    )
//	    );
//	    return $response['body'];

    }

	/****************** 3.Second Curl *******************/
    function curl2($url){

        $lang = $this->location();
        $headers[]  = "User-Agent:Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13";
        $headers[]  = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $headers[]  = "Accept-Language:".$lang["local"].",".$lang["lang"].";q=0.5";
        $headers[]  = "Accept-Encoding:gzip,deflate";
        $headers[]  = "Accept-Charset:utf-8,ISO-8859-1;q=0.7,*;q=0.7";
        $headers[]  = "Keep-Alive:115";
        $headers[]  = "Connection:keep-alive";
        $headers[]  = "Cache-Control:max-age=0";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;

    }
	/***************************     /CURL   ********************************************/

	//	**
	//	**
	//	**

	/***************************     DOM   ********************************************/

	/****************** 1.Name *******************/
	function name_dom($id, $type="curl"){
		$data = $this->curl_name($id);
		$dom = new DomDocument('1.0', 'utf-8');
		@$dom->LoadHTML($data);
		/* Create a new XPath object */
		$xpath = new DomXPath($dom);
		return $xpath;

	}

	/****************** 2.Title *******************/
    function title_dom($id,$type="curl"){

        $data = $this->curl_title($id);
        $dom = new DomDocument(null, 'utf-8');
        @$dom->LoadHTML($data);
        /* Create a new XPath object */
        $xpath = new DomXPath($dom);
        $path = array();
        $path['xpath'] = $xpath;
	    $path['dom'] = $dom;
        return $path;

    }

	/****************** 3.Quote *******************/
    function quote_dom($id){
        $data = $this->curl2('http://www.imdb.com/title/'.$id.'/quotes');
        $dom = new DomDocument('1.0', 'utf-8');
        @$dom->LoadHTML($data);
        $xpath = new DomXPath($dom);
        $arr['xpath'] = $xpath;
        $arr['dom'] = $dom;
        return $arr;
    }



	/****************** 4.LIST *******************/
	function list_dom($id,$page = 1)
	{

		$url = 'https://www.imdb.com/list/' . $id . '/?page='.$page;

		$data = $this->curl2($url);
		$dom = new DomDocument('1.0', 'utf-8');
		@$dom->LoadHTML($data);
		/* Create a new XPath object */
		$xpath = new DomXPath($dom);
		$arr['dom'] = $dom;
		$arr['xpath'] = $xpath;
		return $arr;

	}

	/****************** 5. HTML *******************/
	function html_dom($data,$xdom)
	{
		$dom = new DomDocument(null, 'utf-8');
		$html = $xdom->saveHTML($data);
		@$dom->LoadHTML($html);
		/* Create a new XPath object */
		$xpath = new DomXPath($dom);
		return $xpath;

	}


	/***************************     /DOM   ********************************************/

	//	**
	//	**
	//	**

	/***************************     FETCH   ********************************************/

	/******************** 1.Name ***************************/
	function name($id){
		// FETCH name
		$xpath = $this->name_dom($id);
		$data['error'] = "yes";
		@$error_bubble  = $xpath->query('//div[@class="error_bubble"]');
		if(!isset($error_bubble->item(0)->nodeValue)):
		$data['error'] = "no";
		$data['imdb_id'] = $id;
		// NAME
		@$name = $xpath->query('//span[@class="itemprop"]');
		$data["name"] = isset($name->item(0)->nodeValue) ? esc_attr(trim($name->item(0)->nodeValue,chr(0xC2).chr(0xA0))) : "???";

		//JOBS
		@$jobs = $xpath->query('//div/a[@onclick="nameJobCategoriesClickHandler(this)"]');
		$data['jobs'] = "";
		if(isset($jobs)){
			$jb = array();
			foreach ($jobs as $j){
				$jb[] = esc_attr(trim($j->nodeValue));
			}
			$data['jobs'] = implode(", ",  $jb);

		}

		//BORN
		@$born = $xpath->query('//div[@id="name-born-info"]');
		$data['born'] = isset($born->item(0)->nodeValue) ? trim(str_replace("Born:","",$born->item(0)->nodeValue)) : "---";
		$data['born'] = esc_attr($data['born']);
		//DEATH :(
		@$death = $xpath->query('//div[@id="name-death-info"]');
		$data['death'] = isset($death->item(0)->nodeValue) ? trim(str_replace("Died:","",$death->item(0)->nodeValue)) : "---";
		$data['death'] = esc_attr($data['death']);
		//BIO
		@$bio = $xpath->query('//div[@class="name-trivia-bio-text"]/div');
		$data['bio'] = "";
		if(isset($bio)){
			$data["bio"] = trim(str_replace("See full bio","", $bio->item(0)->nodeValue));
			$data["bio"] = trim(str_replace("»","", $data["bio"]));
			$data["bio"] = esc_attr($data["bio"]);
		}

		// NAME PHOTO
		@$photo = $xpath->query('//img[@id="name-poster"]/@src');
		$data["photo"] = isset($photo->item(0)->nodeValue) ? esc_url($photo->item(0)->nodeValue) : esc_url(SHIMDB_URL."includes/assets/nopohoto.png");

		// KNOWN FOR
		@$posters = $xpath->query('//img[@data-baseref="nm_knf_i"]');
		$data['known'] = "";
		$noposter = "https://m.media-amazon.com/images/G/01/imdb/images/nopicture/medium/film-3385785534._CB483791896_.png";
		$noposter2 = "https://m.media-amazon.com/images/G/01/imdb/images/nopicture/medium/tv-3264496829._CB470041855_.png";
		if(isset($posters)){
			$known = array();
			foreach ($posters as $p){
				if($p->getAttribute('src') != $noposter  && $p->getAttribute('src') != $noposter2) {
					$known[] = array("img" =>esc_sql($p->getAttribute("src")), "link" => esc_sql($p->getAttribute("data-tconst")));
				}
			}
			$data['known'] = $known;
		}

		//BEST TITLE
		@$bestTitle = $xpath->query('//div[@class="knownfor-title-role"]/a');
		$data['bestTitle'] = "";
		if(isset($bestTitle)){
			$bestTHref = $bestTitle->item(0)->getAttribute('href');
			$bestT = esc_sql(utf8_decode($bestTitle->item(0)->nodeValue));
			$data['bestTitle'] = '<a href="https://imdb.com'.$bestTHref.'" target="_blank">'.$bestT.'</a>';

		}

		/* Images */
		@$images = $xpath->query('//div[@class="mediastrip"]/a');
		$data['img'] = "";
		if($images->length>0){
			$imgs = array();
			foreach ($images as $k => $i){
				@$imgs[$k]['link'] = esc_url('http://www.imdb.com'.$i->getAttribute('href'));
				@$get_img = $xpath->query('//div[@class="mediastrip"]/a/img/@loadlate');
				@$imgs[$k]['img'] = esc_url($get_img->item($k)->nodeValue);
			}
			$data['img'] = isset($imgs[0]['img']) ? $imgs : "";
		}

		/* Videos */
		@$videos = $xpath->query('//div[@class="mediastrip_big"]/span/a');
		$data['videos'] = "";
		if(isset($videos)){
			$vids = array();
			foreach ($videos as $k => $i){
				$vids[$k]['link'] = esc_url('http://www.imdb.com'.$i->getAttribute('href'));
				@$get_vid = $xpath->query('//div[@class="mediastrip_big"]/span/a/img/@loadlate');
				$vids[$k]['img'] = esc_url($get_vid->item($k)->nodeValue);
			}
			$data['videos'] = isset($vids[0]['img']) ? $vids : "";
		}

		/* Filmography */
		@$jumpto = $xpath->query('//div[@id="jumpto"]/a');
		$data['filmo'] = "";
		if($jumpto->length>0){
			$arr_filmo = array();
			foreach ($jumpto as $j){
				$filmo_job = esc_attr(trim($j->nodeValue));
				$arr_filmo[$filmo_job] = array();
				$filmo_tag = str_replace('#','',$j->getAttribute('href'));
				@$get_filmo = $xpath->query('//div[contains(@id, "'.$filmo_tag.'")]/b/a');
				if($get_filmo->length>0) {
					foreach ( $get_filmo as $k => $a ) {
						$link     = @$a->getAttribute( 'href' ) ? esc_url( 'https://www.imdb.com' . $a->getAttribute( 'href' ) ) : "";
						$arr_filmo[$filmo_job][] = '<a href="' . $link . '" target="_blank">' . esc_attr( $a->nodeValue ) . '</a>';

					}

				}
			}
			$data['filmo'] = $arr_filmo;
		}

		endif;


		//END
		$data_json = json_encode($data);
		return json_decode($data_json);


	}

	/******************** 2. Title ***************************/
    function title($id){
        $path = $this->title_dom($id);
        $xpath = $path['xpath'];
        $dom = $path['dom'];
	    $data['error'] = "yes";
	    @$error_bubble  = $xpath->query('//div[@class="error_bubble"]');
	    $yeni = false;
	    if(!isset($error_bubble->item(0)->nodeValue)) {
		    $data['error'] = "no";
		    /* Poster */
		    @$poster = $xpath->query( '//div[@class="poster"]/a/img/@src' );
		    $data['poster'] = isset( $poster->item( 0 )->nodeValue ) ? esc_url( $poster->item( 0 )->nodeValue ) : esc_url( SHIMDB_URL . "includes/assets/noposter.png" );
		    if($data['poster'] == esc_url( SHIMDB_URL . "includes/assets/noposter.png" )){
		    	$yeni = true;
		    	@$poster = $xpath->query('//div[contains(@class,"ipc-media--poster")]/img[@class="ipc-image"]/@src');
		    	if(isset($poster->item( 0 )->nodeValue)){
				    $data['poster'] = $poster->item( 0 )->nodeValue;
			    }
		    }
		    /* Title Parent*/
		    $tparent = $xpath->query( '//div[@class="titleParent"]/a' );
		    $tpar    = isset( $tparent->item( 0 )->nodeValue ) ? $tparent->item( 0 )->nodeValue . ": " : "";

		    /* Title */
		    @$title = $xpath->query( '//h1' );
		    $data['title'] = "";
		    if ( isset( $title->item( 0 )->nodeValue ) ) {
			    $tt            = explode( "(", $title->item( 0 )->nodeValue );
			    $data["title"] = esc_attr( trim( $tpar . utf8_decode($tt[0]), chr( 0xC2 ) . chr( 0xA0 ) ) );

		    }


		    /* AKA */

		    @$aka = $xpath->query( '//meta[@property="og:title"]/@content' );
		    $data['aka'] = "";
		    if ( isset( $aka ) ) {
			    $aka         = $aka->item( 0 )->nodeValue;
			    $aka         = explode( '(', $aka );
			    $aka         = trim( $aka[0] );
			    $data['aka'] = $aka;
		    }
		    if($yeni){
			    @$aka = $xpath->query( '//li[@data-testid="title-details-akas"]/div/ul/li/span' );
			    $aka         = utf8_decode($aka->item( 0 )->nodeValue);
			    $data['aka'] = $aka;
		    }

		    /* Year */
		    $data['year'] = "";
		    @$year = $xpath->query( '//span[@id="titleYear"]' );
		    $data['year'] = isset( $year->item( 0 )->nodeValue ) ? esc_sql( trim( substr( $year->item( 0 )->nodeValue, 1, 4 ) ) ) : "";
		    if ( $data['year'] == "" ) {
			    @$year = $xpath->query( '//div[@class="subtext"]/a' );
			    if ( isset( $year ) ) {
				    foreach ( $year as $y ) {
					    $check = $y->getAttribute( "href" );
					    if ( strpos( $check, 'releaseinfo' ) !== false ) {
						    $data['year'] = isset( $y->nodeValue ) ? esc_attr( trim( $y->nodeValue ) ) : "";
					    }
				    }
			    }

		    }
		    if($yeni){
			    @$year = $xpath->query( '//a[@href="/title/'.$id.'/releaseinfo?ref_=tt_ov_rdat#releases"]' );
			    $data['year'] = isset( $year->item( 0 )->nodeValue ) ? esc_sql( trim( substr( $year->item( 0 )->nodeValue, 0, 4 ) ) ) : "";
		    }

		    /* Genre */
		    @$genre = $xpath->query( '//div[@class="subtext"]/a' );
		    $data['genres'] = "";
		    if ( isset( $genre ) ) {
			    $x      = 0;
			    $genres = array();
			    foreach ( $genre as $g ) {
				    $check_genre = $g->getAttribute( 'href' );
				    if ( strpos( $check_genre, 'genres=' ) !== false ) {
					    $genres[ $x ] = esc_attr( trim( $g->nodeValue ) );
					    $x ++;
				    }
			    }
			    $data['genres'] = implode( ", ", $genres );
		    }
		    if($yeni){
		    	@$genre = $xpath->query('//li[@data-testid="storyline-genres"]/div/ul/li/a');
			    if ( isset( $genre ) ) {
				    $x = 0;
				    $genres = array();
				    foreach ( $genre as $g ) {

						    $genres[ $x ] = esc_attr( trim( $g->nodeValue ) );
						    $x ++;

				    }
				    $data['genres'] = implode( ", ", $genres );
			    }
		    }

		    /* Rating */
		    @$rating = $xpath->query( '//span[@itemprop="ratingValue"]' );
		    $data['rating'] = isset( $rating->item( 0 )->nodeValue ) ? esc_attr( trim( $rating->item( 0 )->nodeValue ) ) : "?.?";
		    if($yeni){
		    	@$rating = $xpath->query('//span[contains(@class,"AggregateRatingButton__RatingScore")]');
			    $data['rating'] = isset( $rating->item( 0 )->nodeValue ) ? esc_attr( trim( $rating->item( 0 )->nodeValue ) ) : "?.?";
		    }

		    /* Votes */
		    @$votes = $xpath->query( '//span[@itemprop="ratingCount"]' );
		    $data['votes'] = isset( $votes->item( 0 )->nodeValue ) ? esc_attr( trim( $votes->item( 0 )->nodeValue ) ) : "";
		    if($yeni){
			    @$votes = $xpath->query('//div[contains(@class,"AggregateRatingButton__TotalRatingAmount")]');
			    $data['votes'] = isset( $votes->item( 0 )->nodeValue ) ? esc_attr( trim( $votes->item( 0 )->nodeValue ) ) : "";
		    }

		    /* meta score */
		    @$meta = $xpath->query( '//div[contains(@class,"metacriticScore")]/span' );
		    $data['metascore'] = isset( $meta->item( 0 )->nodeValue ) ? esc_attr( trim( $meta->item( 0 )->nodeValue ) ) : "";
		    if($yeni){
			    @$meta = $xpath->query( '//span[@class="score-meta"]' );
			    $data['metascore'] = isset( $meta->item( 0 )->nodeValue ) ? esc_attr( trim( $meta->item( 0 )->nodeValue ) ) : "";
		    }

		    /* Release */
		    @$release = $xpath->query( '//a[@title="See more release dates"]' );
		    $data['release'] = isset( $release->item( 0 )->nodeValue ) ? esc_attr( trim( $release->item( 0 )->nodeValue ) ) : "";
		    if($yeni){
		    	@$release = $xpath->query('//li[@data-testid="title-details-releasedate"]/div/ul/li/a');
			    $data['release'] = isset( $release->item( 0 )->nodeValue ) ? esc_attr( trim( $release->item( 0 )->nodeValue ) ) : "";
		    }

		    /* Summary */
		    @$sum = $xpath->query( '//div[@class="summary_text"]' );
		    @$data['sum'] = isset( $sum->item( 0 )->nodeValue ) ? esc_attr( trim( $sum->item( 0 )->nodeValue ) ) : "";
		    if($yeni){
		    	@$sum = $xpath->query('//p[@data-testid="plot"]/span');
			    @$data['sum'] = isset( $sum->item( 0 )->nodeValue ) ? esc_attr( trim( $sum->item( 0 )->nodeValue ) ) : "";
		    }

		    /* Budget */
		    @$budget = $xpath->query( '//div[@class="txt-block"]' );
		    $mybudget = "";
		    $mygross  = "";

		    if ( isset( $budget ) ) {
			    foreach ( $budget as $b ) {
				    if ( strpos( $b->nodeValue, 'Budget' ) !== false ) {
					    $mybudget = trim( str_replace( "Budget:", "", $b->nodeValue ) );
				    } else if ( strpos( $b->nodeValue, 'Gross' ) !== false ) {
					    $mygross = explode( ':', $b->nodeValue );
					    $mygross = trim( $mygross[1] );
				    }
//
			    }
		    }

		    if($yeni){
			    @$budget = $xpath->query('//li[@data-testid="title-boxoffice-budget"]/div/ul/li/span');
			    if(isset($budget->item(0)->nodeValue)){
			    	$mybudget = $budget->item(0)->nodeValue;
			    }
			    @$gross = $xpath->query('//li[@data-testid="title-boxoffice-cumulativeworldwidegross"]/div/ul/li/span');
			    if(isset($gross->item(0)->nodeValue)){
				    $mygross = $gross->item(0)->nodeValue;
			    }
		    }
		    $data['budget'] = esc_attr( $mybudget );
		    $data['gross']  = esc_attr( $mygross );

		    //Certificate
		    @$certificate = $xpath->query( '//div[@class="subtext"]' );
		    $mycer = "";
		    if ( isset( $certificate ) ) {
			    $cer = explode( "|", $certificate->item( 0 )->nodeValue );
			    if ( count( $cer ) == 4 ) {
				    $mycer = trim( $cer[0] );
			    }
		    }
		    if($yeni){
		    	@$certificate = $xpath->query('//a[contains(@href,"parentalguide?ref_=tt_ov_pg#certificates")]');
		    	if(isset($certificate->item(0)->nodeValue)){
		    		$mycer = $certificate->item(0)->nodeValue;
			    }
		    }
		    $data['certificate'] = $mycer;

		    /* full summary */
		    @$fullsum = $xpath->query( '//div[@class="inline canwrap"]' );
		    $data['fullsum'] = isset( $fullsum->item( 0 )->nodeValue ) ? esc_attr( trim( $fullsum->item( 0 )->nodeValue ) ) : "";
		    if($yeni){
		    	@$fullsum = $xpath->query('//div[@data-testid="storyline-plot-summary"]/div/div');
			    $data['fullsum'] = isset( $fullsum->item( 0 )->nodeValue ) ? esc_attr( trim( utf8_decode($fullsum->item( 0 )->nodeValue )) ) : "";
		    }

		    /* Time */
		    @$tm = $xpath->query( '//time' );
		    $data['runtime']  = isset( $tm->item( 0 )->nodeValue ) ? esc_attr( trim( $tm->item( 0 )->nodeValue ) ) : "";
		    $data['runtime2'] = isset( $tm->item( 1 )->nodeValue ) ? esc_attr( trim( $tm->item( 1 )->nodeValue ) ) : "";
		    if($yeni){
			    @$tm = $xpath->query('//li[@data-testid="title-techspec_runtime"]/div/ul/li/span');
			    $data['runtime']  = isset( $tm->item( 0 )->nodeValue ) ? esc_attr( trim( $tm->item( 0 )->nodeValue ) ) : "";
		    }

		    /* Country & lang */
		    @$country = $xpath->query( '//div[@class="txt-block"]/a' );
		    $data['country'] = "";
		    $data['lang']    = "";
		    $countries       = array();
		    $langs           = array();
		    if ( isset( $country ) ) {
			    foreach ( $country as $c ) {
				    $check = $c->getAttribute( 'href' );
				    if ( strpos( $check, 'country_of_origin' ) !== false ) {
					    $countries[] = esc_attr( trim( $c->nodeValue ) );
				    }

				    if ( strpos( $check, 'primary_language' ) !== false ) {
					    $langs[] = esc_attr( trim( $c->nodeValue ) );
				    }
			    }
			    $data['country'] = implode( ", ", $countries );
			    $data['lang']    = implode( ", ", $langs );
		    }

		    if($yeni){
		    	@$country = $xpath->query('//a[contains(@href,"/search/title/?country_of_origin")]');
		    	if(isset($country)){
		    		foreach ($country as $c){
					    $countries[] = esc_attr( trim( $c->nodeValue ) );
				    }
				    $data['country'] = implode( ", ", $countries );
			    }
			    @$lang = $xpath->query('//a[contains(@href,"primary_language")]');
			    if(isset($lang)){
				    foreach ($lang as $l){
					    $langs[] = esc_attr( trim( $l->nodeValue ) );
				    }
				    $data['lang'] = implode( ", ", $langs );
			    }
		    }

		    /* Video */

		    @$trailer = $xpath->query( '//div[@class="slate"]/a' );
		    $data['trailer'] = "";
		    if ( @$trailer->length > 0 ) {
			    $video = array();

			    @$video['link'] = esc_url( 'http://www.imdb.com' . $trailer->item( 0 )->getAttribute( 'href' ) );
			    @$get_video_img = $trailer->item( 0 )->getElementsByTagName( 'img' );
			    @$video['thumb'] = esc_url( $get_video_img->item( 0 )->getAttribute( 'src' ) );


			    $data['trailer'] = $video;
		    }

		    if($yeni){
			    @$trailer = $xpath->query('//div[contains(@class,"ipc-media--slate")]/img[@class="ipc-image"]/@src');
			    if(isset($trailer->item(0)->nodeValue)){
				    $video = array();
				    $video['thumb'] = esc_url($trailer->item(0)->nodeValue);
				    @$tralink = $xpath->query('//a[contains(@class,"hero-media__slate-overlay")]/@href');
				    $video['link'] = isset($tralink->item(0)->nodeValue) ? esc_url('http://www.imdb.com'.$tralink->item(0)->nodeValue) : "#";
				    $data['trailer'] = $video;
			    }

		    }

		    /* Images */
		    @$images = $xpath->query( '//div[@id="titleImageStrip"]/div/a' );
		    $data['img'] = "";
		    if ( $images->length > 0 ) {
			    $imgs = array();
			    foreach ( $images as $k => $i ) {
				    @$imgs[ $k ]['link'] = esc_url( 'http://www.imdb.com' . $i->getAttribute( 'href' ) );
				    @$get_img = $xpath->query( '//div[@id="titleImageStrip"]/div/a/img/@loadlate' );
				    @$imgs[ $k ]['img'] = esc_url( $get_img->item( $k )->nodeValue );
			    }
			    $data['img'] = isset( $imgs[0]['img'] ) ? $imgs : "";
		    }
		    if($yeni){
		    	@$images = $xpath->query('//div[contains(@class,"ipc-photo__photo-image")]/img/@src');
		    	if(@$images->length>0){
				    $imgs = array();
		    		foreach ($images as $k => $i){
					    @$imgs[ $k ]['img'] = esc_url( $i->nodeValue );
					    @$imgslink = $xpath->query('//div[contains(@class,"ipc-photo--base")]/a/@href');
					    @$imgs[ $k ]['link'] = esc_url( 'http://www.imdb.com' . $imgslink->item($k)->nodeValue  );

				    }
				    $data['img'] = isset( $imgs[0]['img'] ) ? $imgs : $data['img'];
			    }
		    }

		    /* Videos */
		    @$videos = $xpath->query( '//div[@id="titleVideoStrip"]/div/span/a' );
		    $data['videos'] = "";
		    if ( isset( $videos ) ) {
			    $vids = array();
			    foreach ( $videos as $k => $i ) {
				    $vids[$k]['link'] = esc_url( 'http://www.imdb.com' . $i->getAttribute( 'href' ) );
				    @$get_vid = $xpath->query( '//div[@id="titleVideoStrip"]/div/span/a/img/@loadlate' );
				    $vids[$k]['img'] = esc_url( $get_vid->item( $k )->nodeValue );
			    }
			    $data['videos'] = isset( $vids[0]['img'] ) ? $vids : "";
		    }
		    if($yeni){
		    	$videos = $xpath->query('//div[contains(@class,"ipc-slate-card")]/div/img/@src');
		    	if(@$videos->length>0){
		    		$vids = array();
				    foreach ( $videos as $z=> $v ){
				    	$vids[$z]['img'] = esc_url($v->nodeValue);
					    @$vidlink = $xpath->query('//a[contains(@data-testid,"videos-slate-overlay")]/@href');
					    $vids[$z]['link'] = esc_url( 'http://www.imdb.com' . $vidlink->item($z)->nodeValue );
				    }
				    $data['videos'] = isset( $vids[0]['img'] ) ? $vids : "";
			    }
		    }


		    // Fetch summary Crew
		    @$sum_crew = $xpath->query( '//div[@class="credit_summary_item"]/a' );
		    $data['director'] = "";
		    $data['star']     = "";
		    $data['writer']   = "";
		    if ( isset( $sum_crew ) ) {
			    $directors = array();
			    $writers   = array();
			    $stars     = array();
			    foreach ( $sum_crew as $s ) {

				    $check_crew = $s->getAttribute( 'href' );
				    /* Director */
				    if ( strpos( $check_crew, '/?ref_=tt_ov_dr' ) !== false ) {
					    $directors[] = '<a href="' . esc_url( 'http://www.imdb.com' . $check_crew ) . '" target="_blank">' . esc_attr( $s->nodeValue ) . '</a>';
				    } /* Writers */
				    else if ( strpos( $check_crew, '/?ref_=tt_ov_wr' ) !== false && strpos( $s->nodeValue, 'more credits' ) == false ) {
					    $writers[] = '<a href="' . esc_url( 'http://www.imdb.com' . $check_crew ) . '" target="_blank">' . esc_attr( $s->nodeValue ) . '</a>';

				    } /* Stars */
				    else if ( ( strpos( $check_crew, 'tt_ov_st' ) !== false ) and ( strpos( $s->nodeValue, 'full cast' ) == false ) ) {
					    $stars[] = '<a href="' . esc_url( 'http://www.imdb.com' . $check_crew ) . '" target="_blank">' . esc_attr( $s->nodeValue ) . '</a>';
				    }
			    }
			    $directors         = array_unique( $directors );
			    $stars             = array_unique( $stars );
			    $writers           = array_unique( $writers );
			    $data['directors'] = implode( ', ', $directors );
			    $data['stars']     = implode( ', ', $stars );
			    $data['writers']   = implode( ', ', $writers );

		    }
		    if($yeni){
			    $directors = array();
			    $writers   = array();
			    $stars     = array();
			    @$sum_crew = $xpath->query( '//a[contains(@href,"?ref_=tt_ov_")]' );
			    if(isset($sum_crew)){
				    foreach ( $sum_crew as $s ) {
					    $check_crew = $s->getAttribute( 'href' );
					    /* Director */
					    if ( strpos( $check_crew, '/?ref_=tt_ov_dr' ) !== false && strpos( $check_crew, '/?ref_=tt_ov_dr_sm' ) == false ) {
						    $directors[] = '<a href="' . esc_url( 'http://www.imdb.com' . $check_crew ) . '" target="_blank">' . esc_attr( $s->nodeValue ) . '</a>';
					    } /* Writers */
					    else if ( strpos( $check_crew, '/?ref_=tt_ov_wr' ) !== false && strpos( $s->nodeValue, 'more credits' ) == false && strpos( $check_crew, '/?ref_=tt_ov_wr_sm' ) == false) {
						    $writers[] = '<a href="' . esc_url( 'http://www.imdb.com' . $check_crew ) . '" target="_blank">' . esc_attr( $s->nodeValue ) . '</a>';
					    } /* Stars */
					    else if ( ( strpos( $check_crew, 'tt_ov_st' ) !== false ) and ( strpos( $s->nodeValue, 'full cast' ) == false ) && ( strpos( $check_crew, 'tt_ov_st_sm' ) == false ) ) {
						    $stars[] = '<a href="' . esc_url( 'http://www.imdb.com' . $check_crew ) . '" target="_blank">' . esc_attr( $s->nodeValue ) . '</a>';
					    }
				    }
				    $directors         = array_unique( $directors );
				    $stars             = array_unique( $stars );
				    $writers           = array_unique( $writers );
				    $data['directors'] = implode( ', ', $directors );
				    $data['stars']     = implode( ', ', $stars );
				    $data['writers']   = implode( ', ', $writers );
			    }
		    }

		    // Fetch Cast
		    @$cast_img = $xpath->query( '//table[@class="cast_list"]/tr/td[@class="primary_photo"]/a' );
		    @$chars = $xpath->query( '//td[@class="character"]' );

		    $data['cast'] = "";
		    if ( $cast_img->length > 0 ) {
			    $arr_cast = array();
			    foreach ( $cast_img as $k => $c ) {
				    $get_img                = $c->getElementsByTagName( 'img' );
				    $arr_cast[ $k ]['img']  = @$get_img->item( 0 )->getAttribute( 'loadlate' ) ? esc_url( $get_img->item( 0 )->getAttribute( 'loadlate' ) ) : esc_url( 'https://m.media-amazon.com/images/G/01/imdb/images/nopicture/32x44/name-2138558783._CB470041625_.png' );
				    $arr_cast[ $k ]['name'] = esc_attr( $get_img->item( 0 )->getAttribute( 'title' ) );
				    $arr_cast[ $k ]['link'] = esc_url( "https://imdb.com" . $c->getAttribute( 'href' ) );
				    if($arr_cast[ $k ]['img'] != 'https://m.media-amazon.com/images/G/01/imdb/images/nopicture/32x44/name-2138558783._CB470041625_.png'){
					    $cast_photo = explode('V1',$arr_cast[ $k ]['img']);
					    $cast_photo = $cast_photo[0].'V1_.jpg';
					    list($width1, $height1, $type1, $attr1) = getimagesize($cast_photo);
					    $arr_cast[ $k ]['img_size']['w'] = $width1;
					    $arr_cast[ $k ]['img_size']['h'] = $height1;
				    }

			    }
			    foreach ( $chars as $k => $c ) {
				    $arr_cast[ $k ]['char'] = esc_html( trim( $c->nodeValue ) );
			    }
			    $data['cast'] = $arr_cast;
		    }

	    }

	    if($yeni){
	    	@$casts = $xpath->query('//div[@data-testid="title-cast-item"]');
	    	if(isset($casts)){
	    		$arr_cast = array();
	    		foreach ($casts as $k => $c){
	    			$cpath = $this->html_dom($c,$dom);
	    			@$cimage = $cpath->query('//div[contains(@class,"ipc-media--avatar ")]/img/@src');
				    $arr_cast[ $k ]['img'] = isset($cimage->item(0)->nodeValue) ? esc_url($cimage->item(0)->nodeValue): esc_url( 'https://m.media-amazon.com/images/G/01/imdb/images/nopicture/32x44/name-2138558783._CB470041625_.png' );
					@$ccast = $cpath->query('//a[contains(@href,"/name/nm")]');
				    $arr_cast[ $k ]['name'] = isset($ccast->item(1)->nodeValue) ? esc_attr( trim(utf8_decode($ccast->item(1)->nodeValue)) ) : "";

				    $arr_cast[ $k ]['link'] = isset( $ccast->item( 1 )->nodeValue ) ? esc_url( "https://imdb.com" . $ccast->item( 1 )->getAttribute( 'href' ) ) : "#";
				    @$cchar = $cpath->query('//a[@data-testid="cast-item-characters-link"]/span');
				    $arr_cast[ $k ]['char'] = isset( $cchar->item( 0 )->nodeValue ) ? esc_html( trim( utf8_decode( $cchar->item( 0 )->nodeValue ) ) ) : "";


			    }
			    $data['cast'] = $arr_cast;
		    }
	    }
        // TURN JSON
        $data_json = json_encode($data);
        return json_decode($data_json);

        //


    }


    /******************** 3.Quote ***************************/
    function quotes($args,$id,$title=""){
        global $wpdb;
        $html="";
        $check_cache = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE imdb_id="'.esc_sql($id).'" AND type="quote"');
        if(count($check_cache)==0) {
            $api_check = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'options WHERE option_name="shortcode-imdb-api"');
            $element_value = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'options WHERE option_name="shortcode-imdb-ex-quotes"');
            if ((count($element_value) > 0) & (count($api_check) > 0)) {
                $arr = $this->quote_dom($id);
                $xpath = $arr['xpath'];
                $dom = $arr['dom'];
                foreach ($element_value as $r) {
                    $element = $r->option_value;
                }
                foreach ($api_check as $a) {
                    $api = $a->option_value;
                }


                $key = $this->get_secret_key($api);

                @$quotes = $xpath->query($this->decrypt($element, $key));
                $cache = "";
                if ($quotes->length > 0) {
                    foreach ($quotes as $k => $q) {
                        //$t = nl2br($q->nodeValue);
                        @$t = $dom->saveHTML($q);
                        $t = str_replace('/name/', 'http://imdb.com/name/', $t);
                        $t = str_replace('sodatext', 'imdb_quote', $t);
                        $cache .= $t . ($k == $quotes->length - 1 ? "" : "<hr/>");
                    }
                    echo $cache;
                    $wpdb->query('INSERT INTO ' . $wpdb->prefix . 'shortcode_imdb_cache (imdb_id,title,type,cache) VALUES ("' . $id . '","' . $title . '","quote","' . htmlspecialchars($cache, ENT_QUOTES) . '")');
                }else{
	                $html .= $key;
                }
            } else {
	            $html .= $this->quote_msg();
            }
        }else{
            foreach ($check_cache as $c){
	            $html.= htmlspecialchars_decode($c->cache);
            }
        }

        return $html;


    }

	/******************** 4.List ***************************/

	function lists($id,$args) // id = content
	{
		$my_return = "";
		$fetch = $this->grab_list($id);
		if($fetch == "apinot"){
			$my_return = $this->premium_msg();
		}else{

			/******************************************************* START ********************************************/
			$cache = json_decode(json_encode($fetch));
			$image_size="x:660";
			//IMAGES
			if(@$cache->type=="image"){

				include SHIMDB_ROOT.'includes/classes/content/list/list.show.image.php';

			}
			//VIDEOS
			else if(@$cache->type=="video"){

				include SHIMDB_ROOT.'includes/classes/content/list/list.show.video.php';

			}
			else if(@$cache->type=="title"){

				include SHIMDB_ROOT.'includes/classes/content/list/list.show.title.php';

			}
			else if(@$cache->type=="name"){

				include SHIMDB_ROOT.'includes/classes/content/list/list.show.name.php';

			}

			/******************************************************* /END ********************************************/
		}


		return $my_return;

	}


    /**************************** 5. Grab List *******************/
    function grab_list($id,$page = 1) // id = content
    {
	    $listarr = "";
	    $api = $this->api_exist();
	    if($api != "") {
		    global $wpdb;
		    $listarr     = array();
		    $check_cache = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'shortcode_imdb_cache WHERE imdb_id="' . esc_sql( $id ) . '" AND (type="list" OR type="listvideo" OR type="listimage")' );
		    /***************** NOT CACHE HERE *******************/
		    if ( count( $check_cache ) == 0 ) {
			    $listarr['cachenow'] = "False";
			    $api              = $this->api_exist();
			    set_time_limit( 0 );
			    $ext_dom_key = $this->ExtentionCheck();
				$key         = $this->get_secret_key( $api );
				$checkList   = $this->decrypt( $ext_dom_key['checkList'], $key );
				$ListName    = $this->decrypt( $ext_dom_key['ListName'], $key );
				$pathx       = $this->list_dom( $id );
				$xpath       = $pathx['xpath'];
				@$ListName = $xpath->query( $ListName );
				if ( @$ListName->length > 0 ) {
				   $Title            = esc_sql( mb_convert_encoding( $ListName->item( 0 )->nodeValue, 'HTML-ENTITIES', 'UTF-8' ) );
				   $listarr['title'] = str_replace( "\'", "'", $Title );

				 }

				@$checkList = $xpath->query( $checkList ); // checkList
				if ( @$checkList->length > 0 ) {
					 $check = explode( " ", trim( $checkList->item( 0 )->nodeValue ) );
					 $type  = trim( $check[1] );
					 $count = str_replace( ',', "", $check[0] );
					 /************** START *******************/
					 $howmanypage = ceil( $count / 100 );
				     //LIST SETTİNGS HERE
				     include SHIMDB_ROOT . 'includes/classes/content/list/list.php';
//				     $arr = base64_encode( json_encode( $listarr ) );
//				     $wpdb->query( 'INSERT INTO ' . $wpdb->prefix . 'shortcode_imdb_cache (imdb_id,title,type,cache) VALUES ("' . $id . '","' . $Title . '","list","' . $arr . '")' );

				     $last_id = $wpdb->insert_id;
					$listarr['list_id'] = $id;
					$listarr['id'] = $last_id;
					$listarr['howmanypage'] = $howmanypage;
					 $listarr['adminLink'] = admin_url( 'admin.php?page=shortcode_imdb_lists&id=' . $last_id );

				     /************** /END *******************/
				}

			    /************* /API ********************/
		    } /***************** /NOT CACHE *******************/
		    else {
			    /***************** CACHE HERE *******************/
			    foreach ($check_cache as $c) {
				    $listarr = json_decode(base64_decode($c->cache),true);
				    $listarr['list_id'] = $id;
				    $listarr['id'] = $c->id;
				    $listarr['error'] = "no";
				    $listarr['adminLink'] = admin_url( 'admin.php?page=shortcode_imdb_lists&id=' . $c->id );
			    }
			    $listarr['cachenow'] = "True";
			    /***************** /CACHE ENDS *******************/
		    }


	    }else{
	    	 $listarr = "apinot";
	    }
	    return $listarr;
    }

	/**************************** 6. Fetch List *******************/
	function fetch_list($id,$page=1){
		$arr = $this->grab_list($id,$page);
		$arr2 = array();
		$arr2['cachenow'] = $arr['cachenow'];
		$arr2['adminLink'] = $arr['adminLink'];
		$arr2['title'] = $arr['title'];
		echo json_encode($arr2);
	}

	/***************************     /FETCH   ********************************************/

	//	**
	//	**
	//	**

	/***************************     MESSAGE   ********************************************/
	/***************** 1. Premium Message  **********************/
	function premium_msg(){
		return "This feature is included in the premium package. To open the premium features of this plugin, please visit <a href='https://pluginpress.net' target='_blank'>pluginpress.net</a>.";
	}

	/***************** 2. Quote Message  **********************/
	function quote_msg(){
		return "To turn this feature on, sign up and get your api-key and add 'Shortcode IMDB Quote' product for free. Please visit <a href='https://pluginpress.net' target='_blank'>pluginpress.net</a>.";
	}

	/***************************     /MESSAGE   ********************************************/

	//	**
	//	**
	//	**

	/***************************     BRING DATA   ********************************************/

	/*************** 1. Secret Key *******************/
	function get_secret_key($api){
		if(isset($_SESSION['imdb_secret_key'])){
			$key =  $_SESSION['imdb_secret_key'];
		} else{
			$key = $this->curl2($this->baseUrl().$api."/secret");
			@$_SESSION['imdb_secret_key'] = $key;
		}
		return $key;
	}

	/*************** 2. Grab Title from DB or Web *******************/
	function grab_imdb($id,$type){
		global $wpdb;
		$id = esc_sql($id);
		$result = $wpdb->get_results( 'SELECT * FROM ' . $wpdb->prefix . 'shortcode_imdb_cache WHERE imdb_id="' . $id . '" AND type="' . $type . '"' );
		$values ="";
		if(count($result)>0){
			foreach ($result as $r){
				$output = json_decode( str_replace( "//", "/", $r->cache ) );
			}
		}else{
			if($type=="name"){
				$values = $this->name($id);
				$title = esc_sql($values->name);
			}elseif($type=="title"){
				$values = $this->title($id);
				$title = esc_sql($values->title);
			}
			if(isset($values->error)=="no") {
				$wpdb->insert(
					$wpdb->prefix . 'shortcode_imdb_cache',
					array(
						'imdb_id' => $id,
						'type'    => $type,
						'title'   => $title,
						'cache'   => json_encode( $values )
					)
				);
			}
			$output = $values;
		}
		return $output;
	}

	/*************** 3. Bring Image List from Excel *******************/
	function list_image_excel($id){
		$url = 'https://www.imdb.com/list/'.$id.'/export?ref_=rmls_otexp';
		$row = 1;
		$list = array();
		$arrContextOptions=array(
			"ssl"=>array(
				"verify_peer"=>true,
			),
		);

		if (($handle = fopen($url, "r",false, stream_context_create($arrContextOptions))) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$num = count($data);
				if($row>1) {
					$list[$row - 2]['id'] = $data[1];
					$list[$row - 2]['desc'] = utf8_encode($data[4]);
				}

				$row++;
			}
			fclose($handle);
		}
		return $list;
	}


	/***************************     /BRING DATA   ********************************************/


	/************************************ POPOVERS *****************************************/

	function popups($content,$args){
		$api = $this->api_exist();
		if($api!="") {
			$ext_dom_key = $this->ExtentionCheck();
			if(isset($ext_dom_key['popups'])) {
				if ( isset( $args['id'] ) ) {
					$imdb = new shimdb_imdb_get_skin();
					if ( $content != "" ) {
						$newc = $content;
					} else {
						if ( isset( $args['tube'] ) ) {
							$youtube = $this->get_youtube( $args['tube'] );
							$newc    = '<div style="background: url(' . $youtube->thumbnail_url . ') no-repeat center center;background-size:cover; max-height:300px !important; max-width:480px !important;text-align:center!important;">
								<img style="top: 50%; bottom: 50%;margin-left: auto !important; margin-right: auto  !important;" src="' . SHIMDB_URL . 'includes/assets/player.png">					
		    				</div>';
						} else {
							$newc = "Null";
						}
					}
					$my_return = '<a href="#" id="' . $args['id'] . '" class="imdb-popup-click">' . $newc . '</a><span id="pop-up-here-' . $args['id'] . '" class="imdb-popup-here"></span>
								<input type="hidden" value="' . SHIMDB_URL . '" id="imdb-p-url-' . $args['id'] . '">
								<input type="hidden" value="' . ( isset( $args['tube'] ) ? $args['tube'] : "" ) . '" id="imdb-p-tube-' . $args['id'] . '">
								<input type="hidden" value="' . ( isset( $args['autoplay'] ) ? $args['autoplay'] : "1" ) . '" id="imdb-p-autoplay-' . $args['id'] . '">';


					return $my_return;

				} else {
					return "We cannot find an imdb id";
				}
			}else{
				return $this->premium_msg();
			}
		}else{
			return $this->premium_msg();
		}
	}


	/************************************ /POPOVERS *****************************************/
	/******************** Youtube *****************/
	function get_youtube($id){
		$url = "https://www.youtube.com/oembed?url=http://www.youtube.com/watch?v=".$id."&format=json";
		return json_decode(file_get_contents($url));
	}
	/******************** /Youtube ********************/

	/********************************** WooCommerce ************************/
	function WooCommerce_type($id){
			$id = trim($id);
			if(substr($id,0,2) == "nm"){
				return "name";
			}else if(substr($id,0,2) == "tt"){
				return 'title';
			}else{
				return "null";
			}

	}
	/********************************** /WoCommerce *********************/
	/***********************  TABS  ***************************/
	function tabs_show($content,$args){
		/**
		 * @var shimdb_imdb_get_skin $html
		 */
		include SHIMDB_ROOT.'includes/external/tabs.php';
		return $html;
	}

	function get_tabs($imdb_id){
		global $wpdb;
		$get_id = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE imdb_id="'.$imdb_id.'" AND type="tabs"');
		$data = "";
		if(count($get_id)>0){
			foreach ($get_id as $g){
				$id = $g->id;
			}
			$tabs = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE imdb_id="'.$id.'-tab" ORDER by page');
			$data = array();
			if(count($tabs)>0){
				$data = $tabs;
			}

		}
		return $data;

	}

	function sub_tab_show($tab,$cast,$k=0,$y=0){
		$html ="";
		if($tab->type == "cast"){
			if($tab->show == "grid"){
				foreach ($cast as $c){
					$sizes = array(0,0);
					if(isset($c->img_size)){
						$sizes = array($c->img_size->w, $c->img_size->h);
					}
					$html .= '<div class="imdb-cast-tab">
						<div class="imdb-tab-cast-photo" style="border: 1px solid">
							<a href="'.$c->link.'" target="_blank"><img src="'. $this->imdb_image_square_convertor($c->img,'200',$sizes).'"></a>
						</div>
						<div class="imdb-woo-content">
							<div>
								<a href="'.$c->link.'" target="_blank"><b>'.utf8_decode($c->name).'</b></a>
							</div>
							<div>
								'.utf8_decode($c->char).'
							</div>
						</div>


					</div>';

				}
				$html .= "<div style='clear: both'></div>";
			}
			else {
				$html .= '<div class="imdb_default_tr">';
				foreach ($cast as $c){
					$html .='<div class="cast">
                                    <div class="profile"><a href="'.$c->link.'" target="_blank"><img src="'.$this->imdb_image_convertor($c->img,200).'"/></a></div>
                                    <div class="name"><a href="'.$c->link.'" target="_blank">'.utf8_decode($c->name).'</a></div>
                                    <div class="seperate">...</div>
                                    <div class="char">'.utf8_decode($c->char).'</div>
                                </div>';
				}
				$html .= '</div>';
			}
		}
		else if($tab->type == "text"){
			$html = htmlspecialchars_decode($this->text_cleaner($tab->text));
		}
		else if($tab->type=="youtube"){
//			https://www.youtube.com/watch?v=go6GEIrcvFY
			$youtube = explode('v=',$tab->youtube);
			$youtube = $youtube[1];
			$youtube = explode('&',$youtube);
			$youtube = $youtube[0];
			$html .= '<div class="imdb-video-container"><iframe width="560" height="315" src="https://www.youtube.com/embed/'.$youtube.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
		}
		else if($tab->type=="woo"){
			if($tab->show=="grid") {
				$html .= do_shortcode( '[products ids="' . trim( $tab->woo ) . '"]' );
			}else{
				$html .= do_shortcode( '[products ids="' . trim( $tab->woo ) . ' " columns="1"]' );
			}
		}
		else if($tab->type == "embed"){
			if($tab->display_time>0) {
				$html .= '<div class="imdb_embed_area"><div id="adverb' . $k . '-' . $y . '" style="width:100%">' . htmlspecialchars_decode( $this->text_cleaner( $tab->adverb ) ) . '</div><div id="embed' . $k . '-' . $y . '" style="display:none">' . htmlspecialchars_decode( $this->text_cleaner( $tab->embed ) ) . '</div></div>';
				$html .= '<button class="open-ads" id="openadverb' . $k . '-' . $y . '" style="border:1px solid; background-color:transparent; color:inherit; ">' . $this->lang( 'Close the ad' ) . ' <span id="count' . $k . '-' . $y . '"></span></button>';
				$html .= '<input type="hidden" value="' . $tab->display_time . '" id="display_time' . $k . '-' . $y . '">';
			}else{
				$html .= '<div class="imdb_embed_area"><div id="embed' . $k . '-' . $y . '">' . htmlspecialchars_decode( $this->text_cleaner( $tab->embed ) ) . '</div></div>';
			}
		}
		else if($tab->type=="filmo"){
			if($cast !=""){
				foreach ($cast as $k => $film){
					$html .= '<div class="job_title"><a href="#" class="imdb_job_click" style="background-color: transparent; font-size: 18px" imdat="'.sanitize_title($k).'">'.$this->lang($k).'<span class="imdb-arrow"><div class="imdb-arrow-down imdb_arrow_'.sanitize_title($k).'"></div></span></a></div><div class="imdb_job_'.sanitize_title($k).' panel-collapsed">';
					foreach ($film as $y => $a){
						$html .= '<div class="list">'.$a.'</div>';

					}
					$html .= "</div><br/>";

				}
			}
		}

		return $html;
	}
	/***********************  /TABS  ***************************/




}