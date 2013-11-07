<?php
namespace Models\Import;

use Models\Base;
use Models\Import\LocalStorage;

class Expenses extends Base implements LocalStorage
{	
	public function addBunch(array $data)
	{
		$this->_insertAll('expenses', $data);
	}
}