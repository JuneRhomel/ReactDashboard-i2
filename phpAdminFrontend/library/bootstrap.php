<?php
/**
 * File: libray/bootstrap.php
 * 
 */

/**
 * Bootstrap
 * @param string $url Page request url
 */
function bootstrap($url)
{
	$url_array = explode('/',$url);
	
	if(count($url_array) == 1) //no action was specified
	{
		$url_array[1] = 'index'; //set default action as index
	}
	
	if($url_array[1] == '') //empty action was specified
	{
		$url_array[1] = 'index'; //set default action as index
	}
	
	$class = $url_array[0]; //get controller
	array_shift($url_array);
	$action = $url_array[0];
	array_shift($url_array);
	$args = $url_array;
	

	if($class == 'undefined') $class =  (!defined(PAGE_INDEX) ? 'index' : PAGE_INDEX) ;

	//workaround for class index and action index
	//function index is default however will cause an already defined method
	if($class == 'index')
	{
		$class = 'main';
	}
	
	//load controller
	try{
		$dispatch = new Controller($class,$action,$args);
	}catch(Exception $e){
		if(DEBUG)
		{
			debug_print_backtrace();
		}
		error_log($e);
	}
}



include(DIR_LIBRARY . '/shared.php');
include(DIR_LIBRARY . '/PHPExcel.php');

//call bootstrap
bootstrap($url);

/* End of file bootstrap.php */
/* Location: library/bootstrap.php */