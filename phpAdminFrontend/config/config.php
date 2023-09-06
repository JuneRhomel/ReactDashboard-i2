<?php
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
define('WEB_ROOT_PROTOCOL', $protocol . "://");
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


$ots2 = 'xnd_development_wWdcYivwuptrQhQg6XG7AKzAsjU8bmEWFk2HwOyZw5ttyZZQwpoBIAbz4lYJIQcX';

define('XENDIT_API_SECRET','eG5kX2RldmVsb3BtZW50X3dXZGNZaXZ3dXB0clFoUWc2WEc3QUt6QXNqVThibUVXRmsySHdPeVp3NXR0eVpaUXdwb0JJQWJ6NGxZSklRY1g6');
