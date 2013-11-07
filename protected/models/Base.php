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
	
	protected function _insertAll($table, array $data)
	{
		\Yii::app()
			->db
			->schema
			->commandBuilder
			->createMultipleInsertCommand($table, $data)
			->execute();
	}
}