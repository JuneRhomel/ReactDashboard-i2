<?php 
$result;

$role_id = $_POST['id'];
unset($_POST['id']);
$records = $_POST;
$records['id'] = $role_id;

$result = $ots->execute('admin','permission-save-data',$records);
print_r($result);
?>