<?php 

$data = $_POST;
echo $result = $ots->execute('utilities','create-payment', $data);
p_r($result);