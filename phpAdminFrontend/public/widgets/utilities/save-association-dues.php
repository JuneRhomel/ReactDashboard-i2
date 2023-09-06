<?php

$data = $_POST;
// print_r($data);
echo $result = $ots->execute('utilities','save-association-dues',$data);