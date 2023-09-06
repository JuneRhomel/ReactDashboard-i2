<?php
header('Content-Type: application/json; charset=utf-8');
$movements = $ots->execute('tenant','get-moveinout-list',$_POST);
echo $movements;