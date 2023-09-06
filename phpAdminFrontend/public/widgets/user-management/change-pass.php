<?php

$data = $_POST;
if ($_POST['new_password'] === $_POST['retype_password']) {
    $data = [
        'id' => $_POST['id'],
        'password' => md5($_POST['new_password']),
        'module' => $_POST['module'],
        'table' => $_POST['table'],
    ];
    $result = $ots->execute('module', 'save', $data);
    echo  $result;
} else {
    $error = ['success'=>0,'description'=>'The New Password and Retype Password is not Match'];
    echo  json_encode($error);
}





