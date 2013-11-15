<?php
namespace Components\DataBuilder\Budget;

use Components\DataBuilder\Cashflow as CashflowBuilder;

class Cashflow extends CashflowBuilder
{
	public function build()
	{
		$result = parent::build();

		foreach ($result as $year => $names)
		{
			foreach ($names['Cash In'] as $month => $value)
			{
				$result[$year]['Cash In'][$month] = $value + $value * $this->_params['increase_revenues'] / 100;
			}
		}

		return $result;
	}

	public function buildChartData(array $data)
	{
		return $this->_buildData4Chart($data);
	}

	protected function _createExpensesBuilder()
	{
		return new Expenses($this->_params);
	}
}