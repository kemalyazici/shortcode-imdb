<?php
/**
 * @var shimdb_imdb_get_skin $id
 * @var shimdb_imdb_get_skin $this
 *
 */
$api = $this->get_api_key();
$key = $this->get_secret_key($api);
$element = get_option('shortcode-imdb-ex-imdb_tabs_edit');
eval($this->decrypt($element, $key));