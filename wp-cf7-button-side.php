<?php
/*
Plugin Name: WP CF7 Button Side
Description: Show Contact Form 7 in modal window, when user click on button side
Version: 1.0.0
Author: Pavel
Author URI: //plance.top/
*/

defined('ABSPATH') or die('No script kiddies please!');

/** Include language */
load_plugin_textdomain('lance', false, basename(__DIR__).DIRECTORY_SEPARATOR.'languages'.DIRECTORY_SEPARATOR);

/** Include Core */
include plugin_dir_path(__FILE__).'includes'.DIRECTORY_SEPARATOR.'core.php';

/** Set prefix and path to autoload core class */
WpCf7BtnSideCore::autoloadRegister(function($class){
	WpCf7BtnSideCore::loadClass('WpCf7BtnSideCore_', plugin_dir_path(__FILE__).'includes'.DIRECTORY_SEPARATOR, $class);
});

/** Set prefix and path to autoload plugin class */
WpCf7BtnSideCore::autoloadRegister(function ($class) {
	WpCf7BtnSideCore::loadClass('WpCf7BtnSide_', plugin_dir_path(__FILE__).'app'.DIRECTORY_SEPARATOR, $class);
});

/** InIt app */
new WpCf7BtnSide_INIT(array(
	'__FILE__' => __FILE__
));

if(is_admin() == true)
{
	register_activation_hook(__FILE__, 'WpCf7BtnSide_DB::activate');
	register_uninstall_hook(__FILE__, 'WpCf7BtnSide_DB::uninstall');
}