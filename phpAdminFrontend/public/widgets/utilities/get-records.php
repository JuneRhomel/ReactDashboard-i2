<?php 
$data = $_POST;

echo $result = $ots->execute('utilities','get-record',$data);
?>