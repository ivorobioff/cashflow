<?php
namespace Helpers;

class Basic extends \CBehavior
{
	public function money($value)
	{
		return sprintf("%01.2f", $value);
	}	
}