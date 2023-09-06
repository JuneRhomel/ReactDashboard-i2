<?php
// $records = $ots->execute('module','get-download',$_REQUEST);
// echo $records;

$path = '/file/absolute/path.pdf';
$content = $_REQUEST['ids'];

file_put_contents($path, $content);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="'.$table.'.csv";');