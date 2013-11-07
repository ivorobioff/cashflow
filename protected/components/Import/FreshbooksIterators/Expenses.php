<?php
namespace Components\Import\FreshbooksIterators;

use Components\Import\FreshbooksIterators\Base;

class Expenses extends Base
{
	private $_date_from;
	
	public function __construct($date_from)
	{
		$this->_date_from = $date_from;	
	}
	
	protected function _onSuccess(array $response)
	{	
		return $this->_prepareResult($response, 'expenses', 'expense');
	}
	
	protected function _convertData(array $data)
	{
		return array(
			'user_id' => \Yii::app()->user->id,
			'foreign_category_id' => $data['category_id'],
			'foreign_id' => $data['expense_id'],
			'amount' => $data['amount'],
			'date' => $data['date'],
			'source_name' => 'freshbooks'
		);
	}
	
	protected function _modifyPostData(array $data)
	{
		$data['date_from'] = $this->_date_from;
		return $data;
	}
	
	protected function _getFuncName()
	{
		return 'expense.list';
	}
}