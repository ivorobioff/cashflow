<?php
namespace Components\Validators\Import;

use Components\Validators\Base;

class Freshbooks extends Base
{
	protected function _getFieldsConfig()
	{
		return array(
			'key' => array(
				'settness' => 'Enter your Freshbooks API key',
			),
			'sub_domain' => array(
				'settness' => 'Enter your Freshbooks sub-domain',
			),
		);
	}
}