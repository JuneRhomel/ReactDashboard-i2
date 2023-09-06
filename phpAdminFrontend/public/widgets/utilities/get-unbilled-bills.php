<?php 

$data = $_POST;

echo $result = $ots->execute('utilities','get-unbilled-bills',$data);