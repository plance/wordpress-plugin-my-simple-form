<?php

/**
 * InIt form
 */
class Plance_MSF_Controller_Admin_Notification extends Plance_Controller
{
	const PAGE = __CLASS__;
	
	//===========================================================
	// Actions
	//===========================================================
	
	/**
	 * Show list areas
	 */
	public function actionIndex()
	{
		$this -> _FormValidate = Plance_Validate::factory(wp_unslash($_POST))
		-> setLabels(array(
			'admin_email'		=> __('Admin Email', 'plance'),
			'admin_name'		=> __('Admin Name', 'plance'),
			'noreply_email'		=> __('Noreply Email', 'plance'),
			'noreply_name'		=> __('Noreply Name', 'plance'),
			'shortcode_name'	=> __('Shortcode Name', 'plance'),
			'message_subject'	=> __('Message subject', 'plance'),
			'message_template'	=> __('Message template', 'plance'),
			'flash_message'		=> __('Flash Message', 'plance'),
		))
				
		-> setFilters('*', array(
			'trim' => array(),
		))
				
		-> setRules('admin_email', array(
			'required' => array(),
		))
		-> setRules('admin_name', array(
			'required' => array(),
		))
		-> setRules('noreply_email', array(
			'required' => array(),
		))
		-> setRules('noreply_name', array(
			'required' => array(),
		))
		-> setRules('message_subject', array(
			'required' => array(),
		))
		-> setRules('message_template', array(
			'required' => array(),
		))
		-> setRules('shortcode_name', array(
			'required' => array(),
			'regex' => array('/^[a-z]+[a-z0-9\-_]+[a-z]$/i'),
		))
		-> setRules('admin_email', array(
			'email' => array(),
		))
		-> setRules('noreply_email', array(
			'email' => array(),
		))
						
		-> setMessages(array(
			'required'	=> __('"{field}" must not be empty', 'plance'),
			'email'		=> __('"{field}" must be a email', 'plance'),
			'regex'		=> __('"{field}" does not match the required format', 'plance'),
		));
		
		if(Plance_Request::isPost() && $this -> _FormValidate -> validate())
		{
			update_option('plance_msf_notification', $this -> _FormValidate -> getData());
			
			Plance_Flash::instance() -> redirect('?page='.$this -> page(), __('Configure updated', 'plance'));
		}
		else if(Plance_Request::isPost() == false)
		{
			$this -> _FormValidate -> setData(
				get_option('plance_msf_notification')
			);
		}
		
		if($this -> _FormValidate -> isErrors())
		{
			Plance_Flash::instance() -> show('error', $this -> _FormValidate -> getErrors());
		}
	}
	
	//===========================================================
	// Views
	//===========================================================
	
	public function viewIndex()
	{
		echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/notification/form', array(
			'Validate' => $this -> _FormValidate
		));
	}
}