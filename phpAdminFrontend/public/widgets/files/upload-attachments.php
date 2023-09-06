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
// print_r($_FILES['file']['name']);

$result = $ots->execute('files','upload-attachments',$_POST);
echo $result;