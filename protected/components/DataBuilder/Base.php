<?php
namespace Components\DataBuilder;

use Components\ExcelFormulas;
abstract class Base
{
	protected $_params;

	private $_cache_growth;

	public function __construct(array $params)
	{
		$this->_params = $params;
	}

	public function build()
	{
		$data = $this->_fetchData();
		$skeleton = $this->_createSkeleton();
		return $this->_prepareResult($data, $skeleton);
	}

	public function buildSummary(array $data)
	{
		$res = array();

		foreach ($data as $year => $names)
		{
			foreach ($names as $name => $months)
			{
				foreach ($months as $month => $value)
				{
					if (!isset($res[$year]['months'][$month]))
					{
						$res[$year]['months'][$month] = 0;
					}

					$res[$year]['months'][$month] += $value;

					if (!isset($res[$year]['names'][$name]))
					{
						$res[$year]['names'][$name] = 0;
					}

					$res[$year]['names'][$name] += $value;
				}
			}
		}

		foreach ($res as $year => $items)
		{
			$res[$year]['total'] = array_sum($items['months']);
		}

		return $res;
	}

	protected function _createSkeleton()
	{
		$year_from = date('Y', strtotime($this->_params['date_from']));
		$year_to = date('Y', strtotime($this->_params['date_to']));

		$month_from = intval(date('m', strtotime($this->_params['date_from'])));
		$month_to = intval(date('m', strtotime($this->_params['date_to'])));

		$res = array();
		$month_count_from = $month_from;
		$month_count_to = 12;

		for ($year = $year_from; $year <= $year_to; $year ++)
		{
			if ($year == $year_to)
			{
				$month_count_to = $month_to;
			}

			foreach ($this->_getNames() as $name)
			{
				for ($month = $month_count_from; $month <= $month_count_to; $month ++)
				{
					$res[$year][$name][$month] = 0;
				}
			}

			$month_count_from = 1;
		}

		return $res;
	}

	protected function _prepareResult(array $data, array $skeleton)
	{
		$res = array();
		$past_values = array();

		$absolute_future_month = 0;
		$absolute_past_month = 0;

		foreach ($skeleton as $year => $names)
		{
			foreach ($names as $name => $months)
			{
				$afm = 0;
				$apm = 0;

				foreach ($months as $month => $value)
				{
					if (!$this->_isFuture($year, $month))
					{
						$apm ++;
						$new_value = setif(setif(setif($data, $year, array()), $name, array()), $month, 0);
						$res[$year][$name][$month] = $new_value;
						$past_values[$name][$absolute_past_month + $apm] = $new_value;
						continue ;
					}

					$afm ++;

					$res[$year][$name][$month] = $this->_calcFutureValue($past_values[$name], $absolute_future_month + $afm);
				}
			}

			$absolute_past_month += $apm;
			$absolute_future_month += $afm;
		}

		return $res;
	}

	private function _calcFutureValue(array $past_values, $absolute_future_month)
	{
		if (is_null($this->_cache_growth))
		{
			$year_from = date('Y', strtotime($this->_params['date_from']));
			$month_from = intval(date('m', strtotime($this->_params['date_from'])));

			$year_to = date('Y', strtotime($this->_params['date_to']));
			$month_to = intval(date('m', strtotime($this->_params['date_to'])));

			$current_year = date('Y');
			$current_month = intval(date('m'));

			$total_past_months = (($current_year - $year_from + 1) * 12) - ($month_from - 1) - (12 - $current_month + 1);
			$total_future_months = (($year_to - $current_year + 1) * 12) - ($current_month - 1) - (12 - $month_to);

			$past_months_array = array();

			for ($i = 1; $i <= $total_past_months; $i ++)
			{
				if ($past_values[$i] == 0)
				{
					unset($past_values[$i]);
					continue ;
				}

				$past_months_array[] = $i;
			}

			$future_months_array = array();

			for ($i = $total_past_months + 1; $i <= $total_past_months + $total_future_months; $i ++)
			{
				$future_months_array[] = $i;
			}

			$formula = new ExcelFormulas();

			if (count($past_values) < 2) return 0;

			$past_values = array_merge(array(), $past_values);

			$this->_cache_growth = $formula->calcGrowth($past_values, $past_months_array, $future_months_array);
		}

		return setif($this->_cache_growth, $absolute_future_month - 1, 0);
	}

	private function _isFuture($year, $month)
	{
		$current_year = date('Y');
		$current_month = intval(date('m'));

		if ($year > $current_year) return true;
		if ($year == $current_year && $month >= $current_month) return true;

		return false;
	}

	abstract protected function _fetchData();
	abstract protected function _getNames();
}