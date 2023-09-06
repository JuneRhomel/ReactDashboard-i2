<?php
$data = $_POST;
$data = [
    // 'id' => $_POST['id'],
    // 'issue_id' => $_POST['issue_id'],
    // 'contact_no' => $_POST['contact_no'],
    // 'description' => $_POST['description'],
    // 'module' => $_POST['module'],
    // 'name_id' => $_POST['name_id'],
    // 'table'=> $_POST['table'],
    // 'unit_id'=> $_POST['unit_id'],
];


// echo json_encode($data)
echo $result = $ots->execute('admin','save-role',$_POST);
?>