<?php
namespace Models\Import;

use Models\Base;
use Models\Import\LocalStorage;
use Components\InsertOnly;

class Expenses extends Base implements LocalStorage
{	
	public function addBunch(array $data)
	{
		InsertOnly::into('expenses')
			->theseData($data)
			->ifDuplicate('id=id')
			->run();
	}
}