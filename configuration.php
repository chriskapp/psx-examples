<?php

/*
This is the configuration file of PSX. Every parameter can be used inside your
application or in the DI container. Which configuration file gets loaded depends 
on the DI container parameter "config.file". See the container.php if you want 
load an different configuration depending on the environment.
*/

return array(

	// The url to the psx public folder (i.e. http://127.0.0.1/psx/public or 
	// http://localhost.com)
	'psx_url'                 => 'http://example.phpsx.org',

	// The input path 'index.php/' or '' if you use mod_rewrite
	'psx_dispatch'            => '',

	// The default timezone
	'psx_timezone'            => 'UTC',

	// Whether PSX runs in debug mode or not. If not error reporting is set to 0
	'psx_debug'               => false,

	// Your SQL connections
	'psx_sql_host'            => 'localhost',
	'psx_sql_user'            => 'root',
	'psx_sql_pw'              => '',
	'psx_sql_db'              => 'psx',

	// Path to the routing file
	'psx_routing'             => __DIR__ . '/routes',

	// Path to the cache folder
	'psx_path_cache'          => __DIR__ . '/cache',

	// Path to the library folder
	'psx_path_library'        => __DIR__ . '/src',

	// Class name of the error controller
	//'psx_error_controller'    => null,

	// If you only want to change the appearance of the error page you can 
	// specify a custom template
	//'psx_error_template'      => null,

);
