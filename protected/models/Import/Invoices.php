<?php
namespace Models\Import;

use Models\Base;
use Models\Import\LocalStorage;
use Components\InsertOnly;

class Invoices extends Base implements LocalStorage
{	
	public function addBunch(array $data)
	{
		InsertOnly::into('invoices')
			->theseData($data)
			->ifDuplicate('id=id')
			->run();
	}
}