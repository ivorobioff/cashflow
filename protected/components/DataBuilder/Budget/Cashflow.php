<?php
namespace Components\DataBuilder\Budget;

use Components\DataBuilder\Cashflow as CashflowBuilder;

class Cashflow extends CashflowBuilder
{
	protected function _fetchData()
	{
		$result = parent::_fetchData();

		foreach ($result as $year => $names)
		{
			foreach ($names['Cash In'] as $month => $value)
			{
				$result[$year]['Cash In'][$month] = $value + $value * $this->_params['increase_revenues'] / 100;
			}
		}

		return $result;
	}

	protected function _createExpensesBuilder()
	{
		return new Expenses($this->_params);
	}
}