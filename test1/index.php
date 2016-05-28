<?php

	//include Zend Framework
	define( 'ZF_PATH', '../test3/zf' );
	set_include_path( implode( ":", array( ZF_PATH, get_include_path(), ) ) );

	//display all errors
	ini_set( 'display_startup_errors', 1 );
	ini_set( 'display_errors', 1 );
	error_reporting( -1 );

	//acclaim
	echo "Welcome to the 1st ZEND Framework Test<br><br>";

	//show include path
	echo "Include Path: [" . ini_get('include_path') . "]<br><br>";

	//include ZEND Framework - Test
	include( "Zend/Application.php" );

	//show phpinfo
	//phpinfo();

	echo "Done.";
?>
