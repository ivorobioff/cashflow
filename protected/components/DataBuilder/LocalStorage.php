<?php
namespace Components\DataBuilder;
use Components\DataBuilder\Base;
use Models\Import\Expenses as ExpensesModel;

abstract class LocalStorage extends Base
{
	private $_fetched_data;

	protected function _fetchData()
	{
		$model = new ExpensesModel();

		$this->_fetched_data = $this->_getLocalStorage()->getAllByUserId(\Yii::app()->user->id, $this->_params['date_from'], $this->_params['date_to']);

		if (!$this->_fetched_data) return array();

		$result = array();

		foreach ($this->_fetched_data as $row)
		{
			$seconds = strtotime($row['date']);
			$year = date('Y', $seconds);
			$month = intval(date('m', $seconds));
			$category = trim($row['name']);

			if (!isset($result[$year][$category][$month]))
			{
				$result[$year][$category][$month] = 0;
			}

			$result[$year][$category][$month] += $row['amount'];
		}

		return $result;
	}

	protected function _getNames()
	{
		$res = array();

		foreach ($this->_fetched_data as $item)
		{
			$category = trim($item['name']);

			if (!$category) continue ;
			if (in_array($category, $res)) continue ;

			$res[] = $category;
		}

		asort($res);

		return $res;
	}


	/**
	 * @return \Models\Import\LocalStorage
	 */
	abstract protected function _getLocalStorage();
}