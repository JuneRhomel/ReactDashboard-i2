<?php
header('Content-Type: application/json; charset=utf-8');
$tenant = $ots->execute('tenant','search',$_POST);
echo $tenant;