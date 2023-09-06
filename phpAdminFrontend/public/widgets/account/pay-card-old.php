<?php
    // $url = "https://api.xendit.co/recurring/plans";
	// $headers = [];
	// $headers[] = "Authorization: Basic eG5kX2RldmVsb3BtZW50X3dXZGNZaXZ3dXB0clFoUWc2WEc3QUt6QXNqVThibUVXRmsySHdPeVp3NXR0eVpaUXdwb0JJQWJ6NGxZSklRY1g6";
	// $headers[] = "Content-Type: application/json";
	// $body = '{
	// 	"reference_id": "test_reference_id",
	// 	"customer_id": "cust-239c16f4-866d-43e8-9341-7badafbc019f",
	// 	"recurring_action": "PAYMENT",
	// 	"currency": "IDR",
	// 	"amount": 13579,
	// 	"payment_methods": [{
	// 	  "payment_method_id": "pm-asdaso213897821hdas",
	// 	  "rank": 1
	// 	}],
	// 	"schedule": {
	// 	  "reference_id": "test_reference_id",
	// 	  "interval": "MONTH",
	// 	  "interval_count": 1,
	// 	  "total_recurrence": 12,
	// 	  "anchor_date": "2022-02-15T16:23:52Z",
	// 	  "retry_interval": "DAY",
	// 	  "retry_interval_count": 3,
	// 	  "total_retry": 2,
	// 	  "failed_attempt_notifications": [1,2]
	// 	},
	// 	"immediate_action_type": "FULL_AMOUNT",
	// 	"notification_config": {
	// 	  "recurring_created": ["WHATSAPP","EMAIL"],
	// 	  "recurring_succeeded": ["WHATSAPP","EMAIL"],
	// 	  "recurring_failed": ["WHATSAPP","EMAIL"],
	// 	  "locale": "en"},
	// 	"failed_cycle_action": "STOP",
	// 	"metadata": null,
	// 	"description": "Video Game Subscription",
	// 	"items": [
	// 		  {
	// 			  "type": "DIGITAL_PRODUCT",
	// 			  "name": "Cine Mraft",
	// 			  "net_unit_amount": 13579,
	// 			  "quantity": 1,
	// 			  "url": "https://www.xendit.co/",
	// 			  "category": "Gaming",
	// 			  "subcategory": "Open World"
	// 		  }
	// 	  ],
	// 	"success_return_url": "https://www.xendit.co/successisthesumoffailures",
	// 	"failure_return_url": "https://www.xendit.co/failureisthemotherofsuccess"
	//   }';

	$body = [
			"id"=> "pm-6d1c8be4-f4d9-421c-9f0b-ab3b2b6bbc39",
			"type"=> "CARD",
			"reusability"=> "MULTIPLE_USE",
			"customer_id"=> "fc4c060b-3c41-4707-b7b2-df9c3376edde",
			"business_id"=> "5f27a14a9bf05c73dd040bc8",
			"status"=> "REQUIRES_ACTION",
			"country"=> "PHP",
			"actions"=> [
				"action"=> "AUTH",
				"url_type"=> "WEB",
				"url"=> "https://link-web.xendit.co/oauth/user_redirection_url",
				"method"=> "GET"
				],
			"card"=> [
				"currency"=> "PHP",
				"channel_properties"=> [
					"skip_three_d_secure"=> "false",
					"cardonfile_type"=> "RECURRING",
					"success_return_url"=> "https://your-redirect-website.com/success",
					"failure_return_url"=> "https://your-redirect-website.com/failure"
				],
				"card_information"=> [
					"card_number"=> "4000000000001000",
					"expiry_month"=> "09",
					"expiry_year"=> "24",
					"cardholder_name"=> "Test Only"
				]
			]
		];
	  $datas = json_encode($body);

	  $Curl = curl_init();
	  curl_setopt_array($Curl, [
		  CURLOPT_URL => "https://api.xendit.co/v2/payment_methods",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $datas,
		  CURLOPT_HTTPHEADER => [
			  "Accept: application/json",
			  "Authorization: Basic " . XENDIT_API_SECRET,
			  "Content-Type: application/json"
		  ],
	  ]);
	  
	  $Response = curl_exec($Curl);//return as json
	  $Response = json_decode($Response);
	  print_r($Response);
?>