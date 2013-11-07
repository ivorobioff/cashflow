<?php
namespace Models;

use Models\Base;

class Users extends Base
{
	public function getByCredentials($username, $password)
	{
		return $this->_createQuery()
			->from('users')
			->where('username=:username', array(':username' => $username))
			->andWhere('password=:password', array(':password' => md5($password)))
			->queryRow(true);
	}
}