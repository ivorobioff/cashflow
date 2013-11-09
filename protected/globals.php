<?php
use Components\JsComposer;
use Components\JsComposer\Exceptions\NoStart;

function pre($str)
{
	echo '<pre>';
	print_r($str);
	echo '</pre>';
}

function pred($str)
{
	pre($str);
	die();
}

function setif($array, $key, $default = null)
{
	return isset($array[$key]) ? $array[$key] : $default;
}

/**
 * Check whether the passed location is the current one.
 * @param string $path
 * @return boolean
 */
function is_location($path)
{
	$path = explode('/', trim($path, '/'));

	if (count($path) < 3)
	{
		array_unshift($path, '');
	}
	
	$module = $path[0];
	$controller = $path[1];
	$action = $path[2];
	
	$real_module = !is_null(Yii::app()->controller->module) ? Yii::app()->controller->module->id : '';
	$real_controller = Yii::app()->controller->id;
	$real_action = Yii::app()->controller->action->id;

	return $module == $real_module && $controller == $real_controller && $action == $real_action;
}

function __(Closure $func)
{
	return $func();
}

function load_js()
{
	$controller = Yii::app()->controller->id;
	$action = Yii::app()->controller->action->id;
	
	$bootstrap_name = strtolower($controller.($action != 'index' ? '_'.$action : ''));

	$bin = md5($bootstrap_name);

	if (Yii::app()->params['is_production'])
	{
		return '<script src="'.Yii::app()->request->baseUrl.'/js/app/bin/'.$bin.'.js"></script>';
	}
	
	$composer = new JsComposer(Yii::app()->params['js_composer']);
	
	try
	{
		$composer
			->addBootstrap('common.js')
			->addBootstrap($bootstrap_name.'.js')
			->process()
			->save($bin.'.js');
	}
	catch (NoStart $ex)
	{
		return '';
	}

	return '<script src="'.Yii::app()->request->baseUrl.'/js/app/bin/'.$bin.'.js"></script>';
}

function is_auth()
{
	return !Yii::app()->user->isGuest;
}