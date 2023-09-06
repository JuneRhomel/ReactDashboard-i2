<?php 

$params = [
    "business_id"=>"63743544edc773ab7872ef01",
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
    "business_id":"63743544edc773ab7872ef01",
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
        "Authorization: Basic eG5kX2RldmVsb3BtZW50X3dXZGNZaXZ3dXB0clFoUWc2WEc3QUt6QXNqVThibUVXRmsySHdPeVp3NXR0eVpaUXdwb0JJQWJ6NGxZSklRY1g6",
        "Content-Type: application/json"
    ],
]);

$Response = curl_exec($Curl);//return as json
$Response = json_decode($Response);
print_r($Response);
?>