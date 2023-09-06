<?php
header('Content-Type: application/json; charset=utf-8');
$tenants = $ots->execute('tenant','get-tenants',$_POST);
echo $tenants;