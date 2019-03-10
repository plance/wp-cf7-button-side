<?php

class WpCf7BtnSideCore
{
	/**
	 * Set spl_autoload_register function
	 * @param string|function $function
	 */
	public static function autoloadRegister($function)
	{
		spl_autoload_register($function);
	}

	/**
	 * Check and autoload class
	 * @param string $class class name
	 */
	public static function loadClass($prefix_class, $path, $class)
	{
		if(strstr($class, $prefix_class) == true && class_exists($class) == false)
		{
			require_once (
				$path.strtolower(
					str_replace('_', DIRECTORY_SEPARATOR,
						str_replace($prefix_class, '', $class)
					)
				).'.php'
			);
		}
	}
	
	/**
	 * Check and autoload class
	 * @param string $class class name
	 */
	public static function loadNamespace($prefix_class, $path, $class)
	{
		if(strstr($class, $prefix_class) == true && class_exists($class) == false)
		{
			require_once(
				$path.str_replace('\\', DIRECTORY_SEPARATOR,
					str_replace($prefix_class, '', $class)
				).'.php'
			);
		}
	}
}