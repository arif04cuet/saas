<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerNamespaces(array(
	'Vokuro\Models' => $config->application->modelsDir,
	'Vokuro\Controllers' => $config->application->controllersDir,
	'Vokuro\Forms' => $config->application->formsDir,
	'Vokuro' => $config->application->libraryDir,
//	'Phalcon' => $config->application->incubatorDir,

));

$loader->registerClasses(
    array(
    )
);

$loader->register();
