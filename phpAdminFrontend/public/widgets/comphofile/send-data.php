<?php
$module = $_POST['module'];
$command = $_POST['command'];
unset($_POST['module']);
unset($_POST['command']);

$result = $ots->execute($module,$command,$_POST);
echo $result;