<?php
namespace Components\Validators;

use Components\Validators\Base;

class Params extends Base
{
	protected function _getFieldsConfig()
	{
		return array(
			'key' => array(
				'settness' => 'Key is not set',
				'inList' => array(
					'error' => 'Wrong param',
					'list' => array(
						'starting_cashin',
						'average_time',
						'increase_revenues',
						'reduction_expenses',
						'decrease_revenues',
						'decrease_expenses'
					)
				),
			),
			'value' => array(
				'settness' => 'Value is not set',
				'number' => 'Value must be a number'
			),
		);
	}
}