<?php
header('Content-Type: application/json; charset=utf-8');
$locations = $ots->execute('form','get-forms',$_POST);
echo $locations;