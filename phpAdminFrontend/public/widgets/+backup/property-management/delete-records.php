<?php 
$data = $_POST;

echo $result = $ots->execute('property-management','delete-records',$data);
?>