<?php
namespace Models;

abstract class Base
{		
	/**
	 * @return \CDbCommand
	 */
	protected function _createQuery()
	{
		return \Yii::app()->db->createCommand();
	}
}