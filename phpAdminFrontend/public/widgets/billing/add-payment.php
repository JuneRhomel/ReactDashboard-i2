<?php
header('Content-Type: application/json; charset=utf-8');
$billings = $ots->execute('billing','add-payment',$_POST);
echo $billings;