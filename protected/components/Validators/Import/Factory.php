<?php
namespace Components\Validators\Import;

use Components\Validators\Import\Freshbooks;

class Factory
{
	/**
	 * @param string $alias
	 * @param array $params
	 * @return \Components\Validators\Base
	 */
	static public function create($alias)
	{
		if ($alias == 'freshbooks') return new Freshbooks();
	}
}