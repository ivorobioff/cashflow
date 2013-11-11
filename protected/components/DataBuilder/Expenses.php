<?php
namespace Components\DataBuilder;
use Components\DataBuilder\LocalStorage;
use Models\Import\Expenses as ExpensesModel;

class Expenses extends LocalStorage
{	
	protected function _getLocalStorage()
	{
		return new ExpensesModel();
	}
}