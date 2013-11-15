<?php
namespace Models;

use Models\Base;

class Params extends Base
{
	public function getByUserId($id)
	{
		$res = $this->_createQuery()
			->from('params')
			->where('user_id=:user_id', array(':user_id' => $id))
			->queryRow(true);

		if (!$res['date_from']) $res['date_from'] = date('Y-01-01');
		if (!$res['date_to']) $res['date_to'] = date('Y-12-31');

		$res['expenses_fixed'] = json_decode(setif($res, 'expenses_fixed', '[]'), true);
		$res['budgets'] = json_decode(setif($res, 'budgets', '[]'), true);

		return $res;
	}

	public function updateByUserId($id, array $params)
	{
		$this->_createQuery()
			->update('params', $params, 'user_id=:user_id', array(':user_id' => $id));
	}

	public function updateExpensesFixedByUserId($key, $value, $user_id)
	{
		$data = $this->getByUserId($user_id);

		$expenses_fixed = $data['expenses_fixed'];
		$expenses_fixed[$key] = $value;
		$expenses_fixed = json_encode($expenses_fixed);

		$this->_createQuery()
			->update('params', array('expenses_fixed' => $expenses_fixed), 'user_id=:user_id', array(':user_id' => $user_id));
	}

	public function updateBudgetUserId($date, $amount, $user_id)
	{
		$data = $this->getByUserId($user_id);

		$budgets = $data['budgets'];
		$budgets[$date] = $amount;
		$budgets = json_encode($budgets);

		$this->_createQuery()
		->update('params', array('budgets' => $budgets), 'user_id=:user_id', array(':user_id' => $user_id));
	}
}