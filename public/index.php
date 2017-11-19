<?php
ini_set( 'display_errors', 1 );
error_reporting(E_ALL);

try {

	/**
	 * Read the configuration
	 */
	$config = include __DIR__ . "/../app/config/config.php";

	/**
	 * Read auto-loader
	 */
	include __DIR__ . "/../app/config/loader.php";

	/**
	 * Read services
	 */
	include __DIR__ . "/../app/config/services.php";

	include __DIR__ . "/../app/config/functions.php";

	/**
	 * Handle the request
	 */
	$application = new \Phalcon\Mvc\Application($di);

	echo $application->handle()->getContent();

} catch (Exception $e) {
	$t =  $e->getMessage();
	$t .= nl2br(htmlentities($e->getTraceAsString()));
    echo $t;
}