<?php 
define('MAIN_URL','http://i2-sandbox.inventiproptech.com/registration/');
define('TITLE','Inventi');

/** Alias for web root */
$root= str_replace($_SERVER['DOCUMENT_ROOT'] ,'',str_replace(DIRECTORY_SEPARATOR,'/',str_replace('config','',dirname(__FILE__))));
$root = (substr($root,-1) == '/' ? substr($root,0,strlen($root)-1): $root);

$protocol = 'http';
if(isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'){
	$protocol = 'https';
}elseif(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'){
	$protocol = 'https';
}


//define('WEB_ROOT', $protocol . "://" . $_SERVER["HTTP_HOST"] . ($root ? '/' :'') . $root);
define('WEB_ROOT', $protocol . "://" . $_SERVER["HTTP_HOST"]);

define('DEBUG',false);

define('DIR_ROOT', realpath(dirname(__FILE__)  . '/..'));
define('DIR_LIBRARY',DIR_ROOT . '/library');
define('DIR_PUBLIC',DIR_ROOT . '/public');

define('API_URL','http://apii2-sandbox.inventiproptech.com');
define('API_ID','UdAgg7J2Htbp5WECsm42LnUnXxLG5NwM');
define('API_SECRET','8vYW4XyXEsTUsxg8LvKzWcyB54BSFDa2');

define('NO_AUTH',[
	'auth','account'
]);
