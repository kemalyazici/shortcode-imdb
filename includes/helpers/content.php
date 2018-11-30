<?php
//CACHE LIST LAYOUT
function si_imdb_cache_layout(){
    $Cache = new SI_IMDB_Cache_List_Table();
    if(isset($_POST['bulk-delete'])){
        foreach ($_POST['bulk-delete'] as $id){
            $Cache->delete_customer($id);
        }
    }
    $Cache->prepare_items();
    echo "<form method='post'>";
    $Cache->search_box("Search IMDB ID/Title","search_imdb_id");
    $Cache->display();
    echo "</form>";

}

// MAIN PAGE
function si_imdb_general_info()
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
                IMDB Shortcode is a simple but powerful plugin that can grab data from IMDB and show proper way in your articles.
                <br/>
                <h2>USAGE</h2>
                Implementing the plugin in your articles is very simple.<br/>
                Copy the imdb title or name number from the url and paste between the shortcode tags. The following example illustrates how you can carry out the tags in a post.<br/><br/>
                <h3>Name example:</h3>
                    https://www.imdb.com/name/{nm0000489}/<br/><br/>
                    <code><b>[imdb_name]nm0000489[/imdb_name]</b></code><br/><br/>
                <b>You can show the data in different styles. There is three options more.</b><br/><br/>
                    <code><b>[imdb_name style="imdb_white"]nm0000489[/imdb_name]</b></code><br/><br/>
                    <code><b>[imdb_name style="imdb_gray"]nm0000489[/imdb_name]</b></code><br/><br/>
                    <code><b>[imdb_name style="imdb_transparent"]nm0000489[/imdb_name]</b></code><br/><br/>
                <h3>Title example:</h3>
                Title can be used in a very similar way......<br/><br/>
                    https://www.imdb.com/title/{tt0120737}/<br/><br/>
            <code><b>[imdb_title]tt0120737[/imdb_title]</b></code><br/><br/>
            You can show the title in different styles just like the name.<br/><br/>
            <code><b>[imdb_title style="imdb_white"]tt0120737[/imdb_title]</b></code><br/><br/>
            <code><b>[imdb_title style="imdb_gray"]tt0120737[/imdb_title]</b></code><br/><br/>
            <code><b>[imdb_title style="imdb_transparent"]tt0120737[/imdb_title]</b></code><br/>

                <br/><b>To demonstration, you can visit our demo website from <a href="http://demo.pluginpress.net/imdb-shortcode/2018/11/29/imdb-shortcode/" target="_blank">here</a>.</b>



            </div>
        </div>
        <div class="imdb_right">
            <?php si_imdb_side_menu()?>
        </div>
    </div>
    <?php
}





// CACH LIST PAGE
function si_imdb_cache_info(){
    // Double check user capabilities    ;
    if ( !current_user_can('manage_options') ) {
        return;
    }
    ?>
    <div class="wrap">
        <div class="imdb_left">

            <h1><?php esc_html_e( get_admin_page_title() ); ?></h1>
            <p><?php
                si_imdb_cache_layout()

                ?></p>

        </div>
        <div class="imdb_right">

            <?php si_imdb_side_menu()?>



        </div>
    </div>

    <?php

}


// ADMIN MENU SIDE BAR
function si_imdb_side_menu(){
    ?>
    <h2>IMDB ShortCode Plugin</h2>
    <p>Publish imdb.com data in your articles.</p>

    <p><a href="http://pluginpress.net">IMDB Shortcode V. 1.0</a>.</p>
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