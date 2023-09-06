<?php
header('Content-Type: application/json; charset=utf-8');

echo $result = $ots->execute('dashboard','save',$_POST);