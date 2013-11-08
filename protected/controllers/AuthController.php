<?php
use Components\Controller;
use Components\Validators\Auth as AuthValidator;
use Components\UserIdentity;
use Models\Users;

class AuthController extends Controller
{
	protected $_require_auth = false;
	
	public function actionIndex()
	{
		if (!Yii::app()->user->isGuest)
		{
			return $this->redirect($this->createUrl('/dashboard'));	
		}
		
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
		
		$users_model = new Users();
		
		$has_freshbooks = false;
		if ($user = $users_model->getById(\Yii::app()->user->id))
		{
			if ($user['freshbooks_token'] && $user['freshbooks_domain']) $has_freshbooks = true;
		}
		
		return $this->ajaxSuccess(array('has_freshbooks' => $has_freshbooks));
	}
	
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect($this->createUrl(\Yii::app()->user->loginUrl));
	}
}