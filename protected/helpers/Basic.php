<?php
namespace Helpers;

use Models\Params;
class Basic extends \CBehavior
{
	private $_cache_params;

	public function money($value)
	{
		return sprintf("%01.2f", $value);
	}

	public function convertDate($date)
	{
		$date_array = explode('/', $date);
		return $date_array[1].'-'.$date_array[0].'-01';
	}

	public function getParams()
	{
		if (is_null($this->_cache_params))
		{
			$params = new Params();
			$this->_cache_params = $params->getByUserId(\Yii::app()->user->id);
		}

		return $this->_cache_params;
	}
}