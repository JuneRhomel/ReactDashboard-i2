<?php
$data = $_POST;

// echo json_encode($data)
echo $result = $ots->execute('user-management','account',$data);
?>