<?php
namespace Components;
use Helpers\Basic as BasicHelper;
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends \CController
{
	public $layout='//layouts/main';
	
	protected $_require_auth = true;
	protected $_auth_exceptions = array();
	
	public function init()
	{
		parent::init();
		$this->attachBehavior('basic_helper', new BasicHelper());
	}
	
	/**
	 * Отправить ответ об успехе
	 * @param array $data
	 */
	protected function ajaxSuccess(array $data = array())
	{
		echo json_encode(array('status' => 'success', 'data' => $data));
	}
	
	/**
	 * Отправить ответ об ошибке
	 * @param array $data
	 */
	protected function ajaxError(array $data = array())
	{
		echo json_encode(array('status' => 'error', 'data' => $data));
	}
	
	protected function isAjax()
	{
		return \Yii::app()->request->isAjaxRequest;
	}
	
	public function beforeAction($action)
	{
		parent::beforeAction($action);
	
		if (!$this->_checkAuth())
		{
			return $this->redirect($this->createUrl($this->createUrl(\Yii::app()->user->loginUrl)));
		}
	
		return true;
	}
	
	protected function _checkAuth()
	{
		foreach ($this->_auth_exceptions as &$value)
		{
			$value = strtolower($value);
		}
	
		if ($this->_require_auth)
		{
			if (!in_array(strtolower($this->action->id), $this->_auth_exceptions) && !is_auth())
			{
				return false;
			}
		}
		else
		{
			if (in_array(strtolower($this->action->id), $this->_auth_exceptions) && !is_auth())
			{
				return false;
			}
		}
	
		return true;
	}
}