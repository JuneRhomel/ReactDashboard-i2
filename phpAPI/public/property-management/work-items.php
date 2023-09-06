<?php
$result = [
	'date' => date('d M'),
	'data' => [
		['description'=>'Water leak','date'=>'10:00 AM - 12:00 PM'],
		['description'=>'Check aging work orders','date'=>'3:00 PM - 3:45 PM'],
	]
	];
	echo json_encode($result);
