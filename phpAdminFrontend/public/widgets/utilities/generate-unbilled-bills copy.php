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
    echo $ots->execute('utilities','generate-soa',$gen_soa_data);
}
// print_r($result);