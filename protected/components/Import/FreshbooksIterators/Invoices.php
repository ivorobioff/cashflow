<?php
namespace Components\Import\FreshbooksIterators;

use Components\Import\FreshbooksIterators\Base;

class Invoices extends Base
{
	private $_date_from;
	
	public function __construct($date_from)
	{
		$this->_date_from = $date_from;
	}
	
	protected function _onSuccess(array $response)
	{
		$invoices = $this->_prepareResult($response, 'invoices', 'invoice');
		
		$result_lines['lines']['line'] = array();
		
		foreach ($invoices as $invoice)
		{
			$lines = $this->_prepareResult($invoice, 'lines', 'line');
			
			foreach ($lines as $line)
			{
				if (!$line['name']) continue;
				$line['date'] = $invoice['date'];
				$result_lines['lines']['line'][] = $line;
			}
		}

		return $this->_prepareResult($result_lines, 'lines', 'line');
	}
	
	protected function _convertData(array $data)
	{
		return array(
			'user_id' => \Yii::app()->user->id,
			'name' => $data['name'],
			'foreign_id' => intval($data['line_id']),
			'source_name' => 'freshbooks',
			'amount' => $data['amount'],
			'date' => $data['date']
		);
	}
	
	protected function _modifyPostData(array $data)
	{
		$data['date_from'] = $this->_date_from;
		return $data;
	}
	
	protected function _getFuncName()
	{
		return 'invoice.list';
	}
}