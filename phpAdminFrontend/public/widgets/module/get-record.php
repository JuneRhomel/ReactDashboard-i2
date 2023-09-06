<?php
header('Content-Type: application/json; charset=utf-8');

$records = $ots->execute("module","get-records",$_POST);
echo $records;