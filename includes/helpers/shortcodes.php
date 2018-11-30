<?php
//TITLE SHORTCODE
function imdb_title_shortcode($args, $content=""){
    global $IMDB;
    global $SKIN;
    $output = $IMDB->grab_imdb($content,'title');

    $html = $SKIN->standard_title($args,$output,$content);
    return $html;
}
//NAME SHORTCODE
function imdb_name_shortcode($args, $content=""){
    global $IMDB;
    global $SKIN;
    $output = $IMDB->grab_imdb($content,'name');
    $html = $SKIN->standard_name($args,$output,$content);

    return $html;
}



/********** REGISTER ALL SHORTCODES *******/
function imdb_register_shortcodes() {

    add_shortcode('imdb_title', 'imdb_title_shortcode');
    add_shortcode('imdb_name', 'imdb_name_shortcode');


}



