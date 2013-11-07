<?php
namespace Components;
use Models\Users;
/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends \CUserIdentity
{
	private $_data = array();
	
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$users = new Users();
		
		if (!$this->_data = $users->getByCredentials($this->username, $this->password)) return false;
				
		return true;
	}
	
	public function getId()
	{
		return $this->_data['id'];
	}
}