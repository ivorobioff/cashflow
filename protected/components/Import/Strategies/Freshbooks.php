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
	
	public function getCategories()
	{	
		return new Categories();
	}
	
	public function getExpenses()
	{
		return new Expenses($this->_config['date_from']);
	}
	
	public function getInvoices()
	{		
		return new Invoices($this->_config['date_from']);
	}
}