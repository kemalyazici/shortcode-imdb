<?php
//TITLE SHORTCODE
function shimdb_imdb_title_shortcode($args, $content=""){
    global $SHIMDB_IMDB;
    global $SHIMDB_SKIN;
    $output = $SHIMDB_IMDB->grab_imdb($content,'title');

    $html = $SHIMDB_SKIN->standard_title($args,$output,$content);
    return $html;
}
//NAME SHORTCODE
function shimdb_imdb_name_shortcode($args, $content=""){
    global $SHIMDB_IMDB;
    global $SHIMDB_SKIN;
    $output = $SHIMDB_IMDB->grab_imdb($content,'name');
    $html = $SHIMDB_SKIN->standard_name($args,$output,$content);

    return $html;
}

function shimdb_imdb_general_shordcode($args, $content=""){
    if(substr($content,0,2) == "nm"){
        return shimdb_imdb_name_shortcode($args,$content);
    }else{
        return shimdb_imdb_title_shortcode($args,$content);
    }

}



/********** REGISTER ALL SHORTCODES *******/
function shimdb_imdb_register_shortcodes() {

    add_shortcode('imdb_title', 'shimdb_imdb_title_shortcode');
    add_shortcode('imdb_name', 'shimdb_imdb_name_shortcode');
    add_shortcode('imdb', 'shimdb_imdb_general_shordcode');


}



