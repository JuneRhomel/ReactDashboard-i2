<?php
$table = $_REQUEST['table'];
$records = $ots->execute('module','get-download',$_REQUEST);
// echo $records;
// INIT HEADER
$fields = [];
foreach( json_decode($_REQUEST['fields']) as $label=>$field) {
	$fields[] = $label;
}
// INIT CONTENT
$f = fopen('php://memory', 'w'); 
$arr = json_decode($records,true);
fputcsv($f,$fields); // CREATE HEADER
foreach($arr as $record) {
	fputcsv($f, $record);
}
fseek($f, 0);
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="'.$table.'.csv";');
fpassthru($f);