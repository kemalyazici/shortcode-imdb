<?php
class shimb_imdb_general{

	/**************************  LOCATION  ********************************/

    function bring_location(){
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'options WHERE option_name="shortcode_imdb_location"');
        $local = "en*en-US";
        if(count($results)>0){
            foreach ($results as $r){
                $local = $r->option_value;
            }
        }
        return $local;
    }

    function location(){
        $arr = array();
        $location = $this->bring_location();
        $loc = explode('*',$location);
        $arr['local'] = $loc[1];
        $arr['lang'] = $loc[0];
        return $arr;
    }

    function save_location($lang){
        global $wpdb;
        $wpdb->query('DELETE FROM '.$wpdb->prefix.'options WHERE option_name = "shortcode_imdb_location"');

        $wpdb->insert(
            $wpdb->prefix.'options',
            array(
                'option_name'    => "shortcode_imdb_location",
                'option_value'   => $lang,
            )
        );
    }

	/**************************  /LOCATION  ********************************/

	//	*
	//	*
	//	*

	/**************************  CONVERTOR  ********************************/
	function sanitize_my_json_string($json){
		$sanitized_value = array();
		foreach (json_decode($json,true) as $value) {
			$sanitized_value[] = esc_attr($value);
		}
		return json_encode($sanitized_value);
	}

	function bbc2html($content) {
		$content = str_replace('[I]','[i]',$content);
		$content = str_replace('[/I]','[/i]',$content);
		$content = str_replace('[B]','[b]',$content);
		$content = str_replace('[/B]','[/b]',$content);
		$search = array (
			'/(\[b\])(.*?)(\[\/b\])/',
			'/(\[i\])(.*?)(\[\/i\])/',
			'/(\[u\])(.*?)(\[\/u\])/',
			'/(\[ul\])(.*?)(\[\/ul\])/',
			'/(\[li\])(.*?)(\[\/li\])/',
			'/(\[url=)(.*?)(\])(.*?)(\[\/url\])/',
			'/(\[url\])(.*?)(\[\/url\])/',
			'/(\[link=)(.*?)(\])(.*?)(\[\/link\])/',
			'/(\[link\])(.*?)(\[\/link\])/',
			'/(\[I\])(.*?)(\[\/I\])/',
		);

		$replace = array (
			'<strong>$2</strong>',
			'<em>$2</em>',
			'<u>$2</u>',
			'<ul>$2</ul>',
			'<li>$2</li>',
			'<a href="https://imdb.com$2" target="_blank">$4</a>',
			'<a href="https://imdb.com$2" target="_blank">$2</a>',
			'<a href="https://imdb.com$2" target="_blank">$4</a>',
			'<a href="https://imdb.com$2" target="_blank">$2</a>',
			'<em>$2</em>',
		);

		return preg_replace($search, $replace, $content);
	}

	function str_replace_first($from, $to, $content)
	{
		$from = '/'.preg_quote($from, '/').'/';

		return preg_replace($from, $to, $content, 1);
	}

	function decrypt($data, $key, $method='AES-256-CBC')
	{
		$data = base64_decode($data);
		$ivSize = openssl_cipher_iv_length($method);
		$iv = substr($data, 0, $ivSize);
		$data = openssl_decrypt(substr($data, $ivSize), $method, $key, OPENSSL_RAW_DATA, $iv);

		return $data;
	}

	function imdb_image_convertor($image,$size='x:0'){
		if($image != "https://m.media-amazon.com/images/G/01/imdb/images/nopicture/140x209/film-4001654135._CB466678728_.png") {
			$image_arr = explode( 'V1_', $image );
			$image     = $image_arr[0] . 'V1_.jpg';
			$size      = explode( ":", $size );
			if ( $size[1] > 0 ) {
				if ( $size[0] == "x" ) {
					$image = $image_arr[0] . 'V1_SX' . $size[1] . '.jpg';
				} else if ( $size[0] == "y" ) {
					$image = $image_arr[0] . 'V1_SY' . $size[1] . '.jpg';
				}
			}
		}

		return $image;
	}

	function imdb_image_convertor2($image,$size){
		if($image != "https://m.media-amazon.com/images/G/01/imdb/images/nopicture/140x209/film-4001654135._CB466678728_.png") {
			$image_arr = explode( 'V1_', $image );
			$image     = $image_arr[0] . 'V1_'.$size.'.jpg';
		}

		return $image;
	}

	function imdb_image_square_convertor($image,$size,$sizes){
		if($image != "https://m.media-amazon.com/images/G/01/imdb/images/nopicture/140x209/film-4001654135._CB466678728_.png") {
			$image_arr = explode( 'V1_', $image );
			$width = $sizes[0];
			$height = $sizes[1];
			$u = 'UX';
			$y = 0;
			if($width>$height){
				$u = 'UY';
				$y = $size/4;
			}

			$image     = $image_arr[0] . 'V1__QL75_'.$u.$size.'_CR'.$y.',0,'.$size.','.$size.'_.jpg';
		}

		return $image;
	}

	function perfect_image_converter($image ,$x,$y){
		$arr = explode('V1_',$image);
		$root = $arr[0];
		$stack = $arr[1];
		$set = explode('_',$stack);
		foreach ($set as $s){
			$ux = explode('UX',$s);
			if(count($ux)>1){
				$stack = str_replace($s,'UX'.$x,$stack);
			}
			$uy = explode('UY',$s);
			if(count($uy)>1){
				$stack = str_replace($s,'UY'.$y,$stack);
			}
			$cr = explode('CR',$s);
			if(count($cr)>1){
				$CR = explode(',',$s);
				$one = str_replace('CR','',$CR[0]);
				$one = $one=="0" ? '0': round(($y*$one)/$CR[3]);
				$one = "CR".$one;
				$two = $CR[1] == "0" ? "0" : round(($y*$CR[1])/$CR[3]);
				$three = $x;
				$four = $y;
				$last = $one.','.$two.','.$three.','.$four;
				$stack = str_replace($s,$last,$stack);
				//https://m.media-amazon.com/images/M/MV5BMmFlZDEyZTctNTZkZi00YjI1LWEyNTMtYWNhMTBiZTEwYTUyXkEyXkFqcGdeQXVyMDQxMDEwMw@@._V1_QL75_UX200_CR0,0,200,200_.jpg

			}
		}

		return $root.$stack;
	}

	function skin_converter($key){
		if(substr($key,0,5) != "imdb_"){
			$key = 'imdb_'.$key;
		}
		return $key;
	}

	function html_fetcher($arr,$html){
		foreach ($arr as $var => $ar){

					$html = str_replace("{{".$var."}}",$ar,$html);

			}

		return $html;

	}

	function create_list_code(){
		$time = microtime(true);
		$t = explode('.',$time);
		$code = 'SC'.$t[0];
		return $code;
	}

	/**************************  /CONVERTOR  ********************************/

	//	*
	//	*
	//	*

	/**************************  PREMIUM CONTROL  ********************************/

    function premium_set(){
        global $wpdb;
        $results = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'options WHERE option_name="shortcode_imdb_premium_set"');
        $pre = "show";
        if(count($results)>0){
            foreach ($results as $r){
                $pre = $r->option_value;
            }
        }
        return $pre;
    }

    function premium_set_save($val){
        global $wpdb;
        $wpdb->query('DELETE FROM '.$wpdb->prefix.'options WHERE option_name = "shortcode_imdb_premium_set"');

        $wpdb->insert(
            $wpdb->prefix.'options',
            array(
                'option_name'    => "shortcode_imdb_premium_set",
                'option_value'   => $val,
            )
        );


    }

	/**************************  /PREMIUM CONTROL  ********************************/

	//CURL
	function insideCurl($url){

		$headers[]  = "User-Agent:Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13";
		$headers[]  = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
		$headers[]  = "Accept-Language:en-GB,en;q=0.5";
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

	//GET HTML
	function html_get_contents($url){
		return $this->insideCurl($url);
	}

	function get_file($name){
		return file_get_contents(SHIMDB_ROOT.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.$name.'.html');
	}

	function get_lang_json(){
		return json_decode(file_get_contents(SHIMDB_ROOT.'includes'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'lang.json'),true);
	}

	function lang($word){
		global $wpdb;
		$translate = $word;
		$results = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE title="'.$word.'" AND type="lang"');
		if(count($results)>0){
			foreach ($results as $c){
				$translate = $c->cache;
			}
		}

		return $translate;

	}


	function date_translator($text){
		$months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		foreach ($months as $m){
			$text = str_replace($m,$this->lang($m),$text);
		}
		return $text;
	}


	function min_translator($text){
		$arr = explode(' ',$text);
		if(count($arr)>1){
			$hour = str_replace('h','',$arr[0]);
			$min = str_replace('min','',$arr[1]);
			$maxmin = 60*$hour + $min;
		}else{
			$hour = str_replace('h','',$arr[0]);
			$maxmin = $hour*60;
		}
		return $maxmin;
	}

	function get_imdb_id($id){
		$id = esc_sql($id);
		global $wpdb;
		$getid = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE id='.$id);
		$imdb = "";
		if(count($getid)>0){
			foreach ($getid as $g){
				$imdb = $g->imdb_id;
			}
		}
		return $imdb;
	}

	function get_my_imdb_id($id){
		$id = esc_sql($id);
		global $wpdb;
		$getid = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE id='.$id);
		$imdb = "";
		if(count($getid)>0){
			foreach ($getid as $g){
				$imdb = $g;
			}
		}
		return $imdb;
	}

	function text_cleaner($text){
		$text = str_replace("\\'","'", $text);
		$text = str_replace("\'","'",$text);
		$text = str_replace('\\"','"',$text);
		$text = str_replace('\"','"',$text);
		return $text;
	}

	function bring_tag_link($tg){
		$tag = get_term_by('name', $tg, 'post_tag');
		return get_tag_link($tag->term_id);
	}

	function create_my_tag( $tag_name, $taxonomy = 'post_tag' ) {
		$id = term_exists( $tag_name, $taxonomy );
		if ( $id ) {
			return $id;
		}

		return wp_insert_term( $tag_name, $taxonomy );
	}

	function get_api_key(){
		return get_option('shortcode-imdb-api');
	}

















}