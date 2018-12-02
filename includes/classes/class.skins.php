<?php
//FRONTEND SKINS
class shimdb_imdb_get_skin{

    function standard_title($args,$output,$content){

        /* Style Settings */
        $main_styles = array('imdb_dark', 'imdb_white', 'imdb_transparent', 'imdb_gray');
        $div_style = 'imdb_dark';
        if(isset($args['style'])){
            $div_style = in_array($args['style'],$main_styles) ? $args['style'] : $div_style;
        }
        /* output html */
        $dr = $output->directors != "" ? '<span id="imdb_general"><b>Director:</b> '.$output->directors."</span>" : "";
        $wr = $output->writers != "" ? '<span id="imdb_general"><b>Writers:</b> '.$output->writers."</span>" : "";
        $sr = $output->stars != "" ? '<span id="imdb_general"><b>Stars:</b> '.$output->stars."</span>" : "";
        $runtime = $output->runtime != "" ? '<span id="imdb_general"><b>Runtime:</b> '.$output->runtime."</span>" : "";
        $runtime2 = $output->runtime2 != "" ? '<span id="imdb_general"><b>Runtime:</b> '.$output->runtime2."</span>" : "";
        $country = $output->country != "" ? '<span id="imdb_general"><b>Countries:</b> '.$output->country."</span>" : "";
        $lang = $output->lang != "" ? '<span id="imdb_general"><b>Languages:</b> '.$output->lang."</span>" : "";
        $year = $output->year!="" ? ' ('.$output->year.')' : "";
        if (strpos($year, 'TV') !== false) $year = " | <small>".$output->year."</small>";
        $rating = strlen($output->rating) == 1 ? $output->rating.".0" : $output->rating;
        $html = '<div style="all: unset"><div class="'.$div_style.'">                               
                        <div class="imdb_left">    
                        <a href="http://www.imdb.com/title/'.$content.'" target="_blank">
                        <div class="poster_parent" style="
                        background: url('._SI_IMDB_URL_.'includes/assets/star.png),
                        url('.$output->poster.')no-repeat center center; 
                        background-size: cover; 
                        -webkit-background-size: cover;
                        -moz-background-size: cover;
                        -o-background-size: cover;
                        background-size: cover;">                            
                            <span id="imdb_rating">'.esc_html($rating).'</span>
                        </div>
                        </a>
                        </div>    
                        <div class="imdb_right">
                        <span id="movie_title"><a href="http://www.imdb.com/title/'.esc_html($content).'" target="_blank">'.esc_html($output->title).'<small>'.esc_html($year).'</small></a></span>
                        <span id="genres">'.$output->genres.'</span>                               
                        <div class="imdb_general">'.$dr.$wr.$sr.'</div>                            
                        <span id="summary"><b>Summary: </b>'.$output->sum.'</span>     
                        <div class="imdb_general">'.$runtime2.$country.$lang.'</div>                          
                        
                        </div>
                 </div></div>';
        return $html;
    }

    function standard_name($args,$output,$content){
        $main_styles = array('imdb_dark', 'imdb_white', 'imdb_transparent', 'imdb_gray');
        $div_style = 'imdb_dark';
        if(isset($args['style'])){
            $div_style = in_array($args['style'],$main_styles) ? $args['style'] : $div_style;
        }
        $known = "";
        if($output->known != ""){
            $knownfor = array();
            foreach ($output->known as $k){
                $knownfor[] = '<a href="http://www.imdb.com/title/'.$k->link.'" target="_blank"><img src="'.$k->img.'"/></a>';
            }
            $known = '<b>Known For</b><br/><span class="known_for">'.implode("", $knownfor).'</span>';
        }
        $death = $output->death != "" ? '<div class="imdb_general"><b>Died: </b>'.$output->death.'</div>' : "";

        $html = '
                 <div style="all: unset; overflow:hidden;"><div class="'.$div_style.'">
                        <div class="imdb_left">
                        <a href="http://www.imdb.com/name/'.$content.'" target="_blank">                    
                        <div class="poster_parent" style="
                        background: url('.$output->photo.')no-repeat center center; 
                        background-size: cover; 
                        -webkit-background-size: cover;
                        -moz-background-size: cover;
                        -o-background-size: cover;
                        background-size: cover;">                            
                            
                        </div>
                        </a>
                        </div>    
                        <div class="imdb_right">
                        <span id="movie_title"><a href="http://www.imdb.com/name/'.$content.'" target="_blank">  '.$output->name.'</a></span>
                        <span id="genres">'.$output->jobs.'</span>                             
                        <span id="summary"><b>Biography: </b>'.$output->bio.'</span>     
                        <div class="imdb_general"><b>Born: </b>'.$output->born.'</div>'.$death.'
                        <div class="imdb_general">'.$known.'</div>                          
                        
                        </div>
                 </div></div>';

        return $html;
    }

}