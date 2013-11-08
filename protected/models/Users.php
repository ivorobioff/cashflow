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
	
	public function getById($id)
	{
		return $this->_createQuery()
			->from('users')
			->where('id=:id', array(':id' => $id))
			->queryRow(true);
	}
	
	public function updateById($id, $data)
	{
		$this->_createQuery()->update('users', $data, 'id=:id', array(':id' => $id));
	}
	
	public function hasData($id)
	{
		$res = $this->_createQuery()
			->from('expenses')
			->where('user_id=:user_id', array(':user_id' => $id))
			->queryRow();
		
		if ($res) return true;
		
		$res = $this->_createQuery()
			->from('invoices')
			->where('user_id=:user_id', array(':user_id' => $id))
			->queryRow();
		
		if ($res) return true;
		
		return false;
	} 
}