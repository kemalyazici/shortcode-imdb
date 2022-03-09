<?php
//TITLE SHORTCODE
function shimdb_imdb_title_shortcode($args, $content=""){
	global $SHIMDB_IMDB;
	global $SHIMDB_SKIN;
	if(substr($content,0,1)=="["){
		$content = do_shortcode($content);
	}
	$output = $SHIMDB_IMDB->grab_imdb($content,'title');

	$html = $SHIMDB_SKIN->standard_title($args,$output,$content);
	return $html;
}
//NAME SHORTCODE
function shimdb_imdb_name_shortcode($args, $content=""){
	global $SHIMDB_IMDB;
	global $SHIMDB_SKIN;
	if(substr($content,0,1)=="["){
		$content = do_shortcode($content);
	}
	$output = $SHIMDB_IMDB->grab_imdb($content,'name');
	$html = $SHIMDB_SKIN->standard_name($args,$output,$content);

	return $html;
}
//TITLE AND NAME SHORTCODE
function shimdb_imdb_general_shordcode($args, $content=""){
	if(substr($content,0,1)=="["){
		$content = do_shortcode($content);
	}
	if(substr($content,0,2) == "nm"){
		return shimdb_imdb_name_shortcode($args,$content);
	}else{
		return shimdb_imdb_title_shortcode($args,$content);
	}

}

//QUOTES SHORTCODE
function shimdb_imdb_quotes_shortcode($args, $content=""){
	global $SHIMDB_IMDB;
	global $SHIMDB_SKIN;
	if(substr($content,0,1)=="["){
		$content = do_shortcode($content);
	}

	$output = $SHIMDB_IMDB->grab_imdb($content,'title');
	$newarg['style'] = "transparent";
	$html = "";
	$html .= $SHIMDB_SKIN->standard_title($newarg,$output,$content);

	$html .=  '<div class="wrap">';
	$html .=  "<h2>Quotes</h2>";
	$html .= $SHIMDB_IMDB->quotes($args,$content,sanitize_text_field(esc_sql($output->title)));
	$html .=  "</div>";
	return $html;
}

// LISTS SHORTCODE
function shimdb_imdb_lists_shortcode($args,$content=""){
	global $SHIMDB_IMDB;
	if(substr($content,0,1)=="["){
		$content = do_shortcode($content);
	}
	return $SHIMDB_IMDB->lists($content,$args);
}

// Popovers Shortcode
function shimdb_imdb_popovers_shortcode($args,$content=""){
	global $SHIMDB_IMDB;
	if(substr($content,0,1)=="["){
		$content = do_shortcode($content);
	}
	return $SHIMDB_IMDB->popups($content,$args);
}


// Tabs Shortcode

function shimdb_imdb_tabs_shortcode($args,$content=""){
	global $SHIMDB_IMDB;
	if(substr($content,0,1)=="["){
		$content = do_shortcode($content);
	}
	return $SHIMDB_IMDB->tabs_show($content,$args);
}
function shimdb_imdb_code_shortcode($args,$content=""){
	$size = isset($args['size']) ? $args['size'].'px' : "inherit";
	$color = isset($args['color']) ? "#".$args['color'] : "inherit";
	$bg = isset($args['bg']) ? "#".$args['bg'] : "transparent";
	$html = '<div style="padding: 10px;text-align: center;width: 100%;color:'.$color.';background-color:'.$bg.';display:block;font-size:'.$size.';margin-bottom:20px;">';
	$html .= $content;
	$html .= '</div>';
	return $html;
}

/********** REGISTER ALL SHORTCODES *******/
function shimdb_imdb_register_shortcodes() {

	add_shortcode('imdb_title', 'shimdb_imdb_title_shortcode');
	add_shortcode('imdb_name', 'shimdb_imdb_name_shortcode');
	add_shortcode('imdb', 'shimdb_imdb_general_shordcode');
	add_shortcode('imdb-quotes', 'shimdb_imdb_quotes_shortcode');
	add_shortcode('imdb-lists', 'shimdb_imdb_lists_shortcode');
	add_shortcode('imdb-pop', 'shimdb_imdb_popovers_shortcode');
	add_shortcode('imdb-tab','shimdb_imdb_tabs_shortcode');
	add_shortcode('imdb-code','shimdb_imdb_code_shortcode');


}



