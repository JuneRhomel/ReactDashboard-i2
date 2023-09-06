<?php
header('Content-Type: application/json; charset=utf-8');
$records = $ots->execute('module','search-meters',$_POST);
echo $records;