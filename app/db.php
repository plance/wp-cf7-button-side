<?php
defined('ABSPATH') or die('No script kiddies please!');

/**
 * DB class
 */
class WpCf7BtnSide_DB
{
	const OPTION = 'wp_cf7_btn_side__option';
	
    /**
	 * Plugin Activate
	 */
    public static function activate()
    {
		$option = get_option(WpCf7BtnSide_DB::OPTION);
		if($option == false)
		{
			update_option(WpCf7BtnSide_DB::OPTION, array(
				'button_position' => 'right-middle',
				'button_class' => 'btn btn-primary',
				'button_label' => 'Contact me',
				'button_img_url' => 'https://via.placeholder.com/300x60?text=Contact+me',
				'button_type' => 'text',
				'modal_title' => 'Contact form',
				'cf7_id' => '',
				'url_css' => '',
				'url_js' => '',
				'use_plugin_css' => 1,
			));
		}
		
        return true;
    }
	
    /**
	 * Plugin Uninstall
	 */
    public static function uninstall()
    {
		delete_option(WpCf7BtnSide_DB::OPTION);
		
		return true;
    }
    
	/**
	 * Return options
	 * @staticvar array $option
	 * @return array
	 */
	public static function options()
	{
		static $option;
		
		if(empty($option))
		{
			$option = get_option(WpCf7BtnSide_DB::OPTION);
		}
		
		return $option;
	}
}