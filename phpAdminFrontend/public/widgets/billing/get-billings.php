<?php
header('Content-Type: application/json; charset=utf-8');
$billings = $ots->execute('billing','get-billings',$_POST);
echo $billings;