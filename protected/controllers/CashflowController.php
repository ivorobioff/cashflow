<?php
use Components\Controller;
use Models\Users;
use Components\DataBuilder\Cashflow;
use Models\Params;

class CashflowController extends Controller
{
	public function actionIndex()
	{
		$users_model = new Users();

		if (!$users_model->hasData(\Yii::app()->user->id))
		{
			return $this->redirect($this->createUrl('/import'));
		}

		$builder = new Cashflow($this->getParams());
		$data = $builder->build();
		$summary_data = $builder->buildSummary($data);
		$chart_data = $builder->buildChartData($data);

		$this->render('//contents/cashflow', array(
			'data' => $data,
			'summary_data' => $summary_data,
			'chart_data' => $chart_data,
		));
	}
}