<?php
header('Content-Type: application/json; charset=utf-8');
$forms = $ots->execute('form','get-submitted-list',$_POST);
echo $forms;