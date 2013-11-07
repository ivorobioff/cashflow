<?php
use Components\Controller;

class ExpensesController extends Controller
{
	public function actionIndex()
	{
		$this->render('//contents/expenses');
	}
}