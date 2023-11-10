<?php 
$url = "https://api.xendit.co/v2/invoices";
$key = "xnd_development_FxkGVmvvPxK2yoEflpYc0FnCHagUuSgPemI1joGzypCxvGDrBNOonCSRAhV";

/*var_dump(json_encode($fields));
echo "<br>";*/
$body = '{
    "external_id": "123",
    "amount": 8000,
    "description": "SOA #123",
    "invoice_duration":86400,
    "customer": {
        "given_names": "John",
        "surname": "Doe",
        "email": "johndoe@example.com",
        "mobile_number": "+639171234567"
    },
    "success_redirect_url": "https://www.google.com",
    "failure_redirect_url": "https://www.yahoo.com",
    "currency": "PHP",
    "items": [
        {
            "name": "Rental Fee - Oct 2023",
            "quantity": 1,
            "price": 5000
        },
        {
            "name": "Water - Oct 2023",
            "quantity": 1,
            "price": 1000
        },
        {
            "name": "Electricity - Oct 2023",
            "quantity": 1,
            "price": 2000
        }
    ]
}';

//var_dump(json_encode($body)); exit;
/*$header = array();
$header[] = "Accept: application/json";
$header[] = "Authorization: Basic $key";
$header[] = "Content-Type: application/json";
//var_dump($header); exit;
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $body,
    CURLOPT_HTTPHEADER => $header,
]);

$response = curl_exec($curl);//return as json
if ($response===false)
	print_r('Curl error: ' . curl_error($crl));
$response = json_decode($response);
print_r($response);*/


//$ch = curl_init($url);
$ch = curl_init($url);
/*$curl_headers = ["Content-Type: application/json"];
$curl_headers[] = "Authorization: Basic ".$key;
$curl_headers[] = "Accept: application/json";*/
$curl_headers = array("Content-Type: application/json","Accept: application/json","Authorization: Basic $key");
curl_setopt($ch, CURLOPT_POST,1);
curl_setopt($ch, CURLOPT_HTTPHEADER,$curl_headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_FAILONERROR,true);
curl_setopt($ch, CURLOPT_TIMEOUT,30);
curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2');
curl_setopt($ch, CURLOPT_POSTFIELDS,$body);
$response = curl_exec($ch);
if (curl_error($ch))
	print_r('Curl error: ' . curl_error($ch));
//var_dump($response);
$response = json_decode($response);

?>