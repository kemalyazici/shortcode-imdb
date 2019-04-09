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
            <div style="background-color: #ffffff; padding: 16px;" class="imdb-dashboard">

                <main>

                    <input id="tab1" type="radio" name="tabs" checked>
                    <label for="tab1">News</label>

                    <input id="tab2" type="radio" name="tabs">
                    <label for="tab2">Changelog</label>

                    <input id="tab3" type="radio" name="tabs">
                    <label for="tab3">Documentation</label>



                    <section id="content1">

                            <h2>GamePress - The Game Database Plugin is now live.</h2>
                            <b>
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/7w9BErlHwG8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe><br/>
                                You can download The Game Database Plugin: <a href="http://www.wordpress.org/plugins/gamepress" target="_blank">GamePress</a><br/><br/>
                                You can check the demo from  <a href="http://demo.pluginpress.net/gpress" target="_blank">here</a>
                            </b>
                            <h2>The Movie Database Plugin is coming!</h2>
                            <b>
                                The movie database plugin is also on the way. It will have an integration with Shortcode IMDB. Please support these plugins so I can focus more on it.
                                You can check news from <a href="http://www.pluginpress.net" target="_blank">pluginpress.net</a>
                            </b>



                        <br/>

                    </section>

                    <section id="content2">
                        <ul>
                            <h2>Version 4.2 Update</h2>
                            <b>Now, the plugin can grab more filmography data from imdb names. Please clear the cache to see new features.</b>
                            <h2>Version 4.1 Update</h2>
                            <b>Default mode can be shown transparent style now</b><br/><br/>

                            <b>4.2 - 2019-04-09</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Updated: Fetching Filmography capacity has been expanded.</li>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some css issues has been fixed.</li>
                            <b>4.1 - 2019-03-14</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Default mode can be shown in transparent way.</li>
                            <b>4.0 - 2019-03-12</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: link css bug fixed.</li>
                            <b>3.8 - 2019-03-10</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Image shrink issue fixed.</li>
                            <b>3.7 - 2019-02-13</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Release date of a title can be edited from Manage Caches menu.</li>
                            <b>3.6 - 2019-01-13</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Changed: Menu order has changed.</li>

                            <b>3.5 - 2019-01-01</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Manage Cache search bug fixed.</li>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Slash problem on titles fixed.</li>

                            <b>3.4 - 2018-12-29</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Now you can change the title with aka via adding argument title="aka".</li>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some css bugs fixed.</li>

                            <b>3.3 - 2018-12-27</b>
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
                            <b>2.2 - 2018-12-10</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some small css problems fixed.</li>
                            <b>2.0 - 2018-12-09</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Updated: Default style has changed. You can still reach old default style with 'style="imdb_dark"'.</li>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: New default style can be shown in detailed version. You should add the tag 'data="detailed"'.</li>
                            <b>1.1 - 2018-12-05</b>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: imdb_coffee style.</li>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: imdb_black style.</li>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: imdb_navy style.</li>
                            <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: imdb_wood style.</li>



                        </ul>
                    </section>

                    <section id="content3">



                            <h2>USAGE</h2>
                            Implementing the plugin in your articles is very simple.<br/>
                            Copy the imdb title or name number from the url and paste between the shortcode tags. <b>The following examples illustrates how you can carry out the tags in a post.</b><br/>
                            <br/>
                             <h2>Default Mode</h2>
                            <b>Title: [imdb]tt0109830[/imdb] </b><br/>
                            <b>Name: [imdb]nm0000489[/imdb] /b>
                             <br><br>
                            If you add data="detailed" argument in the tag, the content will be shown more detailed. Please note that, it works for only default skin.
                            <br/>
                            <b>[imdb data="detailed"]tt0107692[/imdb]</b>
                            <br/>
                            <b>[imdb data="detailed"]nm0000489[/imdb]</b>
                            <br/><br/>
                            <a href="http://demo.pluginpress.net/shortcode-imdb/2018/12/09/default-title-examples/" target="_blank">Title Examples</a><br/>
                                <a href="http://demo.pluginpress.net/shortcode-imdb/2018/12/09/default-name-examples/" target="_blank">Name Examples</a>
                            <br/>
                            <br/>
                            You can show "also known as" title of a movie by adding title="aka" argument. For instance, when you add an anime movie, the content will be shown with original title.
                            <br/>
                            <b>[imdb title="aka"]tt0107692[/imdb]</b>
                            <br/><br/>
                            You can turn default skin to transparent.<br/>

                            Normal name/title:<br/>
                            <b>[imdb show="transparent"]tt0109830[/imdb]</b><br/>

                            Detailed name/title:<br/>
                            <b>[imdb show="transparent" data="detailed"]tt0109830[/imdb]</b>

                                <br/><br/> <a href="http://demo.pluginpress.net/shortcode-imdb/2019/03/14/full-tranparent-examples/" target="_blank">Examples</a>

                            <h2>Old Styles</h2>
                            You can show the content with different styles. These features are from the old version.
                            <br/><b>Example: [imdb style="dark"]tt0109830[/imdb] or [imdb style="transparent"]nm0000489[/imdb]</b>
                            <br/><br/>
                        <b>All old style tags here:</b><br>
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
                        <p><b>To demonstration, you can visit <a href="http://demo.pluginpress.net/shortcode-imdb/2018/11/29/shortcode-imdb/" target="_blank">here</a></b></p>








                    </section>



                </main>



                <!--------------------------------------------------->






                <p><small><b>Disclaimer:</b> This plugin has been coded to automatically quote data from imdb.com. Not available for any other purpose. All showing data have a link to imdb.com. The user is responsible for any other use or change codes.</small></p>


            </div>
        </div>
        <div class="imdb_right">
            <div class="right_item">
                <?php shimdb_imdb_side_menu()?>
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

    <p><a href="http://demo.pluginpress.net/shortcode-imdb/2018/11/29/shortcode-imdb/" target="_blank">Shortcode IMDB V. 4.2</a>. </p>
    <h3>Resources</h3>
    <ul>
        <li><a href="http://pluginpress.net" target="_blank"><i aria-hidden="true" class="dashicons dashicons-external"></i> Website</a></li>
        <li><a href="mailto:pluginpress.net@gmail.com" target="_blank"><i aria-hidden="true" class="dashicons dashicons-external"></i> Contact</a> (for suggestions)</li>

    </ul>


    <div class="imdb_donation">Your donations will allow me to continue further updates and new projects.</div>

    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick" />
        <input type="hidden" name="hosted_button_id" value="PSMRT29N7K3CE" />
        <input type="image" src="https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
        <img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1" />
    </form>
    <a href="http://www.wordpress.org/plugins/gamepress" target="_blank"><img src='<?php echo esc_url(SHIMDB_URL."includes/assets/gp.jpg");?>' style="width: 100%"/></a>

    <?php
}



function shimdb_imdb_side_changelog(){
    ?>


    <h3>Changelog</h3>


    <ul>
        <b>4.2 - 2019-04-09</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Updated: Fetching Filmography capacity has been expanded.</li>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some css issues has been fixed.</li>
        <b>4.1 - 2019-03-14</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Default mode can be shown in transparent way.</li>
        <b>4.0 - 2019-03-12</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: link css bug fixed.</li>
        <b>3.8 - 2019-03-10</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Image shrink issue fixed.</li>
        <b>3.7 - 2019-02-13</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Release date of a title can be edited from Manage Caches menu.</li>
        <b>3.6 - 2019-01-13</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Changed: Menu order has changed.</li>

        <b>3.5 - 2019-01-01</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Manage Cache search bug fixed.</li>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Slash problem on titles fixed.</li>

        <b>3.4 - 2018-12-29</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Now you can change the title with aka via adding argument title="aka".</li>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some css bugs fixed.</li>

        <b>3.3 - 2018-12-27</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some css and db insert bugs has been cleaned.</li>

        <b>3.1 - 2018-12-27</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some HTML attributes problems while cache saving solved.</li>

        <b>3.0 - 2018-12-27</b>
        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Hereafter, some cache data can be edited from "Manage Cache" screen.</li>



    </ul>



    <?php
}