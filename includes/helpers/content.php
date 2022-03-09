<?php
//CACHE LIST LAYOUT
function shimdb_imdb_cache_layout($args)
{

    $skin = new shimdb_imdb_get_skin();
    $cache_id = isset($_GET['id']) ? $_GET['id'] : "";
    if ($cache_id == "") {
        //CACHE ID
        if(@$_GET['add']!="new" && @$_GET['fetch']!="new") {
            // ADD NEW ELSE
            if (isset($_POST['imdb_id'])) {
                @$skin->cache_post($_POST);
            }
            if (isset($_POST['imdb_quote_id'])) {
                @$skin->cache_quote_post($_POST);
            }
            $Cache = new SHIMDB_IMDB_Cache_List_Table($args);
            if (isset($_POST['bulk-delete'])) {
                foreach ($_POST['bulk-delete'] as $id) {
                    $Cache->delete_customer(esc_sql($id));
                }
            }

            if (@$_GET['page'] == "shortcode_imdb_lists" OR @$_GET['page'] == "shortcode_imdb_tabs") {
//                echo '<a href="' . admin_url("admin.php?page=" . $_GET['page'] . "&fetch=new") . '" class="button imdb-button">Fetch a list</a>&nbsp;';
                echo '<a href="' . admin_url("admin.php?page=" . $_GET['page'] . "&add=new") . '" class="button button-primary">Add New</a>';
            }
            $Cache->prepare_items();
            echo "<form method='post'>";
            $Cache->search_box("Search IMDB ID/Title", "search_imdb_id");
            $Cache->display();
            echo "</form>";
        }else{
            // ADD NEW
            if(@$_GET['fetch'] == "new") {
                //LİST
                if(@$_GET['page'] == "shortcode_imdb_lists") {
                    $skin->cache_list_fetch_new();
                }
            }
            else if($_GET['add'] == "new"){
                //LİST
                if(@$_GET['page'] == "shortcode_imdb_lists") {
                    $skin->cache_list_add_new();
                }
	            if(@$_GET['page'] == "shortcode_imdb_tabs") {
		            $skin->cache_tabs_add_new();
	            }
            }
        }
     //CACHE ID ELSE
    } else {
      //CACHE ID ELSE START
        // Title Edit
        if (@$_GET['page'] == "shortcode_imdb_titles") {
            $skin->cache_title_edit($cache_id);
        // Name Edit
        } else if (@$_GET['page'] == "shortcode_imdb_names") {
            $skin->cache_name_edit($cache_id);
       // Quote Edit
        } else if (@$_GET['page'] == "shortcode_imdb_quotes") {
            $skin->cache_quote_edit($cache_id);
        }
        //List Edit
        else if (@$_GET['page'] == "shortcode_imdb_lists") {
            $skin->cache_list_edit($cache_id);
        }
	    else if(@$_GET['page'] == "shortcode_imdb_tabs") {
		    $skin->cache_tabs_edit($cache_id);
	    }
     //CACHE ID ELSE END
    }
    include SHIMDB_ROOT.'includes/incadmin/disclaimer.php';

}

// MAIN PAGE
function shimdb_imdb_general_info()
{
	$IMDB = new shimdb_imdb_grab();
    // Double check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    include SHIMDB_ROOT.'includes/incadmin/dashboard.vars.php';
    include SHIMDB_ROOT.'includes/incadmin/dashboard.php';

}

// Lists Page

function shimdb_imdb_lists_info(){
    // Double check user capabilities    ;
    if (!current_user_can('manage_options')) {
        return;
    }
    $Api = new shimb_imdb_api();
    $IMDB = new shimdb_imdb_grab();
    $check = $Api->ExtentionCheck('checkList');
    if (isset($check['checkList'])) {
        ?>
        <div class="wrap">
            <div class="imdb_left">

                <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
                <p><?php
                    $args = array(
                        "type" => "list",
                        "singular" => "List",
                        "plural" => "Lists",
                        "link" => 'admin.php?page=shortcode_imdb_lists&id='
                    );
                    shimdb_imdb_cache_layout($args);

                    ?></p>

            </div>
            <div class="imdb_right">
                <div class="right_item">
                    <?php shimdb_imdb_side_menu() ?>
                </div>

            </div>
        </div>

        <?php
    } else {
        echo '<div class="wrap"><div class="imdb-message"><span>' . $IMDB->premium_msg() . '</span></div></div>';
    }

}


// Quotes PAGE
function shimdb_imdb_quotes_info()
{
    // Double check user capabilities    ;
    if (!current_user_can('manage_options')) {
        return;
    }
    $Api = new shimb_imdb_api();
    $IMDB = new shimdb_imdb_grab();
    $check = $Api->ExtentionCheck('quotes');
    if (isset($check['quotes'])) {
        ?>
        <div class="wrap">
            <div class="imdb_left">

                <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
                <p><?php
                    $args = array(
                        "type" => "quote",
                        "singular" => "Quote",
                        "plural" => "Quotes",
                        "link" => 'admin.php?page=shortcode_imdb_quotes&id='
                    );
                    shimdb_imdb_cache_layout($args);

                    ?></p>

            </div>
            <div class="imdb_right">
                <div class="right_item">
                    <?php shimdb_imdb_side_menu() ?>
                </div>

            </div>
        </div>

        <?php
    } else {
        echo '<div class="wrap"><div class="imdb-message"><span>' . $IMDB->quote_msg() . '</span></div></div>';
    }

}


// CACH LIST PAGE
function shimdb_imdb_titles_info()
{
    // Double check user capabilities    ;
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <div class="imdb_left">

            <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
            <p><?php
                $args = array(
                    "type" => "title",
                    "singular" => "Title",
                    "plural" => "Titles",
                    "link" => 'admin.php?page=shortcode_imdb_titles&id='
                );
                shimdb_imdb_cache_layout($args);

                ?></p>

        </div>
        <div class="imdb_right">
            <div class="right_item">
                <?php shimdb_imdb_side_menu() ?>
            </div>

        </div>
    </div>

    <?php

}

// CACH LIST PAGE
function shimdb_imdb_names_info()
{
    // Double check user capabilities    ;
    if (!current_user_can('manage_options')) {
        return;
    }
    ?>
    <div class="wrap">
        <div class="imdb_left">

            <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
            <p><?php
                $args = array(
                    "type" => "name",
                    "singular" => "Name",
                    "plural" => "Names",
                    "link" => 'admin.php?page=shortcode_imdb_names&id='
                );
                shimdb_imdb_cache_layout($args);

                ?></p>

        </div>
        <div class="imdb_right">
            <div class="right_item">
                <?php shimdb_imdb_side_menu() ?>
            </div>

        </div>
    </div>

    <?php

}
// Language info
function shimdb_imdb_lang_info(){
	if (!current_user_can('manage_options')) {
		return;
	}
	?>
    <div class="wrap">
    <div class="imdb_left">
    <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
    <?php
    include SHIMDB_ROOT.'includes/external/lang.php';
    ?>
    </div>
        <div class="imdb_right">
            <div class="right_item">
			    <?php shimdb_imdb_side_menu() ?>
            </div>

        </div>
    </div>
    <?php
}

// Popup info
function shimdb_imdb_popups_info(){
	if (!current_user_can('manage_options')) {
		return;
	}
	global $wpdb;

	if(isset($_POST['pop-submit'])){
		$data = array();
		$top = $_POST['top'];
		$position = $_POST['position'];
		$data['top'] = $top;
		$data['position'] = $position;
		$wpdb->delete($wpdb->prefix.'options',
            array('option_name' => 'shortcode-imdb-ex-popups-settigs')
        );
		$wpdb->insert($wpdb->prefix.'options',[
			'option_name' => 'shortcode-imdb-ex-popups-settigs',
			'option_value' => json_encode($data)
		]);
	}


	$check = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'options WHERE option_name="shortcode-imdb-ex-popups-settigs"');
	if(count($check)>0){
		foreach ($check as $c) {
			$element = json_decode($c->option_value);
			$position = $element->position;
			$top = $element->top;
			}


    }else{
	    $position = "fixed";
	    $top = "30";
    }
	?>
    <div class="wrap">
        <div class="imdb_left">

            <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
            <br/><br/>
            <form action="admin.php?page=shortcode_imdb_popups" method="post">
            <label><b>Pop-up position css:</b></label>
            <select name="position">
                <option value="fixed" <?php echo $position == "fixed" ? "selected" : "" ?>>fixed</option>
                <option value="absolute" <?php echo $position == "absolute" ? "selected" : "" ?>>absolute</option>
            </select> (Pop up position will be fixed or absolute)
            <br/><br/><br/>
            <label><b>Top range:</b></label>
            <input type="text" name="top" value="<?php echo $top?>" style="width:50px"> px (Arrange your range of popup from the top according your theme)
            <br> <br>
            <button class="button" name="pop-submit" type="submit">Save</button>
            </form>

        </div>
        <div class="imdb_right">
            <div class="right_item">
				<?php shimdb_imdb_side_menu() ?>
            </div>

        </div>
    </div>

	<?php
}

//TAB MENU
function shimdb_imdb_tabs_info(){
	if (!current_user_can('manage_options')) {
		return;
	}
	$Api = new shimb_imdb_api();
	$IMDB = new shimdb_imdb_grab();
	$check = $Api->ExtentionCheck('checkList');
	if (isset($check['checkList'])) {
		?>
        <div class="wrap">
            <div class="imdb_left">

                <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
                <p><?php
					$args = array(
						"type" => "tabs",
						"singular" => "Tab Name",
						"plural" => "Tab Names",
						"link" => 'admin.php?page=shortcode_imdb_tabs&id='
					);
					shimdb_imdb_cache_layout($args);

					?></p>

            </div>
            <div class="imdb_right">
                <div class="right_item">
					<?php shimdb_imdb_side_menu() ?>
                </div>

            </div>
        </div>

		<?php
	} else {
		echo '<div class="wrap"><div class="imdb-message"><span>' . $IMDB->premium_msg() . '</span></div></div>';
	}
}

// ADMIN MENU SIDE BAR
function shimdb_imdb_side_menu()
{
    include SHIMDB_ROOT.'includes/incadmin/sidemenu.php';
}



