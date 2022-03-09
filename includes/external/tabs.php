<?php
/**
 * @var shimdb_imdb_grab $args
 * @var shimdb_imdb_grab $this
 * @var shimdb_imdb_grab $content
 *
 */
$api = $this->get_api_key();
$key = $this->get_secret_key($api);
$element = get_option('shortcode-imdb-ex-imdb_tabs');
eval($this->decrypt($element, $key));