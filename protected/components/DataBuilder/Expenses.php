<?php
namespace Components\DataBuilder;
use Components\DataBuilder\Base;
use Models\Import\Expenses as ExpensesModel;

class Expenses extends Base
{
	private $_expenses_data;
	
	protected function _fetchData()
	{
		$model = new ExpensesModel();
		
		$this->_expenses_data = $model->getAllByUserId(\Yii::app()->user->id, $this->_params['date_from'], $this->_params['date_to']);
		
		if (!$this->_expenses_data) return array();

		$result = array();
				
		foreach ($this->_expenses_data as $row)
		{
			$seconds = strtotime($row['date']);
			$year = date('Y', $seconds);
			$month = intval(date('m', $seconds));
			$category = trim($row['category_name']);
			
			if (!isset($result[$year][$month][$category]))
			{
				$result[$year][$month][$category] = 0;
			}
			
			$result[$year][$month][$category] += $row['amount'];
		}		
		
		return $result;
	}
	
	protected function _getNames()
	{
		$res = array();
		
		foreach ($this->_expenses_data as $item)
		{
			$category = trim($item['category_name']);
			
			if (!$category) continue ;
			if (in_array($category, $res)) continue ;
			
			$res[] = $category;
		}
		
		return $res;
	} 
}