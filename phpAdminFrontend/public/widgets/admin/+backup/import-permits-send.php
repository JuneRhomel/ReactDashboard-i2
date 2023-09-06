<?php

session_start();
$post = $_POST;



$post = $_POST;

//convert excel to array
$excel_content = excel_to_array($_FILES['upload_file']['tmp_name']);
// print_r($excel_content);

$post['excel_content'] = remove_excel_white_space($excel_content);

$result = $ots->execute('contracts','import-csv',$post);
echo $result;

?>
