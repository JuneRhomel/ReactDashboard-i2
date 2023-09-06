<?php
//header('Content-Type: application/json; charset=utf-8');
$tenants = $ots->execute('tenant','get-tenants-download',$_POST ?? []);

$f = fopen('php://memory', 'w'); 

$tenants_array = json_decode($tenants,true);
foreach($tenants_array as $tenant)
{
	fputcsv($f, $tenant);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="tenants.csv";');
fpassthru($f);