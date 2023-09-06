<?php
$_POST['file'] = [
	'filename' => $_FILES['file']['name'],
	'data' => chunk_split(base64_encode(file_get_contents($_FILES['file']['tmp_name'])))
];
$result = $ots->execute('form','save',$_POST);
echo $result;