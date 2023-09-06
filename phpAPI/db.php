<?php
	require_once(__DIR__ . '/db.class.php');
	//$db = new PDO("mysql:host=". DB_HOST . ";dbname=" . DB_NAME , DB_USER, DB_PWD);
	
	// set the PDO error mode to exception
	//$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);

	$db = new DB();
	