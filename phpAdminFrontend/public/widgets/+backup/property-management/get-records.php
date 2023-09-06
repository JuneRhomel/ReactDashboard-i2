<?php 
$data = $_POST;

echo $result = $ots->execute('property-management','get-records',$data);
?>