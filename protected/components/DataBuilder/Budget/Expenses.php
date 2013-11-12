<?php
namespace Components\DataBuilder\Budget;

use Components\DataBuilder\Base;
use Components\DataBuilder\Expenses as ExpensesBuilder;

class Expenses extends Base
{
	private $_expenses_names = array();

	protected function _fetchData()
	{
		$builder = new ExpensesBuilder($this->_params);
		$data = $builder->build();

		$result = array();

		foreach ($data as $year => $names)
		{
			foreach ($names as $name => $months)
			{
				foreach ($months as $month => $value)
				{
					$this->_expenses_names[$name] = 1;
					$result[$year][$name][$month] = $value - $value * $this->_params['reduction_expenses'] / 100;
				}
			}
		}

		return $result;
	}

	protected function _getNames()
	{
		$names = array_keys($this->_expenses_names);

		asort($names);

		return $names;
	}
}