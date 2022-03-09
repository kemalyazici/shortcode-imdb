<?php
class shimdb_imdb_get_skin extends shimb_imdb_api {
//**BEGIN

    /*********************************************** TEMPLATES *******************************************************/

    /***********************  1. Standard Title Template ***************************/
    function standard_title($args,$output,$content){

        $arr = array();

	    $arr['content'] = esc_html($content);
        /* Style Settings */
        $main_styles = array('imdb_dark', 'imdb_white', 'imdb_transparent', 'imdb_gray', 'imdb_coffee', 'imdb_black', 'imdb_navy', 'imdb_wood');
	    $arr['div_style'] = 'imdb_default_title';
        if(isset($args['style'])){
            $check_style= $this->skin_converter($args['style']);
	        $arr['div_style'] = in_array($check_style,$main_styles) ? $check_style : $arr['div_style'];
        }
        /* output html */
	    $arr['dr'] = $output->directors != "" ? '<span id="imdb_general"><b>'.$this->lang('Director').':</b> '.$output->directors."</span>" : "";
	    $arr['wr'] = $output->writers != "" ? '<span id="imdb_general"><b>'.$this->lang('Writer').':</b> '.$output->writers."</span>" : "";
	    $arr['sr'] = $output->stars != "" ? '<span id="imdb_general"><b>'.$this->lang('Stars').':</b> '.$output->stars."</span>" : "";
	    $arr['runtime'] = $output->runtime != "" ? $this->min_translator($output->runtime).$this->lang('min')." | " : "";
	    $arr['runtime2'] = $output->runtime2 != "" ? '<span id="imdb_general"><b>'.$this->lang('Runtime').':</b> '.$output->runtime2."</span>" : "";
	    $arr['country'] = $output->country != "" ? '<span id="imdb_general"><b>'.$this->lang('Countries').':</b> '.$output->country."</span>" : "";
	    $arr['lang'] = $output->lang != "" ? '<span id="imdb_general"><b>'.$this->lang('Languages').':</b> '.$output->lang."</span>" : "";
	    $arr['year'] = $output->year!="" ? ' ('.$output->year.')' : "";
	    $arr['year2'] = "";
	    $arr['sum'] = str_replace("\\'","'", $output->sum);
	    $arr['sum'] = str_replace("\'","'",$arr['sum']);
	    $arr['sum'] = str_replace('\\"','"',$arr['sum']);
	    $arr['sum'] = str_replace('\"','"',$arr['sum']);

        /* Title */
	    $arr['showing_title'] = esc_html($output->title);
        if(isset($args['title'])){
	        $arr['showing_title'] = $args['title'] == "aka" ? $output->aka : $output->title;
        }

        if(count(explode('pisode', $arr['year']))>1){
	        $arr['year'] = "";
	        $arr['year2'] = str_replace("Episode aired","",$output->year);
	        $arr['year2'] = " | ".trim($arr['year2']);
        }
	    $arr['release'] = $output->release!="" && count(explode("aired",$output->release))<2 ? " | ".$this->date_translator($output->release) : "";
        if (strpos($arr['year'], 'TV') !== false) $arr['year'] = " | <small>".$output->year."</small>";
	    $arr['rating'] = strlen($output->rating) == 1 ? $output->rating.".0" : $output->rating;
	    $arr['rating'] = esc_html($arr['rating']);
	    $arr['starPNG'] = SHIMDB_URL."includes/assets/star.png";
	    $arr['poster'] = $output->poster;
	    $genres = array();
	    $genre_arr = explode(',',$output->genres);
	    foreach ($genre_arr as $g){
		    $genres[] = $this->lang(trim($g));
	    }
	    $arr['genres'] = implode(', ',$genres);
	    $arr['summary'] = $this->lang('Summary');
	    $arr['source'] = $this->lang('Source');

	    $html = $this->get_file('standard-title');


	    $html = $this->html_fetcher($arr,$html);

        $return_html = $arr['div_style'] == "imdb_default_title" ? $this->default_style_title($args,$output,$content) : $html;
        return $return_html;
    }


	/***********************  2. Default Style Title Template ***************************/
    function default_style_title($args,$output,$content){

	    $arr = array();
	    $arr['content'] = $content;
	    $budget = str_replace('estimated',$this->lang('estimated'),$output->budget);
        $arr['dr']= $output->directors != "" ? '<span class="crew"><b>'.$this->lang('Director').':</b> '.$output->directors."</span>" : "";
	    $arr['wr'] = $output->writers != "" ? '<span class="crew"><b>'.$this->lang('Writer').':</b> '.$output->writers."</span>" : "";
	    $arr['sr'] = $output->stars != "" ? '<span class="crew"><b>'.$this->lang('Stars').':</b> '.$output->stars."</span>" : "";
	    $arr['year'] = $output->year!="" ? ' <small>('.$output->year.')</small>' : "";
	    $arr['country'] = $output->country != "" ? '<span class="extra"><b>'.$this->lang('Countries').':</b> '.$output->country."</span>" : "";
	    $arr['lang'] = $output->lang != "" ? '<span class="extra"><b>'.$this->lang('Languages').':</b> '.$output->lang."</span>" : "";
	    $arr['budget'] = $output->budget != "" ? '<span class="extra"><b>'.$this->lang('Budget').':</b> '.$budget."</span>" : "";
	    $arr['transp'] = isset($args['show']) == "transparent" ? '_tr' : '_title';
        $check_year = explode('TV', $arr['year']);
        if(@count($check_year)>1){
	        $arr['year'] = "";
        }

        if(count(explode('pisode', $arr['year']))>1){
	        $arr['year'] = "";
        }

	    $arr['rating'] ="";
        if($output->rating != "?.?"){
	        $arr['rating'] = '<img src="'.SHIMDB_URL."includes/assets/onlystar.png".'"/> <span id="rating">'.$output->rating.'</span>';
        }
        /* Image Add*/
	    $arr['img'] = "";
        if($output->img!=""){
	        $arr['img'] .= "<h3>".$this->lang('Photos')."</h3>
                    <div class='images'>";
            foreach ($output->img as $k => $i){
	            $arr['img'] .= '<div><a href="'.$i->link.'" target="_blank"><img src="'.$i->img.'" style="width: 99px"/></a></div>';
	            if($k==5){
		            break;
	            }
            }
	        $arr['img'] .= '</div>
             <br><a href="https://www.imdb.com/title/'.$content.'/mediaindex" target="_blank" style="padding-left: 10px;">'.$this->lang("See all photos").' >></a>   
            <div class="spacer" style="clear: both;"></div><br/>';
        }

	    $arr['vid'] = "";
	    if($output->videos!=""){
		    $arr['vid'] .= "<h3>".$this->lang('Videos')."</h3>
                    <div class='images'>";
		    foreach ($output->videos as $k => $i){
			    $arr['vid'] .= '<div><a href="'.$i->link.'" target="_blank"><img src="'.$i->img.'" style="width: 100px"/></a></div>';
			    if($k==5){
			        break;
                }
		    }
		    $arr['vid'] .= '</div>
             <br><a href="https://www.imdb.com/title/'.$content.'/videogallery" target="_blank" style="padding-left: 10px;">'.$this->lang("See all videos").' >></a>   
            <div class="spacer" style="clear: both;"></div><br/>';
	    }

	    /* CAST */
	    $cast_html = "";
	    if($output->cast != ""){
		    $cast_html .= '<h3>'.$this->lang('Cast').'</h3>';
		    foreach ($output->cast as $k => $c){
			    $cast_bg = ($k%2==0) ? ($arr['transp'] != "_tr" ? ' style="background-color:#eeeeee"' : "") : "";
			    $cast_html .= '<div class="cast"'.$cast_bg.'>
                                    <div class="profile"><a href="'.$c->link.'" target="_blank"><img src="'.$c->img.'"/></a></div>
                                    <div class="name"><a href="'.$c->link.'" target="_blank">'.$c->name.'</a></div>
                                    <div class="seperate">...</div>
                                    <div class="char">'.$c->char.'</div>
                                </div>';
		    }
		    $cast_html .= '<br><a href="https://www.imdb.com/title/'.$content.'/fullcredits" target="_blank" style="padding-left: 10px;">'.$this->lang('See full cast').' >></a>   
                    <div class="spacer" style="clear: both;"></div><hr/>';
	    }

	    $arr['cast_html'] = $cast_html;

        /* Video Add */
	    $arr['video_html'] = "";
        if($output->trailer != ""){
	        $arr['video_html'] .= '<a href="'.$output->trailer->link.'" target="_blank"><div class="video"
                                    style="background: url('.$output->trailer->thumb.') no-repeat center center;"><img style="
                        display: block;
                        top: 50%; bottom: 50%;
                        margin-left: auto; margin-right: auto;" src="'.SHIMDB_URL.'includes/assets/player.png"></div></a>
                  <div class="spacer" style="clear: both;"></div>';
        }

        /* Title */
	    $arr['showing_title'] = $output->title;
        if(isset($args['title'])){
	        $arr['showing_title'] = $args['title'] == "aka" ? $output->aka : $output->title;
        }
	    $arr['showing_title'] = str_replace("\\'","'", $arr['showing_title']);
	    $arr['showing_title'] = str_replace("\'","'",$arr['showing_title']);
	    $arr['showing_title'] = str_replace('\\"','"',$arr['showing_title']);
	    $arr['showing_title'] = str_replace('\"','"',$arr['showing_title']);

	    $arr['sum'] = str_replace("\\'","'", $output->fullsum);
	    $arr['sum'] = str_replace("\'","'",$arr['sum']);
	    $arr['sum'] = str_replace('\\"','"',$arr['sum']);
	    $arr['sum'] = str_replace('\"','"',$arr['sum']);
	    $arr['sum'] = str_replace("\\'","'",$arr['sum']);
	    $genres = array();
	    $genre_arr = explode(',',$output->genres);
	    foreach ($genre_arr as $g){
	        $genres[] = $this->lang(trim($g));
        }
        $arr['genres'] = implode(', ',$genres);
        $arr['runtime'] = $output->runtime != "" ? " | ".$this->min_translator($output->runtime).$this->lang('min') : "";
        $arr['release'] = $output->release != "" ? " | ".$this->date_translator($output->release) : "";
        $arr['poster'] = $output->poster;
	    $arr['summary'] = $this->lang('Summary');
	    $arr['source'] = $this->lang('Source');



        $html = isset($args['data']) == "detailed" ? $this->get_file('default-detailed-style-title') : $this->get_file('default-style-title');
        $html = $this->html_fetcher($arr,$html);

        return $html;
    }


    /***********************  3. Standard Name Template ***************************/
    function standard_name($args,$output,$content){
        $arr = array();
        $main_styles = array('imdb_dark', 'imdb_white', 'imdb_transparent', 'imdb_gray', 'imdb_coffee', 'imdb_black', 'imdb_navy', 'imdb_wood');
        $arr['div_style'] = 'imdb_default_name';
	    $arr['content'] = $content;
        if(isset($args['style'])){
            $check_style= $this->skin_converter($args['style']);
	        $arr['div_style'] = in_array($check_style,$main_styles) ? $check_style : $arr['div_style'];
        }
        $arr['known'] = "";
        if($output->known != ""){
            $knownfor = array();
            foreach ($output->known as $k){
                $knownfor[] = '<a href="http://www.imdb.com/title/'.$k->link.'" target="_blank"><img src="'.$k->img.'"/></a>';
            }
	        $arr['known'] = '<b>'.$this->lang('Known For').'</b><br/><span class="known_for">'.implode("", $knownfor).'</span>';
        }



	    $Death = str_replace(" in"," |",$this->date_translator($output->death));
	    $Death = str_replace('age ',$this->lang('age').' ',$Death);
	    $arr['death'] = $output->death != "---" ? '<div class="imdb_general"><b>'.$this->lang('Died').': </b>'.$Death.'</div>' : "";


        $name = str_replace("\\'","'", $output->name);
        $name = str_replace("\'","'",$name);
        $name = str_replace('\\"','"',$name);
        $name = str_replace('\"','"',$name);
	    $arr['name'] = $name;

        $bio = str_replace("\\'","'", $output->bio);
        $bio = str_replace("\'","'",$bio);
        $bio = str_replace('\\"','"',$bio);
        $bio = str_replace('\"','"',$bio);
	    $arr['bio'] = $bio;
	    $arr['photo'] = $output->photo;
	    $myjobs = explode(',',$output->jobs);
	    $job_tr = array();
	    foreach ($myjobs as $j){
		    $job_tr[] = $this->lang(trim($j));
	    }
	    $arr['jobs'] = implode(", ",$job_tr);
	    $arr['born'] = str_replace(" in"," |",$this->date_translator($output->born));
	    $arr['source'] = $this->lang('Source');
	    $arr['bio_title'] = $this->lang('Biography');
	    $arr['see_full_bio'] = $this->lang('See full bio');
	    $arr['born_title'] = $this->lang('Born');

	    $html = $this->get_file('standard-name');
	    $html = $this->html_fetcher($arr,$html);
        $return_html = $arr['div_style'] == "imdb_default_name" ? $this->default_style_name($args,$output,$content) : $html;
        return $return_html;
    }


	/***********************  4. Default Style Name Template ***************************/
    function default_style_name($args,$output,$content){
        $arr = array();
	    $arr['content'] = $content;
	    $arr['transp'] = isset($args['show']) == "transparent" ? '_nametr' : '_name';
	    $Death = str_replace(" in"," |",$this->date_translator($output->death));
	    $Death = str_replace('age ',$this->lang('age').' ',$Death);
	    $arr['death'] = $output->death != "---" ? '<span class="info"><b>'.$this->lang('Died').': </b>'.$Death.'</span>' : "";
	    $known = "";
	    if($output->known != ""){
		    $known .= '<h3>'.$this->lang('Known For').'</h3><div class="known">';
		    foreach ($output->known as $k){
			    $known .= '<a href="http://www.imdb.com/title/'.$k->link.'" target="_blank"><img src="'.$k->img.'"/></a>';
		    }
		    $known .= '</div><hr/>';
	    }

	    $arr['known'] = $known;

	    $img = "";
	    if($output->img != ""){
		    $img .= '<h3>'.$this->lang('Photos').'</h3><div class="known">';
		    foreach ($output->img as $i){
			    $img .= '<a href="'.$i->link.'" target="_blank"><img src="'.$i->img.'"/></a>';
		    }
		    $img .= '</div><a href="https://www.imdb.com/name/'.$content.'/mediaindex" style="margin-left: 10px" target="_blank">'.$this->lang('See all photos').' >></a><hr/>';
	    }

	    $arr['img'] = $img;

	    $vids = "";
	    if($output->videos != ""){
		    $vids .= '<h3>'.$this->lang('Videos').'</h3><div class="known">';
		    foreach ($output->videos as $i){
			    $vids .= '<a href="'.$i->link.'" target="_blank"><img src="'.$i->img.'"/></a>';
		    }
		    $vids .= '</div><a href="https://www.imdb.com/name/'.$content.'/videogallery" style="margin-left: 10px" target="_blank">'.$this->lang('See all videos').' >></a><hr/>';
	    }

	    $arr['vids'] = $vids;

	    $filmo = "";
	    if($output->filmo!=""){
		    foreach ($output->filmo as $k => $film){
			    $filmo .= '<div class="job_title"><a href="#" class="imdb_job_click" style="background-color: transparent; font-size: 18px" imdat="'.sanitize_title($k).'">'.$this->lang($k).'<span class="imdb-arrow"><div class="imdb-arrow-down imdb_arrow_'.sanitize_title($k).'"></div></span></a></div><div class="imdb_job_'.sanitize_title($k).' panel-collapsed">';
			    foreach ($film as $a){
				    $filmo .= '<div class="list">'.$a.'</div>';

			    }
			    $filmo .= "</div><br/>";

		    }
        }

	    $arr['filmo'] = $filmo;



	    $name = str_replace("\\'","'", $output->name);
	    $name = str_replace("\'","'",$name);
	    $name = str_replace('\\"','"',$name);
	    $name = str_replace('\"','"',$name);
	    $arr['name'] =$name;

	    $bio = str_replace("\\'","'", $output->bio);
	    $bio = str_replace("\'","'",$bio);
	    $bio = str_replace('\\"','"',$bio);
	    $bio = str_replace('\"','"',$bio);
	    $arr['bio'] =$bio;
	    $myjobs = explode(',',$output->jobs);
	    $job_tr = array();
	    foreach ($myjobs as $j){
	        $job_tr[] = $this->lang(trim($j));
        }
	    $arr['photo'] = $output->photo;
	    $arr['jobs'] = implode(', ',$job_tr);
	    $arr['born'] = str_replace(" in"," |",$this->date_translator($output->born));
	    $arr['transp2'] = isset($args['show']) == "transparent" ? 'style="color: #f5c518 !important;"' : "";
	    $arr['source'] = $this->lang('Source');
	    $arr['bio_title'] = $this->lang('Biography');
	    $arr['see_full_bio'] = $this->lang('See full bio');
	    $arr['born_title'] = $this->lang('Born');
	    $arr['filmography'] = $this->lang('Filmography');



	    $html = isset($args['data']) == "detailed" ? $this->get_file('default-detailed-style-name') : $this->get_file('default-style-name');
	    $html = $this->html_fetcher($arr,$html);

        return $html;
    }





	/*********************************************** /TEMPLATES *******************************************************/

    //**
    //**
    //**

	/*********************************************** EDIT *******************************************************/

	/***********************  1. Edit Title Cache ***************************/
    function cache_title_edit($id){
        global $wpdb;
        $id = esc_sql(absint($id));
        $result = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE id='.$id);
        if(count($result)>0){
         //BEGIN
            foreach ($result as $r){
                $title = $r->title;
                $type = $r->type;
                $cache = json_decode($r->cache);
            }
            $cover = $type=="title" ? $cache->poster : $cache->photo;
            $info = $type=="title" ? $cache->sum : $cache->bio;?>
            <div style="background-color: #ffffff; padding: 16px; position: relative">
                    <form method="post" action="<?php echo admin_url('admin.php?page=shortcode_imdb_titles')?>">

                            <img src="<?php echo $cover?>" class="imdb-cover-img">

                            <div>


                                <div class="options">
                                    <p>
                                        <label>Title</label>
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
                                        <label>Summary</label>
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
                                        <label>Big Summary</label>
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

	/***********************  2. Edit Name Cache ***************************/
    function cache_name_edit($id){
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
            <div style="background-color: #ffffff; padding: 16px; position: relative">
                <form method="post" action="<?php echo admin_url('admin.php?page=shortcode_imdb_names')?>">
                    <img src="<?php echo $cover?>" class="imdb-cover-img">
                    <div>
                        <h2>Edit Content</h2>

                        <div class="options">
                            <p>
                                <label>Name</label>
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
                                <label>Photo</label>
                                <br />
                                <input type="text" name="imdb_cover" value="<?php echo $cover?>" style="width: 40%"/>
                            </p>
                        </div>
                        <div class="options">
                            <p>
                                <label>Biography</label>
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

	/***********************  3. Edit List Cache ***************************/
    function cache_list_edit($id){
        global $wpdb;
        $result = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE id='.$id);
        if(count($result)>0){
            foreach ($result as $r){
                $list = $r;
            }
            $imdb_id = $list->imdb_id;
	        $output = json_decode(base64_decode($list->cache),true);
            $check_more = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE imdb_id="'.$id.'-page"');
            if(count($check_more)>0){
                $arr = array();
                $z = 0;
                foreach ($check_more as $c){
                    $cache =  json_decode(base64_decode($c->cache),true);
                    foreach ($cache['content'] as $cac){
	                    array_push($output['content'],$cac);

                    }
                }

            }
            $output = json_decode(json_encode($output));

        ?>
        <div class="container" style="background-color: #f1d486;padding: 20px; border:1px solid #0c0c0c; color:#000!important;">
            <div class="imdb-top">
                <label for="imdb-add-new-title">Title of List </label>
                <input type="text" id="imdb-add-title" class="form-control" placeholder="Enter your title of your list" value="<?php echo $list->title?>">


                <div class="imdb-add-new-inbox">
                    <label for="imdb-add-new">Add New Item </label>
                    <input type="hidden" id="imdb-list-type" class="form-control" value="<?php echo $output->type?>">
                    <input type="text" id="imdb-add-new" class="form-control" placeholder="Add <?php echo $output->type?> id...."> <input class="button" id="add_imdb_item_in_edit" type="button" value="Add">
                </div>
            </div>
            <div class="imdb-add-new-container">
                <?php
                if($output->type=="name") {
	                foreach ( $output->content as $k => $o ) {
	                    $data = array();
		                $data['name']['imdb_id'] = $o->imdb_id;
		                $data['name']['bestTitle'] = $o->bestTitle;
		                $data['name']['photo'] = $o->photo;
		                $data['name']['name'] = $o->name;
		                $data['name']['name_link'] = $o->name_link;
		                $data['name']['gender'] = $o->gender;
		                $data['enc']                  = base64_encode( json_encode( $data['name'] ) );
		                $bio = str_replace("\\'","'",$o->bio);
		                $bio = str_replace("\'","'",$bio);
		                $bio = str_replace('\\"','"',$bio);
		                $bio = str_replace('\"','"',$bio);

		                $desc = str_replace("\'","'",$o->desc);
		                $desc = str_replace('\\"','"',$o->desc);
		                $desc = str_replace('\"','"',$o->desc);
		                echo "<div class='imdb-add-container sortable ".$o->imdb_id. "'>";

		                echo "<div class='imdb-add-row'>";
		                echo "<div class='imdb-add-poster'><img src='" . $o->photo . "'/><div style='clear: both'></div></div>";
		                echo "<div class='imdb-add-content'><div class='imdb-add-close'><a href='#' data-id='" .$o->imdb_id. "' class='imdb-close-click'><img src='" .SHIMDB_URL. "includes/assets/close.png'/></a></div>" .
		                        "<div class='imdb-add-title'><span class='imdb-order-number'>".($k+1).".&nbsp;</span>"
		                        .$o->name.
		                        "</div>" .
		                        "<div class='imdb-add-desc'>" .
		                        "<label for='sum'>Bio</label>" .
		                        "<textarea placeholder='You can enter a bio here...' name='imdb_desc[]'>" .$bio. "</textarea>" .
		                        "</div>" .
		                        "<div class='imdb-add-desc'>" .
		                        "<label for='desc'>Description</label>" .
		                        "<textarea placeholder='You can enter a description here...' name='imdb_list_desc[]'>".$desc."</textarea>" .
		                        "<div style='clear: both'></div>" .
		                        "<input name='imdb_list_values[]' type='hidden' value='" .$data['enc'] . "' class='imdb_list_value'>" .
		                        "</div>";
		                echo '</div>';
		                echo  '</div>';
		                echo '</div>';

	                }
                }else if($output->type=="title"){
	                foreach ( $output->content as $k => $o ) {
		                $data['title']['imdb_id']     = $o->imdb_id;
		                $data['title']['poster']      = $o->poster;
		                $data['title']['title']       = $o->title;
		                $data['title']['year']        = $o->year;
		                $data['title']['certificate'] = $o->certificate;
		                $data['title']['runtime']     = $o->runtime;
		                $data['title']['genre']       = $o->genres;
		                $data['title']['metascore']   = $o->metascore;
		                $data['title']['rating']      = $o->rating;
		                $data['title']['vote']        = $o->vote;
		                $data['title']['gross']       = $o->gross;
		                $data['title']['director']    = $o->director;
		                $data['title']['stars']       = $o->stars;
		                $data['enc']                  = base64_encode( json_encode( $data['title'] ) );
		                $desc = str_replace("\'","'",trim($o->desc));
		                $desc = str_replace('\\"','"',$desc);
		                $desc = str_replace('\"','"',$desc);
		                $listdesc = str_replace("\'","'",trim($o->list_desc));
		                $listdesc = str_replace('\\"','"',$listdesc);
		                $listdesc = str_replace('\"','"',$listdesc);
		                echo "<div class='imdb-add-container sortable " .$o->imdb_id. "'>";

		                echo "<div class='imdb-add-row'>";
		                echo "<div class='imdb-add-poster'><img src='" .$o->poster. "'><div style='clear: both'></div></div>";
		                echo "<div class='imdb-add-content'><div class='imdb-add-close'><a href='#' data-id='" .$o->imdb_id. "' class='imdb-close-click'><img src='" .SHIMDB_URL. "includes/assets/close.png'/></a></div>" .
		                        "<div class='imdb-add-title'><span class='imdb-order-number'>".($k+1).".&nbsp;</span><a href='https://imdb.com/title/" .$o->imdb_id. "' target='_blank'>".
		                        $o->title .
		                        " " .$o->year. "" .
		                        "</a></div>" .
		                        "<div class='imdb-add-genre'>" .$o->genres."</div>" .
		                        "<div class='imdb-add-desc'>" .
		                        "<label for='sum'>Summary</label>" .
		                        "<textarea placeholder='You can enter a summary here...' name='imdb_desc[]'>" .$desc. "</textarea>" .
		                        "</div>" .
		                        "<div class='imdb-add-desc'>" .
		                        "<label for='desc'>Description</label>" .
		                        "<textarea placeholder='You can enter a description here...' name='imdb_list_desc[]'>".$listdesc."</textarea>" .
		                        "<div style='clear: both'></div>" .
		                        "<input name='imdb_list_values[]' type='hidden' value='" .$data['enc']. "' class='imdb_list_value'>" .
		                        "</div>";
		                echo '</div>';
		                echo '</div>';
		                echo '</div>';





	                }
                }else if($output->type=="video"){
                    foreach ($output->content as $k => $o){
	                    $data['video']['imdb_id']     = $o->imdb_id;
	                    $data['video']['muted']     = $o->muted;
	                    $data['video']['VideoImage']     = $o->VideoImage;
	                    $data['video']['VideoImageLink'] = $o->VideoImageLink;
	                    $data['enc']                  = base64_encode( json_encode( $data['video'] ) );
	                    $listdesc = str_replace("\'","'",trim($o->VideoDesc));
	                    $listdesc = str_replace('\\"','"',$listdesc);
	                    $listdesc = str_replace('\"','"',$listdesc);

	                    $image_size="x:280";
	                    echo "<div class='imdb-add-container sortable " .$o->imdb_id. "'>";
	                    echo "<div class='imdb-add-row'>";
	                    echo "<div class='imdb-add-poster'><img src='" .$this->imdb_image_convertor($o->VideoImage,$image_size). "'>
                                <div style='clear: both'></div>
                              </div>";
	                    echo "<div class='imdb-add-content'>
                                <div class='imdb-add-close'><a href='#' data-id='" .$o->imdb_id. "' class='imdb-close-click'><img src='" .SHIMDB_URL. "includes/assets/close.png'/></a></div>
	                         <div class='imdb-add-title'><span class='imdb-order-number'>".($k+1).".&nbsp;</span><a href='" .$o->VideoImageLink. "' target='_blank'>".
	                         $o->title .
	                         "</a><br><small style='font-size:12px'>".$o->muted."</brsmall></div>" .
	                         "<div class='imdb-add-desc'>" .
	                         "<label for='desc'>Description</label>" .
	                         "<textarea placeholder='You can enter a description here...' name='imdb_list_desc[]'>".$listdesc."</textarea>" .
                             "</div>".
	                         "<div style='clear: both'></div>" .
	                         "<input name='imdb_list_values[]' type='hidden' value='" .$data['enc']. "' class='imdb_list_value'>" .
	                         "</div>";
	                    echo '</div>';
	                    echo '</div>';
                    }
                }
                ?>
            </div>
            <input type="hidden" name="shimdbURL" id="shimdbURL" value="<?php echo SHIMDB_URL?>" class="form-control"/>
            <input type="hidden" name="imdb-list-id" id="imdb-list-id" value="<?php echo $_GET['id']?>" class="form-control"/>
            <input type="hidden" name="imdb-id" id="imdb-id" value="<?php echo $imdb_id?>" class="form-control"/>
            <input type="hidden" name="adminURL" id="adminURL" value="<?php echo admin_url('admin.php?page=shortcode_imdb_lists')?>" class="form-control"/>
            <input type="hidden" id="imdb-added" value="">
        </div>
        <div class="imdb-add-footer"><button class="button edit-list-btn">Save</button></div>

        <?php
        }else{
            echo "Wrong id?";
        }
    }

	/***********************  4. Edit Quote Cache ***************************/
	function cache_quote_edit($id){
		global $wpdb;
		$id = esc_sql(absint($id));
		$result = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'shortcode_imdb_cache WHERE id='.$id);
		if(count($result)>0){
			//BEGIN
			foreach ($result as $r){
				$title = $r->title;
				$imdb = $r->imdb;
				$type = $r->type;
				$cache = $r->cache;
			}
			?>
            <div style="background-color: #ffffff; padding: 16px;">
                <form method="post" action="<?php echo admin_url('admin.php?page=shortcode_imdb_quotes')?>">

                    <div>
                        <h2>Edit Content</h2>

                        <div class="options">
                            <p>
                                <label>Title</label>
                                <br />
								<?php
								$title = str_replace("\\'","'",$title);
								$title = str_replace("\'","'",$title);
								$title = str_replace('\\"','"',$title);
								$title = str_replace('\"','"',$title);
								?>
                                <input type="text" name="imdb_title" value="<?php echo str_replace("\'","'",$title)?>" style="width: 40%"/>

                                <input type="hidden" name="imdb_quote_id" value="<?php echo $id?>"/>
                                <input type="hidden" name="imdb_type" value="<?php echo $type?>"/>
                            </p>
                        </div>


                        <div class="options">
                            <p>
                                <label>Quotes</label>
                                <br />
								<?php
								wp_editor( htmlspecialchars_decode($cache), "imdb_quotes" );
								?>
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

	/*********************************************** /EDIT *******************************************************/

	//**
	//**
	//**

	/*********************************************** ADD *******************************************************/

	/***********************  1. Fetch New List ***************************/
    function cache_list_fetch_new(){
        ?>
        <div class="container" style="background-color: #ffffff;">
            <div class="imdb-dashboard" style="padding: 15px;">

                    <div class="form-group">
                        <label for="imdb_id">IMDB ID</label>
                        <input type="text" name="imdb-id" id="imdb-id" class="form-control">
                        <input type="hidden" name="imdb-type" id="imdb-type" value="list" class="form-control">
                        <input type="hidden" name="shimdbURL" id="shimdbURL" value="<?php echo SHIMDB_URL?>" class="form-control">
                        <input type="hidden" name="imdb-page" id="imdb-page" value="1" class="form-control">
                        <input type="hidden" name="list-page" id="list-page" value="<?php echo admin_url("admin.php?page=shortcode_imdb_lists")?>" class="form-control">
                        <input type="hidden" name="imdb-page-now" id="imdb-page-now" value="1" class="form-control">
                        <input type="button" class="button btn btn-primary imdb-button" style="position: relative;top:7px" id="imdb-fetch" value="Fetch">
                    </div>
                <small><strong>Note: This is beta version. Problems may arise with very large lists.</strong></small>
                    <div id="imdbIndex"></div>


            </div>
        </div>
        <?php

    }

	/***********************  2. Add New List ***************************/
    function cache_list_add_new(){
        ?>
        <div class="container" style="background-color: #f1d486;padding: 20px; border:1px solid #0c0c0c; color:#000!important;">
            <div class="imdb-top">
            <label for="imdb-add-new-title">Title of List </label>
            <input type="text" id="imdb-add-title" class="form-control" placeholder="Enter your title of your list">
            <label for="imdb-list-type"><b>List Type</b></label>
            <select class="form-control dark" id="imdb-list-type">
                <option value="-" selected>---</option>
                <option value="title">Title List</option>
                <option value="name">Actor/Actress List</option>
<!--                <option value="video">Video List</option>-->
<!--                <option value="image">Image List</option>-->
            </select>
            <div class="imdb-add-new-inbox"></div>
            </div>
            <div class="imdb-add-new-container"></div>
            <input type="hidden" name="shimdbURL" id="shimdbURL" value="<?php echo SHIMDB_URL?>" class="form-control"/>
            <input type="hidden" name="adminURL" id="adminURL" value="<?php echo admin_url('admin.php?page=shortcode_imdb_lists')?>" class="form-control"/>
            <input type="hidden" id="imdb-added" value="">
        </div>
        <div class="imdb-add-footer"><button class="button add-new-btn">Add New</button></div>
        <?php
    }

	/*********************************************** /ADD *******************************************************/

	//**
	//**
	//**

	/*********************************************** POST *******************************************************/

	/***********************  1. Cache Post ***************************/
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
                        'id'=> $imdb_id,
                    )
                );
            }

        }

    }

	/***********************  2. Cache Quote Post ***************************/
    function cache_quote_post($post){
        global $wpdb;
        $title = sanitize_text_field($post['imdb_title']);
        $cache = $post['imdb_quotes'];
        $imdb_id = absint($post['imdb_quote_id']);
        $wpdb->query('UPDATE ' . $wpdb->prefix . 'shortcode_imdb_cache SET title="'.$title.'",  cache="' . htmlspecialchars($cache, ENT_QUOTES) . '" WHERE id='.$imdb_id);
    }

	/*********************************************** /POST *******************************************************/


	/***********************  TABS  ***************************/
    function cache_tabs_add_new(){
	   include SHIMDB_ROOT.'includes/incadmin/tabs.php';
    }

	function cache_tabs_edit($id){
		include SHIMDB_ROOT.'includes/incadmin/tabs.edit.php';
	}




//**END
}