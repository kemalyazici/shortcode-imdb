<?php
/* @var $SHIMB_Ex;
 */
// Add action of shortcodes
add_action('init', 'shimdb_imdb_register_shortcodes');
// Add action of admin css
add_action('admin_enqueue_scripts','shimdb_imdb_admin_styles');
// Add action of frontend css
add_action('wp_enqueue_scripts','shimdb_imdb_frontend_styles',100);
//js
add_action( 'wp_footer', 'shimdb_frontpage_js',10);
// Add admin menu
add_action('admin_menu','shimdb_imdb_settings_page');
// Add admin js
add_action( 'admin_footer', 'shimdb_admin_js');



function shimdb_admin_js() {
	wp_register_script( 'shimdb_admin_app_js', SHIMDB_URL.'/includes/js/app.js', array('jquery'));
	wp_enqueue_script( 'shimdb_admin_app_js' );

	wp_register_script( 'shimdb_admin_close_js', SHIMDB_URL.'/includes/js/close.js', array('jquery'));
	wp_enqueue_script( 'shimdb_admin_close_js' );

	wp_register_script( 'shimdb_admin_listnew_js', SHIMDB_URL.'/includes/js/listnew.js', array('jquery'));
	wp_enqueue_script( 'shimdb_admin_listnew_js' );

	wp_register_script( 'shimdb_admin_sort_js', SHIMDB_URL.'/includes/js/sortable.js', array('jquery','jquery-ui-sortable'));
	wp_enqueue_script( 'shimdb_admin_sort_js' );

	wp_register_script( 'shimdb_admin_add_js', SHIMDB_URL.'/includes/js/addnew.js', array('jquery'));
	wp_enqueue_script( 'shimdb_admin_add_js' );

	wp_register_script( 'shimdb_admin_edit_js', SHIMDB_URL.'/includes/js/editlist.js', array('jquery'));
	wp_enqueue_script( 'shimdb_admin_edit_js' );

	wp_register_script( 'shimdb_admin_edit_add_js', SHIMDB_URL.'/includes/js/listeditadditem.js', array('jquery'));
	wp_enqueue_script( 'shimdb_admin_edit_add_js' );

	wp_register_script( 'shimdb_admin_notice_js', SHIMDB_URL.'/includes/js/notice.js', array('jquery'));
	wp_enqueue_script( 'shimdb_admin_notice_js' );

	if(@$_GET['page'] == "shortcode_imdb_tabs") {
		wp_register_script( 'shimdb_admin_add_tab_js', SHIMDB_URL . '/includes/js/addnewtabid.js', array( 'jquery' ) );
		wp_enqueue_script( 'shimdb_admin_add_tab_js' );
	}






	// do admin stuff here
}

function shimdb_frontpage_js(){

	wp_register_script( 'shimdb_collapse_js', SHIMDB_URL.'/includes/js/collapse.js', array('jquery'));
	wp_enqueue_script( 'shimdb_collapse_js' );

	wp_register_script( 'shimdb_scroll_js', SHIMDB_URL.'/includes/js/scroll-down.js', array('jquery'));
	wp_enqueue_script( 'shimdb_scroll_js' );

	wp_register_script( 'shimdb_popups_js', SHIMDB_URL.'/includes/js/popups.js', array('jquery'));
	wp_enqueue_script( 'shimdb_popups_js' );
	wp_register_script( 'shimdb_width_js', SHIMDB_URL.'/includes/js/width.js', array('jquery'));
	wp_enqueue_script( 'shimdb_width_js' );


}

//Woo

if(isset($SHIMB_Ex['WooCommerce'])) {


	    add_action( 'woocommerce_before_add_to_cart_button', 'shimdb_after_add_to_cart_btn' );
	    function shimdb_after_add_to_cart_btn() {
	        global $SHIMB_Ex;
		    include SHIMDB_ROOT."includes/external/woo.info.php";
	    }


	    add_filter( 'woocommerce_product_tabs', 'shimdb_new_product_tab' );
	    function shimdb_new_product_tab( $tabs ) {
// Adds the new tab
		    $imdb              = new shimdb_imdb_grab();
		    $id = get_post_meta( get_the_ID(), '_custom_product_imdb_field', true );
		    $type = $imdb->WooCommerce_type($id);
		    if($type=="title") {
			    $tabs['imdb_tab'] = array(
				    'title'    => __( $imdb->lang( 'Cast' ), 'woocommerce' ),
				    'priority' => 10,
				    'callback' => 'shimdb_new_product_tab_cast_content'
			    );
		    }else if( $type == "name"){
			    $tabs['imdb_tab'] = array(
				    'title'    => __( $imdb->lang( 'Filmography' ), 'woocommerce' ),
				    'priority' => 10,
				    'callback' => 'shimdb_new_product_tab_filmo_content'
			    );
            }

		    return $tabs;
	    }

	    function shimdb_new_product_tab_cast_content() {
		    global $SHIMB_Ex;
		    include SHIMDB_ROOT."includes/external/woo.cast.php";
	    }
	    function shimdb_new_product_tab_filmo_content() {
		    global $SHIMB_Ex;
		    include SHIMDB_ROOT."includes/external/woo.filmo.php";
	    }

	    add_action( 'woocommerce_product_options_general_product_data', 'shimdb_product_custom_fields' );
	    add_action( 'woocommerce_process_product_meta', 'shimdb_product_custom_fields_save' );


	    function shimdb_product_custom_fields() {
		    woocommerce_wp_text_input(
			    array(
				    'id'          => '_custom_product_imdb_field',
				    'placeholder' => 'tt123123 or nm12343 etc...',
				    'label'       => __( 'IMDB ID', 'woocommerce' ),
				    'type'        => 'text'
			    )
		    );
	    }

	    function shimdb_product_custom_fields_save( $post_id ) {
		    // Custom Product Text Field
		    $woocommerce_custom_product_text_field = $_POST['_custom_product_imdb_field'];
		    if ( ! empty( $woocommerce_custom_product_text_field ) ) {
			    update_post_meta( $post_id, '_custom_product_imdb_field', esc_attr( $woocommerce_custom_product_text_field ) );
		    }

	    }

}
////sessions
//function register_shimdb_session(){
//	if( !session_id() )
//		session_start();
//}
//add_action('init','register_shimdb_session');


//Notice

if( !function_exists( 'the_field' ) && empty( get_option( 'my-shimdb-notice-dismissed_v502' ) ) ) {
	add_action( 'admin_notices', 'my_shimdb_admin_update_notice_v502' );
}
if( !function_exists( 'the_field' ) && empty( get_option( 'my-shimdb-notice-dismissed_v510' ) ) ) {
	add_action( 'admin_notices', 'my_shimdb_admin_update_notice_v510' );
}
if( !function_exists( 'the_field' ) && empty( get_option( 'my-shimdb-notice-dismissed_v520' ) ) ) {
	add_action( 'admin_notices', 'my_shimdb_admin_update_notice_v520' );
}

if( !function_exists( 'the_field' ) && empty( get_option( 'my-shimdb-notice-dismissed_v600' ) ) ) {
	add_action( 'admin_notices', 'my_shimdb_admin_update_notice_v600' );
}

function my_shimdb_admin_update_notice_v502() {
	?>
	<div class="notice error my-shimdb-notice is-dismissible" style="height: 50px">
		<p><img src="<?php echo SHIMDB_URL.'includes/assets/badges/list.png'?>" style="float: left;width: 30px;margin-right: 5px"><b>To create movie lists, actor/actress lists and more, get an API Key. Details on your <?php echo '<a href="'.admin_url("admin.php?page=shortcode_imdb").'">dashboard</a>'?></b></p>
	</div>


	<?php
}

function my_shimdb_admin_update_notice_v510() {
	?>
    <div class="notice error my-shimdb-notice is-dismissible" style="height: 50px">
        <p><img src="<?php echo SHIMDB_URL.'includes/assets/badges/popovers.png'?>" style="float: left;width: 30px;margin-right: 5px"><b>To add fancy imdb popups into your posts, get an API Key. Details on your <?php echo '<a href="'.admin_url("admin.php?page=shortcode_imdb").'">dashboard</a>'?></b></p>
    </div>


	<?php
}
function my_shimdb_admin_update_notice_v520() {
	?>
    <div class="notice error my-shimdb-notice is-dismissible" style="height: 50px">
        <p><img src="<?php echo SHIMDB_URL.'includes/assets/badges/bundle.png'?>" style="float: left;width: 30px;margin-right: 5px"><b>To add imdb data into your WooCommerce Pages, get an API Key. Details on your <?php echo '<a href="'.admin_url("admin.php?page=shortcode_imdb").'">dashboard</a>'?></b></p>
    </div>


	<?php
}
function my_shimdb_admin_update_notice_v600() {
	?>
    <div class="notice error my-shimdb-notice is-dismissible" style="height: 220px">
        <p><img src="https://pluginpress.net/storage/images/VKbcUVa5VPBy7lEWZ6LmLmrcdCjUC4Rs27lOSEMq.jpg" style="float: left;width: 300px;margin-right: 15px">
        <div style="font-weight: bold;font-size: 18px;display: block;margin-bottom: 15px"><a href="<?php echo admin_url("admin.php?page=shortcode_imdb")?>">You can get "Shortcode IMDB Tabs" extension now!</a></div>
        <div style="font-size: 16px;margin-bottom: 10px">This extension allows you to create unlimited tabs for your movie posts. You can access the demos from the links below. </div>
        <div style="display: block;margin-bottom: 5px;font-weight: bold"><a href="https://demo.pluginpress.net/shortcode-imdb/2021/07/14/example-for-all-sub-menu-styles/" target="_blank">Movie example</a></div>
        <div style="display: block;margin-bottom: 5px;font-weight: bold"><a href="https://demo.pluginpress.net/shortcode-imdb/2021/07/07/rick-and-morty/" target="_blank">TV series example</a></div>
        <div style="display: block;margin-bottom: 5px;font-weight: bold"><a href="https://demo.pluginpress.net/shortcode-imdb/2021/07/07/ian-mckellen/" target="_blank">Actor example</a></div>
        <div style="display: block;margin-bottom: 5px;font-weight: bold"><a href="https://demo.pluginpress.net/shortcode-imdb/2021/07/09/shortcode-imdb-tabs/" target="_blank">Documentation</a></div>


        </p>
    </div>


	<?php
}

function my_dismiss_shimdb_notice(){
	add_option("my-shimdb-notice-dismissed_v502",'1');
	add_option("my-shimdb-notice-dismissed_v510",'1');
	add_option("my-shimdb-notice-dismissed_v520",'1');
	add_option("my-shimdb-notice-dismissed_v600",'1');
}

add_action("wp_ajax_my_dismiss_shimdb_notice", "my_dismiss_shimdb_notice");

