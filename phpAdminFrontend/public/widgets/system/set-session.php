<?php
$key = $_GET['key'] ?? '';
$value = $_GET['value']  ?? '';
if($key)
	$_SESSION[$key] = $value;