<?php
$data = $_POST;

// echo json_encode($data)
echo $result = $ots->execute('admin','save-role',$data);
?>