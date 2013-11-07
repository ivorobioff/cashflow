<?php
use Components\Controller;
use Components\Import\LocalStorage;
use Components\Import\Strategies\Factory as StrategiesFactory;
use Components\Validators\Import\Factory as ValidatorsFactory;

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
	
	public function actionSave($alias)
	{
		$allowed_aliases = array('freshbooks', 'excel', 'manual');
		
		if (!in_array($alias, $allowed_aliases) || !$this->isAjax()) 
		{
			throw new CHttpException(404,'The specified page cannot be found.');
		}
		 		
		$errors = ValidatorsFactory::create($alias)
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
				
		$strategy = StrategiesFactory::create($alias, $_POST);
			
		$storage = new LocalStorage();
		$storage->save($strategy);
		
		$this->ajaxSuccess();
	}
}