<?php
header('Content-Type: application/json; charset=utf-8');
$tenant = $ots->execute('tenant','searchowners',$_POST);
echo $tenant;