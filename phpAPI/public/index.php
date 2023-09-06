<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include(__DIR__ . '/../config.php');
include(__DIR__ . '/../db.php');
include(__DIR__ . '/../shared.php');
include(__DIR__ . '/../mailer/mailer.class.php');

date_default_timezone_set('Asia/Manila');

$clients = [
	'UdAgg7J2Htbp5WECsm42LnUnXxLG5NwM' => '8vYW4XyXEsTUsxg8LvKzWcyB54BSFDa2' //sandbox-ots
];

$input = file_get_contents("php://input");
$data = json_decode($input,true) ?? [];
//vdumpx($data);

//get headers
$headers_auth = null;
if (isset($_SERVER['Authorization']))
{
	$headers_auth = trim($_SERVER["Authorization"]);
}else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
	$headers_auth = trim($_SERVER["HTTP_AUTHORIZATION"]);
} elseif (function_exists('apache_request_headers')) {
	$requestHeaders = apache_request_headers();
	// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
	$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
	if (isset($requestHeaders['Authorization'])) 
	{
		$headers_auth = trim($requestHeaders['Authorization']);
	}
}

$url = isset($_GET['url']) ?
	($_GET['url'] == 'default.asp' ? 'index' : $_GET['url']) //fixed for iis
	: (!defined(PAGE_INDEX) ? 'index' : PAGE_INDEX) ;
$url = preg_replace('/<script(.*?)>(.*?)<\/script>/is', '',$url);

$url_array = explode('/',$url);

$module = $url_array[0] ?? 'main';
$command = $url_array[1] ?? 'main';

if($command == 'index') $command = 'main';

if(!$headers_auth)
{
	header("HTTP/1.1 401 Unauthorized");
	$module = 'error';
	$command = '401';
}

$bearer = explode(" ",$headers_auth);

$accountcode = ($data['accountcode']) ?? ""; //get account code

unset($data['accountcode']);  //remove account code from $data
$sth = $db->prepare('select * from accounts where account_code=:account_code');
$sth->execute(['account_code'=>$accountcode]);
$account = $sth->fetch();
$user_id = 0;

if(!$account && $accountcode !='')
{
	header("HTTP/1.1 404 Unauthorized");
	$module = 'error';
	$command = '401';
}else{

	$account_db  =  DB_NAME . '_' . $account['id'];

	if(in_array($command,['authenticate','accountdetails','getotp','get-unit-list','self-register','reset-password-request','reset-password','register','save-systeminfo']))
	{
		//login token not required
		$client_credentials = explode(":",base64_decode($bearer[1]));
		if(!isset($clients[$client_credentials[0]]) || $clients[$client_credentials[0]] != $client_credentials[1])
		{
			header("HTTP/1.1 401 Unauthorized");
			$module = 'error';
			$command = '401';
		}
	}else{ //check token

		$token = explode(":",$bearer[1]);
		$token_type = $token[1] ?? 'user';

		if($token_type == 'tenant')
			$user_token_table = "{$account_db}._tenant_tokens";
		else	
			$user_token_table = "{$account_db}._user_tokens";
		$sth = $db->prepare("select * from {$user_token_table} where token=:token");
		$sth->execute(['token'=>$token[0]]);
		$user_token = $sth->fetch();

		if(!$user_token)
		{
			header("HTTP/1.1 401 Unauthorized");
			$module = 'error';
			$command = '401';
		}else{
			$user_id = $user_token["{$token_type}_id"];
		}
	}
}
//vdumpx($account_db);


if(!file_exists(__DIR__ . '/'. $module . '/' . $command . '.php'))
{
	header("HTTP/1.0 404 Not Found"); //command does not exist
	$command = __DIR__ . '/error/404';	
}else{
	$command = __DIR__ . '/'. $module  . '/' . $command;
}

include($command . '.php');