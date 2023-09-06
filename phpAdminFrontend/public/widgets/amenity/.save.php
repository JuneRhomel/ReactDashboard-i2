<?php
$_POST['main_image'] = [
	'filename' => $_FILES['main_image']['name'],
	'data' => chunk_split(base64_encode(file_get_contents($_FILES['main_image']['tmp_name'])))
];
$result = $ots->execute('amenity','save',$_POST);
echo $result;