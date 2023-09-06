<?php
$attachments = [];
foreach($_FILES['file']['name'] as $index=>$name)
{
	$attachments[] = [
		'filename' => $_FILES['file']['name'][$index],
		'data' => chunk_split(base64_encode(file_get_contents($_FILES['file']['tmp_name'][$index])))
	];
}
$_POST['attachments'] = $attachments;

$result = $ots->execute('tenant','save-punchlist-update',$_POST);
echo $result;