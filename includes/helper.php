<?php
defined('ABSPATH') or die('No script kiddies please!');

class WpCf7BtnSideCore_Helper
{

	/**
	 * Wrap set_time_limit()
	 */
	public static function set_time_limit()
	{
		if(function_exists('set_time_limit'))
		{
			set_time_limit(0);
		}
	}
	
	//===========================================================
	// Flash
	//===========================================================
	
	/**
	 * Flash Init
	 */
	public static function flashInit()
	{
		if(session_id() == false)
		{
			session_start();
		}

		add_action('admin_notices', function()
		{
			if(isset($_SESSION['flash_redirect']))
			{
				self::flashShow($_SESSION['flash_redirect']['class'], $_SESSION['flash_redirect']['message']);
				unset($_SESSION['flash_redirect']);
			}
		});
	}
	
	/**
	 * Flash Redirect
	 * @param string $uri
	 * @param string $message
	 * @param bool $type
	 */
	public static function flashRedirect($uri, $message, $type = true)
	{
		$_SESSION['flash_redirect'] = array(
			'class'   => $type == true ? 'updated' : 'error',
			'message' => $message,
		);
		wp_redirect($uri);
		exit;
	}
	
	/**
	 * Flash Show
	 */
	public static function flashShow($class, $message)
	{
		$messages = (array) $message;
		
		echo '<div class="'.$class.' notice is-dismissible">';
		echo '<button type="button" class="notice-dismiss"></button>';
		foreach($messages as $message)
		{
			echo '<p>'.$message.'</p>';
		}
		echo '</div>';
	}
	
	//===========================================================
	// Request
	//===========================================================
	
	/**
	 * Return data from $_GET var
	 * @param string $index
	 * @param mixed $default
	 * @return mided
	 */
	public static function requestGet($index, $default = NULL)
	{
		return key_exists($index, $_GET) ? $_GET[$index] : $default;
	}

	/**
	 * Return data from $_POST var
	 * @param string $index
	 * @param mixed $default
	 * @return mided
	 */
	public static function requestPost($index, $default = NULL)
	{
		return key_exists($index, $_POST) ? $_POST[$index] : $default;
	}

	/**
	 * Check, REQUEST_METHOD is POST
	 *
	 * @return bool
	 */
	public static function requestIsPost()
	{
		 return $_SERVER['REQUEST_METHOD'] == "POST";
	}

	/**
	 * Check, is Ajax
	 *
	 * @return bool
	 */
	public static function requestIsAjax()
	{
		 return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	//===========================================================
	// View
	//===========================================================
	
	/**
	 * Get template content
	 *
	 * @param string $path path to view
	 * @param array $array data array
	 * @param string $ext file extension
	 * @return string
	 */
	public static function getView($path, $array = array(), $ext = 'php')
	{
		if(is_array($array) == TRUE)
		{
			extract($array, EXTR_SKIP);
		}

		ob_start();

		try
		{
			include $path.'.'.$ext;
		}
		catch (Exception $e)
		{
			ob_end_clean();

			throw $e;
		}

		return ob_get_clean();
	}
	
	//===========================================================
	// Controller
	//===========================================================
	
	/**
	 * Call controller action or view
	 * @param object $object
	 * @param string $pref
	 * @param string $get
	 * @return boolean
	 */
	public static function controller($object, $pref, $get = 'action')
	{
		//Sets
		$action = filter_input(INPUT_GET, $get, FILTER_SANITIZE_STRING);
		
		if(empty($action))
		{
			$action = 'index';
		}
		$action = $pref.ucfirst($action);
		
		if(method_exists($object, $action))
		{
			call_user_func(array($object, $action));
		}
		else
		{
			return false;
		}
		return true;
	}
}