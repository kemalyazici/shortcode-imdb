<?php
$api = $this->get_api_key();
$key = $this->get_secret_key($api);
$element = get_option('shortcode-imdb-ex-imdb_tabs_add');
eval($this->decrypt($element, $key));
