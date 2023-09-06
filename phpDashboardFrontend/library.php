<?php
include(__DIR__ . '/config.php');

function getLocInfo() {
	session_start();
	$tenant = initSession('tenant');	
	foreach ($tenant['locations'] as $key=>$val) {
	    if ($val['is_default'])
	      return $val;
	}	
}

function initFile($upload_file) {
	$file = $upload_file['tmp_name'];
	if ($file!="") {
		$filename = $upload_file['name'];
		$content = chunk_split(base64_encode(file_get_contents($file)));
		return array("filename"=>$filename,"data"=>$content);
	} else {
		return "";
	}
	
}

function apiSend(string $module,string $command,array $params = []):string {

	// create a new cURL resource
	$ch = curl_init(API_URL . '/' . strtolower($module) . '/' . strtolower($command));
	
	//set user agent
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2');

	// set URL and other appropriate options
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	//add headers
	$curl_headers = ["Content-Type: application/json"];
	if(in_array($command,['authenticate','accountdetails','getotp','get-unit-list','self-register','get-acctcode']))
		$curl_headers[] = "Authorization: Bearer " . base64_encode(API_ID . ":" . API_SECRET);
	else
		$curl_headers[] = "Authorization: Bearer " . $_SESSION['tenant']['token'] . ':tenant';

	curl_setopt($ch, CURLOPT_HTTPHEADER,$curl_headers);
	curl_setopt($ch, CURLOPT_FAILONERROR, true);

	if(!isset($params['accountcode']))
	{
		$params['accountcode'] = isset($_SESSION['accountcode']) ? $_SESSION['accountcode'] : ACCOUNT_CODE;
	}

	// 23-0728 ATR: CHECK SESSION INSTEAD OF PARAM
	

	//add data
	curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($params));
	
	$return_value = curl_exec($ch);
	
	if(curl_errno($ch))  $return_value = curl_error($ch);

	curl_close($ch);
	
	//$return_value = curl_error($ch);

	return $return_value;
}

/**
 * Encrypt data. Numeric or String.
 * @param integer|string $data Data to encrypt
 * @return string Encrypted data
 */
function encryptData($data)
{
	$encrypt_method = "AES-256-CBC";
	$key = defined('ENCRYPT_KEY') ? md5(ENCRYPT_KEY . time()) : md5(randomString() . time());
	$iv = substr($key,0,16);
	$data = base64_encode(openssl_encrypt($data,$encrypt_method,$key,0,$iv));
	$data = str_replace(array('+','/','='),array('-','_',''),$data);
	return $data . "." . $key;
}

/**
 * Decrypt data
 * @param string $data Encrypted data to decrypt
 * @return integer|string Decrypted data
 */
function decryptData($data)
{
	$encrypt_method = "AES-256-CBC";
	$data = str_replace(array('-','_'),array('+','/'),$data);
	$mod4 = strlen($data) % 4;
	if ($mod4)
	{
		$data .= substr('====', $mod4);
	}
	//$key = defined('ENCRYPT_KEY') ? md5(ENCRYPT_KEY) : md5($_SERVER['HTTP_HOST']);
	$parts = explode(".",$data);

	if(count($parts) < 2) return '';
	
	$key = $parts[1];
	$iv = substr($key,0,16);
	return openssl_decrypt(base64_decode($parts[0]),$encrypt_method,$key,0,$iv);
}

function alertNew($message, $newpage) {
    echo "<script language='javascript'>";
    echo "alert('" . $message . "');";
    echo "window.document.location=('" . $newpage . "');";
    echo "</script>";
    exit;
}

function alertJS($message) {
    echo "<script language='javascript'>";
    echo "alert('" . $message . "');";
    echo "</script>";
    exit;
}

function formatDate($val) {
	return date("d M Y",strtotime($val));
}

function formatDateUnix($val) {
	return date("d M Y",$val);
}

function formatNumber($val, $digit = 2) {
    return ($val == "") ? "" : number_format($val, $digit, ".", "");
}

function formatPrice($val, $ynSign = 0) {
    //$sign = ($ynSign == 1) ? "<span style=''>&#8369;</span> " : "";
    $sign = ($ynSign == 1) ? "<span style=''>PhP</span> " : "";
    return ($val==0) ? 0 : $sign . number_format($val, 2, ".", ",");
}

function initObj($obj) {
    if (isset($_REQUEST[$obj]))
        $val = str_replace("'", "`", $_REQUEST[$obj]);
    else
        $val = "";
    return $val;
}

function setSession($sessname, $obj) {
    $_SESSION[$sessname] = $obj;
}

function initSession($obj) {
    return (isset($_SESSION[$obj])) ? $_SESSION[$obj] : $val = "";
}

function debug($val) {
    $val = str_replace("''", "null", $val);
    $val = str_replace("'null'", "null", $val);
    echo date("m/d/Y H:i:s") . " >  " . $val;
    exit;
}

function vdump($val) {
    echo date("m/d/Y H:i:s") . "<br>";
	echo "<pre>";
    var_dump($val);
	echo "</pre>";
}

function vdumpx($val) {
    echo date("m/d/Y H:i:s") . "<br>";
	echo "<pre>";
    var_dump($val);
	echo "</pre>";
    exit;
}

function genQRcode($link)
{
	error_reporting(E_ALL);
    ini_set('display_errors', 1); // Enable error reporting
    include __DIR__.'/public/library/phpqrcode/qrlib.php';
    $redirectUrl = $link;
    // Output image file path
    $outputFile = './assets/images/qrcode.png';

    // Generate QR Code
    QRcode::png($redirectUrl, $outputFile, QR_ECLEVEL_H, 5, 4);
    // Display the QR Code image
    echo '<img class="qr-code" src="' . $outputFile . '" alt="QR Code">';
    // Add a download link
    echo '<br><a class="btn btn-dark btn-primary settings-save d-block px-5 py-2 " style="width: 300px;" href="' . $outputFile . '" download>Download QR Code</a>';
}

