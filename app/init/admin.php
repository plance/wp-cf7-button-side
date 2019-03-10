<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * InIt Admin
 */
class WpCf7BtnSide_INIT_Admin
{
	/**
	* Create
	*/
	public function __construct()
	{
		add_action('admin_menu', array($this, 'admin_menu'), 10);
	}
	
	/**
	 * admin_menu
	 */
	public function admin_menu()
	{
		$ControllerConfig = new WpCf7BtnSide_Controller_Admin_Config();
		$hook = add_submenu_page(
			'options-general.php',
			__('CF7 in Modal', 'lance'),
			__('CF7 in Modal', 'lance'),
			'manage_options',
			'wp-cf7-button-side',
			array($ControllerConfig, 'viewIndex')
		);
		add_action('load-'.$hook, array($ControllerConfig, 'actionIndex'));
	}
}