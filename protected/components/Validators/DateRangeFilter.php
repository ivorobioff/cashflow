<?php
namespace Components\Validators;

use Components\Validators\Base;
use Helpers\Basic as BasicHelper;

class DateRangeFilter extends Base
{
	protected function _getFieldsConfig()
	{
		return array(
			'date_from' => array(
				'settness' => 'Please enter data from',
			),
			'date_to' => array(
				'settness' => 'Please enter date to',
				'dateRange' => 'The date from must be lower the date to'
			),
		);
	}

	protected function _checkDateRange($field, $error)
	{
		if ($this->_hasError('date_from')) return ;

		$helper = new BasicHelper();

		$date_from = strtotime($helper->convertDate($this->_data['date_from']).' 00:00:00');
		$date_to = strtotime($helper->convertDate($this->_data[$field]).' 23:59:59');

		if ($date_from >= $date_to)
		{
			$this->_addError($field, $error);
		}
	}
}