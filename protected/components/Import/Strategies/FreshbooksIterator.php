<?php
namespace Components\Import\Strategies;

use Components\Freshbooks\Request;

class FreshbooksIterator implements \Iterator
{
	const ITEMS_PER_PAGE = 100;
	
	private $_request;
	
	public function __construct(Request $request)
	{
		$this->_request = $request;
	}

	public function current()
	{
		
	}
	
	public function valid()
	{
		
	}
	
	public function next()
	{
		
	}
	
	public function key()
	{
		
	}
	
	public function rewind()
	{
		
	}
}