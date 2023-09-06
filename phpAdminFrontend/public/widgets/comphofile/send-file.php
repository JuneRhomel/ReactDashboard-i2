<?php
$module = $_POST['module'];
$command = $_POST['command'];
unset($_POST['module']);
unset($_POST['command']);

$attachments = [];
$attachments[] = [
	'filename' => $_FILES['file']['name'],
	'data' => chunk_split(base64_encode(file_get_contents($_FILES['file']['tmp_name'])))
];

$_POST['attachments'] = $attachments;

$result = $ots->execute($module,$command,$_POST);
echo $result;