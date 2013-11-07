<?php
use Components\Controller;
use Components\Import\LocalStorage;
use Components\Validators\Import\Freshbooks as FreshbooksValidator;
use Components\Import\Strategies\Freshbooks as FreshbooksStrategy;
use Components\Import\Exceptions\FreshbooksPullingError;

class ImportController extends Controller
{
	public function actionIndex()
	{
		$this->render('//contents/import/index');
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
		
		$this->ajaxSuccess();
	}
}