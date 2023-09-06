<?php
    $url = "https://api.xendit.co/credit_card_charges";
	$headers = [];
	$headers[] = "Authorization: Basic eG5kX2RldmVsb3BtZW50X3dXZGNZaXZ3dXB0clFoUWc2WEc3QUt6QXNqVThibUVXRmsySHdPeVp3NXR0eVpaUXdwb0JJQWJ6NGxZSklRY1g6";
	$headers[] = "Content-Type: application/json";
	$data = [
        'external_id' => 'test-external-id',
        'token_id' => $_POST['id'],
        'amount' => 5000,
        'authentication_id' => $_POST['authentication_id'],
        'capture'=>'false'
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

?>