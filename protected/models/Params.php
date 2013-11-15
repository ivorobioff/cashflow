<?php
namespace Models;

use Models\Base;

class Params extends Base
{
	public function getByUserId($id)
	{
		return $this->_createQuery()
			->from('params')
			->where('user_id=:user_id', array(':user_id' => $id))
			->queryRow(true);
	}

	public function updateByUserId($id, array $params)
	{
		$this->_createQuery()
			->update('params', $params, 'user_id=:user_id', array(':user_id' => $id));
	}

	public function updateExpensesFixedByUserId($expenses_fixed, $user_id)
	{
		$this->_createQuery()
			->update('params', array('expenses_fixed' => $expenses_fixed), 'user_id=:user_id', array(':user_id' => $user_id));
	}

	public function updateBudgetUserId($budgets, $user_id)
	{
		$this->_createQuery()
			->update('params', array('budgets' => $budgets), 'user_id=:user_id', array(':user_id' => $user_id));
	}
}