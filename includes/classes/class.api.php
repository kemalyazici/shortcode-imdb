<?php
class shimb_imdb_api extends shimb_imdb_general {
    /**************************** CURL SETTINGS *********************************************/
    function curl($url,$api)
    {

        $site = $this->get_my_url();
        $headers[] = "User-Agent:Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13";
        $headers[] = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $headers[] = "Accept-Language:en-us,en;q=0.5";
        $headers[] = "Accept-Encoding:gzip,deflate";
        $headers[] = "Accept-Charset:utf-8,ISO-8859-1;q=0.7,*;q=0.7";
        $headers[] = "Keep-Alive:115";
        $headers[] = "Connection:keep-alive";
        $headers[] = "Cache-Control:max-age=0";
        $headers[] = "HTTP_X_FORWARDED_FOR:".gethostbyname($site);
        $headers[] = "HTTP_CF_CONNECTING_IP:".gethostbyname($site);
        $headers[] = "HTTP_CLIENT_IP:".gethostbyname($site);
        $resolve = array(sprintf(
            "%s:%d:%s",
            $site,
            21,
            gethostbyname($site)
        ));


        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RESOLVE, $resolve);
        curl_setopt($curl, CURLOPT_REFERER, $site);
        curl_setopt($curl, CURLOPT_URL, $url . $api);
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_ENCODING, "gzip");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;

    }
	/**************************** /CURL SETTINGS *********************************************/

	//	*
	//	*
	//	*

	/**************************  VARIABLES ********************************/

	/****************** 1. PluginPress Api URL  **************************/
    function baseUrl(){
        return 'https://pluginpress.net/api/member/';
    }

	/****************** 2. PluginPress URL  **************************/
    function PPUrl(){
        return 'https://pluginpress.net/';
    }

	/****************** 3. Get Wordpress Site URL  **************************/
    function get_my_url(){
        global $wpdb;
        $result = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'options WHERE option_name="siteurl"');
        $url = "xxx.xx";
        if(count($result)>0){
            foreach ($result as $r){
                $url = $r->option_value;
                $url = str_replace('https://',"",$url);
                $url = str_replace('http://',"",$url);
                $url = str_replace('www.',"",$url);
                $url = explode("/",$url);
                $url = $url[0];
            }
        }
        return $url;
    }

	/****************** 3. Extention List  **************************/
	function getExList(){
		return [
			'quotes',
			'checkList',
			'imageListLinks',
			'ListName',
			'VideoList',
			'TitleList',
			'NameList',
			'popups',
			'popups_title',
			'popups_name',
			'WooCommerce',
			'Woo_Filmo',
			'Woo_Cast',
			'Woo_Info',
			'imdb_tabs',
			'imdb_tabs_edit',
			'imdb_tabs_add',
			'imdbTabs'
		];
	}

	/**************************  /VARIABLES  ********************************/

	//	*
	//	*
	//	*

	/**************************  CHECK  ********************************/

    /************ 1. Api DB Check *****************/
    function api_exist(){
        global $wpdb;
        $value= "";
        $result = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'options WHERE option_name="shortcode-imdb-api"');
        if(count($result)>0){
            foreach ($result as $r){
                $value = trim($r->option_value);
            }
        }
        return $value;
    }

	/************ 2. Extention Check *****************/
    function ExtentionCheck($ex=""){
        global $wpdb;
        $value="none";
        $result = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'options WHERE option_name LIKE "shortcode-imdb-ex-'.$ex.'%"');
        if(count($result)>0){
            $value = array();
            foreach ($result as $r){
                $def = $ex == "" ? str_replace('shortcode-imdb-ex-','',$r->option_name) : $ex;
                $value[$def] = $r->option_value;
            }
        }
        return $value;

    }

	/************ 3. Api Check *****************/
    function check_api($api){
		global $wpdb;
		$api = $api=="" ? "Empty" : $api;
		$api = esc_sql($api);
		$url = $this->get_my_url();
		$ip = str_replace(".","-",gethostbyname($url));
		$data = $this->curl($this->baseUrl(),$api);
		//$data = $this->direct_fetch($api);
		@$json = json_decode($data);
		$value = array();
		$value["msg"] = $data.' - '.gethostbyname($this->get_my_url());
		$value['api'] = "";
		$forbidden = "ok";
		if(strpos($data,'Forbidden')!==false){
			$forbidden = "no";
		}
		if((isset($json->member) == "active") && ($forbidden=="ok")){
			$check = $this->api_exist();
			if($check!="") {

				$wpdb->query('DELETE FROM '.$wpdb->prefix.'options WHERE option_name  LIKE "shortcode-imdb%"');
			}
			$wpdb->insert(
				$wpdb->prefix.'options',
				array(
					'option_name'    => "shortcode-imdb-api",
					'option_value'   => $api,
				)
			);

			/***************** ADDIN EXTENTIONS ***************************/
			$exList = $this->getExList();
			foreach ($exList as $ext){
				if(isset($json->$ext)){
					$wpdb->insert(
						$wpdb->prefix . 'options',
						array(
							'option_name' => "shortcode-imdb-ex-".$ext,
							'option_value' => $json->$ext,
						)
					);
					$value[$ext] = $json->$ext;
				}
			}

			/***************** /ADDIN EXTENTIONS ***************************/
			$value["api"]= $api;
			$value["msg"]= gethostbyname($this->get_my_url())."!";
			if(isset($_SESSION['imdb_secret_key'])) {
				unset($_SESSION['imdb_secret_key']);
			}
			$_SESSION['imdb_secret_key'] = $json->secret;

		}else{
			$check = $this->api_exist();
			if($check!="") {
				$wpdb->query('DELETE FROM '.$wpdb->prefix.'options WHERE option_name  LIKE "shortcode-imdb%"');
			}
			if(isset($_SESSION['imdb_secret_key'])) {
				unset($_SESSION['imdb_secret_key']);
			}


		}

		return $value;

	}

	/**************************  /CHECK  ********************************/

	/*************** 1. Secret Key *******************/
	function get_secret_key($api){
		if(isset($_SESSION['imdb_secret_key'])){
			$key =  $_SESSION['imdb_secret_key'];
		} else{
			$key = $this->curl3($this->baseUrl().$api."/secret");
			@$_SESSION['imdb_secret_key'] = $key;
		}
		return $key;
	}

	/****************** 3.Second Curl *******************/
	function curl3($url){

		$headers[]  = "User-Agent:Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.2.13) Gecko/20101203 Firefox/3.6.13";
		$headers[]  = "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
		$headers[]  = "Accept-Language:en,en-GB;q=0.5";
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










}