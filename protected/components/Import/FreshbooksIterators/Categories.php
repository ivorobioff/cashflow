<?php
namespace Components\Import\FreshbooksIterators;

use Components\Import\FreshbooksIterators\Base;

class Categories extends Base
{
	protected function _onSuccess(array $response)
	{
		return $this->_prepareResult($response, 'categories', 'category');
	}
	
	protected function _convertData(array $data)
	{
		return array(
			'user_id' => \Yii::app()->user->id,
			'name' => $data['name'],
			'foreign_id' => $data['category_id'],
			'source_name' => 'freshbooks'
		);
	}
	
	protected function _getFuncName()
	{
		return 'category.list';
	}
}