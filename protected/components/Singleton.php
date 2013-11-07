<?php
namespace Components;

abstract class Singleton
{
	static protected $_instances;

	/**
	 * @return \Components\Singleton
	 */
	static public function getInstance()
	{
		$class = get_called_class();

		if (!isset(static::$_instances[$class]))
		{
			static::$_instances[$class] = new static();
		}

		return static::$_instances[$class];
	}
}