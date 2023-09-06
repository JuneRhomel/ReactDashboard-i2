<?php 

$data = $_POST;

echo $result = $ots->execute('property-management','pm-update-stage',$data);