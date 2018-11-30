<?php
// Creating table
register_activation_hook( _IMDB_FILE_, 'prefix_create_table' );

//Uninstall settings
register_uninstall_hook(_IMDB_FILE_, 'pluginprefix_function_to_run');