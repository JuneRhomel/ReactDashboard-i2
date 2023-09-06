<?php
// //header('Content-Type: application/json; charset=utf-8');
$records = $ots->execute('property-management','get-download-records',$_POST ?? []);

$f = fopen('php://memory', 'w'); 

$records_array = json_decode($records,true);
foreach($records_array as $record)
{
	fputcsv($f, $record);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="tenants.csv";');
fpassthru($f);
?>