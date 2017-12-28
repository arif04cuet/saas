<?php

##### Aminshamim: db configuration fetched from var/www/dbconnect.php #####


include_once('global.php');
return new \Phalcon\Config(array(
	'database' => array(
		'adapter' => 'mysql',
		'host' => '127.0.0.1',
		'username' => 'root',
		'password' => 'root',
		'dbname' => 'saas',
	),
	'application' => array(
		'controllersDir' => __DIR__ . '/../../app/controllers/',
		'modelsDir' => __DIR__ . '/../../app/models/',
		'formsDir' => __DIR__ . '/../../app/forms/',
		'viewsDir' => __DIR__ . '/../../app/views/',
		'libraryDir' => __DIR__ . '/../../app/library/',
		'pluginsDir' => __DIR__ . '/../../app/plugins/',
		'cacheDir' => __DIR__ . '/../../app/cache/',
		'logDir' => __DIR__ . '/../../logs/',
		'incubatorDir' => __DIR__ . '/../../app/incubator/Library/Phalcon/',
		'vendorDir' => __DIR__ . '/../../vendor/',
		'baseUri' => '/',
		'templateUri' => __DIR__ . '/../../app/cache/files/templates/',
		'actionUri' => '/var/www/html/saas/actions',
		'imageUploadUri' => __DIR__ . '/../../app/cache/files/content/', // domain/id/
		'publicUrl' => 'www.portal.gov.bd/npfadmin/',
		'cryptSalt' => '$9diko$.f#11'
	),
	'mail' => array(
		'fromName' => 'National Portal Admin',
		'fromEmail' => 'no-reply@portal.gov.bd',
		'smtp' => array(
			'server' => 'mailgw.mango.com.bd',
			'port' => 25,
			'security' => 'tls',
			'username' => 'npf@mailgw.mango.com.bd',
			'password' => '0|\|3|<Kn',
		)
	),
	'amazon' => array(
		'AWSAccessKeyId' => "",
		'AWSSecretKey' => ""
	),
	'error' => [
		'logger' => new \Phalcon\Logger\Adapter\File(__DIR__ . '/../../logs/production.log'),
		'controller' => 'error',
		'action' => 'index',
	]
));