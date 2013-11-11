<?php
use Components\Controller;
use Models\Users;
use Components\DataBuilder\Expenses;
use Models\Params;

class ExpensesController extends Controller
{
	public function actionIndex()
	{
		$users_model = new Users();
		
		if (!$users_model->hasData(\Yii::app()->user->id))
		{
			return $this->redirect($this->createUrl('/import'));
		}
		
		$params_model = new Params();
		$params = $params_model->getByUserId(\Yii::app()->user->id);
		
		$builder = new Expenses($params);
		$data = $builder->build();
		$summary_data = $builder->buildSummary($data);
		
		$this->render('//contents/expenses', array(
			'data' => $data,
			'summary_data' => $summary_data
		));
	}
}