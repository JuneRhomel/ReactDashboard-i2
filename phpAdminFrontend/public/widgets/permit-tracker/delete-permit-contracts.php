<?php 
// print_r($_GET);
$id = explode('/', $_GET['url'])[2];
$data = $_GET;
$data['id'] = $id;
// print_R($data);

$result = $ots->execute('contracts','delete-permit-contracts',$data);
$result = json_decode($result);
if($result->success == 1){
    if($_GET['table'] == 'permits'){
        header ('location:' . WEB_ROOT . '/contracts/permit-tracker?submenuid=permittracker');
    }
    else{
        header ('location:' . WEB_ROOT . '/contracts/contract-tracker?submenuid=permittracker');
    }
}

// print_R($result);