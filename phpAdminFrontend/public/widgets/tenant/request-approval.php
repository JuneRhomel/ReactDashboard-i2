<?php
$data = $_POST;
$approved = $ots->execute('tenant','approve-service-request',$data);
// var_dump($_POST);
echo $approved;