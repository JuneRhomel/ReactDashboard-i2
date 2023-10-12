<?php
session_start();
include("../library.php");

/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

$arr = array(
    'Gate Pass'=>array('gatepass','save-update-gatepass','gatepass_id'),
    'Service Request'=>array('servicerequest','save-update-request','sr_id'),
    'Reservation'=>array('amenity','save-update-reservation','reservation_id'),
    'Turnover'=>array('servicerequest','save-update-turnover','sr_id'),
    'Move In/Out'=>array('servicerequest','save-update-movement','sr_id'),
    'Punch List'=>array('servicerequest','save-update-punchlist','sr_id'),
);

$id = initObj('id');
$form = initObj('form');
$status = initObj('status');
$description = initObj('description');

$module = $arr[$form][0];
$command = $arr[$form][1];

$post[$arr[$form][2]] = $id;
$post['description'] = $description;
$post['status'] = $status;
//vdump($post);

$api = apiSend($module,$command,$post);
//vdump($api);

header("location: myrequests-view.php?id=$id&form=$form");
?>