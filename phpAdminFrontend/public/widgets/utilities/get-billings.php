<?php 
$data = [
    'month'=> $_POST['month'],
    'year'=>$_POST['year'],
];

$results = $ots->execute('utilities', 'get-billings',$data);
echo $results;
