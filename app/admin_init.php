<?php

/**
 * InIt user
 */
class Plance_MSF_Admin_INIT
{
    /**
     * Create
     */
    public function __construct()
    {
		$AdminInit = new Plance_Interface();
		$AdminInit -> addController('@', 'Plance_MSF_Controller_Admin_User', array(
			array('action' => 'view'),
			array('action' => 'delete'),
			array('action' => '-1', '@method' => 'delete'),
			array('action' => 'file'),
		));
		$AdminInit -> addController('config', 'Plance_MSF_Controller_Admin_Config');
		$AdminInit -> addController('notification', 'Plance_MSF_Controller_Admin_Notification');

		$AdminInit -> setMenu(array(
			'@' => array(__('List applications', 'plance'), __('Applications', 'plance')),
			'config' => array(__('Configure fields', 'plance'), __('Configure fields', 'plance')),
			'notification' => array(__('Notification', 'plance'), __('Notification', 'plance')),
		));
    }
}