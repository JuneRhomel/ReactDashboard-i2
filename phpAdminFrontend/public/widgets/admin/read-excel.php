<?php
unset($_SESSION['excel_errors']);
$post = $_POST;

//convert excel to array
$excel_content = excel_to_array($_FILES['upload_file']['tmp_name']);
$excel_content = remove_excel_white_space($excel_content);
$post['excel_content'] = $excel_content;
echo $result = $ots->execute('importexcel','import-excel',$post);

// $result = json_decode($result);
// // exit();
// if($result->success == 1){
//     Header('Location:' . $_POST['redirect']);
    
// }
// else{
//     $_SESSION['excel_errors'] = $result->excel_errors;   
//     Header('Location:' . $_POST['error_redirect'] . "&error=" . $result->description);
// }
