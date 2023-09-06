<?php
header('Content-Type: application/json; charset=utf-8');
$pm = $ots->execute('wo','get-wo-list',$_POST);
echo $pm;