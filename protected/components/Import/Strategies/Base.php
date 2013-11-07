<?php
namespace Components\Import\Strategies;

abstract class Base
{
	abstract public function getCategories();
	abstract public function getExpenses();
	abstract public function getInvoices();	
}