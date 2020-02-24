<?php
require 'environment.php';

$config = array();
$config['use_db'] = true;

if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/app/");
	$config['dbname'] = 'app';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root2';
	$config['dbpass'] = 'root2';
} else {
	define("BASE_URL", "http://meusite.com.br/");
	$config['dbname'] = 'crudoo';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
}

global $db;
try {
	if ($config['use_db']) {
	
		$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);

	}
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}