<?php
unset($_SESSION['excel_errors']);
$post = $_POST;

//convert excel to array
$excel_content = excel_to_array($_FILES['upload_file']['tmp_name']);
$excel_content = remove_excel_white_space($excel_content);
$post['excel_content'] = $excel_content;
echo $result = $ots->execute('admin','read-excelfile',$post);