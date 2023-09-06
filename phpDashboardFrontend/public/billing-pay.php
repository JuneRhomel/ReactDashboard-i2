<?php
include("footerheader.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id = initObj('id');
$tenant = initSession('tenant');

$api = apiSend('billing','get-billing',[ 'billingid'=>$id ]);
$val = json_decode($api,true);

// form the arrays for paymaya
$TotalAmount = [
    'value' => $val['amount'],
    'currency'=> 'PHP',
    'details'=> [
        'discount' => 0,
        'serviceCharge' => 0,
        'shippingFee' => 0,
        'tax' => 0,
        'subtotal' => $val['amount'],
        ],
    ];

$BuyerInfo = [
    'fullName'=> $val['tenant_name'],
    'contact'=> [
        'phone'=> strval($tenant['mobile']),
        'email'=> $tenant['email'],
        ],
    'billingAddress'=> [
        'line1'=> 'Address1',
        'line2'=> 'Address2',
        'city'=> 'City',
        'state'=> 'Metro Manila',
        'zipCode'=> '',
        'countryCode'=> 'PH'
        ],
    ];

$RedirectURL = [
    "success"=> 'https://web.intuition.ph/payment',
    "failure"=> 'https://web.intuition.ph/payment',
    "cancel"=> 'https://web.intuition.ph/payment',
    ];

$CreatePaymentArray = [
    'totalAmount' => $TotalAmount,
    'buyer' => $BuyerInfo,
    'redirectUrl' => $RedirectURL,
    'requestReferenceNumber' => 'x123456789',
];

$CombinedString = 'pk-suqfDXLtTLvLcTdypJDwGJ9Q83nw4BVplXvrwPISYcQ' . ':';
$EncodedString = base64_encode($CombinedString);
$EncodedString = 'cGstWjBPU3pMdkljT0kyVUl2RGhkVEdWVmZSU1NlaUdTdG5jZXF3VUU3bjBBaDo=';

$ch = curl_init('https://pg-sandbox.paymaya.com/checkout/v1/checkouts');
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Basic ' . $EncodedString,
    ]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($CreatePaymentArray));
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$CURLReturn = curl_exec($ch);

curl_close($ch);

$decoded = json_decode($CURLReturn, TRUE);
header("location: "  . $decoded['redirectUrl']);