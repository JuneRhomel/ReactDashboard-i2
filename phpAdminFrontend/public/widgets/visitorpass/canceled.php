<?php
header('Content-Type: application/json; charset=utf-8');
$approved = $ots->execute('visitor','set-status',$_POST);
echo $approved;