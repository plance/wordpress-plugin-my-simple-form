<?php
/*
Plugin Name: My Simple Form
Plugin URI: http://wordpress.org/plugins/my-simple-form/
Description: Simple plugin for form on job, purchase, donations, credit, etc.
Version: 1.1
Author: Pavel
Author URI: http://plance.in.ua/
*/

defined('ABSPATH') or die('No script kiddies please!');

//Include language
load_plugin_textdomain('plance', false, basename(__DIR__).'/languages/');

if(class_exists('Plance_Include') == FALSE)
{
	require_once(plugin_dir_path(__FILE__).'library/wp-plance/include.php');
}

define('PLANCE_MSF_PATH_TO_UPLOADS', plugin_dir_path(__FILE__).'../../uploads/my-simple-form/');

Plance_Include::load(array(
	'index' => array(
		array(
			'class'=> 'Plance_Registry',
			'path' => plugin_dir_path(__FILE__).'library/wp-plance/registry.php',
			'call' => function()
			{
				add_action('plugins_loaded', function() {
					Plance_Registry::setPlugin(basename(__DIR__));
					Plance_Registry::set('path_to_plugin', plugin_dir_path(__FILE__));
					Plance_Registry::set('url_to_plugin', content_url('uploads/my-simple-form/'));
				});
			}
		),
		array(
			'class' => 'Plance_Flash',
			'path'	=> plugin_dir_path(__FILE__).'library/wp-plance/flash.php',
			'call' => function()
			{
				Plance_Flash::instance() -> init();
			}
		),
		'Plance_Validate'	=> plugin_dir_path(__FILE__).'library/plance/validate.php',
		'Plance_View'		=> plugin_dir_path(__FILE__).'library/plance/view.php',
		'Plance_Request'	=> plugin_dir_path(__FILE__).'library/plance/request.php',
		plugin_dir_path(__FILE__).'app/index_init.php',
				
		plugin_dir_path(__FILE__).'vendor/kohana/include.php',
		'Kohana_Upload'		=> plugin_dir_path(__FILE__).'vendor/kohana/kohana/upload.php',
		'Upload'			=> plugin_dir_path(__FILE__).'vendor/kohana/upload.php',
	),
	'admin' => array(
		'WP_List_Table'		=> ABSPATH.'wp-admin/includes/class-wp-list-table.php',
		'Plance_Interface'	=> plugin_dir_path(__FILE__).'library/wp-plance/interface.php',
		'Plance_Controller' => plugin_dir_path(__FILE__).'library/wp-plance/controller.php',
		'Plance_Validate'	=> plugin_dir_path(__FILE__).'library/plance/validate.php',
		
		plugin_dir_path(__FILE__).'app/db.php',
		plugin_dir_path(__FILE__).'app/admin_init.php',
		/*Helper*/
		plugin_dir_path(__FILE__).'app/helper/table/User.php',
		/*Controller*/
		plugin_dir_path(__FILE__).'app/controller/admin/Config.php',
		plugin_dir_path(__FILE__).'app/controller/admin/User.php',
		plugin_dir_path(__FILE__).'app/controller/admin/Notification.php',
	),
));

if(is_admin() == TRUE)
{
	register_activation_hook(__FILE__, 'Plance_MSF_DB::activate');
	register_uninstall_hook(__FILE__, 'Plance_MSF_DB::uninstall');
//	register_deactivation_hook(__FILE__, 'Plance_MSF_DB::uninstall');
	
    new Plance_MSF_Admin_INIT();
}
else
{
	new Plance_MSF_Index_INIT();
}

Plance_Registry::clean();