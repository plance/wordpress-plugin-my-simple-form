<?php

/**
 * InIt form
 */
class Plance_MSF_Controller_Admin_Config extends Plance_Controller
{
	const PAGE = __CLASS__;
	
	//===========================================================
	// Styles
	//===========================================================
	
	/**
	 * Create options
	 */
	public function styleIndex()
	{
		echo '
		<style type="text/css">
			.msa-table tr:first-child td {
				text-align: center;
				font-weight: bold;
			}
			.msa-table th:nth-child(1) {
				width: 150px;
			}
			.msa-table td:nth-child(2) {
				text-align: center;
				width: 200px;
			}
			.msa-table td:nth-child(2) input {
				width: 200px;
			}
			.msa-table td:nth-child(3) {
				text-align: center;
				width: 110px;
			}
			.msa-table td:nth-child(4) {
				text-align: center;
				width: 160px;
			}
			.msa-table td:nth-child(5) {
				text-align: center;
				width: 130px;
			}
		</style>
		';
	}
	
	//===========================================================
	// Actions
	//===========================================================
	
	/**
	 * Show list areas
	 */
	public function actionIndex()
	{
		if(Plance_Request::isPost() == true && isset($_POST['msa']))
		{
			update_option('plance_msf_rows', wp_unslash($_POST['msa']));
			
			Plance_Flash::instance() -> redirect('?page='.$this -> page(), __('Configure updated', 'plance'));
		}
	}
	
	//===========================================================
	// Views
	//===========================================================
	
	public function viewIndex()
	{
		echo Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/admin/config/form', array(
			'data_ar' => get_option('plance_msf_rows')
		));
	}
}