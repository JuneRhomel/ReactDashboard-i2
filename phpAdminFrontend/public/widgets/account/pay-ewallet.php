<?php 

$params = [
    'reference_id' => 'test-reference-id',
    'currency' => 'PHP',
    'amount' => 100000,
    'checkout_method' => 'ONE_TIME_PAYMENT',
    'channel_code' => 'PH_GCASH',
    'channel_properties' => [
        'success_redirect_url' => 'https://dashboard.xendit.co/register/1',
    ],
    'metadata' => [
        'branch_code' => 'tree_branch'
    ]
];

$body = '{
    "reference_id": "order-id-{{$timestamp}}",
    "currency": "PHP",
    "amount": 25000,
    "checkout_method": "ONE_TIME_PAYMENT",
    "channel_code": "PH_GCASH",
    "channel_properties": {
        "success_redirect_url": "https://redirect.me/payment",
        "failure_redirect_url": "https://redirect.me/failed"
    },
    "metadata": {
        "branch_city": "MANILA"
    }
}';

$Curl = curl_init();
curl_setopt_array($Curl, [
    CURLOPT_URL => "https://api.xendit.co/ewallets/charges",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => [
        "Accept: application/json",
        "Authorization: Basic " . XENDIT_API_SECRET,
        "Content-Type: application/json"
    ],
]);

$Response = curl_exec($Curl);//return as json
$Response = json_decode($Response);
print_r($Response);