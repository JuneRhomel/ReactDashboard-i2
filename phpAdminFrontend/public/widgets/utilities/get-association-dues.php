<?php 
$data = $_POST;

$result = $ots->execute('utilities','get-association-dues',$data);

echo $result;