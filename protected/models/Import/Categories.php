<?php
namespace Models\Import;

use Models\Base;
use Models\Import\LocalStorage;
use Components\InsertOnly;

class Categories extends Base implements LocalStorage
{
	public function addBunch(array $data)
	{
		InsertOnly::into('categories')
			->theseData($data)
			->ifDuplicate('id=id')
			->run();
	}
}