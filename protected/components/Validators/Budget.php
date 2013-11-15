<?php
namespace Components\Validators;

use Components\Validators\Base;

class Budget extends Base
{
	protected function _getFieldsConfig()
	{
		return array(
			'date' => array(
				'settness' => 'Date is missing'
			),
			'amount' => array(
				'settness' => 'The amount is not set',
				'number' => 'The amount must be a number'
			),
		);
	}
}