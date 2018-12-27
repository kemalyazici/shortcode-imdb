<?php
//CACHE LIST LAYOUT
function shimdb_imdb_cache_layout(){
    $skin = new shimdb_imdb_get_skin();
    $cache_id = isset($_GET['id']) ? $_GET['id'] : "";
    if($cache_id=="") {
        if(isset($_POST['imdb_id'])) {
            @$skin->cache_post($_POST);
        }
        $Cache = new SHIMDB_IMDB_Cache_List_Table();
        if (isset($_POST['bulk-delete'])) {
            foreach ($_POST['bulk-delete'] as $id) {
                $Cache->delete_customer(esc_sql($id));
            }
        }
        $Cache->prepare_items();
        echo "<form method='post'>";
        $Cache->search_box("Search IMDB ID/Title", "search_imdb_id");
        $Cache->display();
        echo "</form>";

     }else{

        $skin->cache_edit($cache_id);

    }
    ?>
    <p><small><b>Disclaimer:</b> This plugin has been coded to automatically quote data from imdb.com. Not available for any other purpose. All showing data have a link to imdb.com. The user is responsible for any other use or change codes.</small></p>
    <?php

}

// MAIN PAGE
function shimdb_imdb_general_info()
{
    // Double check user capabilities
    if ( !current_user_can('manage_options') ) {
        return;
    }
    ?>
    <div class="wrap">
        <div class="imdb_left" style="font-size: 14px;">
            <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
            <div style="background-color: #ffffff; padding: 16px;">
                <h3>If you updated from 1.* version, please clear all cache from <a href="admin.php?page=shortcode_imdb_cache">here</a></h3><br/>
                Shortcode IMDB is a simple but powerful plugin that can grab data from IMDB and show proper way in your articles.
                <br/>
                <h2>USAGE</h2>
                Implementing the plugin in your articles is very simple.<br/>
                Copy the imdb title or name number from the url and paste between the shortcode tags. <b>The following example illustrates how you can carry out the tags in a post.</b><br/><br/>
                <br/>
                <h3>Default Style</h3>
                With v2.0, default style of plugin has been upgrated and added some extra settings.
                <br/><br/>
                Default name shorde code is: <br/>
                <h3>[imdb]nm0000489[/imdb] <small>- (<code>[imdb_name]nm0000489[/imdb_name]</code> older version, but still can be used.)</small></h3>

                And now you can show more detaled data with data="detailed" argument. It works for only default skin.<br>
                <h3>[imdb data="detailed"]nm0000489[/imdb]</h3>

                <p><b>See default names examples from <a href="http://demo.pluginpress.net/shortcode-imdb/2018/12/09/default-name-examples/" target="_blank">demo website</a></b></p>

                <p>For titles...</p>

                <h3>[imdb]tt0109830[/imdb] <small>- (<code>[imdb_title]tt0109830[/imdb_title]</code> older version, but still can be used.)</small></h3>

                and you can show the detailed version in the same way.

                <h3>[imdb data="detailed"]tt0109830[/imdb]</h3>

                <p><b>See default title examples from <a href="http://demo.pluginpress.net/shortcode-imdb/2018/12/09/default-title-examples//" target="_blank">demo website</a></b></p>

                <p>Old styles still up there. You can reach old default style with using style="dark" tag.</p>

                All old style tags here:
                <ul>
                    <li><i aria-hidden="true" class="dashicons dashicons-yes"></i><b>dark</b> (old v. imdb_dark.)</li>
                    <li><i aria-hidden="true" class="dashicons dashicons-yes"></i><b>white</b> (old v. imdb_white.)</li>
                    <li><i aria-hidden="true" class="dashicons dashicons-yes"></i><b>gray</b> (old v. imdb_gray.)</li>
                    <li><i aria-hidden="true" class="dashicons dashicons-yes"></i><b>navy</b> (old v. imdb_navy.)</li>
                    <li><i aria-hidden="true" class="dashicons dashicons-yes"></i><b>wood</b> (old v. imdb_wood.)</li>
                    <li><i aria-hidden="true" class="dashicons dashicons-yes"></i><b>black</b> (old v. imdb_black.)</li>
                    <li><i aria-hidden="true" class="dashicons dashicons-yes"></i><b>coffee</b> (old v. imdb_coffee.)</li>
                    <li><i aria-hidden="true" class="dashicons dashicons-yes"></i><b>transparent</b> (old v. imdb_transparent.)</li>
                </ul>
                <p><h3>Example: [imdb style="dark"]tt0109830[/imdb] or [imdb style="transparent"]nm0000489[/imdb]</h3></p>
                <p><b>To demonstration, you can visit <a href="http://demo.pluginpress.net/shortcode-imdb/2018/11/29/shortcode-imdb/" target="_blank">here</a></b></p>








                <p><small><b>Disclaimer:</b> This plugin has been coded to automatically quote data from imdb.com. Not available for any other purpose. All showing data have a link to imdb.com. The user is responsible for any other use or change codes.</small></p>


            </div>
        </div>
        <div class="imdb_right">
            <div class="right_item">
                <?php shimdb_imdb_side_menu()?>
            </div>
            <div class="right_item">
                <?php shimdb_imdb_side_changelog()?>
            </div>
        </div>
    </div>
    <?php
}





// CACH LIST PAGE
function shimdb_imdb_cache_info(){
    // Double check user capabilities    ;
    if ( !current_user_can('manage_options') ) {
        return;
    }
    ?>
    <div class="wrap">
        <div class="imdb_left">

            <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
            <p><?php
                shimdb_imdb_cache_layout()

                ?></p>

        </div>
        <div class="imdb_right">
        <div class="right_item">
            <?php shimdb_imdb_side_menu()?>
        </div>
        <div class="right_item">
            <?php shimdb_imdb_side_changelog()?>
        </div>
        </div>
    </div>

    <?php

}


// ADMIN MENU SIDE BAR
function shimdb_imdb_side_menu(){
    ?>

    <div style="background: #000;width:%100;">
        <img src='<?php echo esc_url(SHIMDB_URL."includes/assets/imdblogo.png")?>' style=" left:5px; top:2px; position: relative"/>
    </div>
    <p>Publish imdb.com data in your articles.</p>

    <p><a href="http://demo.pluginpress.net/shortcode-imdb/2018/11/29/shortcode-imdb/" target="_blank">Shortcode IMDB V. 3.2</a>. </p>
    <h3>Resources</h3>
    <ul>
        <li><a href="http://pluginpress.net" target="_blank"><i aria-hidden="true" class="dashicons dashicons-external"></i> Website</a></li>
        <li><a href="mailto:pluginpress.net@gmail.com" target="_blank"><i aria-hidden="true" class="dashicons dashicons-external"></i> Contact</a> (for suggestions)</li>

    </ul>


    <b>Your donations will allow us to continue further updates and add new settings.</b>

    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick" />
        <input type="hidden" name="hosted_button_id" value="PSMRT29N7K3CE" />
        <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
        <img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" />
    </form>

    <?php
}



function shimdb_imdb_side_changelog(){
    ?>


    <h3>Changelog</h3>


    <ul>
        <b>3.2 - 2018-12-27</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some css and db insert bugs has been cleaned.</li>

        <b>3.1 - 2018-12-27</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some HTML attributes problems while cache saving solved.</li>

        <b>3.0 - 2018-12-27</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Hereafter, some cache data can be edited from "Manage Cache" screen.</li>

        <b>2.6 - 2018-12-22</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Release date bug fixed.</li>

        <b>2.5 - 2018-12-22</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Title bug on TV episodes fixed.</li>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Changed: Small changes made on old style.</li>

        <b>2.4 - 2018-12-19</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Title bug on TV episodes fixed.</li>

        <b>2.3 - 2018-12-12</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Updated: [imdb] shortcode can be used instead of imdb_title or imdb_name.</li>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Updated: white,navy etc. styles can be used instead of imdb_white, imdb_navy etc.</li>


    </ul>



    <?php
}