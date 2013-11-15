<?php
use Components\Controller;
use Models\Users;
use Components\ExcelFormulas;
use Models\Params;
use Components\DataBuilder\Cashflow;
use Components\DataBuilder\Expenses;
use Components\DataBuilder\Base as BaseBuilder;
use Components\DataBuilder\Invoices;
use Components\DataBuilder\Budget\Cashflow as CashflowRevised;
use Components\DataBuilder\Budget\Expenses as ExpensesRevised;

class DashboardController extends Controller
{
	public function actionIndex()
	{
		$users_model = new Users();

		if (!$users_model->hasData(\Yii::app()->user->id))
		{
			return $this->redirect($this->createUrl('/import'));
		}

		$this->render('//contents/dashboard', array(
			'cashflow_chart_data' => $this->_buildChartData(new Cashflow($this->getParams())),
			'expenses_chart_data' => $this->_buildChartData(new Expenses($this->getParams())),
			'sales_chart_data' => $this->_buildChartData(new Invoices($this->getParams())),
			'revised_cashflow_chart_data' => $this->_buildChartData(new CashflowRevised($this->getParams())),
			'revised_expenses_chart_data' => $this->_buildChartData(new ExpensesRevised($this->getParams()))
		));
	}

	private function _buildChartData(BaseBuilder $builder)
	{
		$data = $builder->build();

		if (!$data) return false;

		return $builder->buildChartData($data);
	}
}