<?php
namespace Models\Import;

use Models\Base;
use Models\Import\LocalStorage;
use Components\InsertOnly;

class Expenses extends Base implements LocalStorage
{
	public function addBunch(array $data)
	{
		InsertOnly::into('expenses')->theseData($data)->ifDuplicate('id=id')->run();
	}

	public function getLastDate($user_id)
	{
		$res = $this->_createQuery()
			->from('expenses')
			->where('user_id=:user_id', array(':user_id' => $user_id))
			->order('date DESC')
			->queryRow(true);

		if (!$res) return '1900-01-01 00:00:00';

		return $res['date'];
	}

	public function getAllByUserId($id, $date_from, $date_to)
	{
		return $this->_createQuery()
			->from('expenses')
			->where('date >=:date_from', array(':date_from' => $date_from))
			->andWhere('date <=:date_to', array(':date_to' => $date_to))
			->andWhere('user_id=:user_id', array(':user_id' => $id))
			->queryAll(true);
	}

	public function getFirstDate($user_id)
	{
		$data = $this->_createQuery()
			->from('expenses')
			->where('user_id=:user_id', array(':user_id' => $user_id))
			->order('date ASC')
			->queryRow(true);

		if (!$data) return false;
		return $data['date'];
	}
}