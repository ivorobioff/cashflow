<?php
namespace Components\Import\Strategies;

use Components\Import\Strategies\Base;
use Components\Import\FreshbooksIterators\Categories;
use Components\Import\FreshbooksIterators\Expenses;
use Components\Import\FreshbooksIterators\Invoices;
use Components\Freshbooks\Request;

class Freshbooks extends Base
{	
	private $_config = array();
	
	public function __construct(array $config)
	{
		$this->_config = $config;
		Request::init($this->_config['domain'], $this->_config['token']);
	}
	
	public function getExpenses()
	{
		if (isset($this->_config['expenses_date_from']))
		{
			$date_from = $this->_config['expenses_date_from'];
		}
		else
		{
			$date_from = $this->_config['date_from'];	
		}
		
		return new Expenses($date_from);
	}
	
	public function getInvoices()
	{		
		if (isset($this->_config['invoices_date_from']))
		{
			$date_from = $this->_config['invoices_date_from'];
		}
		else
		{
			$date_from = $this->_config['date_from'];
		}
		
		return new Invoices($date_from);
	}
}