<?php
class shimdb_imdb_grab{


    //FETCHING WITH DOM
    function title_dom($id,$type="classic"){

        switch($type){

            case 'classic':
                // CREATING DOM ELEMENTS
                $dom = new DomDocument('1.0', 'utf-8');
                @$dom->loadHTMLFile('http://www.imdb.com/title/'.$id);


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
            $data["title"] = trim($tt[0],chr(0xC2).chr(0xA0));
        }

        /* Year */
        $data['year'] = "";
        @$year = $xpath->query('//span[@id="titleYear"]');
        $data['year'] = isset($year->item(0)->nodeValue) ? trim(substr($year->item(0)->nodeValue, 1,4)) : "";
        if($data['year'] == "" ){
            @$year = $xpath->query('//div[@class="subtext"]/a');
            if(isset($year)){
                foreach($year as $y){
                    $check = $y->getAttribute("href");
                    if (strpos($check, 'releaseinfo') !== false) {
                        $data['year'] = isset($y->nodeValue) ? trim($y->nodeValue) : "";
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
                    $genres[$x] = trim($g->nodeValue);
                    $x++;
                }
            }
            $data['genres'] = implode(", ", $genres);
        }

        /* Rating */
        @$rating = $xpath->query('//span[@itemprop="ratingValue"]');
        $data['rating'] = isset($rating->item(0)->nodeValue) ? trim($rating->item(0)->nodeValue) : "?.?";

        /* Poster */
        @$poster = $xpath->query('//div[@class="poster"]/a/img/@src');
        $data['poster'] = isset($poster->item(0)->nodeValue) ? $poster->item(0)->nodeValue : _SI_IMDB_URL_."includes/assets/noposter.png";

        /* Summary */
        @$sum = $xpath->query('//div[@class="summary_text"]');
        @$data['sum'] = isset($sum->item(0)->nodeValue) ? trim($sum->item(0)->nodeValue) : "";

        /* Time */
        @$tm = $xpath->query('//time');
        $data['runtime'] = isset($tm->item(0)->nodeValue) ? trim($tm->item(0)->nodeValue) : "";
        $data['runtime2'] = isset($tm->item(1)->nodeValue) ? trim($tm->item(1)->nodeValue) : "";

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
                    $countries[] = trim($c->nodeValue);
                }

                if (strpos($check, 'primary_language') !== false) {
                    $langs[] = trim($c->nodeValue);
                }
            }
            $data['country'] = implode(", ", $countries);
            $data['lang'] = implode(", ", $langs);
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
                    $directors[] = '<a href="http://www.imdb.com'.$check_crew.'" target="_blank">'. $s->nodeValue.'</a>';
                }

                /* Writers */
                else if(strpos($check_crew, '/?ref_=tt_ov_wr') !== false && strpos($s->nodeValue, 'more credits') == false){
                    $writers[] = '<a href="http://www.imdb.com'.$check_crew.'" target="_blank">'. $s->nodeValue.'</a>';
                }

                /* Stars */
                else if((strpos($check_crew, 'tt_ov_st') !== false) AND (strpos($s->nodeValue, 'full cast') == false)){
                    $stars[] = '<a href="http://www.imdb.com'.$check_crew.'" target="_blank">'. $s->nodeValue.'</a>';
                }
            }
            $directors = array_unique($directors);
            $stars = array_unique($stars);
            $writers  = array_unique($writers);
            $data['directors'] = implode(', ', $directors);
            $data['stars'] = implode(', ', $stars);
            $data['writers'] = implode(', ', $writers);

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
        $data["name"] = isset($name->item(0)->nodeValue) ? trim($name->item(0)->nodeValue,chr(0xC2).chr(0xA0)) : "???";

        //JOBS
        @$jobs = $xpath->query('//div/a[@onclick="nameJobCategoriesClickHandler(this)"]');
        $data['jobs'] = "";
        if(isset($jobs)){
            $jb = array();
            foreach ($jobs as $j){
                $jb[] = trim($j->nodeValue);
            }
            $data['jobs'] = implode(", ",  $jb);

        }

        //BORN
        @$born = $xpath->query('//div[@id="name-born-info"]');
        $data['born'] = isset($born->item(0)->nodeValue) ? trim(str_replace("Born:","",$born->item(0)->nodeValue)) : "---";

        //DEATH :(
        @$death = $xpath->query('//div[@id="name-death-info"]');
        $data['death'] = isset($death->item(0)->nodeValue) ? trim(str_replace("Died:","",$death->item(0)->nodeValue)) : "---";
        //BIO
        @$bio = $xpath->query('//div[@class="name-trivia-bio-text"]/div');
        $data['bio'] = "";
        if(isset($bio)){
            $data["bio"] = trim(str_replace("See full bio","", $bio->item(0)->nodeValue));
            $data["bio"] = trim(str_replace("»","", $data["bio"]));
        }

        // NAME PHOTO
        @$photo = $xpath->query('//img[@id="name-poster"]/@src');
        $data["photo"] = isset($photo->item(0)->nodeValue) ? $photo->item(0)->nodeValue : _SI_IMDB_URL_."includes/assets/nopohoto.png";

        // KNOWN FOR
        @$posters = $xpath->query('//img[@data-baseref="nm_knf_i"]');
        $data['known'] = "";
        $noposter = "https://m.media-amazon.com/images/G/01/imdb/images/nopicture/medium/film-3385785534._CB483791896_.png";
        if(isset($posters)){
            $known = array();
            foreach ($posters as $p){
                if($p->getAttribute('src') != $noposter) {
                    $known[] = array("img" =>$p->getAttribute("src"), "link" => $p->getAttribute("data-tconst"));
                }
            }
            $data['known'] = $known;
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
                $title = $values->name;
            }elseif($type=="title"){
                $values = $this->title($id);
                $title = $values->title;
            }
            $wpdb->insert(
                $wpdb->prefix.'shortcode_imdb_cache',
                array(
                    'imdb_id'    => $id,
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