<?php

/**
 * File library/shared.php
 */

/**
 * Autoload required class
 *
 * Filename format &lt;classname&gt;.class.php
 * @param string $class_name Class to load.
 */

function app_autoload($class_name)
{
	$class_name = strtolower($class_name);

	if (file_exists(DIR_LIBRARY . "/{$class_name}.class.php")) {
		require_once(DIR_LIBRARY . "/{$class_name}.class.php");
	} else {
		echo '<center>Opppps!!! Something went wrong.</center>';
	}
}

spl_autoload_register('app_autoload');

function initFile($upload_file)
{
	$file = $upload_file['tmp_name'];
	if ($file != "") {
		$filename = $upload_file['name'];
		$content = chunk_split(base64_encode(file_get_contents($file)));
		return array("filename" => $filename, "data" => $content);
	} else {
		return "";
	}
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
	$iv = substr($key, 0, 16);
	$data = base64_encode(openssl_encrypt($data, $encrypt_method, $key, 0, $iv));
	$data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
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
	$data = str_replace(array('-', '_'), array('+', '/'), $data);
	$mod4 = strlen($data) % 4;
	if ($mod4) {
		$data .= substr('====', $mod4);
	}
	//$key = defined('ENCRYPT_KEY') ? md5(ENCRYPT_KEY) : md5($_SERVER['HTTP_HOST']);
	$parts = explode(".", $data);

	if (count($parts) < 2) return '';

	$key = $parts[1];
	$iv = substr($key, 0, 16);
	return openssl_decrypt(base64_decode($parts[0]), $encrypt_method, $key, 0, $iv);
}

function excel_to_array($inputFileName, $row_callback = null)
{
	if (!class_exists('PHPExcel')) return false;
	try {
		$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);
	} catch (Exception $e) {
		return ('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
	}
	$sheet = $objPHPExcel->getSheet(0);
	$highestRow = $sheet->getHighestRow();
	$highestColumn = $sheet->getHighestColumn();
	$keys = array();
	$results = array();
	if (is_callable($row_callback)) {
		for ($row = 1; $row <= $highestRow; $row++) {
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
			if ($row === 1) {
				$keys = $rowData[0];
			} else {
				$record = array();
				foreach ($rowData[0] as $pos => $value) $record[$keys[$pos]] = $value;
				$row_callback($record);
			}
		}
	} else {
		for ($row = 1; $row <= $highestRow; $row++) {
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, false);
			if ($row === 1) {
				$keys = $rowData[0];
			} else {
				$record = array();
				foreach ($rowData[0] as $pos => $value) $record[$keys[$pos]] = $value;
				$results[] = $record;
			}
		}
		return $results;
	}
}

function remove_excel_white_space($excel_content)
{

	$excel_content_final = [];

	foreach ($excel_content as $rows) {
		//count the cell of each row that has value
		$cell_count = 0;

		foreach ($rows as $key => $val) { // loop each rows

			if ($val != '') { // if the cellvalue is empty
				$cell_count++;
			}
		}

		if ($cell_count > 0) { //if all the values of each row has 0 count of cell that has values it will not push to the final

			array_push($excel_content_final, $rows);
		}
	}
	//sending final

	//converting to 
	return $excel_content_final;
}

//print_r();

function p_r($array)
{
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}


//compute expiration
function compute_days_to_expire($expiry_date)
{
	$now = time(); // or your date as well
	$exp_date = strtotime($expiry_date);
	$datediff = $exp_date - $now;
	return round($datediff / (60 * 60 * 24));
}


// Library 
function get_providers($ots)
{
	$data = [
		'view' => 'service_providers_view'
	];
	$providers = $ots->execute('property-management', 'get-records', $data);
	$providers = json_decode($providers);
	return $providers;
}

function get_equipments($ots)
{
	$data = [
		'view' => 'view_equipments'
	];
	$equipments = $ots->execute('property-management', 'get-records', $data);
	$equipments = json_decode($equipments);
	return $equipments;
}

function get_personnel($ots)
{
	$data = [
		'view' => 'building_personnel_view'
	];
	$equipments = $ots->execute('property-management', 'get-records', $data);
	$equipments = json_decode($equipments);
	return $equipments;
}
function get_tenants($ots)
{
	$data = [
		'view' => 'view_tenant'
	];
	$equipments = $ots->execute('property-management', 'get-records', $data);
	$equipments = json_decode($equipments);
	return $equipments;
}

function vdump($val)
{
	echo "<pre>";
	var_dump($val);
	echo "</pre>";
}

function vdumpx($val)
{
	echo "<pre>";
	var_dump($val);
	echo "</pre>";
	exit;
}

function formatNumber($val, $digit = 0)
{
	return ($val == "" || $val == 0) ? "" : number_format($val, $digit, ".", ",");
}

function formatPrice($val,$default="-")
{
	return ($val == "" || $val == 0) ? $default : number_format($val, 2, ".", ",");
}

function formatDate($val)
{
	return date("m/d/Y", strtotime($val));
}

function formatDateSave($val)
{
	return date("Y-m-d", strtotime($val));
}

function formatDateTime($val)
{
	return date("m/d/Y h:i A", strtotime($val));
}

function formatDateUnix($val)
{
	return date("m/d/Y", ($val));
}

function formatDateTimeUnix($val)
{
	return date("m/d/Y h:i A", ($val));
}

function initObj($obj)
{
	return isset($_REQUEST[$obj]) ? str_replace("'", "`", $_REQUEST[$obj]) : "";
}

function debug($val)
{
	$val = str_replace("''", "null", $val);
	$val = str_replace("'null'", "null", $val);
	echo date("m/d/Y H:i:s") . " >  " . $val;
	exit;
}

function searchArray($needle, $haystack)
{
	foreach ($haystack as $key => $value) {
		$arr = explode('|', $value);
		if (strpos($arr[1], $needle) !== false) {
			return $arr[0];
		}
	}
	return '';
}

function inString($haystack, $needle)
{
	if (strpos($haystack, $needle) !== false)
		return true;
	else
		return false;
}

function genQRcode($link)
{
    include __DIR__ . '/phpqrcode/qrlib.php';
    $redirectUrl = $link;
    // Output image file path
    $outputFile = DIR_ROOT.'/public/images/qrcode.png';
    // Generate QR Code
    QRcode::png($redirectUrl, $outputFile, QR_ECLEVEL_H, 5, 4);
    // Display the QR Code image
    echo '<img src="' . $outputFile . '" alt="QR Code">';
    // Add a download link
    echo '<br><a class="main-btn px-5 " style="width: 400px;" href="' . $outputFile . '" download>Download QR Code</a>';
}

