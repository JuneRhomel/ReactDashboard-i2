<?php 
$data = [
    'month'=> $_POST['month'],
    'year'=>$_POST['year'],
];

$results = $ots->execute('utilities', 'update-billing-info',$data);
echo $results;
