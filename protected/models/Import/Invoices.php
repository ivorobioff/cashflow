<?php
namespace Models\Import;

use Models\Base;
use Models\Import\LocalStorage;
use Components\InsertOnly;

class Invoices extends Base implements LocalStorage
{	
	public function addBunch(array $data)
	{
		InsertOnly::into('invoices')
			->theseData($data)
			->ifDuplicate('id=id')
			->run();
	}
	
	public function getLastDate($user_id)
	{
		$res = $this->_createQuery()
			->from('invoices')
			->where('user_id=:user_id', array(':user_id' => $user_id))
			->order('date DESC')
			->queryRow(true);
	
		if (!$res) return '1900-01-01 00:00:00';
	
		return $res['date'];
	}
}