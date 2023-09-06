<?php 
// p_r($_POST);
$table = $_POST['table'];
$view_table = $_POST['view_table'];
$error = [];
for($x = 0;$x < count($_POST['id']); $x++ ){
    $data = [
        'meter_id' => $_POST['id'][$x],
        'reading' => $_POST['meter_reading'][$x],
        'month'=> $_POST['month'],
        'year'=> $_POST['year'],
    ];
    $result = $ots->execute('utilities','input-new-reading',$data);
    $result = json_decode($result);
    // p_r($data);
    if($result->success == 0){
        array_push($error, $result->description);
    }
}
if(count($error) >0 ){
    $_SESSION['error'] = $error;
}
$redirect = "Location: " . WEB_ROOT . "/utilities/input-reading?submenuid=meterinput";
header($redirect);

?>