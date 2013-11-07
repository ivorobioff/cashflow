<?php
use Components\Controller;
use Components\Validators\Auth as AuthValidator;
use Components\UserIdentity;

class AuthController extends Controller
{
	protected $_require_auth = false;
	
	public function actionIndex()
	{
		$this->renderPartial('//contents/auth');
	}
	
	public function actionLogin()
	{		
		if (!$this->isAjax())
		{
			throw new CHttpException(404,'The specified page cannot be found.');
		}
		
		$validator = new AuthValidator();
		
		if ($errors = $validator->setData($_POST)->validate()->getErrors())
		{
			foreach ($errors as $error)
			{
				return $this->ajaxError(array($error));
			}
		}
		
		$auth = new UserIdentity($_POST['username'], $_POST['password']);

		if (!$auth->authenticate()) return $this->ajaxError(array('Wrong username or password.'));
			
		Yii::app()->user->login($auth);
		
		return $this->ajaxSuccess();
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect($this->createUrl(\Yii::app()->user->loginUrl));
	}
}