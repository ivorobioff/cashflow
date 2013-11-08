<?php
namespace Components\Import\FreshbooksIterators;

use Components\Import\FreshbooksIterators\Base;
use Components\Freshbooks\Request;
use Components\Import\Exceptions\FreshbooksPullingError;

class Expenses extends Base
{
	private $_date_from;
	
	private $_cache_categories;
	
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
			'category_name' => setif($this->_cache_categories, $data['category_id'], ''),
			'foreign_id' => intval($data['expense_id']),
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
	
	protected function _pull()
	{
		if ($data = parent::_pull())
		{
			if (is_null($this->_cache_categories))
			{
				$categories = $this->_pullCategories();
				
				foreach ($categories as $category)
				{
					$this->_cache_categories[intval($category['category_id'])] = $category['name'];
				}
			}		
		}
		
		return $data;
	}
	
	private function _pullCategories()
	{
		$request = new Request('category.list');
		$request->post(array('per_page' => 1000));
		
		$request->request();
		
		if ($request->success())
		{
			return $this->_prepareResult($request->getResponse(), 'categories', 'category');
		}
		else
		{
			throw new FreshbooksPullingError($request->getError());
		}
	}
}