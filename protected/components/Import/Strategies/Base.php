<?php
namespace Components\Import\Strategies;

abstract class Base
{
	abstract public function getExpenses();
	abstract public function getInvoices();	
}