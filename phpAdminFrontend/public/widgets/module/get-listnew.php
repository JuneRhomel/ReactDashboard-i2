<?php
header('Content-Type: application/json; charset=utf-8');
if (!isset($_POST))
	$_POST = $_GET;
$records = $ots->execute("module","get-listnew",$_POST);
echo $records;