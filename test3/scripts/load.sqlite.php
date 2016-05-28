<?php

	/**
	 * Skript für das Erstellen und Laden der Datenbank
	 */

	// Initialisiert den Pfad und das Autoloading der Anwendung
	defined('APPLICATION_PATH')
	|| define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
	set_include_path(implode(PATH_SEPARATOR, array(
	APPLICATION_PATH . '/../library',
	get_include_path(),
	)));
	require_once 'Zend/Loader/Autoloader.php';
	Zend_Loader_Autoloader::getInstance();

	// Definiert einige CLI Optionen
	$getopt = new Zend_Console_Getopt(array(
			'withdata|w' => 'Datenbank mit einigen Daten laden',
			'env|e-s'    => "Anwendungsumgebung für welche die Datenbank "
			. "erstellt wird (Standard ist Development)",
			'help|h'     => 'Hilfe -- Verwendung',
	));
	try {
		$getopt->parse();
	} catch (Zend_Console_Getopt_Exception $e) {
		// Schlechte Option übergeben: Verwendung ausgeben
		echo $e->getUsageMessage();
		return false;
	}

	// Wenn Hilfe angefragt wurde, Verwendung ausgeben
	if ($getopt->getOption('h')) {
		echo $getopt->getUsageMessage();
		return true;
	}

	// Werte basierend auf ihrer Anwesenheit oder Abwesenheit von CLI Optionen initialisieren
	$withData = $getopt->getOption('w');
	$env      = $getopt->getOption('e');
	defined('APPLICATION_ENV')
	|| define('APPLICATION_ENV', (null === $env) ? 'development' : $env);

	//directly set ENV
	$env = 'production';
	echo "Setting DB for target [" . $env . "]<br><br>";


	// Zend_Application initialisieren
	$application = new Zend_Application(
			APPLICATION_ENV,
			APPLICATION_PATH . '/configs/application.ini'
	);

	// Die DB Ressource initialisieren und empfangen
	$bootstrap = $application->getBootstrap();
	$bootstrap->bootstrap('db');
	$dbAdapter = $bootstrap->getResource('db');

	// Den Benutzer informieren was abgeht
	// (wir erstellen hier aktuell eine Datenbank)
	if ('testing' != APPLICATION_ENV) {
		echo 'Schreiben in die Guestbook Datenbank (control-c um abzubrechen): ' . PHP_EOL;
		for ($x = 5; $x > 0; $x--) {
			echo $x . "\r"; sleep(1);
		}
	}

	// Prüfen um zu sehen ob wir bereits eine Datenbankdatei haben
	$options = $bootstrap->getOption('resources');
	$dbFile  = $options['db']['params']['dbname'];
	if (file_exists($dbFile)) {
		unlink($dbFile);
	}

	// Dieser Block führt die aktuellen Statements aus welche von der Schemadatei
	// geladen werden.
	try
	{
		$schemaSql = file_get_contents(dirname(__FILE__) . '/schema.sqlite.sql');

		echo "<br><br>Picked script file content: [" . $schemaSql . "]<br><br>";

		echo "dbFile is [" . $dbFile . "]<br><br>";

		// Die Verbindung direkt verwenden um SQL im Block zu laden
		$dbAdapter->getConnection()->exec($schemaSql);

		chmod( $dbFile, 0666 );

		if ( 'testing' != APPLICATION_ENV )
		{
			echo PHP_EOL;
			echo 'Datenbank erstellt';
			echo PHP_EOL;
		}

		//ALWAYS create sample data!
		if ( true || $withData )
		{
			$dataSql = file_get_contents(dirname(__FILE__) . '/data.sqlite.sql');

			echo "<br><br>Picked file content: [" . $dataSql . "]<br><br>";

			// Die Verbindung direkt verwenden um SQL in Blöcken zu laden
			$dbAdapter->getConnection()->exec($dataSql);
			if ('testing' != APPLICATION_ENV)
			{
				echo 'Daten geladen.';
				echo PHP_EOL;
			}
		}
	}
	catch ( Exception $e )
	{
		echo 'EIN FEHLER IST AUFGETRETEN:' . PHP_EOL;
		echo $e->getMessage() . PHP_EOL;
		return false;
	}

	// dieses Skript von der Kommandozeile aus aufgerufen
	return true;

?>
