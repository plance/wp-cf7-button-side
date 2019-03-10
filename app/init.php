<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
* InIt
*/
class WpCf7BtnSide_INIT
{
	private $config_ar;
	public static $glob = array();

	/**
	* Create
	*/
	public function __construct($config_ar)
	{
		$this -> config_ar = $config_ar;

		/** Flahs init */
		WpCf7BtnSideCore_Helper::flashInit();
		
		add_action('plugins_loaded', array($this, 'plugins_loaded'));
	}
	
	/**
	 * WP hook "plugins_loaded"
	 */
	public function plugins_loaded()
	{
		self::$glob['path'] = plugin_dir_path($this -> config_ar['__FILE__']);
		self::$glob['url']  = plugin_dir_url($this -> config_ar['__FILE__']);

		if(is_admin() == true)
		{
			new WpCf7BtnSide_INIT_Admin();
		}
		else
		{
			new WpCf7BtnSide_INIT_Index();
		}
	}
}