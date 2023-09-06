<?php
header('Content-Type: application/json; charset=utf-8');
$servicerequest = $ots->execute('servicerequest','get-servicerequests',$_POST);
echo $servicerequest;