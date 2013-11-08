<?php
namespace Components\Import\FreshbooksIterators;

use Components\Freshbooks\Request;
use Components\Import\Exceptions\FreshbooksPullingError;

abstract class Base implements \Iterator
{
	const ITEMS_PER_PAGE = 100;
	
	private $_buffer_data = array();
	private $_counter = 0;
	private $_current_page = 1;
	
	private $_is_valid = true;
	
	public function current()
	{
		return $this->_convertData(current($this->_buffer_data));
	}
	
	public function valid()
	{
		return $this->_is_valid;
	}
	
	public function next()
	{
		if (next($this->_buffer_data) === false)
		{
			$this->_current_page ++;
			$this->_buffer_data = $this->_pull();
			
			if (!$this->_buffer_data)
			{
				$this->_is_valid = false;
			}
		}
		
		$this->_counter ++;
	}
	
	public function key()
	{
		return $this->_counter;
	}
	
	public function rewind()
	{
		$this->_counter = 0;
		$this->_current_page = 1;
		$this->_buffer_data = $this->_pull();
		
		if (!$this->_buffer_data)
		{
			$this->_is_valid = false;
		}
	}
	
	protected function _pull()
	{
		$request = new Request($this->_getFuncName());
		
		$data = array(
			'page' => $this->_current_page,
			'per_page' => self::ITEMS_PER_PAGE
		);
				
		$request->post($this->_modifyPostData($data));	
		$request->request();
		
		if ($request->success())
		{	
			return $this->_onSuccess($request->getResponse());
		}
		else
		{
			throw new FreshbooksPullingError($request->getError());
		}
	}
	
	protected function _modifyPostData(array $data)
	{
		return $data;
	}
	
	protected function _prepareResult($response, $top_level, $low_level)
	{
		if (empty($response[$top_level][$low_level])) return array();
		
		if (!isset($response[$top_level][$low_level][0]))
		{
			$response[$top_level][$low_level] = array($response[$top_level][$low_level]);
		}
		
		return $response[$top_level][$low_level];
	}
	
	abstract protected function _onSuccess(array $response);
	abstract protected function _convertData(array $data);
	abstract protected function _getFuncName();
}