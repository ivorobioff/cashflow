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
	
	protected function _createSkeleton()
	{		
		$year_from = date('Y', strtotime($this->_params['date_from']));
		$year_to = date('Y', strtotime($this->_params['date_to']));
		
		$res = array();
		
		for ($year = $year_from; $year <= $year_to; $year ++)
		{
			for ($month = 1; $month <= 12; $month ++)
			{
				foreach ($this->_getNames() as $name)
				{
					$res[$year][$month][$name] = 0;
				}
			}
		}
		
		return $res;
	}
	
	protected function _prepareResult(array $data, array $skeleton)
	{
		$res = array();
		$past_values = array();
		$absolute_future_month = 0;

		foreach ($skeleton as $year => $months)
		{
			foreach ($months as $month => $names)
			{
				if ($this->_isFuture($year, $month))
				{
					$absolute_future_month ++;
				}
				
				foreach ($names as $name => $value)
				{
					if (!$this->_isFuture($year, $month))
					{
						$new_value = setif(setif(setif($data, $year, array()), $month, array()), $name, 0);
						$res[$year][$month][$name] = $new_value;
						$past_values[$name][] = $new_value;
						continue ;
					}
					
					$res[$year][$month][$name] = $this->_calcFutureValue($past_values[$name], $absolute_future_month);
				}
			}
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
				if ($past_values[$i - 1] == 0)
				{
					unset($past_values[$i - 1]);
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

			if (!$past_values) return 0;
			
			$this->_cache_growth = $formula->calcGrowth($past_values, $past_months_array, $future_months_array);
		}
		
		return setif($this->_cache_growth, $absolute_future_month - 1, 0);
	}
	
	private function _isFuture($year, $month)
	{
		$current_year = date('Y');
		$current_month = intval(date('m'));

		if ($year > $current_year) return true;
		if ($year = $current_year && $month >= $current_month) return true;
		
		return false;
	}
	
	abstract protected function _fetchData();
	abstract protected function _getNames();
}