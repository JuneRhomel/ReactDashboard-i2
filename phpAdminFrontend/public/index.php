<?php
/**
 * App gateway
 */

date_default_timezone_set('Asia/Manila');
include_once(__DIR__ . '/../config/config.php');

//get url
$url = isset($_GET['url']) ? 
			($_GET['url'] == 'default.asp' ? 'index' : $_GET['url']) //fixed for iis
			: (!defined('PAGE_INDEX') ? 'index' : PAGE_INDEX) ;
			
//sanitize url
//remove script tags
$url = preg_replace('/<script(.*?)>(.*?)<\/script>/is', '',$url);

//load bootstrap
include_once(DIR_LIBRARY . '/bootstrap.php');