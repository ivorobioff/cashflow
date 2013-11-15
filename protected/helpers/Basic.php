<?php
namespace Helpers;

use Models\Params;
use Models\Import\Expenses;
use Models\Import\Invoices;
class Basic extends \CBehavior
{
	private $_cache_params;
	private $_cache_from_bound;

	public function money($value)
	{
		return sprintf("%01.2f", $value);
	}

	public function convertDate($date)
	{
		$date_array = explode('/', $date);
		return $date_array[1].'-'.$date_array[0].'-01';
	}

	public function getParams()
	{
		if (is_null($this->_cache_params))
		{
			$params = new Params();
			$res = $params->getByUserId(\Yii::app()->user->id);

			if (!$res['date_from']) $res['date_from'] = $this->_getDefaultDateFrom();
			if (!$res['date_to']) $res['date_to'] = date('Y-12-31 23:59:59');

			$res['expenses_fixed'] = json_decode(setif($res, 'expenses_fixed', '[]'), true);
			$res['budgets'] = json_decode(setif($res, 'budgets', '[]'), true);

			$this->_cache_params = $res;
		}

		return $this->_cache_params;
	}

	private function _getDefaultDateFrom()
	{
		$bound_from = $this->getBoundFrom();
		$first_day = date('Y-01-01 00:00:00');

		if (strtotime($bound_from) > strtotime($first_day)) return $bound_from;
		return $first_day;
	}

	public function isFuture($year, $month)
	{
		$current_year = date('Y');
		$current_month = intval(date('m'));

		if ($year > $current_year) return true;
		if ($year == $current_year && $month >= $current_month) return true;

		return false;
	}

	private function _fetchBoundFrom()
	{
		$model = new Expenses();
		$exp_date = $model->getFirstDate(\Yii::app()->user->id);

		$model = new Invoices();
		$inv_date = $model->getFirstDate(\Yii::app()->user->id);

		if (!$exp_date) return date('Y-m-d H:i:s', strtotime($inv_date));
		if (!$inv_date) return date('Y-m-d H:i:s', strtotime($exp_date));

		if (strtotime($inv_date) < strtotime($exp_date)) return date('Y-m-d H:i:s', strtotime($inv_date));
		return date('Y-m-d H:i:s', strtotime($exp_date));
	}

	public function getBoundFrom()
	{
		if (is_null($this->_cache_from_bound))
		{
			$this->_cache_from_bound = $this->_fetchBoundFrom();
		}

		return $this->_cache_from_bound;
	}

	public function getBoundTo()
	{
		return date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').' +2 year'));
	}

	public function isAllowedShowCharts()
	{
		$params = $this->getParams();
		if (empty($params['reduction_expenses'])) return false;
		if (empty($params['increase_revenues'])) return false;
		if (empty($params['average_time'])) return false;
		if (empty($params['starting_cashin'])) return false;

		return true;
	}
}