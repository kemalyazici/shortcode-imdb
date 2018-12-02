<?php
// Creating table
register_activation_hook( _SI_IMDB_FILE_, 'prefix_create_table' );

//Uninstall settings
register_uninstall_hook(_SI_IMDB_FILE_, 'pluginprefix_function_to_run');