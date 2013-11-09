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
		
		return $res;
	}
}