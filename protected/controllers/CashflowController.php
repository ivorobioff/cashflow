<?php
use Components\Controller;

class CashflowController extends Controller
{
	public function actionIndex()
	{
		$this->render('//contents/cashflow');
	}
}