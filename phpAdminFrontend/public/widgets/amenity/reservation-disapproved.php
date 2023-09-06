<?php
header('Content-Type: application/json; charset=utf-8');
$approved = $ots->execute('amenity','set-reservation-status',['reservation_id'=>$args[0],'status'=>'Dispproved']);
echo $approved;