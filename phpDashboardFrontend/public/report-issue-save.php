<?php


session_start();
include("../library.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$data = $_POST;
/*if ($_POST['table']=="report_issue") { // FOR REPORT_ISSUE
    $data = [
        'module' => $_POST['module'],
        'table'=> $_POST['table'],
        'issue_id' => $_POST['issue_id'],
        'contact_no' => $_POST['contact_no'],
        'description' => $_POST['description'],        
        'name_id' => $_POST['name_id'],
        'unit_id'=> $_POST['unit_id'],
        'date'=>  date('Y-m-d H:i:s'),
        'status_id'=>1,
    ];
} else { // FOR REPORTISSUE_STATUS
    $data = [
        'module' => $_POST['module'],
        'table'=> $_POST['table'],        
        'status_id'=>1,
        'reportissue_id' => $_POST['issue_id'],
        'date'=>  date('Y-m-d H:i:s'),        
    ];
}*/

if (!empty($_FILES['attachments']['tmp_name'])) {
    $attachment = [
        'filename' => $_FILES['attachments']['name'],
        'data' => chunk_split(base64_encode(file_get_contents($_FILES['attachments']['tmp_name'])))
    ];
    $data['attachments'] = [$attachment];
}


$result = apiSend('tenant','tenant-report-issue-save',$data);
// echo  json_encode($data);
echo  json_encode($result) ;
?>
