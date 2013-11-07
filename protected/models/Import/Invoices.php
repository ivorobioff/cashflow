<?php
namespace Models\Import;

use Models\Base;
use Models\Import\LocalStorage;

class Invoices extends Base implements LocalStorage
{	
	public function addBunch(array $data)
	{
		$this->_insertAll('invoices', $data);	
	}
}