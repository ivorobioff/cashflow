<?php
use Components\Controller;
use Models\Users;

class BudgetsController extends Controller
{
	public function actionIndex()
	{
		$users_model = new Users();
		
		if (!$users_model->hasData(\Yii::app()->user->id))
		{
			return $this->redirect($this->createUrl('/import'));
		}
		
		$this->render('//contents/budgets');
	}
}