<?php
/**
 * @var shimb_imdb_api $api
 * @var shimb_imdb_api $check_img
 * @var shimb_imdb_api $style
 * @var shimb_imdb_api $button_value
 * @var shimb_imdb_api $msg
 * @var shimb_imdb_api $Api
 * * @var shimb_imdb_general $IMDB
 * @var shimb_imdb_api $quote_img
 * @var shimb_imdb_api $quote_img_note
 * @var shimb_imdb_api $list_img
 * @var shimb_imdb_api $list_img_note
 * @var shimb_imdb_api $vid_img
 * @var shimb_imdb_api $vid_img_note
 * @var shimb_imdb_api $rev_img
 * @var shimb_imdb_api $rev_img_note
 *  * @var shimb_imdb_api $popup_img
 * @var shimb_imdb_api $popup_img_note
 *  @var shimb_imdb_api $woo_img
 * @var shimb_imdb_api $woo_img_note
 *  @var shimb_imdb_api $tab_img
 * @var shimb_imdb_api $tab_img_note
 */
if ( ! defined( 'WPINC' ) ) {
    die;
}

?>
<div class="wrap">
    <div class="imdb_left" style="font-size: 14px;padding: 0">
        <h1><?php esc_html_e(get_admin_page_title()); ?></h1>
        <div style="background-color: transparent; padding: 0;" class="imdb-dashboard">
            <main>
                <input id="tab1" type="radio" name="tabs" class="none-imdb" checked>
                <label for="tab1">Dashboard</label>
                <input id="tab2" type="radio" name="tabs" class="none-imdb">
                <label for="tab2">News</label>

                <input id="tab3" type="radio" name="tabs" class="none-imdb">
                <label for="tab3">Changelog</label>

                <input id="tab4" type="radio" name="tabs" class="none-imdb">
                <label for="tab4">Documentation</label>
                <!---------------------------------****************DASHBOARD*********************************--------------------------->
                <section id="content1">
                    <!---------------------API KEY--------------------------->
                    <h2 style="">API-KEY</h2>
                    <form action="admin.php?page=shortcode_imdb" method="post">
                        <label>
                            <?php if ($api == ""): ?>
                                <h3 style="">Register on <a href="https://pluginpress.net" target="_blank">PluginPress</a>
                                    and get your key</h3>
                            <?php endif; ?>
                            <?php echo $check_img ?>
                            <input type="text" placeholder="Enter your API-Key here" value="<?php echo $api ?>"
                                   name="imdb-api" class="regular-text" <?php echo $style; ?>>
                            <input type="submit" value="<?php echo $button_value ?>"
                                   class="button" <?php echo $style; ?>>
                            <?php echo $msg; ?>
                        </label>
                    </form>
                    <br/>
                    <br/>
                    <!---------------------SETTINGS--------------------------->
                    <h2 style="">Settings</h2>
                    <form action="admin.php?page=shortcode_imdb" method="post">
                        <table class="form-table">
                            <tr>
                                <th scope="row"><label for="languages">Select Location</label></th>
                                <td><select name="imdb_location">
                                        <?php
                                        $locs =  $IMDB->get_lang_json();
                                        $location = $Api->bring_location();
                                        ksort($locs);
                                        foreach ($locs as $k => $l) {
                                            $op_value = $l['lang'] . '*' . $k;
                                            $selected = $location == $op_value ? " selected" : "";
                                            echo '<option value="' . $op_value . '"' . $selected . '>' . $l['local'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <br/><small>You can manipulate the server location. In this way, no language
                                        problem occurs in the data taken from imdb.</small>
                                </td>

                            </tr>
                            <tr>
                                <th scope="row"><label for="languages">Premium Settings</label></th>
                                <td><select name="imdb_premium_set">
                                        <?php
                                        $pre_op = $Api->premium_set();
                                        ?>
                                        <option value="show" <?php echo($pre_op == "show" ? "selected" : "") ?>>
                                            Show
                                        </option>
                                        <option value="close" <?php echo($pre_op == "close" ? "selected" : "") ?>>
                                            Don't Show
                                        </option>
                                    </select></td>
                            </tr>
                        </table>

                        <div style="left:30px;position: relative">
                            <input type="submit" class="btn button"
                                   style="background: #2a2a2a;border-color: #3a3a3a;color:#fff" name="save_dashbord"
                                   value="Save">
                        </div>
                    </form>
                    <div class="spacer" style="clear: both;"><br/><br/></div>

                    <!---------------------PREMIUM SETTINGS--------------------------->
                    <?php if ($pre_op == "show"): ?>
                        <hr/>
                        <h2 style="text-align: center;text-decoration: underline;font-weight: bold">Open Premium Settings</h2>


                        <div class="dashcard-container">
                            <div class="dashcard card-1 <?php echo $tab_img?>">
                                <div class="dashcard-check"></div>
                                <div class="dashcard-img"></div>
                                <a href="https://pluginpress.net/product/shortcode-imdb-tabs" class="dashcard-link" target="_blank">
                                    <div class="dashcard-img-hovered"></div>
                                </a>
                                <div class="dashcard-info">
                                    <div class="dashcard-about">
                                        <a class="dashcard-tag tag-tab">TABS</a>
                                        <div class="dashcard-time"><b>£39.99</b></div>
                                    </div>
                                    <h1 class="dashcard-title"><?php echo $tab_img_note?></h1>
                                    <div class="dashcard-creator">&nbsp;</div>
                                </div>
                            </div>
                            <div class="dashcard card-2 <?php echo $woo_img?>">
                                <div class="dashcard-check"></div>
                                <div class="dashcard-img"></div>
                                <a href="https://pluginpress.net/product/shortcode-imdb-woocommerce" class="dashcard-link" target="_blank">
                                    <div class="dashcard-img-hovered"></div>
                                </a>
                                <div class="dashcard-info">
                                    <div class="dashcard-about">
                                        <a class="dashcard-tag tag-woo">WooCommerce</a>
                                        <div class="dashcard-time"><b>£19.99</b></div>
                                    </div>
                                    <h1 class="dashcard-title"><?php echo $woo_img_note?></h1>
                                    <div class="dashcard-creator">&nbsp;</div>
                                </div>
                            </div>
                            <div class="dashcard card-3 <?php echo $list_img?>">
                                <div class="dashcard-check"></div>
                                <div class="dashcard-img"></div>
                                <a href="https://pluginpress.net/product/shortcode-imdb-lists" class="dashcard-link" target="_blank">
                                    <div class="dashcard-img-hovered"></div>
                                </a>
                                <div class="dashcard-info">
                                    <div class="dashcard-about">
                                        <a class="dashcard-tag tag-lists">Lists</a>
                                        <div class="dashcard-time"><b>£29.99</b></div>
                                    </div>
                                    <h1 class="dashcard-title"><?php echo $list_img_note?></h1>
                                    <div class="dashcard-creator">&nbsp;</div>
                                </div>
                            </div>
                            <div class="dashcard card-4 <?php echo $popup_img?>">
                                <div class="dashcard-check"></div>
                                <div class="dashcard-img"></div>
                                <a href="https://pluginpress.net/product/shortcode-imdb-popups" class="dashcard-link" target="_blank">
                                    <div class="dashcard-img-hovered"></div>
                                </a>
                                <div class="dashcard-info">
                                    <div class="dashcard-about">
                                        <a class="dashcard-tag tag-popups">Popups</a>
                                        <div class="dashcard-time"><b>£9.99</b></div>
                                    </div>
                                    <h1 class="dashcard-title"><?php echo $popup_img_note?></h1>
                                    <div class="dashcard-creator">&nbsp;</div>
                                </div>
                            </div>
                            <div class="dashcard card-5 <?php echo $quote_img?>">
                                <div class="dashcard-check"></div>
                                <div class="dashcard-img"></div>
                                <a href="https://pluginpress.net/product/shortcode-imdb-quotes" class="dashcard-link" target="_blank">
                                    <div class="dashcard-img-hovered"></div>
                                </a>
                                <div class="dashcard-info">
                                    <div class="dashcard-about">
                                        <a class="dashcard-tag tag-quotes">Quotes</a>
                                        <div class="dashcard-time"><b>FREE</b></div>
                                    </div>
                                    <h1 class="dashcard-title"><?php echo $quote_img_note?></h1>
                                    <div class="dashcard-creator">&nbsp;</div>
                                </div>
                            </div>

                        </div>

                        <div class="spacer" style="clear: both;"><br/><br/></div>

                    <?php endif; ?>


                </section>
                <!---------------------------------****************NEWS*********************************--------------------------->
                <section id="content2">
                    <h2>Create unlimited tabs in your movie posts</h2>
                    <a href="https://pluginpress.net/product/shortcode-imdb-tabs" target="_blank"><img src="https://pluginpress.net/storage/images/VKbcUVa5VPBy7lEWZ6LmLmrcdCjUC4Rs27lOSEMq.jpg" width="560"></a>
                    <h2>WooCommerce Extension is live now </h2>
                    <a href="https://pluginpress.net/product/shortcode-imdb-woocommerce" target="_blank"><img src="https://demo.pluginpress.net/shortcode-imdb/wp-content/uploads/2021/07/woo.png" width="560"></a>
                    <h2>Now you can create awesome lists...</h2>
                    <a href="https://pluginpress.net/product/shortcode-imdb-lists" target="_blank"><img src="https://demo.pluginpress.net/shortcode-imdb/wp-content/uploads/2021/07/imdblists.png" width="560"></a>
                    <h2>Fancy popups is live now </h2>
                    <a href="https://pluginpress.net/product/shortcode-imdb-popups" target="_blank"><img src="https://demo.pluginpress.net/shortcode-imdb/wp-content/uploads/2021/02/popup.png" width="560"></a>





                </section>
                <!---------------------------------****************CHANGELOG*********************************--------------------------->
                <section id="content3">
                    <ul>
                        <h2>Version 6.0.0 Update</h2>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>* Fixed: Important update! Plugin is now compatible with imdb's new frontend. (Some new issues fixed).</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>* Added: A new premium extension is added (TABS)</li>
                        <h2>Version 5.3 Update</h2>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>* Fixed: Important update! Plugin is now compatible with imdb's new frontend. Some hot fixes may come.</li>
                        <h2>Version 5.2 Update</h2>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Fixed some bugs.</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: WooCommerce extension is live now. You can add imdb data in your product pages. <a href="https://demo.pluginpress.net/shortcode-imdb/product/avengers-endgame-bluray/" target="_blank">Demo here</a></a></li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Language edit option added.</li>

                        <h2>Version 5.0 Update</h2>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: ssl fetch errors fixed.</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: You can fetch all filmography of an actor/actress now.</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i> Added: Name's filmography has an accordion list now.</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>* Added: You can fetch quotes of a title now. (Need registration, details on admin panel)</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>* Added: You can create awesome lists now. (Need registration, it's a premium setting. Details on admin panel)</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>* Added: Admin panel menu has a lot of options now.</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>* Added: You can manipulate the server location now. (Details on admin panel)</li>


                        <h2>Version 4.2 Update</h2>
                        Now, the plugin can grab more filmography data from imdb names. Please clear the cache to
                            see new features.
                        <h2>Version 4.1 Update</h2>
                        <b>Default mode can be shown transparent style now</b><br/><br/>
                        <b>4.5 - 2019-04-18</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Updated: Fetching Filmography
                            capacity has been expanded.
                        </li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some css issues has
                            been fixed.
                        </li>

                        <b>4.2 - 2019-04-09</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Updated: Fetching Filmography
                            capacity has been expanded.
                        </li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some css issues has
                            been fixed.
                        </li>
                        <b>4.1 - 2019-03-14</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Default mode can be
                            shown in transparent way.
                        </li>
                        <b>4.0 - 2019-03-12</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: link css bug fixed.
                        </li>
                        <b>3.8 - 2019-03-10</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Image shrink issue
                            fixed.
                        </li>
                        <b>3.7 - 2019-02-13</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Release date of a title
                            can be edited from Manage Caches menu.
                        </li>
                        <b>3.6 - 2019-01-13</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Changed: Menu order has
                            changed.
                        </li>

                        <b>3.5 - 2019-01-01</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Manage Cache search bug
                            fixed.
                        </li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Slash problem on titles
                            fixed.
                        </li>

                        <b>3.4 - 2018-12-29</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Now you can change the
                            title with aka via adding argument title="aka".
                        </li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some css bugs fixed.
                        </li>

                        <b>3.3 - 2018-12-27</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some css and db insert
                            bugs has been cleaned.
                        </li>

                        <b>3.1 - 2018-12-27</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some HTML attributes
                            problems while cache saving solved.
                        </li>

                        <b>3.0 - 2018-12-27</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: Hereafter, some cache
                            data can be edited from "Manage Cache" screen.
                        </li>

                        <b>2.6 - 2018-12-22</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Release date bug fixed.
                        </li>

                        <b>2.5 - 2018-12-22</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Title bug on TV
                            episodes fixed.
                        </li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Changed: Small changes made on
                            old style.
                        </li>

                        <b>2.4 - 2018-12-19</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Title bug on TV
                            episodes fixed.
                        </li>

                        <b>2.3 - 2018-12-12</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Updated: [imdb] shortcode can
                            be used instead of imdb_title or imdb_name.
                        </li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Updated: white,navy etc.
                            styles can be used instead of imdb_white, imdb_navy etc.
                        </li>
                        <b>2.2 - 2018-12-10</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Fixed: Some small css problems
                            fixed.
                        </li>
                        <b>2.0 - 2018-12-09</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Updated: Default style has
                            changed. You can still reach old default style with 'style="imdb_dark"'.
                        </li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: New default style can
                            be shown in detailed version. You should add the tag 'data="detailed"'.
                        </li>
                        <b>1.1 - 2018-12-05</b>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: imdb_coffee style.</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: imdb_black style.</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: imdb_navy style.</li>
                        <li><i aria-hidden="true" class="dashicons dashicons-yes"></i>Added: imdb_wood style.</li>
                    </ul>
                </section>
                <!---------------------------------****************DOCUMENTATION*********************************--------------------------->
                <section id="content4">
                    <h2>You can read the documentation from <a href="https://demo.pluginpress.net/shortcode-imdb/2021/07/19/shortcode-imdb-documentation/" target="_blank">here</a></h2>
                    

                </section>
            </main>
            <!--------------------------------------------------->
            <p><small><b>Disclaimer:</b> This plugin has been coded to automatically quote data from imdb.com. Not
                    available for any other purpose. All showing data have a link to imdb.com. The user is
                    responsible for any other use or change codes.</small></p>


        </div>
    </div>
    <div class="imdb_right">
        <div class="right_item">
            <?php shimdb_imdb_side_menu() ?>
        </div>

    </div>
</div>
