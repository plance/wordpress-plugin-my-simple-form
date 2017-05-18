<?php

/**
 * InIt form
 */
class Plance_MSF_Controller_Admin_User extends Plance_Controller
{
	const PAGE = __CLASS__;
	
	/**
	 *
	 * @var Plance_MSF_Helper_Table_User
	 */
	public $_Table;
	
	/**
	 * Save screen options
	 */
	public function setScreenOption($status, $option, $value)
	{
		if('pl_msf_per_page' == $option )
		{
			return $value;
		}

		return $status;
	}
	
	//===========================================================
	// Actions
	//===========================================================
	
	/**
	 * Show list areas
	 */
	public function actionIndex()
	{
		$this -> _Table = new Plance_MSF_Helper_Table_User;
		$this -> _Table -> url_page = $this -> page();
	}

	/**
	 * Delete area
	 * @global type $wpdb
	 */
	public function actionDelete()
	{
		global $wpdb;
		
		$id_ar = is_array($_GET['id']) ? array_map('intval', $_GET['id']) : array((int)$_GET['id']);
		
		if(sizeof($id_ar) > 0)
		{
			$data_ar = $wpdb -> get_results("SELECT `file`, `image`
				FROM `{$wpdb -> prefix}plance_msf_user`
				WHERE `id` IN (".join(', ', $id_ar).")", ARRAY_A);
			
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
			
			$wpdb -> query("DELETE FROM `{$wpdb -> prefix}plance_msf_user` WHERE `id` IN (".join(', ', $id_ar).")");
		}
		
		Plance_Flash::instance() -> redirect('?page='.$this -> page(), __('User(s) deleted', 'plance'));
	}
	
	/**
	 * Delete file
	 * @global type $wpdb
	 */
	public function actionFile()
	{
		global $wpdb;
		
		//Sets
		$id = Plance_Request::get('id', 0, 'int');
		$row = false;
		
		$data_ar = $wpdb -> get_results("SELECT `file`, `image`
			FROM `{$wpdb -> prefix}plance_msf_user`
			WHERE `id` = '{$id}'
			LIMIT 1", ARRAY_A);
		
		if(isset($data_ar[0]))
		{
			switch (Plance_Request::get('type'))
			{
				case 'file':
					if(is_file(PLANCE_MSF_PATH_TO_UPLOADS.$data_ar[0]['file']) == true)
					{
						unlink(PLANCE_MSF_PATH_TO_UPLOADS.$data_ar[0]['file']);
					}
					$row = 'file';
				break;
				case 'image':
					if(is_file(PLANCE_MSF_PATH_TO_UPLOADS.$data_ar[0]['image']) == true)
					{
						unlink(PLANCE_MSF_PATH_TO_UPLOADS.$data_ar[0]['image']);
					}
					$row = 'image';
				break;
			}

			if($row == true)
			{
				$wpdb -> update(
					$wpdb -> prefix.'plance_msf_user',
					array(
						$row => NULL,
					),
					array('id' => $id),
					array('%s'),
					array('%d')
				);
			}
		}
			
		Plance_Flash::instance() -> redirect('?page='.$this -> page().'&action=view&id='.$id, __('File deleted', 'plance'));
	}
	
	//===========================================================
	// Styles
	//===========================================================
	
	/**
	 * Create options
	 */
	public function styleIndex()
	{
		echo '<style type="text/css">';
		echo '.wp-list-table .column-id { width: 5%; }';
		echo '</style>';
	}
	
	//===========================================================
	// Views
	//===========================================================
	
	public function viewIndex()
	{
        $this -> _Table -> prepare_items();
        ?>
            <div class="wrap">
                <h2><?php echo __('List applications', 'plance') ?></h2>
				<form method="get">
					<input type="hidden" name="page" value="<?php echo $this -> page() ?>" />
					<?php $this -> _Table -> search_box(__('Search', 'plance'), 'search_id'); ?>
					<?php $this -> _Table -> display(); ?>
				</form>
            </div>
        <?php
	}

	public function viewView()
	{
		global $wpdb;
		
		$data_ar = $wpdb -> get_results("SELECT *
			FROM `{$wpdb -> prefix}plance_msf_user`
			WHERE `id` = ".Plance_Request::get('id', 0, 'int')."
			LIMIT 1", ARRAY_A);
			
		echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/user/view', array(
			'data_ar' => $data_ar[0],
			'rows_ar' => get_option('plance_msf_rows'),
		));
	}
}