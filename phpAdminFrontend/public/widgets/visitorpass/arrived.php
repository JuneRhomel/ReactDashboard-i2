<?php
header('Content-Type: application/json; charset=utf-8');
$approved = $ots->execute('visitor','set-status',['visitor_id'=>$args[0],'status'=>'Arrived']);
echo $approved;