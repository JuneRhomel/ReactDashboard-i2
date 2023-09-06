<?php
header('Content-Type: application/json; charset=utf-8');
$approved = $ots->execute('tenant','set-registration-status',['registration_id'=>$args[0],'status'=>'Approved']);
echo $approved;