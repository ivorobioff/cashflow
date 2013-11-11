<?php
namespace Components\DataBuilder;

use Components\PeriodIterator;
use Components\DataBuilder\Expenses;
use Components\DataBuilder\Invoices;

class Cashflow extends Base
{
	protected function _fetchData()
	{
		$config = array(
			'average_time' => array(
				'builder' => new Expenses($this->_params),
				'name' => 'Expenses',
			),
			'starting_cashin' => array(
				'builder' => new Invoices($this->_params),
				'name' => 'Cash In'
			),
		);

		$result = $this->_buildResultByLookups($config);
		return $result;
	}

	private function _buildResultByLookups($config)
	{
		$result = array();
		$map = $this->_buildParamsMap();

		foreach ($config as $param_name => $item)
		{
			$lookups = $this->_calcLookupParam($param_name);

			$summary = $item['builder']->buildSummary($item['builder']->build());

			foreach ($lookups as $abs_month => $lookup_month)
			{
				$real_month = $map[$abs_month]['month'];
				$real_year = $map[$abs_month]['year'];

				if ($lookup_month == 0)
				{
					$result[$real_year][$item['name']][$real_month] = 0;
					continue ;
				}

				$month = $map[$lookup_month]['month'];
				$year = $map[$lookup_month]['year'];

				$result[$real_year][$item['name']][$real_month] = setif(setif(setif($summary, $year, array()), 'months', array()), $month, 0);
			}
		}

		return $result;
	}

	private function _buildParamsMap()
	{
		$period_iterator = new PeriodIterator($this->_params['date_from'], $this->_params['date_to']);

		foreach ($period_iterator as $absolute_months => $month)
		{
			$result[$absolute_months] = array('year' => $period_iterator->getYear(), 'month' => $month);
		}

		return $result;
	}

	protected function _getNames()
	{
		return array('$ at Bank', 'Cash In', 'Expenses');
	}

	private function _calcLookupParam($name)
	{
		$days_sofar = $this->_buildTotalDays();

		$result = array();

		$prev_param = 0;

		foreach ($days_sofar as $absolute_month => $days)
		{
			if ($prev_param != 0 || $days >= $this->_params[$name])
			{
				$param = $prev_param + 1;
			}
			else
			{
				$param = 0;
			}

			$prev_param = $param;
			$result[$absolute_month] = $param;
		}

		return $result;
	}

	private function _buildTotalDays()
	{
		$result = array();
		$total_days = 0;

		$period_iterator = new PeriodIterator($this->_params['date_from'], $this->_params['date_to']);

		foreach ($period_iterator as $absolute_months => $month)
		{
			$total_days += $period_iterator->getTotalDays();
			$result[$absolute_months] = $total_days;
		}

		return $result;
	}
}