<?php
header('Content-Type: application/json; charset=utf-8');
$approved = $ots->execute('pdc','set-status',['pdc_id'=>$args[0],'status'=>'Deposited']);
echo $approved;