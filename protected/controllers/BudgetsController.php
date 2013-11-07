<?php
use Components\Controller;

class BudgetsController extends Controller
{
	public function actionIndex()
	{
		$this->render('//contents/budgets');
	}
}