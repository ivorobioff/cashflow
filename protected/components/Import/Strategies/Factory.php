<?php
namespace Components\Import\Strategies;

use Components\Import\Strategies\Freshbooks;

class Factory
{
	/**
	 * @param string $alias
	 * @return \Components\Import\Strategies\Base
	 */
	static public function create($alias, array $params)
	{
		if ($alias == 'freshbooks') return new Freshbooks($params);
	}
}