<?php
use Components\Controller;

class SalesController extends Controller
{
	public function actionIndex()
	{
		$this->render('//contents/sales');
	}
}