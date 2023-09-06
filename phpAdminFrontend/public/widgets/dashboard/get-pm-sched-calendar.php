<?php 
$data = $_POST;


// echo $result = $ots->execute('dashboard','get-pm-sched-calendar',$data);
$result = $ots->execute('dashboard','get-pm-sched-calendar',$data);

p_r($result);
?>