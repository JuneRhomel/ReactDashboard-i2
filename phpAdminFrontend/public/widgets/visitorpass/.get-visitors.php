<?php
header('Content-Type: application/json; charset=utf-8');
$records = $ots->execute('visitor','get-visitors',$_POST);
echo $records;