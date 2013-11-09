<?php
use Components\Controller;
use Models\Users;
use Components\DataBuilder\Expenses;
use Models\Params;

class ExpensesController extends Controller
{
	public function actionIndex()
	{
		$params_model = new Params();
		$params = $params_model->getByUserId(\Yii::app()->user->id);

		$builder = new Expenses($params);
		$data = $builder->build();
		pred($data);
		$users_model = new Users();
		
		if (!$users_model->hasData(\Yii::app()->user->id))
		{
			return $this->redirect($this->createUrl('/import'));
		}
		
		$this->render('//contents/expenses');
	}
}