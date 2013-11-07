<?php
namespace Components\Validators;

use Components\Validators\Base;

class Auth extends Base
{
	protected function _getFieldsConfig()
	{
		return array(
			'username' => array(
				'settness' => 'Enter your username',
				'length' => array(
					'error' => 'Username must be at least 2 and at most 20 letters long',
					'min' => 2,
					'max' => 20,
				),
			),
			'password' => array(
				'settness' => 'Enter your password',
				'length' => array(
					'error' => 'Password must be at least 2 and at most 20 letters long',
					'min' => 2,
					'max' => 20,
				),
			)
		);
	}
}