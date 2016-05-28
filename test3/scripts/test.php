<?php

	$db = mysql_connect( 'localhost', 'root', 'root' )
		or die ( 'Konnte keine Verbindung zur Datenbank herstellen' );

	$db_check = mysql_select_db( "wp_goddy" );

	if ( $db )
	{
		echo 'Verbindung zur Datenbank wurde hergestellt<br>';
	}

	if ( $db_check )
	{
		echo 'Datenbank erfolgreich ausgew&auml;hlt<br>';
	}

?>
