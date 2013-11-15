<?php
use Components\Controller;
use Models\Users;
use Components\DataBuilder\Budget\Expenses as ExpensesBudget;
use Models\Params;
use Components\DataBuilder\Budget\Cashflow;
use Components\DataBuilder\Expenses as CurrentExpenses;

class BudgetsController extends Controller
{
	public function actionIndex()
	{
		$users_model = new Users();

		if (!$users_model->hasData(\Yii::app()->user->id))
		{
			return $this->redirect($this->createUrl('/import'));
		}

		$expenses_builder = new ExpensesBudget($this->getParams());
		$expenses_data = $expenses_builder->build();
		$expenses_summary_data = $expenses_builder->buildSummary($expenses_data);
		$expenses_chart_data = $expenses_builder->buildChartData($expenses_data);

		$cashflow_builder = new Cashflow($this->getParams());
		$cashflow_data = $cashflow_builder->build();
		$cashflow_summary_data = $cashflow_builder->buildSummary($cashflow_data);
		$cashflow_chart_data = $cashflow_builder->buildChartData($cashflow_data);

		$current_expenses_model = new CurrentExpenses($this->getParams());
		$current_expenses_chart_data = $current_expenses_model->buildChartData($current_expenses_model->build());

		$this->render('//contents/budgets', array(
			'expenses_data' => $expenses_data,
			'expenses_summary_data' => $expenses_summary_data,
			'cashflow_data' => $cashflow_data,
			'cashflow_summary_data' => $cashflow_summary_data,
			'cashflow_chart_data' => $cashflow_chart_data,
			'current_expenses_chart_data' => $current_expenses_chart_data,
			'expenses_chart_data' => $expenses_chart_data,
		));
	}
}