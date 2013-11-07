<?php
namespace Components\Import\Strategies;

abstract class Base
{
	protected $_params = array();
	
	public function __construct(array $params)
	{
		$this->_params = $params;
	}
	
	abstract public function process(array  $data);
	abstract public function getCategories();
	abstract public function getExpenses();
	abstract public function getInvoices();	
}