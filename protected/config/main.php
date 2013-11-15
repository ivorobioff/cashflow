<?php
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Cloud Cash Flow',
	'defaultController' => 'dashboard',
	'aliases' => array(
		'Components' => __DIR__.'/../components/',
		'Models' => __DIR__.'/../models/',
		'Helpers' => __DIR__.'/../helpers/',
		'Extensions' => __DIR__.'/../extensions/',
	),

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(),


	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin' => false,
			'loginUrl'=> '/auth',
		),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=cashflow',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '1234',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'default/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'is_production' => false,
		'js_composer' => array(
			'app_path' => __DIR__.'/../../js/app', //path to js application
			'bin_path' => __DIR__.'/../../js/app/bin', // path where the compiled js will be saved
		),
	),
);