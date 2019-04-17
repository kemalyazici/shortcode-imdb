<?php
//FRONTEND SKINS
class shimdb_imdb_get_skin{


    function skin_converter($key){
        if(substr($key,0,5) != "imdb_"){
            $key = 'imdb_'.$key;
        }
        return $key;
    }


    /***********************  STANDART TITLE FUNC ***************************/
    function standard_title($args,$output,$content){

        /* Style Settings */
        $main_styles = array('imdb_dark', 'imdb_white', 'imdb_transparent', 'imdb_gray', 'imdb_coffee', 'imdb_black', 'imdb_navy', 'imdb_wood');
        $div_style = 'imdb_default_title';
        if(isset($args['style'])){
            $check_style= $this->skin_converter($args['style']);
            $div_style = in_array($check_style,$main_styles) ? $check_style : $div_style;
        }
        /* output html */
        $dr = $output->directors != "" ? '<span id="imdb_general"><b>Director:</b> '.$output->directors."</span>" : "";
        $wr = $output->writers != "" ? '<span id="imdb_general"><b>Writers:</b> '.$output->writers."</span>" : "";
        $sr = $output->stars != "" ? '<span id="imdb_general"><b>Stars:</b> '.$output->stars."</span>" : "";
        $runtime = $output->runtime != "" ? $output->runtime." | " : "";
        $runtime2 = $output->runtime2 != "" ? '<span id="imdb_general"><b>Runtime:</b> '.$output->runtime2."</span>" : "";
        $country = $output->country != "" ? '<span id="imdb_general"><b>Countries:</b> '.$output->country."</span>" : "";
        $lang = $output->lang != "" ? '<span id="imdb_general"><b>Languages:</b> '.$output->lang."</span>" : "";
        $year = $output->year!="" ? ' ('.$output->year.')' : "";
        $year2 = "";
        $sum = str_replace("\\'","'", $output->sum);
        $sum = str_replace("\'","'",$sum);
        $sum = str_replace('\\"','"',$sum);
        $sum = str_replace('\"','"',$sum);

        /* Title */
        $showing_title = $output->title;
        if(isset($args['title'])){
            $showing_title = $args['title'] == "aka" ? $output->aka : $output->title;
        }

        if(count(explode('pisode', $year))>1){
            $year = "";
            $year2 = str_replace("Episode aired","",$output->year);
            $year2 = " | ".trim($year2);
        }
        $release = $output->release!="" && count(explode("aired",$output->release))<2 ? " | ".$output->release : "";
        if (strpos($year, 'TV') !== false) $year = " | <small>".$output->year."</small>";
        $rating = strlen($output->rating) == 1 ? $output->rating.".0" : $output->rating;
        $html = '<div class="imdb_container"><div style="all: unset"><div class="'.$div_style.'">                               
                        <div class="imdb_left">    
                        <a href="http://www.imdb.com/title/'.$content.'" target="_blank">
                        <div class="poster_parent" style="
                        background: url('.SHIMDB_URL.'includes/assets/star.png),
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
                        <span id="movie_title"><a href="http://www.imdb.com/title/'.esc_html($content).'" target="_blank">'.esc_html($showing_title).'<small>'.$year.'</small></a></span>
                        <span id="genres">'.$runtime.$output->genres. $year2.$release.'</span>                               
                        <div class="imdb_general">'.$dr.$wr.$sr.'</div>                            
                        <span id="summary"><b>Summary: </b>'.str_replace("\\'","'",$sum).'</span>     
                        <div class="imdb_general">'.$country.$lang.'</div>                          
                        <div class="imdb-footer"><span class="imdb_copyright">Source: <a href="https://www.imdb.com" target="_blank">imdb.com</a></span><span style="display: none">Disclaimer: This plugin has been coded to automatically quote data from imdb.com. Not available for any other purpose. All showing data have a link to imdb.com. The user is responsible for any other use or change codes.</span></div>
                        </div>
                 </div></div></div>';

        $return_html = $div_style == "imdb_default_title" ? (@$args['data'] == "detailed" ? $this->default_detailed_style($args,$output,$content) : $this->default_style_title($args,$output,$content)) : $html;
        return $return_html;
    }


    /***********************  DEFAULT STYLE TITLE FUNC ***************************/

    function default_style_title($args,$output,$content){

        $dr = $output->directors != "" ? '<span class="crew"><b>Director:</b> '.$output->directors."</span>" : "";
        $wr = $output->writers != "" ? '<span class="crew"><b>Writers:</b> '.$output->writers."</span>" : "";
        $sr = $output->stars != "" ? '<span class="crew"><b>Stars:</b> '.$output->stars."</span>" : "";
        $year = $output->year!="" ? ' <small>('.$output->year.')</small>' : "";
        $country = $output->country != "" ? '<span class="crew"><b>Countries:</b> '.$output->country."</span>" : "";
        $lang = $output->lang != "" ? '<span class="crew"><b>Languages:</b> '.$output->lang."</span>" : "";
        $budget = $output->budget != "" ? '<span class="crew"><b>Budget:</b> '.$output->budget."</span>" : "";
        $transp = @$args['show'] == "transparent" ? '_tr' : '_title';
        @$check_year = explode('TV', $year);
        if(@count($check_year)>1){
            $year = "";
        }

        if(count(explode('pisode', $year))>1){
            $year = "";
        }

        $rating ="";
        if($output->rating != "?.?"){
            $rating = '<img src="'.SHIMDB_URL."includes/assets/onlystar.png".'"/> <span id="rating">'.$output->rating.'</span>';
        }
        /* Image Add*/
        $img = "";
        if($output->img!=""){
            $img .= "<h3>Photos</h3>
                    <div class='images'>";
            foreach ($output->img as $i){
                $img .= '<div><a href="'.$i->link.'" target="_blank"><img src="'.$i->img.'"/></a></div>';
            }
            $img .= '</div>
             <br><a href="https://www.imdb.com/title/'.$content.'/mediaindex" target="_blank" style="padding-left: 10px;">See all photos >></a>   
            <div class="spacer" style="clear: both;"></div><br/>';
        }

        /* Video Add */
        $video_html = "";
        if($output->trailer != ""){
            $video_html .= '<a href="'.$output->trailer->link.'" target="_blank"><div class="video"
                                    style="background: url('.$output->trailer->thumb.') no-repeat center center;"><img style="
                        display: block;
                        top: 50%; bottom: 50%;
                        margin-left: auto; margin-right: auto;" src="'.SHIMDB_URL.'includes/assets/player.png"></div></a>
                  <div class="spacer" style="clear: both;"></div>';
        }

        /* Title */
        $showing_title = $output->title;
        if(isset($args['title'])){
            $showing_title = $args['title'] == "aka" ? $output->aka : $output->title;
        }
        $showing_title = str_replace("\\'","'", $showing_title);
        $showing_title = str_replace("\'","'",$showing_title);
        $showing_title = str_replace('\\"','"',$showing_title);
        $showing_title = str_replace('\"','"',$showing_title);

        $sum = str_replace("\\'","'", $output->fullsum);
        $sum = str_replace("\'","'",$sum);
        $sum = str_replace('\\"','"',$sum);
        $sum = str_replace('\"','"',$sum);




        $html = '<div class="imdb_container">
         <div class="imdb_default'.$transp.'" style="max-width: 670px; margin-left: auto; margin-right: auto;">
         <div class="title">   
            <span class="left"><a href="http://imdb.com/title/'.$content.'/" target="_blank">'.$showing_title.'</a>'.$year.'</small>
            <small id="genres">'.$output->genres.($output->runtime != "" ? " | ".$output->runtime : "").($output->release != "" ? " | ".$output->release : "").'</small>
            </span> 
            <span class="right">
            '.$rating.'
            </span>
            <div class="spacer" style="clear: both;"></div>
         </div>     
         <div class="middle">
                <div class="poster">
                <a href="http://imdb.com/title/'.$content.'/" target="_blank"><img src="'.$output->poster.'"/></a>
                
                </div>                 
                 '.$video_html.'       
                <div class="content">
                '.$dr.$wr.$sr.'<b>Summary:</b> '.str_replace("\\'","'",$sum).'        
                
                </div>
                <div class="spacer" style="clear: both;"></div>  
            </div>
            <div class="spacer" style="clear: both;"></div>
            '.$img.'
            <div class="imdb-footer"><span class="imdb_copyright">Source: <a href="https://www.imdb.com" target="_blank" style="color: #f5c518 !important;">imdb.com</a></span></div>  
         </div> 
         </div>       
        ';

        return $html;
    }


    /***********************  DEFAULT DETAILED STYLE TITLE FUNC ***************************/

    function default_detailed_style($args,$output,$content){

        $dr = $output->directors != "" ? '<span class="crew"><b>Director:</b> '.$output->directors."</span>" : "";
        $wr = $output->writers != "" ? '<span class="crew"><b>Writers:</b> '.$output->writers."</span>" : "";
        $sr = $output->stars != "" ? '<span class="crew"><b>Stars:</b> '.$output->stars."</span>" : "";
        $year = $output->year!="" ? ' <small>('.$output->year.')</small>' : "";
        $country = $output->country != "" ? '<span class="extra"><b>Countries:</b> '.$output->country."</span>" : "";
        $lang = $output->lang != "" ? '<span class="extra"><b>Languages:</b> '.$output->lang."</span>" : "";
        $budget = $output->budget != "" ? '<span class="extra"><b>Budget:</b> '.$output->budget."</span>" : "";
        $transp = @$args['show'] == "transparent" ? '_tr' : '_title';
        @$check_year = explode('TV', $year);
        if(@count($check_year)>1){
            $year = "";
        }
        if(count(explode('pisode', $year))>1){
            $year = "";
        }
        /* Video Add */
        $video_html = "";
        if($output->trailer != ""){
            $video_html .= '<a href="'.$output->trailer->link.'" target="_blank"><div class="video"
                                    style="background: url('.$output->trailer->thumb.') no-repeat center center;"><img style="
                        display: block;
                        top: 50%; bottom: 50%;
                        margin-left: auto; margin-right: auto;" src="'.SHIMDB_URL.'includes/assets/player.png"></div></a>
                  <div class="spacer" style="clear: both;"></div>';
        }

        /* CAST */
        $cast_html = "";
        if($output->cast != ""){
            $cast_html .= '<h3>Cast</h3>';
            foreach ($output->cast as $k => $c){
                $cast_bg = ($k%2==0) ? ($transp != "_tr" ? ' style="background-color:#eeeeee"' : "") : "";
                $cast_html .= '<div class="cast"'.$cast_bg.'>
                                    <div class="profile"><a href="'.$c->link.'" target="_blank"><img src="'.$c->img.'"/></a></div>
                                    <div class="name"><a href="'.$c->link.'" target="_blank">'.$c->name.'</a></div>
                                    <div class="seperate">...</div>
                                    <div class="char">'.$c->char.'</div>
                                </div>';
            }
            $cast_html .= '<br><a href="https://www.imdb.com/title/'.$content.'/fullcredits" target="_blank" style="padding-left: 10px;">See full cast >></a>   
                    <div class="spacer" style="clear: both;"></div><hr/>';
        }

        /* Image Add*/
        $img = "";
        if($output->img!=""){
            $img .= "<h3>Photos</h3>
                    <div class='images'>";
            foreach ($output->img as $i){
              $img .= '<div><a href="'.$i->link.'" target="_blank"><img src="'.$i->img.'"/></a></div>';
            }
            $img .= '</div>
             <br><a href="https://www.imdb.com/title/'.$content.'/mediaindex" target="_blank" style="padding-left: 10px;">See all photos >></a>   
            <div class="spacer" style="clear: both;"></div><hr/>';
        }

        /* Videos Add*/
        $vid = "";
        if($output->videos!=""){
            $vid .= "<h3>Videos</h3>
                    <div class='images'>";
            foreach ($output->videos as $i){
                $vid .= '<div><a href="'.$i->link.'" target="_blank"><img src="'.$i->img.'"/></a></div>';
            }
            $vid .= '</div>
             <br><a href="https://www.imdb.com/title/'.$content.'/videogallery" target="_blank" style="padding-left: 10px;">See all videos >></a>   
            <div class="spacer" style="clear: both;"></div><hr/>';
        }

        $rating ="";
        if($output->rating != "?.?"){
            $rating = '<img src="'.SHIMDB_URL."includes/assets/onlystar.png".'"/> <span id="rating">'.$output->rating.'</span>';
        }

        /* Title */
        $showing_title = $output->title;
        if(isset($args['title'])){
            $showing_title = $args['title'] == "aka" ? $output->aka : $output->title;
        }

        /* Title */
        $showing_title = $output->title;
        if(isset($args['title'])){
            $showing_title = $args['title'] == "aka" ? $output->aka : $output->title;
        }
        $showing_title = str_replace("\\'","'", $showing_title);
        $showing_title = str_replace("\'","'",$showing_title);
        $showing_title = str_replace('\\"','"',$showing_title);
        $showing_title = str_replace('\"','"',$showing_title);

        $sum = str_replace("\\'","'", $output->fullsum);
        $sum = str_replace("\'","'",$sum);
        $sum = str_replace('\\"','"',$sum);
        $sum = str_replace('\"','"',$sum);

        $html = '<div class="imdb_container">
         <div class="imdb_default'.$transp.'">
         <div class="title">   
            <span class="left"><a href="http://imdb.com/title/'.$content.'/" target="_blank">'.$showing_title.'</a>'.$year.'</small>
            <small id="genres">'.$output->genres.($output->runtime != "" ? " | ".$output->runtime : "").($output->release != "" ? " | ".$output->release : "").'</small>
            </span> 
            <span class="right">
            '.$rating.'
            </span>
            <div class="spacer" style="clear: both;"></div>
         </div>     
         <div class="middle">
                <div class="poster">
                <a href="http://imdb.com/title/'.$content.'/" target="_blank"><img src="'.$output->poster.'"/></a>
                
                </div>                 
                 '.$video_html.'       
                <div class="content">
                '.$dr.$wr.$sr.'<b>Summary:</b> '.str_replace("\\'","'",$sum).'        
                
                </div>
                <div class="spacer" style="clear: both;"></div>  
            </div>
            <div class="spacer" style="clear: both;"></div>
            
            '.$img.$vid.$cast_html.$country.$lang.$budget.'
            
            
            
            <div class="imdb-footer"><span class="imdb_copyright">Source: <a href="https://www.imdb.com" target="_blank" '.($transp=! "_tr" ? 'style="color: #f5c518 !important;"' : "").'>imdb.com</a></span></div>  
         </div></div>
         
        ';

        return $html;

    }


    /***********************  STANDART NAME FUNC ***************************/

    function standard_name($args,$output,$content){
        $main_styles = array('imdb_dark', 'imdb_white', 'imdb_transparent', 'imdb_gray', 'imdb_coffee', 'imdb_black', 'imdb_navy', 'imdb_wood');
        $div_style = 'imdb_default_name';
        if(isset($args['style'])){
            $check_style= $this->skin_converter($args['style']);
            $div_style = in_array($check_style,$main_styles) ? $check_style : $div_style;
        }
        $known = "";
        if($output->known != ""){
            $knownfor = array();
            foreach ($output->known as $k){
                $knownfor[] = '<a href="http://www.imdb.com/title/'.$k->link.'" target="_blank"><img src="'.$k->img.'"/></a>';
            }
            $known = '<b>Known For</b><br/><span class="known_for">'.implode("", $knownfor).'</span>';
        }




        $death = $output->death != "---" ? '<div class="imdb_general"><b>Died: </b>'.$output->death.'</div>' : "";


        $name = str_replace("\\'","'", $output->name);
        $name = str_replace("\'","'",$name);
        $name = str_replace('\\"','"',$name);
        $name = str_replace('\"','"',$name);

        $bio = str_replace("\\'","'", $output->bio);
        $bio = str_replace("\'","'",$bio);
        $bio = str_replace('\\"','"',$bio);
        $bio = str_replace('\"','"',$bio);



        $html = '<div class="imdb_container">
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
                        <span id="movie_title"><a href="http://www.imdb.com/name/'.$content.'" target="_blank">  '.$name.'</a></span>
                        <span id="genres">'.$output->jobs.'</span>                             
                        <span id="summary"><b>Biography: </b>'.str_replace("\\'","'",$bio).'</span>     
                        <div class="imdb_general"><b>Born: </b>'.$output->born.'</div>'.$death.'
                        <div class="imdb_general">'.$known.'</div>                          
                        <div class="imdb-footer"><span class="imdb_copyright">Source: <a href="https://www.imdb.com" target="_blank">imdb.com</a></span></div>
                        </div>
                 </div></div></div>';
        $return_html = $div_style == "imdb_default_name" ? (@$args['data'] == "detailed" ? $this->default_detailed_name_style($args,$output,$content) : $this->default_style_name($args,$output,$content)) : $html;
        return $return_html;
    }


    /***********************  DEFAULT STYLE NAME FUNC ***************************/

    function default_style_name($args,$output,$content){
        $transp = @$args['show'] == "transparent" ? '_nametr' : '_name';
        $death = $output->death != "---" ? '<span class="info"><b>Died: </b>'.$output->death.'</span>' : "";
        $known = "";
        if($output->known != ""){
            $known .= '<h3>Known For</h3><div class="known">';
            foreach ($output->known as $k){
                $known .= '<a href="http://www.imdb.com/title/'.$k->link.'" target="_blank"><img src="'.$k->img.'"/></a>';
            }
            $known .= '</div>';
        }

        $img = "";
        if($output->img != ""){
            $img .= '<h3>Photos</h3><div class="known">';
            foreach ($output->img as $i){
                $img .= '<a href="'.$i->link.'" target="_blank"><img src="'.$i->img.'"/></a>';
            }
            $img .= '</div><a href="https://www.imdb.com/name/'.$content.'/mediaindex" style="margin-left: 10px" target="_blank">See all photos >></a><hr/>';
        }

        $name = str_replace("\\'","'", $output->name);
        $name = str_replace("\'","'",$name);
        $name = str_replace('\\"','"',$name);
        $name = str_replace('\"','"',$name);

        $bio = str_replace("\\'","'", $output->bio);
        $bio = str_replace("\'","'",$bio);
        $bio = str_replace('\\"','"',$bio);
        $bio = str_replace('\"','"',$bio);

        $html = '<div class="imdb_container">
                <div class="imdb_default'.$transp.'">
                <div class="top">
                    <div class="photo"><a href="http://www.imdb.com/name/'.$content.'/" target="_blank"><img src="'.$output->photo.'"/></a></div>
                    <div class="right">
                    <div class="header">
                    <div class="title"><a href="http://www.imdb.com/name/'.$content.'/" target="_blank">'.$name.'</a></div>
                    <div class="jobs">'.$output->jobs.'</div>
                    </div>
                    <div class="content">
                                      
                        <div class="info"><b>Biography: </b>'.str_replace("\\'","'",$bio).' <a href="https://www.imdb.com/name/'.$content.'/bio" target="_blank">See full bio >></a></div>
                        <div class="info"><b>Born: </b>'.$output->born.'</div>'.$death.'
                        
                        
                    
                    </div>
                    </div>
                    <div class="spacer" style="clear: both;"></div>
                     
                </div>  
                <div class="spacer" style="clear: both;"></div>                 
                '.$img.'
                <div class="spacer" style="clear: both;"></div>
                <div class="imdb-footer"><span class="imdb_copyright">Source: <a href="https://www.imdb.com" target="_blank" style="color: #f5c518 !important;">imdb.com</a></span></div>
                
                </div>
                </div>
                
                
        
        ';


        return $html;
    }


    /***********************  DEFAULT DETAILED STYLE TITLE FUNC ***************************/

    function  default_detailed_name_style($args,$output,$content){
        $transp = @$args['show'] == "transparent" ? '_nametr' : '_name';
        $death = $output->death != "---" ? '<span class="info"><b>Died: </b>'.$output->death.'</span>' : "";
        $known = "";
        if($output->known != ""){
            $known .= '<h3>Known For</h3><div class="known">';
            foreach ($output->known as $k){
                $known .= '<a href="http://www.imdb.com/title/'.$k->link.'" target="_blank"><img src="'.$k->img.'"/></a>';
            }
            $known .= '</div><hr/>';
        }

        $img = "";
        if($output->img != ""){
            $img .= '<h3>Photos</h3><div class="known">';
            foreach ($output->img as $i){
                $img .= '<a href="'.$i->link.'" target="_blank"><img src="'.$i->img.'"/></a>';
            }
            $img .= '</div><a href="https://www.imdb.com/name/'.$content.'/mediaindex" style="margin-left: 10px" target="_blank">See all photos >></a><hr/>';
        }

        $vids = "";
        if($output->videos != ""){
            $vids .= '<h3>Videos</h3><div class="known">';
            foreach ($output->videos as $i){
                $vids .= '<a href="'.$i->link.'" target="_blank"><img src="'.$i->img.'"/></a>';
            }
            $vids .= '</div><a href="https://www.imdb.com/name/'.$content.'/videogallery" style="margin-left: 10px" target="_blank">See all videos >></a><hr/>';
        }

        /*Actors*/
        $actor = "";
        if($output->actor  != ""){
            shuffle($output->actor);
            $actor .= '<div class="job_title">Some works as an Actor</div>';
            foreach ($output->actor as $k => $a){
                $list_bg = ($k%2==0) ? ($transp != "_nametr" ? ' style="background-color:#eeeeee"' : "") : "";
                $actor .= '<div class="list"'.$list_bg.'>'.$a.'</div>';

            }

        }

        /* Actress*/
        $actress = "";
        if($output->actress  != ""){
            shuffle($output->actress);
            $actress .= '<div class="job_title">Some works as an Actress</div>';
            foreach ($output->actress as $k => $a){
                $list_bg = ($k%2==0) ? ($transp != "_nametr" ? ' style="background-color:#eeeeee"' : "") : "";
                $actress .= '<div class="list"'.$list_bg.'>'.$a.'</div>';


            }

        }

        /* Director */
        $director = "";
        if($output->director  != ""){
            shuffle($output->director);
            $director .= '<div class="job_title">Some works as a Director</div>';
            foreach ($output->director as $k => $a){
                $list_bg = ($k%2==0) ? ($transp != "_nametr" ? ' style="background-color:#eeeeee"' : "") : "";
                $director .= '<div class="list"'.$list_bg.'>'.$a.'</div>';


            }

        }

        /* Writer */
        $writer = "";
        if($output->writer  != ""){
            shuffle($output->writer);
            $writer .= '<div class="job_title">Some works as a Writer</div>';
            foreach ($output->writer as $k => $a){
                $list_bg = ($k%2==0) ? ($transp != "_nametr" ? ' style="background-color:#eeeeee"' : "") : "";
                $writer .= '<div class="list"'.$list_bg.'>'.$a.'</div>';


            }

        }

        /* Producer */
        $pro = "";
        if($output->producer  != ""){
            shuffle($output->producer);
            $pro .= '<div class="job_title">Some works as a Producer</div>';
            foreach ($output->producer as $k => $a){
                $list_bg = ($k%2==0) ? ($transp != "_nametr" ? ' style="background-color:#eeeeee"' : "") : "";
                $pro .= '<div class="list"'.$list_bg.'>'.$a.'</div>';


            }

        }

        /* Soundtrack */
        $sound = "";
        if($output->soundtrack  != ""){
            shuffle($output->soundtrack);
            $sound .= '<div class="job_title">Soundtrack</div>';
            foreach ($output->soundtrack as $k => $a){
                $list_bg = ($k%2==0) ? ($transp != "_nametr" ? ' style="background-color:#eeeeee"' : "") : "";
                $sound .= '<div class="list"'.$list_bg.'>'.$a.'</div>';


            }

        }

        /* Sound Department */
        $soundd = "";
        if($output->soundd  != ""){
            shuffle($output->soundd);
            $soundd .= '<div class="job_title">Sound Department</div>';
            foreach ($output->soundd as $k => $a){
                $list_bg = ($k%2==0) ? ($transp != "_nametr" ? ' style="background-color:#eeeeee"' : "") : "";
                $soundd .= '<div class="list"'.$list_bg.'>'.$a.'</div>';


            }

        }


        /* Composer */
        $comp = "";
        if($output->composer  != ""){
            shuffle($output->composer);
            $comp .= '<div class="job_title">Some works as a Composer</div>';
            foreach ($output->composer as $k => $a){
                $list_bg = ($k%2==0) ? ($transp != "_nametr" ? ' style="background-color:#eeeeee"' : "") : "";
                $comp .= '<div class="list"'.$list_bg.'>'.$a.'</div>';


            }

        }

        /* Editor */
        $editor = "";
        if($output->editor  != ""){
            shuffle($output->editor);
            $editor .= '<div class="job_title">Editor</div>';
            foreach ($output->editor as $k => $a){
                $list_bg = ($k%2==0) ? ($transp != "_nametr" ? ' style="background-color:#eeeeee"' : "") : "";
                $editor .= '<div class="list"'.$list_bg.'>'.$a.'</div>';


            }

        }

        /* Self */
        $self = "";
        if($output->self  != ""){
            shuffle($output->self);
            $self .= '<div class="job_title">Self</div>';
            foreach ($output->self as $k => $a){
                $list_bg = ($k%2==0) ? ($transp != "_nametr" ? ' style="background-color:#eeeeee"' : "") : "";
                $self .= '<div class="list"'.$list_bg.'>'.$a.'</div>';


            }

        }

        $name = str_replace("\\'","'", $output->name);
        $name = str_replace("\'","'",$name);
        $name = str_replace('\\"','"',$name);
        $name = str_replace('\"','"',$name);

        $bio = str_replace("\\'","'", $output->bio);
        $bio = str_replace("\'","'",$bio);
        $bio = str_replace('\\"','"',$bio);
        $bio = str_replace('\"','"',$bio);


        $html = '<div class="imdb_container">
                <div class="imdb_default'.$transp.'">
                <div class="top">
                    <div class="photo">
                          <a href="http://www.imdb.com/name/'.$content.'/" target="_blank"><img src="'.$output->photo.'"/></a>
                    </div>
                    <div class="right">
                        <div class="header">
                            <div class="title"><a href="http://www.imdb.com/name/'.$content.'/" target="_blank">'.$name.'</a></div>
                            <div class="jobs">'.$output->jobs.'</div>
                        </div>
                        <div class="content">
                                      
                                <div class="info"><b>Biography: </b>'.str_replace("\\'","'",$bio).' <a href="https://www.imdb.com/name/'.$content.'/bio" target="_blank">See full bio >></a></div>
                                <div class="info"><b>Born: </b>'.$output->born.'</div>'.$death.'
                        
                         </div>
                    </div>
                    
                     <div class="spacer" style="clear: both;"></div>
                </div>  
                <div class="spacer" style="clear: both;"></div>                 
                '.$img.$known.$vids.'
                <div class="filmography">
                <h3>Filmography</h3>
                '.$actress.$actor.$director.$writer.$pro. $sound.$comp.$editor.$soundd.$self.'
                <div class="spacer" style="clear: both;"></div>   
                </div>
                <div class="imdb-footer"><span class="imdb_copyright">Source: <a href="https://www.imdb.com" target="_blank" '.($transp=! "_nametr" ? 'style="color: #f5c518 !important;"' : "").'>imdb.com</a></span></div>
                </div>
                </div>
                
        
        ';


        return $html;
    }

    // EDIT CACHE FIELD

    function cache_edit($id){
        global $wpdb;
        $id = esc_sql(absint($id));
        $result = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE id='.$id);
        if(count($result)>0){
         //BEGIN
            foreach ($result as $r){
                $title = $r->title;
                $imdb = $r->imdb;
                $type = $r->type;
                $cache = json_decode($r->cache);
            }
            $cover = $type=="title" ? $cache->poster : $cache->photo;
            $info = $type=="title" ? $cache->sum : $cache->bio;?>
            <div style="background-color: #ffffff; padding: 16px;">
                    <form method="post" action="<?php echo admin_url('admin.php?page=shortcode_imdb_cache')?>">

                            <div>
                                <h2>Edit Content</h2>

                                <div class="options">
                                    <p>
                                        <label>Title/Name</label>
                                        <br />
                                        <?php
                                        $title = str_replace("\\'","'",$title);
                                        $title = str_replace("\'","'",$title);
                                        $title = str_replace('\\"','"',$title);
                                        $title = str_replace('\"','"',$title);
                                        ?>
                                        <input type="text" name="imdb_title" value="<?php echo str_replace("\'","'",$title)?>" style="width: 40%"/>

                                        <input type="hidden" name="imdb_id" value="<?php echo $id?>"/>
                                        <input type="hidden" name="imdb_type" value="<?php echo $type?>"/>
                                        <input type="hidden" name="imdb_cache" value="<?php echo base64_encode(json_encode($cache))?>"/>
                                    </p>
                                </div>
                                <?php if($type=="title"):?>
                                <div class="options"><p>
                                        <label>Release Date</label>
                                        <br/>
                                        <input type="text" name="imdb_rel" value="<?php echo $cache->release?>" style="width: 40%"/>
                                    </p></div>
                                <?php endif;?>
                                <div class="options">
                                    <p>
                                        <label>Cover</label>
                                        <br />
                                        <input type="text" name="imdb_cover" value="<?php echo $cover?>" style="width: 40%"/>
                                    </p>
                                </div>
                                <div class="options">
                                    <p>
                                        <label>Biography/Summary</label>
                                        <br />
                                        <?php
                                                $info = str_replace("\\'","'",$info);
                                                $info = str_replace("\'","'",$info);
                                                $info = str_replace('\\"','"',$info);
                                                $info = str_replace('\"','"',$info);
                                                ?>
                                        <textarea name="imdb_info" style="width: 40%; height: 200px"><?php echo $info?></textarea>
                                    </p>
                                </div>

                                <div class="options">
                                    <p>
                                        <label>Big Summary (Only for Titles)</label>
                                        <br />
                                        <?php
                                        $fullsum = str_replace("\\'","'",$cache->fullsum);
                                        $fullsum = str_replace("\'","'",$fullsum);
                                        $fullsum = str_replace('\\"','"',$fullsum);
                                        $fullsum = str_replace('\"','"',$fullsum);
                                        ?>
                                        <textarea name="imdb_info2" style="width: 40%; height: 200px"><?php echo $fullsum?></textarea>
                                    </p>
                                </div>


                                <div class="options">
                                    <?php submit_button();?>
                                </div>
                            </div>
                    </form>

                </div>
            <?php


         //END
        }else{

            echo "Someting Wrong!. Cannot be reached this cache.";
        }



    }

    function cache_post($post){
        global $wpdb;
        if(isset($post['imdb_title'])){
            $new_title = sanitize_text_field($post['imdb_title']);
            $new_cover = sanitize_text_field($post['imdb_cover']);
            $new_sum = sanitize_textarea_field($post['imdb_info']);
            $new_sum2 =sanitize_textarea_field($post['imdb_info2']);
            @$new_rel =sanitize_text_field($post['imdb_rel']);
            $type = sanitize_text_field($post['imdb_type']);
            $imdb_id = absint($post['imdb_id']);
            $cache = json_decode(base64_decode($post['imdb_cache']));

            if($type=="title"){
                $cache->sum = $new_sum;
                $cache->fullsum = $new_sum2;
                $cache->poster = trim($new_cover);
                $cache->release = trim($new_rel);
                $cache->title = trim($new_title);
                $wpdb->update(
                    $wpdb->prefix.'shortcode_imdb_cache',
                    array(
                        'title' => trim($new_title),
                        'cache' => json_encode($cache)
                    ),
                    array(
                        'id'=> $imdb_id
                    )
                );
            }else if($type == "name"){
                $cache->bio = trim($new_sum);
                $cache->photo = trim($new_cover);
                $cache->name = trim($new_title);
                $wpdb->update(
                    $wpdb->prefix.'shortcode_imdb_cache',
                    array(
                        'title' => trim($new_title),
                        'cache' => json_encode($cache)
                    ),
                    array(
                        'id'=> $imdb_id
                    )
                );
            }

        }

    }


}