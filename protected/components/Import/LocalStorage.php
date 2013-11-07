<?php
namespace Components\Import;

use Components\Import\Strategies\Base as BaseStrategy;
use Models\Import\Categories;
use Models\Import\Expenses;
use Models\Import\Invoices;
use Models\Import\LocalStorage;

class LocalStorage
{
	const BUNCH_LIMIT = 1000;
	
	public function save(BaseStrategy $strategy)
	{
		$this->_saveCategories($strategy->getCategories());
		$this->_saveExpenses($strategy->getExpenses());
		$this->_saveInvoices($strategy->getInvoices());
	}
	
	private function _saveCategories($data)
	{
		$this->_saveModel(new Categories(), $data);
	}
	
	private function _saveExpenses($data)
	{
		$this->_saveModel(new Expenses(), $data);
	}
	
	private function _saveInvoices($data)
	{
		$this->_saveModel(new Invoices(), $data);
	}
	
	private function _saveModel(LocalStorage $model, $data)
	{
		$save_data = array();
		$c = 0;
		
		foreach ($data as $row)
		{
			$save_data[] = $row;
			$c++;
			
			if ($c == self::BUNCH_LIMIT)
			{
				$model->addBunch($save_data);
				$save_data = array();
				$c = 0;
			}	
		}
		
		if ($save_data)
		{
			$model->addBunch($save_data);
		}
	}
}