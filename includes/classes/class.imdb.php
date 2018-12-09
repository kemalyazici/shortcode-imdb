<?php
class shimdb_imdb_grab{


    //FETCHING WITH DOM
    function title_dom($id,$type="classic"){

        switch($type){

            case 'classic':
                // CREATING DOM ELEMENTS
                $dom = new DomDocument('1.0', 'utf-8');
                @$dom->loadHTMLFile('http://www.imdb.com/title/'.$id);
            break;

        }
        /* Create a new XPath object */
        $xpath = new DomXPath($dom);
        return $xpath;

    }

    function name_dom($id, $type="classic"){
        switch($type){

            case 'classic':
                // CREATING DOM ELEMENTS
                $dom = new DomDocument('1.0', 'utf-8');
                @$dom->loadHTMLFile('http://www.imdb.com/name/'.$id);


        }
        /* Create a new XPath object */
        $xpath = new DomXPath($dom);
        return $xpath;

    }

    // GRABBING A TITLE
    function title($id){
        $xpath = $this->title_dom($id);

        /* Title */
        @$title = $xpath->query('//h1');
        $data['title'] = "";
        if(isset($title->item(0)->nodeValue)){

            $tt = explode("(", $title->item(0)->nodeValue);
            $data["title"] =esc_attr(trim($tt[0],chr(0xC2).chr(0xA0)));
        }

        /* Year */
        $data['year'] = "";
        @$year = $xpath->query('//span[@id="titleYear"]');
        $data['year'] = isset($year->item(0)->nodeValue) ? esc_sql(trim(substr($year->item(0)->nodeValue, 1,4))) : "";
        if($data['year'] == "" ){
            @$year = $xpath->query('//div[@class="subtext"]/a');
            if(isset($year)){
                foreach($year as $y){
                    $check = $y->getAttribute("href");
                    if (strpos($check, 'releaseinfo') !== false) {
                        $data['year'] = isset($y->nodeValue) ? esc_attr(trim($y->nodeValue)) : "";
                    }
                }
            }

        }

        /* Genre */
        @$genre = $xpath->query('//div[@class="subtext"]/a');
        $data['genres'] = "";
        if(isset($genre)){
            $info = array();
            $x =0;
            $genres = array();
            foreach ($genre as $g){
                $check_genre = $g->getAttribute('href');
                if (strpos($check_genre, 'genres=') !== false) {
                    $genres[$x] = esc_attr(trim($g->nodeValue));
                    $x++;
                }
            }
            $data['genres'] = implode(", ", $genres);
        }

        /* Rating */
        @$rating = $xpath->query('//span[@itemprop="ratingValue"]');
        $data['rating'] = isset($rating->item(0)->nodeValue) ? esc_attr(trim($rating->item(0)->nodeValue)) : "?.?";

        /* Release */
        @$release = $xpath->query('//a[@title="See more release dates"]');
        $data['release'] = isset($release->item(0)->nodeValue) ? esc_attr(trim($release->item(0)->nodeValue)) : "";

        /* Poster */
        @$poster = $xpath->query('//div[@class="poster"]/a/img/@src');
        $data['poster'] = isset($poster->item(0)->nodeValue) ? esc_url($poster->item(0)->nodeValue) : esc_url(SHIMDB_URL."includes/assets/noposter.png");

        /* Summary */
        @$sum = $xpath->query('//div[@class="summary_text"]');
        @$data['sum'] = isset($sum->item(0)->nodeValue) ? esc_attr(trim($sum->item(0)->nodeValue)) : "";

        /* Budget */
        @$budget = $xpath->query('//div[@class="txt-block"]');
        $mybudget = "";
        if(isset($budget)){
            foreach($budget  as $b){
                if(strpos($b->nodeValue, 'Budget') !== false){
                    $mybudget = trim(str_replace("Budget:","" ,$b->nodeValue));
                }
            }
        }
        $data['budget'] = esc_attr($mybudget);

        /* full summary */
        @$fullsum = $xpath->query('//div[@class="inline canwrap"]');
        $data['fullsum'] = isset($fullsum->item(0)->nodeValue) ? esc_attr(trim($fullsum->item(0)->nodeValue))   : "";

        /* Time */
        @$tm = $xpath->query('//time');
        $data['runtime'] = isset($tm->item(0)->nodeValue) ? esc_attr(trim($tm->item(0)->nodeValue)) : "";
        $data['runtime2'] = isset($tm->item(1)->nodeValue) ? esc_attr(trim($tm->item(1)->nodeValue)) : "";

        /* Country & lang */
        @$country = $xpath->query('//div[@class="txt-block"]/a');
        $data['country'] = "";
        $data['lang'] = "";
        $countries = array();
        $langs = array();
        if(isset($country)) {
            foreach ($country as $c) {
                $check = $c->getAttribute('href');
                if (strpos($check, 'country_of_origin') !== false) {
                    $countries[] = esc_attr(trim($c->nodeValue));
                }

                if (strpos($check, 'primary_language') !== false) {
                    $langs[] = esc_attr(trim($c->nodeValue));
                }
            }
            $data['country'] = implode(", ", $countries);
            $data['lang'] = implode(", ", $langs);
        }

        /* Video */

        @$trailer = $xpath->query('//div[@class="slate"]/a');
        $data['trailer'] = "";
        if(@$trailer->length>0){
            $video = array();

            @$video['link'] = esc_url('http://www.imdb.com'.$trailer->item(0)->getAttribute('href'));
            @$get_video_img = $trailer->item(0)->getElementsByTagName('img');
            @$video['thumb'] = esc_url($get_video_img->item(0)->getAttribute('src'));


            $data['trailer'] = $video;
        }

        /* Images */
        @$images = $xpath->query('//div[@id="titleImageStrip"]/div/a');
        $data['img'] = "";
        if($images->length>0){
            $imgs = array();
            foreach ($images as $k => $i){
                @$imgs[$k]['link'] = esc_url('http://www.imdb.com'.$i->getAttribute('href'));
                @$get_img = $xpath->query('//div[@id="titleImageStrip"]/div/a/img/@loadlate');
                @$imgs[$k]['img'] = esc_url($get_img->item($k)->nodeValue);
            }
            $data['img'] = isset($imgs[0]['img']) ? $imgs : "";
        }

        /* Videos */
        @$videos = $xpath->query('//div[@id="titleVideoStrip"]/div/span/a');
        $data['videos'] = "";
        if(isset($videos)){
            $vids = array();
            foreach ($videos as $k => $i){
                $vids[$k]['link'] = esc_url('http://www.imdb.com'.$i->getAttribute('href'));
                @$get_vid = $xpath->query('//div[@id="titleVideoStrip"]/div/span/a/img/@loadlate');
                $vids[$k]['img'] = esc_url($get_vid->item($k)->nodeValue);
            }
            $data['videos'] = isset($vids[0]['img']) ? $vids : "";
        }


        // Fetch summary Crew
        @$sum_crew = $xpath->query('//div[@class="credit_summary_item"]/a');
        $data['director'] = "";
        $data['star'] = "";
        $data['writer'] = "";
        if(isset($sum_crew)){
            $directors = array();
            $writers = array();
            $stars = array();
            foreach ($sum_crew as $s){

                $check_crew = $s->getAttribute('href');
                /* Director */
                if (strpos($check_crew, '/?ref_=tt_ov_dr') !== false) {
                    $directors[] = '<a href="'.esc_url('http://www.imdb.com'.$check_crew).'" target="_blank">'. esc_attr($s->nodeValue).'</a>';
                }

                /* Writers */
                else if(strpos($check_crew, '/?ref_=tt_ov_wr') !== false && strpos($s->nodeValue, 'more credits') == false){
                    $writers[] = '<a href="'.esc_url('http://www.imdb.com'.$check_crew).'" target="_blank">'. esc_attr($s->nodeValue).'</a>';
                }

                /* Stars */
                else if((strpos($check_crew, 'tt_ov_st') !== false) AND (strpos($s->nodeValue, 'full cast') == false)){
                    $stars[] = '<a href="'.esc_url('http://www.imdb.com'.$check_crew).'" target="_blank">'. esc_attr($s->nodeValue).'</a>';
                }
            }
            $directors = array_unique($directors);
            $stars = array_unique($stars);
            $writers  = array_unique($writers);
            $data['directors'] = implode(', ', $directors);
            $data['stars'] = implode(', ', $stars);
            $data['writers'] = implode(', ', $writers);

        }

        // Fetch Cast
        @$cast_img = $xpath->query('//table[@class="cast_list"]/tr/td[@class="primary_photo"]/a');
        @$chars = $xpath->query('//td[@class="character"]');

        $data['cast'] = "";
        if($cast_img->length>0){
            $arr_cast = array();
            foreach ($cast_img as $k => $c){
                $get_img = $c->getElementsByTagName('img');
                $arr_cast[$k]['img'] = @$get_img->item(0)->getAttribute('loadlate') ? esc_url($get_img->item(0)->getAttribute('loadlate')) : esc_url('https://m.media-amazon.com/images/G/01/imdb/images/nopicture/32x44/name-2138558783._CB470041625_.png');
                $arr_cast[$k]['name'] = esc_attr($get_img->item(0)->getAttribute('title'));
                $arr_cast[$k]['link'] = esc_url("https://imdb.com".$c->getAttribute('href'));

            }
            foreach ($chars as $k => $c){
                $arr_cast[$k]['char'] = esc_html(trim($c->nodeValue));
            }
            $data['cast'] = $arr_cast;
        }



        // TURN JSON
        $data_json = json_encode($data);
        return json_decode($data_json);

        //


    }

    // GRABBING NAMES

    function name($id){
        // FETCH name
        $xpath = $this->name_dom($id);

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
        @$actor = $xpath->query('//div[contains(@id, "actor")]/b/a');
        $data['actor'] = "";
        if($actor->length>0){
            $actors = array();
            foreach ($actor as $k => $a){
                $link = @$a->getAttribute('href') ? esc_url('https://www.imdb.com'.$a->getAttribute('href')) : "";
                $actors[] = '<a href="'.$link.'" target="_blank">'.esc_attr($a->nodeValue).'</a>';

            }
            $data['actor'] = $actors;
        }

        @$actress = $xpath->query('//div[contains(@id, "actress")]/b/a');
        $data['actress'] = "";
        if($actress->length>0){
            $actresses = array();
            foreach ($actress as $a){
                $link = @$a->getAttribute('href') ? esc_url('https://www.imdb.com'.$a->getAttribute('href')) : "";
                $actresses[] = '<a href="'.$link.'" target="_blank">'.esc_attr($a->nodeValue).'</a>';
            }
            $data['actress'] = $actresses;
        }

        @$director = $xpath->query('//div[contains(@id, "director")]/b/a');
        $data['director'] = "";
        if($director->length>0){
            $directors = array();
            foreach ($director as $a){
                $link = @$a->getAttribute('href') ? esc_url('https://www.imdb.com'.$a->getAttribute('href')) : "";
                $directors[] = '<a href="'.$link.'" target="_blank">'.esc_attr($a->nodeValue).'</a>';
            }
            $data['director'] = $directors;
        }

        @$writer = $xpath->query('//div[contains(@id, "writer")]/b/a');
        $data['writer'] = "";
        if($writer->length>0){
            $writers = array();
            foreach ($writer as $a){
                $link = @$a->getAttribute('href') ? esc_url('https://www.imdb.com'.$a->getAttribute('href')) : "";
                $writers[] = '<a href="'.$link.'" target="_blank">'.esc_attr($a->nodeValue).'</a>';
            }
            $data['writer'] = $writers;
        }

        @$producer = $xpath->query('//div[contains(@id, "producer")]/b/a');
        $data['producer'] = "";
        if($producer->length>0){
            $pros = array();
            foreach ($producer as $a){
                $link = @$a->getAttribute('href') ? esc_url('https://www.imdb.com'.$a->getAttribute('href')) : "";
                $pros[] = '<a href="'.$link.'" target="_blank">'.esc_attr($a->nodeValue).'</a>';
            }
            $data['producer'] = $pros;
        }

        @$sound = $xpath->query('//div[contains(@id, "soundtrack")]/b/a');
        $data['soundtrack'] = "";
        if($sound->length>0){
            $track = array();
            foreach ($sound as $a){
                $link = @$a->getAttribute('href') ? esc_url('https://www.imdb.com'.$a->getAttribute('href')) : "";
                $track[] = '<a href="'.$link.'" target="_blank">'.esc_attr($a->nodeValue).'</a>';
            }
            $data['soundtrack'] = $track;
        }

        @$comp = $xpath->query('//div[contains(@id, "composer")]/b/a');
        $data['composer'] = "";
        if($comp->length>0){
            $comps = array();
            foreach ($comp as $a){
                $link = @$a->getAttribute('href') ? esc_url('https://www.imdb.com'.$a->getAttribute('href')) : "";
                $comps[] = '<a href="'.$link.'" target="_blank">'.esc_attr($a->nodeValue).'</a>';
            }
            $data['composer'] = $comps;
        }







        //END
        $data_json = json_encode($data);
        return json_decode($data_json);


    }

    function grab_imdb($id,$type){
        global $wpdb;
        $result = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'shortcode_imdb_cache WHERE imdb_id="'.$id.'"');
        if(count($result)>0){
            foreach ($result as $r){
                $output = json_decode($r->cache);
            }
        }else{
            if($type=="name"){
                $values = $this->name($id);
                $title = esc_sql($values->name);
            }elseif($type=="title"){
                $values = $this->title($id);
                $title = esc_sql($values->title);
            }
            $wpdb->insert(
                $wpdb->prefix.'shortcode_imdb_cache',
                array(
                    'imdb_id'    => esc_sql($id),
                    'type'   => $type,
                    'title' => $title,
                    'cache' => json_encode($values)
                )
            );
            $output = $values;
        }
        return $output;
    }




}