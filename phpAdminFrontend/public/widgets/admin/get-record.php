<?php 
$data = $_POST;

echo $result = $ots->execute('admin','get-record',$data);
?>