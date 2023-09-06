<?php
header('Content-Type: application/json; charset=utf-8');
$records = $ots->execute('module','search-locations',$_POST);
echo $records;