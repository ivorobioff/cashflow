<?php
use Components\Controller;
use Models\Users;
use Components\DataBuilder\Budget\Expenses;
use Models\Params;
use Components\DataBuilder\Budget\Cashflow;

class BudgetsController extends Controller
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

		$expenses_builder = new Expenses($params);
		$expenses_data = $expenses_builder->build();
		$expenses_summary_data = $expenses_builder->buildSummary($expenses_data);

		$cashflow_builder = new Cashflow($params);
		$cashflow_data = $cashflow_builder->build();
		$cashflow_summary_data = $cashflow_builder->buildSummary($cashflow_data);

		$this->render('//contents/budgets', array(
			'expenses_data' => $expenses_data,
			'expenses_summary_data' => $expenses_summary_data,
			'cashflow_data' => $cashflow_data,
			'cashflow_summary_data' => $cashflow_summary_data,
		));
	}
}