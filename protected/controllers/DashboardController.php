<?php
use Components\Controller;

class DashboardController extends Controller
{
	public function actionIndex()
	{
		$this->render('//contents/dashboard');
	}
}