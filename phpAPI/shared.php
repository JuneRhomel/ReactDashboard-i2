<?php
function randomString($length=8)
{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$string = '';
		for ($i = 0; $i < $length; $i++)
		{
				$string .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $string;
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

function uniqueFilename($filename='')
{
	if($filename)
	{
		$str_ext = pathinfo($filename, PATHINFO_EXTENSION);
	}

	// explode the IP of the remote client into four parts
	$ip_array = explode('.', getClientAddress());

	// get both seconds and microseconds parts of the time
	list($usec, $sec) = explode(' ', microtime());

	// fudge the time we just got to create two 16 bit words
	$usec = (integer) ($usec * 65536);
	$sec = ((integer) $sec) & 0xFFFF;

	// fun bit--convert the remote client's IP into a 32 bit
	// hex number then tag on the time.
	// Result of this operation looks like this xxxxxxxx-xxxx-xxxx
	if(count($ip_array) < 4)
	{
		$ip_array = array('127','0','0','1');
	}
	$formatted_string = sprintf("%08x-%04x-%04x", ($ip_array[0] << 24) | ($ip_array[1] << 16) | ($ip_array[2] << 8) | $ip_array[3], $sec, $usec);

	// tack on the extension and return the filename
	return $formatted_string . '.' . $str_ext;
}

function getClientAddress()
{
	$ipaddress = 'UNKNOWN';
	if (isset($_SERVER['HTTP_CLIENT_IP']))
		$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	else if(isset($_SERVER['HTTP_FORWARDED']))
		$ipaddress = $_SERVER['HTTP_FORWARDED'];
	else if(isset($_SERVER['REMOTE_ADDR']))
		$ipaddress = $_SERVER['REMOTE_ADDR'];
	return $ipaddress;
}

function validateInput(){
	
}

function excel_to_array($inputFileName,$row_callback=null){
	
    if (!class_exists('PHPExcel')) return false;
    try {
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);
    } catch(Exception $e) {
        return ('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
    }
    $sheet = $objPHPExcel->getSheet(0); 
    $highestRow = $sheet->getHighestRow(); 
    $highestColumn = $sheet->getHighestColumn();
    $keys = array();
    $results = array();
    if(is_callable($row_callback)){
        for ($row = 1; $row <= $highestRow; $row++){ 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,null,true,false);
            if ($row === 1){
                $keys = $rowData[0];
            } else {
                $record = array();
                foreach($rowData[0] as $pos=>$value) $record[$keys[$pos]] = $value; 
                $row_callback($record);           
            }
        } 
    } else {            
        for ($row = 1; $row <= $highestRow; $row++){ 
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,null,true,false);
            if ($row === 1){
                $keys = $rowData[0];
            } else {
                $record = array();
                foreach($rowData[0] as $pos=>$value) $record[$keys[$pos]] = $value; 
                $results[] = $record;           
            }
        } 
        return $results;
    }
}

function remove_excel_white_space($excel_content){
	$excel_content_final = [];

	foreach($excel_content as $rows){
		//count the cell of each row that has value
		$cell_count = 0;

		foreach($rows as $key => $val){ // loop each rows

			if($val != ''){ // if the cellvalue is empty
				$cell_count++;
			}   
		}
		if($cell_count > 0){ //if all the values of each row has 0 count of cell that has values it will not push to the final
			array_push($excel_content_final, $rows);
		}
	}
	//sending final

	//converting to 
	return $excel_content_final;


}
function compute_days_to_expire($expiry_date){
    $now = time(); // or your date as well
    $exp_date = strtotime($expiry_date);
    $datediff = $exp_date - $now;	
    return round($datediff / (60 * 60 * 24));
}

function get_setting($db ,$account_db, $setting_name){
	try{
		$sql1 = "select *  from {$account_db}._settings WHERE setting_name = :setting_name";
		$record_sth1 = $db->prepare($sql1);
		$record_sth1->execute([
			'setting_name'=>$setting_name
		]);
		return $records1 = $record_sth1->fetch()['setting_value'];
	}
	catch(Exception $e){
		return $e->getMessage();
	}
	// return $setting_name;
}

function debug($val){
	$val = str_replace("''","null",$val);
	$val = str_replace("'null'","null",$val);
	echo date("m/d/Y H:i:s")." >  ".$val; exit;
}

function vdump($val) {
	echo "<pre>";  var_dump($val);  echo "</pre>";
}

function vdumpx($val) {
	echo "<pre>";  var_dump($val);  echo "</pre>"; exit;
}