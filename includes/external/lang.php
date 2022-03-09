<?php
$imdb  = new shimdb_imdb_grab();
global $wpdb;
?>
<hr/>
<form action="<?php echo admin_url('admin.php?page=shortcode_imdb_lang')?>" method="POST">
	<table style="width: 80%">
		<thead><tr>
			<th style="width: 50%; text-align: left">Org. Content</th>
			<th style="width: 50%">Translation</th></tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<label><b>Director: </b></label>
				</td>
				<td>
					<input type="text" name="Director" value="<?php echo $imdb->lang('Director')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Writer: </b></label>
				</td>
				<td>
					<input type="text" name="Writer" value="<?php echo $imdb->lang('Writer')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Stars: </b></label>
				</td>
				<td>
					<input type="text" name="Stars" value="<?php echo $imdb->lang('Stars')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Cast: </b></label>
				</td>
				<td>
					<input type="text" name="Cast" value="<?php echo $imdb->lang('Cast')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Summary: </b></label>
				</td>
				<td>
					<input type="text" name="Summary" value="<?php echo $imdb->lang('Summary')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>See all videos: </b></label>
				</td>
				<td>
					<input type="text" name="See all videos" value="<?php echo $imdb->lang('See all videos')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>See all photos: </b></label>
				</td>
				<td>
					<input type="text" name="See all photos" value="<?php echo $imdb->lang('See all photos')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>See full cast: </b></label>
				</td>
				<td>
					<input type="text" name="See full cast" value="<?php echo $imdb->lang('See full cast')?>" style="width: 100%">
				</td>
			</tr>
            <tr>
                <td>
                    <label><b>See full bio: </b></label>
                </td>
                <td>
                    <input type="text" name="See full bio" value="<?php echo $imdb->lang('See full bio')?>" style="width: 100%">
                </td>
            </tr>
			<tr>
				<td>
					<label><b>Countries: </b></label>
				</td>
				<td>
					<input type="text" name="Countries" value="<?php echo $imdb->lang('Countries')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Languages: </b></label>
				</td>
				<td>
					<input type="text" name="Languages" value="<?php echo $imdb->lang('Languages')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Budget: </b></label>
				</td>
				<td>
					<input type="text" name="Budget" value="<?php echo $imdb->lang('Budget')?>" style="width: 100%">
				</td>
			</tr>
            <tr>
                <td>
                    <label><b>Gross: </b></label>
                </td>
                <td>
                    <input type="text" name="Gross" value="<?php echo $imdb->lang('Gross')?>" style="width: 100%">
                </td>
            </tr>
            <tr>
                <td>
                    <label><b>Votes: </b></label>
                </td>
                <td>
                    <input type="text" name="Votes" value="<?php echo $imdb->lang('Votes')?>" style="width: 100%">
                </td>
            </tr>
            <tr>
                <td>
                    <label><b>Genres: </b></label>
                </td>
                <td>
                    <input type="text" name="Genres" value="<?php echo $imdb->lang('Genres')?>" style="width: 100%">
                </td>
            </tr>
            <tr>
                <td>
                    <label><b>age: </b></label>
                </td>
                <td>
                    <input type="text" name="age" value="<?php echo $imdb->lang('age')?>" style="width: 100%">
                </td>
            </tr>
            <tr>
                <td>
                    <label><b>Runtime: </b></label>
                </td>
                <td>
                    <input type="text" name="Runtime" value="<?php echo $imdb->lang('Runtime')?>" style="width: 100%">
                </td>
            </tr>

			<tr>
				<td>
					<label><b>Source: </b></label>
				</td>
				<td>
					<input type="text" name="Source" value="<?php echo $imdb->lang('Source')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>estimated: </b></label>
				</td>
				<td>
					<input type="text" name="estimated" value="<?php echo $imdb->lang('estimated')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Biography: </b></label>
				</td>
				<td>
					<input type="text" name="Biography" value="<?php echo $imdb->lang('Biography')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Born: </b></label>
				</td>
				<td>
					<input type="text" name="Born" value="<?php echo $imdb->lang('Born')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Died: </b></label>
				</td>
				<td>
					<input type="text" name="Died" value="<?php echo $imdb->lang('Died')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Photos: </b></label>
				</td>
				<td>
					<input type="text" name="Photos" value="<?php echo $imdb->lang('Photos')?>" style="width: 100%">
				</td>
			</tr>
            <tr>
                <td>
                    <label><b>min: </b></label>
                </td>
                <td>
                    <input type="text" name="min" value="<?php echo $imdb->lang('min')?>" style="width: 100%">
                </td>
            </tr>
			<tr>
				<td>
					<label><b>Videos: </b></label>
				</td>
				<td>
					<input type="text" name="Videos" value="<?php echo $imdb->lang('Videos')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Filmography: </b></label>
				</td>
				<td>
					<input type="text" name="Filmography" value="<?php echo $imdb->lang('Filmography')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Known For: </b></label>
				</td>
				<td>
					<input type="text" name="Known For" value="<?php echo $imdb->lang('Known For')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Producer: </b></label>
				</td>
				<td>
					<input type="text" name="Producer" value="<?php echo $imdb->lang('Producer')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Actor: </b></label>
				</td>
				<td>
					<input type="text" name="Actor" value="<?php echo $imdb->lang('Actor')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Actress: </b></label>
				</td>
				<td>
					<input type="text" name="Actress" value="<?php echo $imdb->lang('Actress')?>" style="width: 100%">
				</td>
			</tr>
            <tr>
                <td>
                    <label><b>Stunts: </b></label>
                </td>
                <td>
                    <input type="text" name="Stunts" value="<?php echo $imdb->lang('Stunts')?>" style="width: 100%">
                </td>
            </tr>
			<tr>
				<td>
					<label><b>Additional Crew: </b></label>
				</td>
				<td>
					<input type="text" name="Additional Crew" value="<?php echo $imdb->lang('Additional Crew')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Special effects: </b></label>
				</td>
				<td>
					<input type="text" name="Special effects" value="<?php echo $imdb->lang('Special effects')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Cinematographer: </b></label>
				</td>
				<td>
					<input type="text" name="Cinematographer" value="<?php echo $imdb->lang('Cinematographer')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Visual effects: </b></label>
				</td>
				<td>
					<input type="text" name="Visual effects" value="<?php echo $imdb->lang('Visual effects')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Second Unit Director or Assistant Director: </b></label>
				</td>
				<td>
					<input type="text" name="Second Unit Director or Assistant Director" value="<?php echo $imdb->lang('Second Unit Director or Assistant Director')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Editor: </b></label>
				</td>
				<td>
					<input type="text" name="Editor" value="<?php echo $imdb->lang('Editor')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Makeup Department: </b></label>
				</td>
				<td>
					<input type="text" name="Makeup Department" value="<?php echo $imdb->lang('Makeup Department')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Animation department: </b></label>
				</td>
				<td>
					<input type="text" name="Anmation department" value="<?php echo $imdb->lang('Animation department')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Art director: </b></label>
				</td>
				<td>
					<input type="text" name="Art director" value="<?php echo $imdb->lang('Art director')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Camera and Electrical Department: </b></label>
				</td>
				<td>
					<input type="text" name="Camera and Electrical Department" value="<?php echo $imdb->lang('Camera and Electrical Department')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Costume designer: </b></label>
				</td>
				<td>
					<input type="text" name="Costume designer" value="<?php echo $imdb->lang('Costume designer')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Music department: </b></label>
				</td>
				<td>
					<input type="text" name="Music department" value="<?php echo $imdb->lang('Music department')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Thanks: </b></label>
				</td>
				<td>
					<input type="text" name="Thanks" value="<?php echo $imdb->lang('Thanks')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Self: </b></label>
				</td>
				<td>
					<input type="text" name="Self" value="<?php echo $imdb->lang('Self')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Archive footage: </b></label>
				</td>
				<td>
					<input type="text" name="Archive footage" value="<?php echo $imdb->lang('Archive footage')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Action: </b></label>
				</td>
				<td>
					<input type="text" name="Action" value="<?php echo $imdb->lang('Action')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Adventure: </b></label>
				</td>
				<td>
					<input type="text" name="Adventure" value="<?php echo $imdb->lang('Adventure')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Animation: </b></label>
				</td>
				<td>
					<input type="text" name="Animation" value="<?php echo $imdb->lang('Animation')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Fantasy: </b></label>
				</td>
				<td>
					<input type="text" name="Fantasy" value="<?php echo $imdb->lang('Fantasy')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Thriller: </b></label>
				</td>
				<td>
					<input type="text" name="Thriller" value="<?php echo $imdb->lang('Thriller')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Romance: </b></label>
				</td>
				<td>
					<input type="text" name="Romance" value="<?php echo $imdb->lang('Romance')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Mystery: </b></label>
				</td>
				<td>
					<input type="text" name="Mystery" value="<?php echo $imdb->lang('Mystery')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Horror: </b></label>
				</td>
				<td>
					<input type="text" name="Horror" value="<?php echo $imdb->lang('Horror')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>History: </b></label>
				</td>
				<td>
					<input type="text" name="History" value="<?php echo $imdb->lang('History')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Reality-TV: </b></label>
				</td>
				<td>
					<input type="text" name="Reality-TV" value="<?php echo $imdb->lang('Reality-TV')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Documentary: </b></label>
				</td>
				<td>
					<input type="text" name="Documentary" value="<?php echo $imdb->lang('Documentary')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Musical: </b></label>
				</td>
				<td>
					<input type="text" name="Musical" value="<?php echo $imdb->lang('Musical')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Film-Noir: </b></label>
				</td>
				<td>
					<input type="text" name="Film-Noir" value="<?php echo $imdb->lang('Film-Noir')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Drama: </b></label>
				</td>
				<td>
					<input type="text" name="Drama" value="<?php echo $imdb->lang('Drama')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Comedy: </b></label>
				</td>
				<td>
					<input type="text" name="Comedy" value="<?php echo $imdb->lang('Comedy')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Sci-Fi: </b></label>
				</td>
				<td>
					<input type="text" name="Sci-Fi" value="<?php echo $imdb->lang('Sci-Fi')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Crime: </b></label>
				</td>
				<td>
					<input type="text" name="Crime" value="<?php echo $imdb->lang('Crime')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Family: </b></label>
				</td>
				<td>
					<input type="text" name="Family" value="<?php echo $imdb->lang('Family')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Short: </b></label>
				</td>
				<td>
					<input type="text" name="Short" value="<?php echo $imdb->lang('Short')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Sport: </b></label>
				</td>
				<td>
					<input type="text" name="Sport" value="<?php echo $imdb->lang('Sport')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>War: </b></label>
				</td>
				<td>
					<input type="text" name="War" value="<?php echo $imdb->lang('War')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Western: </b></label>
				</td>
				<td>
					<input type="text" name="Western" value="<?php echo $imdb->lang('Western')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Game-Show: </b></label>
				</td>
				<td>
					<input type="text" name="Game-Show" value="<?php echo $imdb->lang('Game-Show')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Music: </b></label>
				</td>
				<td>
					<input type="text" name="Music" value="<?php echo $imdb->lang('Music')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>News: </b></label>
				</td>
				<td>
					<input type="text" name="News" value="<?php echo $imdb->lang('News')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Adult: </b></label>
				</td>
				<td>
					<input type="text" name="Adult" value="<?php echo $imdb->lang('Adult')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>Talk-Show: </b></label>
				</td>
				<td>
					<input type="text" name="Talk-Show" value="<?php echo $imdb->lang('Talk-Show')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>January: </b></label>
				</td>
				<td>
					<input type="text" name="January" value="<?php echo $imdb->lang('January')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>February: </b></label>
				</td>
				<td>
					<input type="text" name="February" value="<?php echo $imdb->lang('February')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>March: </b></label>
				</td>
				<td>
					<input type="text" name="March" value="<?php echo $imdb->lang('March')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>April: </b></label>
				</td>
				<td>
					<input type="text" name="April" value="<?php echo $imdb->lang('April')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>May: </b></label>
				</td>
				<td>
					<input type="text" name="May" value="<?php echo $imdb->lang('May')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>June: </b></label>
				</td>
				<td>
					<input type="text" name="June" value="<?php echo $imdb->lang('June')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>July: </b></label>
				</td>
				<td>
					<input type="text" name="July" value="<?php echo $imdb->lang('July')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>August: </b></label>
				</td>
				<td>
					<input type="text" name="August" value="<?php echo $imdb->lang('August')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>September: </b></label>
				</td>
				<td>
					<input type="text" name="September" value="<?php echo $imdb->lang('September')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>October: </b></label>
				</td>
				<td>
					<input type="text" name="October" value="<?php echo $imdb->lang('October')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>November: </b></label>
				</td>
				<td>
					<input type="text" name="November" value="<?php echo $imdb->lang('November')?>" style="width: 100%">
				</td>
			</tr>
			<tr>
				<td>
					<label><b>December: </b></label>
				</td>
				<td>
					<input type="text" name="December" value="<?php echo $imdb->lang('December')?>" style="width: 100%">
				</td>
			</tr>
            <tr>
                <td>
                    <label><b>Close the ad: </b></label>
                </td>
                <td>
                    <input type="text" name="Close the ad" value="<?php echo $imdb->lang('Close the ad')?>" style="width: 100%">
                </td>
            </tr>




		</tbody>
	</table>
	<hr>
	<div style="float:left;">
	<input type="submit" class="button" value="Save" style="background: #0a0a0a;color: white;width: 200px" name="lang_submit">
	</div>
</form>
<?php
if(isset($_POST['lang_submit'])){
	$wpdb->delete($wpdb->prefix.'shortcode_imdb_cache',[
		'type' => 'lang'
	]);
	foreach ($_POST as $k => $p){
		if($p != "lang_submit") {
			$title = str_replace( '_', ' ', $k );
			$cache = esc_attr( $p );
			$wpdb->insert( $wpdb->prefix . 'shortcode_imdb_cache', [
				'title'   => $title,
				'cache'   => $cache,
				'imdb_id' => '--',
				'type'    => 'lang'
			] );
		}
	}
	wp_redirect( admin_url('admin.php?page=shortcode_imdb_lang') );
	exit;
}
