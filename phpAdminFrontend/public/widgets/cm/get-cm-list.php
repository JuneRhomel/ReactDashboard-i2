<?php
header('Content-Type: application/json; charset=utf-8');
$pm = $ots->execute('cm','get-pm-list',$_POST);
echo $pm;