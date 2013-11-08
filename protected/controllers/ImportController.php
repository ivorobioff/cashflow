<?php
use Components\Controller;
use Components\Import\LocalStorage;
use Components\Validators\Import\Freshbooks as FreshbooksValidator;
use Components\Import\Strategies\Freshbooks as FreshbooksStrategy;
use Components\Import\Exceptions\FreshbooksPullingError;
use Models\Users;
use Models\Import\Expenses;
use Models\Import\Invoices;

class ImportController extends Controller
{
	public function beforeAction($action)
	{
		parent::beforeAction($action);
		
		$allowed_actions = array('update');
		
		$users_model = new Users();
		
		if ($users_model->hasData(\Yii::app()->user->id) && !in_array($action->id, $allowed_actions))
		{
			return $this->redirect($this->createUrl('/dashboard'));
		}
		
		return true;
	}
	
	public function actionIndex()
	{
		$this->render('//contents/import/index');
	}	
	
	public function actionUpdate()
	{
		$expenses_model = new Expenses();
		$invoices_model = new Invoices();
		$users_model = new Users();
		
		$user = $users_model->getById(\Yii::app()->user->id);
		
		$config = array(
			'domain' => $user['freshbooks_domain'],
			'token' => $user['freshbooks_token'],
			'expenses_date_from' => $expenses_model->getLastDate(\Yii::app()->user->id),
			'invoices_date_from' => $invoices_model->getLastDate(\Yii::app()->user->id),
		);

		$strategy = new FreshbooksStrategy($config);
			
		$storage = new LocalStorage();
		
		try
		{
			$storage->save($strategy);
		}
		catch (FreshbooksPullingError $ex)
		{
			return $this->ajaxError(array($ex->getMessage()));
		}
		
		$this->ajaxSuccess();
	}
	
	public function actionFreshbooks()
	{
		$this->render('//contents/import/freshbooks');
	}
	
	public function actionExcel()
	{
		$this->render('//contents/import/excel');
	}
	
	public function actionSaveFreshbooks()
	{
		if (!$this->isAjax()) 
		{
			throw new CHttpException(404,'The specified page cannot be found.');
		}
		 		
		$validator = new FreshbooksValidator();
		
		$errors = $validator
			->setData($_POST)
			->validate()
			->getErrors();
		
		if ($errors)
		{
			foreach ($errors as $error)
			{
				return $this->ajaxError(array($error));
			}
		}
				
		$config = array(
			'domain' => $_POST['domain'],
			'token' => $_POST['token'],
			'date_from' => date('Y-m-d', strtotime(date('Y-m-d').' -2 year')),
		);
		
		$strategy = new FreshbooksStrategy($config);
			
		$storage = new LocalStorage();
		
		try
		{
			$storage->save($strategy);
		}
		catch (FreshbooksPullingError $ex)
		{
			return $this->ajaxError(array($ex->getMessage()));	
		}
		
		$users_model = new Users();
		
		$users_model->updateById(\Yii::app()->user->id, array(
			'freshbooks_token' => $_POST['token'],
			'freshbooks_domain' => $_POST['domain']
		));
		
		$this->ajaxSuccess();
	}
}