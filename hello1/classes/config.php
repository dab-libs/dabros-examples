<?php
return array(
	'RemoteObjectManager' => array(
		'db' => array(
			'connectionString' => 'mysql:host=localhost;dbname=dabros-examples',
			'username' => 'root',
			'password' => '',
			'table' => 'hello1_storage',
		),
	),
	'RemoteUserSession' => array(
		'sessionFacadeClassName' => 'HelloWorldFacade',
	),
	'javaScrptPath' => '/hello1/js',
	'dabrosUrl' => '/hello1/dabros-handler.php',
);