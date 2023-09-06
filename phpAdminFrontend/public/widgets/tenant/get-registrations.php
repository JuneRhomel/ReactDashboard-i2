<?php
header('Content-Type: application/json; charset=utf-8');
$tenants = $ots->execute('tenant','get-tenant-registrations',$_POST);
echo $tenants;