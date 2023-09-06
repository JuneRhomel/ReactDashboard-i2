<?php
//header('Content-Type: application/json; charset=utf-8');
$tenants = $ots->execute('tenant','get-turnover-download',$_POST ?? []);

$f = fopen('php://memory', 'w'); 

$tenants_array = json_decode($tenants,true);
fputcsv($f, [ "ID","Tenant Name","Location","Stage","Created" ]);
foreach($tenants_array as $tenant)
{
	fputcsv($f, $tenant);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="turnovers.csv";');
fpassthru($f);