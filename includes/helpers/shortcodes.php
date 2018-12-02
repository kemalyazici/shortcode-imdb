<?php
//TITLE SHORTCODE
function si_imdb_title_shortcode($args, $content=""){
    global $_SI_IMDB;
    global $_SI_SKIN;
    $output = $_SI_IMDB->grab_imdb($content,'title');

    $html = $_SI_SKIN->standard_title($args,$output,$content);
    return $html;
}
//NAME SHORTCODE
function si_imdb_name_shortcode($args, $content=""){
    global $_SI_IMDB;
    global $_SI_SKIN;
    $output = $_SI_IMDB->grab_imdb($content,'name');
    $html = $_SI_SKIN->standard_name($args,$output,$content);

    return $html;
}



/********** REGISTER ALL SHORTCODES *******/
function shimdb_imdb_register_shortcodes() {

    add_shortcode('imdb_title', 'si_imdb_title_shortcode');
    add_shortcode('imdb_name', 'si_imdb_name_shortcode');


}



