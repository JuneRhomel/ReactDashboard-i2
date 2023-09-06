<?php
header('Content-Type: application/json; charset=utf-8');
$pdcs = $ots->execute('pdc','get-pdcs',$_POST);
echo $pdcs;