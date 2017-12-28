<?php
$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$namespaces = array(
	'Vokuro\Models' => $config->application->modelsDir,
	'Vokuro\Controllers' => $config->application->controllersDir,
	'Vokuro\Forms' => $config->application->formsDir,
	'Vokuro' => $config->application->libraryDir,
	'Vokuro\Plugins' => $config->application->pluginsDir,
);

$map = require $config->application->vendorDir . 'composer/autoload_namespaces.php';

foreach ($map as $k => $values) {
	$k = trim($k, '\\');
	if (!isset($namespaces[$k])) {
		$dir = '/' . str_replace('\\', '/', $k) . '/';
		$namespaces[$k] = implode($dir . ';', $values) . $dir;
	}
}
$loader->registerNamespaces($namespaces);

$classMap = require $config->application->vendorDir . 'composer/autoload_classmap.php';
$loader->registerClasses($classMap);


$loader->register();