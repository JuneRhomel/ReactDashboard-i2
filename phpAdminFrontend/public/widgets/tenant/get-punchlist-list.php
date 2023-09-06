<?php
header('Content-Type: application/json; charset=utf-8');
$movements = $ots->execute('tenant','get-punchlist-list',$_POST);
echo $movements;