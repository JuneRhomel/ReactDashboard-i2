<?php
/**
 * File: library/controller.class.php
 */


/**
 * System Controller Class
 * 
 * @author	Arnel Benitez
 */
class Controller 
{
	/** @var string $_classname*/
	protected $_classname;
	
	/** @var string $_action*/
	protected $_action;
	
	/** @var array $_args*/
	protected $_args;
	
	/** @var object $session*/
	protected $_session;

	/** @var array $_variables*/
	protected $_variables;

	/** @var string $_account_code */
	protected $_account_code;

	/** @var object $_ots */
	protected $_ots;

	/**
	 * Class constructor
	 *
	 * @param string $classname Class object
	 * @param string $action Method to execute
	 * @param array $args Arguments passed
	 */
	public function __construct($classname=null,$action=null,$args=[])
	{
		$this->_classname = strtolower($classname);
		$this->_action  = strtolower($action);
		$this->_args = $args;
		$this->_variables = [];

		$this->_account_code  = (explode(".",$_SERVER["HTTP_HOST"]))[0]; 

		try{
			$this->_session = new Session($this->_account_code);
			$this->_ots = new OTS($this->_session);
			if(!$this->_session->getAccount() || !$this->_session->getToken())
			{
				$account = $this->_ots->execute('auth','accountdetails',['accountcode'=>$this->_account_code]);
				
				$account_details = json_decode($account,true);
				if(($account_details['success'] ?? 0) == 1)
					$this->_session->setAccount($account_details['data']);
			}

			//echo $this->_account_code;

			if(!$this->_session->getAccount() && $this->_account_code <> 'i2-sandbox')
			{
				$this->_classname = 'error';
				$this->_action = 'page404';
			}
			elseif(!$this->_session->getToken() && !in_array($this->_classname,NO_AUTH)) 
			{
				$this->_classname = 'auth';
				$this->_action = 'login';
			}elseif(!file_exists(DIR_PUBLIC . "/widgets/{$this->_classname}/{$this->_action}.php")){
				$this->_classname = 'error';
				$this->_action = 'page404';
			}

			if($this->_session->getToken() && $this->_classname == 'auth' && $this->_action == 'login')
			{
				header("location: " . WEB_ROOT);
				exit();
			}


		}catch(Exception $e){
			echo $e->getMessage();
		}
	}

	public function __destruct()
	{
		extract($this->_variables);

		$session = $this->_session;
		$widgetname = $this->_classname;
		$accountcode = $this->_account_code;
		$ots = $this->_ots;
		$accountdetails = $this->_session->getAccount();

		$args = $this->_args;

		$menuid = $_GET['menuid'] ?? $_SESSION['menuid'] ?? 'dashboard';
		$submenuid =  $_GET['submenuid'] ?? $_SESSION['submenuid'] ?? 'dashboard';

		$_SESSION['menuid'] = $menuid;
		$_SESSION['submenuid'] = $submenuid;

		//page header
		$output = ($_GET['display'] ?? 'html');
		switch($output)
		{
			case "csv":
				header('Content-Type: text/csv');
				break;
			case "plain":
				header('Content-Type: text/plain');
				break;
			case 'json':
				header('Content-Type: application/json; charset=utf-8');
				break;
			default:
				$header = DIR_PUBLIC . '/themes/default/header.php';
				if(file_exists(DIR_PUBLIC . "/widgets/{$this->_classname}/header.php"))
					$header = DIR_PUBLIC . "/widgets/{$this->_classname}/header.php";
				include_once($header);
		}
			

		if(file_exists(DIR_PUBLIC . "/widgets/{$this->_classname}/{$this->_action}.php"))
			include_once(DIR_PUBLIC . "/widgets/{$this->_classname}/{$this->_action}.php");
		
		if($output == 'html')
		{
			//page footer
			$footer = DIR_PUBLIC . '/themes/default/footer.php';
			if(file_exists(DIR_PUBLIC . "/widgets/{$this->_classname}/footer.php"))
				$footer = DIR_PUBLIC . "/widgets/{$this->_classname}/footer.php";
			include_once($footer);
		}
	}
}