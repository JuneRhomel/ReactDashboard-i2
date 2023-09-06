<?php
//   $url = "https://api.xendit.co/transactions/txn_a6017465-b6ba-4877-9fa7-2f061b7cc1a7";
//   $headers = [];
// //   $headers[] = "Content-Type: application/json";
//   $headers[] = "Authorization: Basic eG5kX2RldmVsb3BtZW50X1A0cURmT3NzME9DcGw4UnRLclJPSGphUVlOQ2s5ZE41bFNmaytSMWw5V2JlK3JTaUN3WjNqdz09Og==";

//   $curl = curl_init($url);
//   curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//   curl_setopt($curl, CURLOPT_URL, $url);
//   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//   $resp = curl_exec($curl);
//   curl_close($curl);


// TEST PAYMENT
	$url = "https://api.xendit.co/ewallets/charges";
	$headers = [];
	$headers[] = "Authorization: Basic eG5kX2RldmVsb3BtZW50X1A0cURmT3NzME9DcGw4UnRLclJPSGphUVlOQ2s5ZE41bFNmaytSMWw5V2JlK3JTaUN3WjNqdz09Og==";
	$headers[] = "Content-Type: application/json";
	$data = [
		'reference_id' => 'test-reference-id',
		'currency' => 'PHP',
		'amount' => 100,
		'checkout_method' => 'ONE_TIME_PAYMENT',
		'channel_code' => 'PH_PAYMAYA',
		'channel_properties' => [
			'success_redirect_url' => 'https://dashboard.xendit.co/register/1',
			'failure_redirect_url' => 'https://dashboard.xendit.co/register/2',
			'cancel_redirect_url' => 'https://dashboard.xendit.co/register/3',
		]
	];

	$curl = curl_init();
	$datas = json_encode($data);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $datas);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$resp = curl_exec($curl);
	curl_close($curl);


  echo json_encode($resp);
?>