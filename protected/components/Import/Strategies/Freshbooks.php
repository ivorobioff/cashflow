<?php
namespace Components\Import\Strategies;

use Components\Import\Strategies\Base;
use Components\Import\Strategies\FreshbooksIterator;
use Components\Freshbooks\Request;

class Freshbooks extends Base
{	
	public function __construct(array $params)
	{
		parent::__construct($params);
		Request::init($data['sub_domain'], $data['key']);
	}
	
	public function getCategories()
	{
		return new FreshbooksIterator(new Request('category.list'));
	}
	
	public function getExpenses()
	{
		return new FreshbooksIterator(new Request('category.list'));
	}
	
	public function getInvoices()
	{
		
	}
}