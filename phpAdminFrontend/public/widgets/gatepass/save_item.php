<?php

$data = $_POST;

$result = $ots->execute('servicerequest','save',$_POST);
echo $result;
