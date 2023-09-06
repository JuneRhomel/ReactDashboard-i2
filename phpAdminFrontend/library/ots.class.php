<?php
class OTS {
	public $session;
	
	public function __construct($session)
	{
		$this->session = $session;
	}

	public function __call($method, $arguments) 
	{
		$return_value = ['success'=>1,'data'=>[]];
		try{
			if(method_exists($this, $method))
			{
				$return_value = call_user_func_array(array($this,$method),$arguments);
			}else{
				$return_value = $this->__apiSend('auth',$method,$arguments ? $arguments[0] : []);
			}
		}catch(Exception $e){

		}

		return $return_value;
	}

	/**
	 * Execute an api command
	 *
	 * @param string $module
	 * @param string $command
	 * @param array $params
	 * @return string
	 */
	public function execute(string $module,string $command,array $params = []):string
	{
		return $this->__apiSend($module,$command,$params);
	}

	/**
	 * Send post reqeust to  ots api server
	 *
	 * @param string $module
	 * @param string $command
	 * @param array $params
	 * @return string
	 */
	private function __apiSend(string $module,string $command,array $params = []):string
	{
		// create a new cURL resource
		//echo API_URL . '/' . strtolower($module) . '/' . strtolower($command);
		$ch = curl_init(API_URL . '/' . strtolower($module) . '/' . strtolower($command));
		
		//set user agent
		curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2');

		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//add headers
		$curl_headers = ["Content-Type: application/json"];
		if(in_array($command,['authenticate','accountdetails','register','verify','save-systeminfo']))
			$curl_headers[] = "Authorization: Bearer " . base64_encode(API_ID . ":" . API_SECRET);
		else
			$curl_headers[] = "Authorization: Bearer " . $this->session->getToken();

		curl_setopt($ch, CURLOPT_HTTPHEADER,$curl_headers);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);

		if(!isset($params['accountcode']))
		{
			$account_code = $this->session->getAccountCode();
			
			$params['accountcode'] = $_SESSION['accountcode'];
		}
		
		//add data
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($params));
		
		$return_value = curl_exec($ch);
		
		if(curl_errno($ch))  $return_value = curl_error($ch);
		curl_close($ch);

		
		return $return_value;
	}
}