<?php
if ( ! defined( 'WPINC' ) ) {
    die;
}
//API CLASS
$Api = new  shimb_imdb_api();
$api = $Api->api_exist();
$ex = $Api->ExtentionCheck();
//VARIABLES
$msg = "";
$check_img = "";

$quote_img = '';
$quote_img_note = '<br/>You can show quotes from a movie or TV show easily.';

$list_img = '';
$list_img_note = 'You can create lists about titles, names and fetch lists from imdb.';

$woo_img = '';
$woo_img_note = 'You can easily add movie and actor information to your product pages.';

$tab_img = '';
$tab_img_note = 'This extention allows you to create unlimited tabs for your movie posts.';

$popup_img = '';
$popup_img_note = '<br/>Add fancy imdb popups in your posts.';


//API CHECK
if ($api!="") {
    $style = 'style="border-color:#3a9551;color: #3a9551"';
    $button_value = "Update";
    $check_img = '<img src="' . SHIMDB_URL . 'includes/assets/check.png" style="float:left;"/>';

    /********************* EXTENTION CHECK ******************************/
    // Quote
    if(isset($ex['quotes'])){
        $quote_img = 'dashcard-bought';
        $quote_img_note = '<br><br><div style="text-align: center">QUOTES</div>';
    }else{
        $quote_img = '';
	    $quote_img_note = 'You can show quotes from a movie or TV show easily.';
    }
    // List
    if(isset($ex['checkList'])){
        $list_img = 'dashcard-bought';
        $list_img_note = '<br><br><div style="text-align: center">LISTS</div>';
    }
    if(isset($ex['popups'])){
	    $popup_img = 'dashcard-bought';
	    $popup_img_note = '<br><br><div style="text-align: center">POPUPS</div>';
    }
	//WOO
	if(isset($ex['WooCommerce'])){
		$woo_img = 'dashcard-bought';
		$woo_img_note = '<br><br><div style="text-align: center">WOOCOMMERCE</div>';
	}
	//TAB
	if(isset($ex['imdbTabs'])){
		$tab_img = 'dashcard-bought';
		$tab_img_note = '<br><br><div style="text-align: center">TABS</div>';
	}
    /********************* /EXTENTION CHECK ******************************/
} else {
    $style = "";
    $button_value = "Check";
}
//POST
if (isset($_POST['imdb-api'])) {
    $apis = $Api->check_api(trim($_POST['imdb-api']));
    if ($apis["api"] != "") {
        $api = $apis["api"];
        $style = 'style="border-color:#3a9551;color: #3a9551"';
        $button_value = "Update";
        $check_img = '<img src="' . SHIMDB_URL . 'includes/assets/check.png" style="float:left;"/>&nbsp;';
        //****************************EXTENTION CHECK2 **********************/
        // QUOTES
        if(isset($apis['quotes'])){
	        $quote_img = 'dashcard-bought';
	        $quote_img_note = '<br><br><div style="text-align: center">QUOTES</div>';
        }else{
	        $quote_img = '';
	        $quote_img_note = '<br/>You can show quotes from a movie or TV show easily.';
        }
        // List
        if(isset($apis['checkList'])){
	        $list_img = 'dashcard-bought';
	        $list_img_note = '<br><br><div style="text-align: center">LISTS</div>';
        }else{
	        $list_img = '';
	        $list_img_note = 'You can create lists about titles, names and fetch lists from imdb.';
        }
        //Popups
	    if(isset($apis['popups'])){
		    $popup_img = 'dashcard-bought';
		    $popup_img_note = '<br><br><div style="text-align: center">POPUPS</div>';
	    }else{
		    $popup_img = '';
		    $popup_img_note = '<br/>Add fancy imdb popups in your posts.';
	    }
	    //Woo
	    if(isset($apis['WooCommerce'])){
		    $woo_img = 'dashcard-bought';
		    $woo_img_note = '<br><br><div style="text-align: center">WOOCOMMERCE</div>';
	    }else{
		    $woo_img = '';
		    $woo_img_note = 'You can easily add movie and actor information to your product pages.';
	    }
	    if(isset($apis['imdbTabs'])){
		    $tab_img = 'dashcard-bought';
		    $tab_img_note = '<br><br><div style="text-align: center">TABS</div>';
	    }else{
		    $tab_img = 'dashcard-bought';
		    $tab_img_note = '<br><br><div style="text-align: center">TABS</div>';
	    }

        //**************************** /EXTENTION CHECK2 **********************/
    } else {
        $style = 'style="border-color:red;color: red"';
        $button_value = "Check";
        $msg = "<br><small style='color: red'>Api-Key is not valid or you cannot use it on this domain...<br>Did you add your web address on pluginpress.net?</small>";
        $check_img = '<img src="' . SHIMDB_URL . 'includes/assets/error.png" style="float:left;"/>&nbsp;';

        /******************* EXTENTION CHECK3*************************/
	    $quote_img = '';
	    $quote_img_note = '<br/>You can show quotes from a movie or TV show easily.';

	    $list_img = '';
	    $list_img_note = 'You can create lists about titles, names and fetch lists from imdb.';

	    $woo_img = '';
	    $woo_img_note = 'You can easily add movie and actor information to your product pages.';

	    $tab_img = '';
	    $tab_img_note = 'This extention allows you to create unlimited tabs for your movie posts.';

	    $popup_img = '';
	    $popup_img_note = '<br/>Add fancy imdb popups in your posts.';
        /*******************  /EXTENTION CHECK3***************************/

    }
}

if (isset($_POST['save_dashbord'])) {
    $Api->save_location($_POST['imdb_location']);
    $Api->premium_set_save($_POST['imdb_premium_set']);
}
