<?php
header('Content-Type: application/json; charset=utf-8');
$pm = $ots->execute('pm','get-pm-list',$_POST);
echo $pm;