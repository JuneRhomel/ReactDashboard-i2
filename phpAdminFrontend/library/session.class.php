<?php
/**
 * File: library/session.class.php
 */



/**
 * System Session Class
 * 
 * @author Arnel Benitez <arnel@inventi.ph>
 */
class Session {
	/** @var string $token*/
	private $_token;

	/** @var object $account */
	private $_account;

	/** @var string $fullname */
	private $_fullname;

	/** @var array $roles */
	private $_roles;

	/** @var string $_accountcode */
	private $_accountcode;

	public function __construct($_accountcode)
	{
		if (session_status() == PHP_SESSION_NONE)
		{
			session_start();
		}
		$this->_account = $_SESSION['account'] ?? false;
		$this->_token = $_SESSION['token'] ?? null;
		$this->_roles = $_SESSION['roles'] ?? null;
		$this->_fullname = $_SESSION['fullname'] ?? null;
		
		$this->_accountcode = $_SESSION['accountcode'] ?? $_accountcode;
	}

	/**
	 * Set user data (token, fullname, roles)
	 *
	 * @param array $data
	 * @return void
	 */
	public function setUserData(array $data)
	{
		$_SESSION['token'] = $this->_token = $data['token'];
		$_SESSION['roles'] = $this->_roles = $data['roles'];
		$_SESSION['fullname'] = $this->_fullname = $data['fullname'];
	}

	/**
	 * Get session token
	 * @return string
	 */
	public function getToken()
	{
		return $this->_token;
	}

	/**
	 * Get logged user name
	 *
	 * @return string
	 */
	public function getUserName()
	{
		return $this->_fullname ?? 'Anonymous';
	}

	/**
	 * Get logged in user role
	 * 
	 * @return array
	 */
	public function getUserRoles()
	{
		return $this->_roles ?? [];
	}

	/** Set Account Details */
	public function setAccount($account)
	{
		$_SESSION['account'] = $this->_account = $account;
	}

	/** Get Account */
	public function getAccount()
	{
		return $this->_account;
	}

	/** Get Account Code*/
	public function getAccountCode()
	{
		return $this->_accountcode;
	}

	/** Logout user */
	public function logout()
	{
		session_destroy();
	}
}