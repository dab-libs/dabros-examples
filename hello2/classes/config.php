<?php
return array(
	'RemoteObjectManager' => array(
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=dabros-examples',
			'username' => 'root',
			'password' => '',
			'table' => 'hello2_storage',
		),
	),
	'RemoteUserSession' => array(
		'sessionFacadeClassName' => 'HelloWorldFacade',
	),
	'phpClassPath' => 'classes',
	'javaScrptPath' => '/hello2/js',
	'dabrosUrl' => '/hello2/dabros-handler.php',
);