<?php
defined('ABSPATH') or die('No script kiddies please!');

class WpCf7BtnSide_Controller_Admin_Config
{
	/**
	 * Validate form
	 */
	private $Validate;
	
	//===========================================================
	// Actions
	//===========================================================
	
	/**
	 * Show list
	 */
	public function actionIndex()
	{
		$this -> Validate = WpCf7BtnSideCore_Library_Validate::factory(wp_unslash($_POST))
		-> setLabels(array(
			'button_position'	=> __('Button position', 'lance'),
			'button_class'		=> __('Button class', 'lance'),
			'button_label'		=> __('Button label', 'lance'),
			'button_img_url'	=> __('URL to button', 'lance'),
			'button_type'		=> __('Button type', 'lance'),
			'modal_title'		=> __('Modal title', 'lance'),
			'cf7_id'			=> __('Contact Form 7 id', 'lance'),
			'url_css'			=> __('Url to CSS file', 'lance'),
			'url_js'			=> __('Url to JavaScript file', 'lance'),
			'use_plugin_css'	=> __('Use plugin CSS file', 'lance'),
		))
		
		-> setFilters('*', array(
			'trim' => array(),
		));
		
		if(WpCf7BtnSideCore_Helper::requestIsPost() && WpCf7BtnSideCore_Helper::requestIsAjax() == false && $this -> Validate -> validate())
		{
			update_option(WpCf7BtnSide_DB::OPTION, $this -> Validate -> getData());
			
			WpCf7BtnSideCore_Helper::flashRedirect(remove_query_arg('_'), __('Data updated', 'lance'));
		}
		else if(WpCf7BtnSideCore_Helper::requestIsPost() == false)
		{
			$this -> Validate -> setData(
				get_option(WpCf7BtnSide_DB::OPTION)
			);
		}
		
		if($this -> Validate -> isErrors())
		{
			WpCf7BtnSideCore_Helper::flashShow('error', $this -> Validate -> getErrors());
		}
	}
	
	//===========================================================
	// Views
	//===========================================================
	
	public function viewIndex()
	{
		$cf7_ids_ar = array();
		
		$Cf7Ar = get_posts(array(
			'post_type' => 'wpcf7_contact_form',
		));
		
		foreach($Cf7Ar as $Cf7)
		{
			$cf7_ids_ar[$Cf7 -> ID] = $Cf7 -> post_title;
		}

		echo WpCf7BtnSideCore_Helper::getView(WpCf7BtnSide_INIT::$glob['path'].'app/view/admin/config/index', array(
			'Validate' => $this -> Validate,
			'cf7_ids_ar' => $cf7_ids_ar
		));
	}
}