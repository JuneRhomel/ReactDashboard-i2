<?php
$data = $_POST;
// print_r($data);
$body = [
    'cmd'=>'get_account',
    'params'=>[
        'email'=>$data['username']
    ]
];			

$Curl = curl_init();

curl_setopt_array($Curl, [
    CURLOPT_URL => "http://35.89.1.106/i2accounts/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($body),
    CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "Authorization: Basic " . PAYMONGOPUBLICKEY,
        "Content-Type: application/json"
    ],
]);


$Response = curl_exec($Curl);//return as json
$Response = json_decode($Response);

if($Response->success == 1){
    $accountcode = $Response->data->account;

    $data['account_code'] = $accountcode;
    
    $result = $ots->execute('auth','authenticate',$data);
    $auth = json_decode($result,true);

    if($auth && $auth['success'] == 1)
    {
        $_SESSION['accountcode'] = $accountcode;
        // var_dump($ots->session);
        // $ots->session->setToken($auth['data']['token']);
        $ots->session->setUserData($auth['data']);
        header("location: " . WEB_ROOT);
    }
    else{
        header("location: " . WEB_ROOT . '/registration/login.php?error=Invalid login');
    }
        
}
else{
    header("location: " . WEB_ROOT . '/registration/login.php?error=Email Account not existed');
}

exit();