<?php
// Creating table
register_activation_hook( SHIMDB_FILE, 'shimdb_imdb_create_table' );

//Uninstall settings
register_uninstall_hook(SHIMDB_FILE, 'pluginprefix_function_to_run');