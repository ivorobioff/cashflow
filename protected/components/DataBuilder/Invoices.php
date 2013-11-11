<?php
namespace Components\DataBuilder;
use Components\DataBuilder\LocalStorage;
use Models\Import\Invoices as InvoicesModel;

class Invoices extends LocalStorage
{	
	protected function _getLocalStorage()
	{
		return new InvoicesModel();
	}
}