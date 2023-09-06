<?php
header('Content-Type: application/json; charset=utf-8');
$equipment = $ots->execute('equipment','get-equipment-list',$_POST);
echo $equipment;