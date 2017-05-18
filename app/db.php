<?php

defined('ABSPATH') or die('No script kiddies please!');

/**
 * DB
 */
class Plance_MSF_DB
{
    /**
	 * Plugin Activate
	 */
    public static function activate()
    {
		global $wpdb;

		require_once(ABSPATH.'wp-admin/includes/upgrade.php');
		
		$plance_msf_rows = array(
			'name'			=> array('show' => 1, 'order' =>  10, 'required' => 1, 'title' => 'Name'),
			'surname'		=> array('show' => 1, 'order' =>  20, 'required' => 1, 'title' => 'Surname'),
			'patronymic'	=> array('show' => 1, 'order' =>  30, 'required' => 1, 'title' => 'Patronymic'),
			'company'		=> array('show' => 1, 'order' =>  40, 'required' => 1, 'title' => 'Company'),
			'birthday'		=> array('show' => 1, 'order' =>  50, 'required' => 1, 'title' => 'Birthday', 'min' => 0, 'max' => 0),
			'phone'			=> array('show' => 1, 'order' =>  60, 'required' => 1, 'title' => 'Phone'),
			'email'			=> array('show' => 1, 'order' =>  70, 'required' => 1, 'title' => 'E-mail'),
			'messenger'		=> array('show' => 1, 'order' =>  80, 'required' => 1, 'title' => 'Messenger'),
			'site'			=> array('show' => 1, 'order' =>  90, 'required' => 1, 'title' => 'Site'),
			'country'		=> array('show' => 1, 'order' => 100, 'required' => 1, 'title' => 'Country'),
			'city'			=> array('show' => 1, 'order' => 110, 'required' => 1, 'title' => 'City'),
			'address'		=> array('show' => 1, 'order' => 120, 'required' => 1, 'title' => 'Address'),
			'credit_card'	=> array('show' => 1, 'order' => 130, 'required' => 1, 'title' => 'Credit card'),
			'sum'			=> array('show' => 1, 'order' => 140, 'required' => 1, 'title' => 'Sum'),
			'comment'		=> array('show' => 1, 'order' => 150, 'required' => 1, 'title' => 'Comment'),
			'image'			=> array('show' => 1, 'order' => 160, 'required' => 1, 'title' => 'Image', 'extension' => 'jpg,png'),
			'file'			=> array('show' => 1, 'order' => 170, 'required' => 1, 'title' => 'File', 'extension' => 'txt,doc'),
			'radio'			=> array('show' => 1, 'order' => 180, 'required' => 1, 'title' => 'Radio element', 'list' => 'One,Two,Three'),
			'select'		=> array('show' => 1, 'order' => 190, 'required' => 1, 'title' => 'Select element', 'list' => 'One,Two,Three'),
			'checkbox'		=> array('show' => 1, 'order' => 200, 'required' => 1, 'title' => 'Checkbox element'),
		);
		
		add_option('plance_msf_rows', $plance_msf_rows);
		
		$message_template = "Form data:\n";
		foreach ($plance_msf_rows as $k => $_)
		{
			$message_template .= "{$_['title']}: \"{{$k}}\"\n";
		}
		
		add_option('plance_msf_notification', array(
			'admin_email' => get_bloginfo('admin_email'),
			'admin_name' => 'Administrator',
			'noreply_email' => get_bloginfo('admin_email'),
			'noreply_name' => get_bloginfo('blogname'),
			'shortcode_name' => 'plance-msf-form',
			'message_subject' => 'Email from Your Site',
			'message_template' => $message_template,
			'flash_message' => '',
		));
		
		dbDelta("CREATE TABLE IF NOT EXISTS `{$wpdb -> prefix}plance_msf_user` (
			`id` INT(11) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
			`name` VARCHAR(40) NULL,
			`surname` VARCHAR(40) NULL,
			`patronymic` VARCHAR(40) NULL,
			`company` VARCHAR(100) NULL,
			`birthday` INT(10) UNSIGNED NULL,
			`phone` VARCHAR(25) NULL,
			`email` VARCHAR(80) NULL,
			`messenger` VARCHAR(30) NULL,
			`site` VARCHAR(100) NULL,
			`country` VARCHAR(30) NULL,
			`city` VARCHAR(30) NULL,
			`address` VARCHAR(100) NULL,
			`credit_card` VARCHAR(20) NULL,
			`sum` VARCHAR(10) NULL,
			`comment` TEXT NULL,
			`image` VARCHAR(20) NULL,
			`file` VARCHAR(20) NULL,
			`radio` VARCHAR(100) NULL,
			`select` VARCHAR(100) NULL,
			`checkbox` TINYINT(1) UNSIGNED NULL,
			`date_create` INT(10) UNSIGNED NOT NULL
		) {$wpdb -> get_charset_collate()};");

		$dir_upload = dirname(PLANCE_MSF_PATH_TO_UPLOADS);
		if(is_dir($dir_upload) == false)
		{
			mkdir($dir_upload, 0777);
		}
		if(is_dir(PLANCE_MSF_PATH_TO_UPLOADS) == false)
		{
			mkdir(PLANCE_MSF_PATH_TO_UPLOADS, 0777);
		}
		
        return TRUE;
    }
	
    /**
	 * Plugin Uninstall
	 */
    public static function uninstall()
    {
		global $wpdb;
		
		$data_ar = $wpdb -> get_results("SELECT `id`, `file`, `image`
			FROM `{$wpdb -> prefix}plance_msf_user`", ARRAY_A);

		foreach($data_ar as $a)
		{
			if(is_file(PLANCE_MSF_PATH_TO_UPLOADS.$a['file']) == true)
			{
				unlink(PLANCE_MSF_PATH_TO_UPLOADS.$a['file']);
			}
			if(is_file(PLANCE_MSF_PATH_TO_UPLOADS.$a['image']) == true)
			{
				unlink(PLANCE_MSF_PATH_TO_UPLOADS.$a['image']);
			}
		}
		
		$wpdb -> query("DROP TABLE IF EXISTS `{$wpdb -> prefix}plance_msf_user`");
		delete_option('plance_msf_rows');
		delete_option('plance_msf_notification');
		
		rmdir(PLANCE_MSF_PATH_TO_UPLOADS);
		
		return TRUE;
    }
}