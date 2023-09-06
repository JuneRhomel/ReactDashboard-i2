<?php
header('Content-Type: application/json; charset=utf-8');
$movements = $ots->execute('tenant','get-turnover-list',$_POST);
echo $movements;