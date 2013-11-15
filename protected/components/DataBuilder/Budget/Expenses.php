<?php
namespace Components\DataBuilder\Budget;

use Components\DataBuilder\Base;
use Components\DataBuilder\Expenses as ExpensesBuilder;

class Expenses extends Base
{
	public function build()
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
					if (!empty($this->_params['expenses_fixed'][$name]))
					{
						$result[$year][$name][$month] = $value;
					}
					else
					{
						$result[$year][$name][$month] = $value - $value * $this->_params['reduction_expenses'] / 100;
					}
				}
			}
		}

		return $result;
	}
}