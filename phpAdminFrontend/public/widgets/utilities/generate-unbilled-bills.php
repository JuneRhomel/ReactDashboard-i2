<?php 

$data = $_POST;

$result = $ots->execute('utilities','get-unbilled-bills',$data);
$result = json_decode($result);

foreach($result->bills as $res){
    $gen_soa_data = [
        'month'=>$data['month'],
        'year'=>$data['year'],
        'bill_id'=>$res->id
    ];
    $ots->execute('utilities','generate-soa',$gen_soa_data);
}
echo json_encode(['success' => true]);
// print_r($result);