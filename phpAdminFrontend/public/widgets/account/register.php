<?php

$data = $_POST;
if($data['step'] == 1){
    unset($_SESSION['profile']);
    session_start();
    $_SESSION['profile'] = $data;
    echo json_encode([
        'success' => 1
    ]);
}
if($data['step'] == 2){
    $body = [
        'cmd'=>'get_account',
        'params'=>[
            'email'=>$data['email']
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
            "Content-Type: application/json"
        ],
    ]);
    
    
    $Response = curl_exec($Curl);//return as json
    $Response = json_decode($Response);
    if($Response->success == 1){
        echo json_encode([
            'success' => 0,
            'description'=>'Account Email Exising'
        ]);
    }
    else{

        $account = str_replace('@','', $data['email']);
        $account = str_replace('.','', $account);

        $body = [
            'cmd'=>'save_account',
            'params'=>[
                'email'=>$data['email'],
                'account'=>$account
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

        if($Response->success == 0){
            echo json_encode([
                'success' => 0,
                'description'=>$Response->error->description,
                'data' => $data,
                'account_return' => $Response
            ]);
        }
        else{
            $data['account_code'] = $account;
            $data['profile'] = $_SESSION['profile'];
            echo $result = $ots->execute('account','register',$data);
            json_encode([
                'success' => 1,
                'description'=>'Go Set Up the account',
                'session'=>$_SESSION,
                'data' => $data,
                'account_return' => $Response
            ]);
        }
    }
    
}
if($data['step'] == 3){
    echo $result = $ots->execute('account','register',$data);
}
if($_GET['verify']){
    
    $data['verify'] = $_POST['verify'];
    $data['account_id'] = $_POST['account_id'];
    echo $result = $ots->execute('account','register',$data);
}




// // $auth = json_decode($result,true);

// if($auth && $auth['success'] == 1)
// {
// 	//$ots->session->setToken($auth['data']['token']);
// 	$ots->session->setUserData($auth['data']);
// 	header("location: " . WEB_ROOT);
// }
// else
// 	header("location: " . WEB_ROOT . '/auth/login?error=' . $auth['description']);
// exit();
