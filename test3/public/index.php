<?php

	//include Zend Framework ( if missing on webserver etc. )
	define( 'ZF_PATH', '../zf' );
	set_include_path( implode( ":", array( ZF_PATH, get_include_path(), ) ) );

	//show include path
	//echo "Include Path: [" . ini_get('include_path') . "]<br><br>";

	// Define path to application directory
	defined('APPLICATION_PATH')
	    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

	// Define application environment
	defined('APPLICATION_ENV')
	    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

	// Ensure library/ is on include_path
	set_include_path(implode(PATH_SEPARATOR, array(
	    realpath(APPLICATION_PATH . '/../library'),
	    get_include_path(),
	)));

	/** Zend_Application */
	require_once 'Zend/Application.php';

	// Create application, bootstrap, and run
	$application = new Zend_Application(
	    APPLICATION_ENV,
	    APPLICATION_PATH . '/configs/application.ini'
	);
	$application->bootstrap()
	            ->run();
