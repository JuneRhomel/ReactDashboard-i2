<?php
header('Content-Type: application/json; charset=utf-8');
$records = $ots->execute('amenity','set-reservation-status',['reservation_id'=>$args[0],'status'=>'Approved']);
echo $records;