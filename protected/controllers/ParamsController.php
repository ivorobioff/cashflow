<?php
use Components\Controller;
use Components\Validators\DateRangeFilter;
use Models\Params;
use \Components\Validators\Params as ParamsValidator;
use Components\Validators\Budget;

class ParamsController extends Controller
{
	public function actionUpdateDate()
	{
		$validator = new DateRangeFilter();

		$errors = $validator->setData($_POST)->validate()->getErrors();

		if ($errors)
		{
			return $this->ajaxError($errors);
		}

		$date_from = $this->convertDate($_POST['date_from']);
		$date_to = $this->convertDate($_POST['date_to']);

		$params = new Params();

		$params->updateByUserId(\Yii::app()->user->id, array('date_from' => $date_from, 'date_to' => $date_to));

		$this->ajaxSuccess();
	}

	public function actionUpdate()
	{
		$validator = new ParamsValidator();

		$error = $validator->setData($_POST)->validate()->getErrors();

		if ($error)
		{
			return $this->ajaxError($error);
		}

		$params = new Params();
		$params->updateByUserId(\Yii::app()->user->id, array($_POST['key'] => $_POST['value']));

		$this->ajaxSuccess();
	}

	public function actionUpdateExpensesFixed()
	{
		$params = new Params();

		$params->updateExpensesFixedByUserId($_POST['name'], intval($_POST['fixed']), \Yii::app()->user->id);

		$this->ajaxSuccess();
	}

	public function actionUpdateBudget()
	{
		$validator = new Budget();

		$error = $validator->setData($_POST)->validate()->getErrors();

		if ($error)
		{
			return $this->ajaxError($error);
		}

		$params = new Params();
		$params->updateBudgetUserId($_POST['date'], $_POST['amount'], \Yii::app()->user->id);

		$this->ajaxSuccess();
	}
}