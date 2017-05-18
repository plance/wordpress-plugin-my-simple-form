<?php

/**
 * InIt form
 */
class Plance_MSF_Index_INIT
{
    /**
     * Create
     */
    public function __construct()
    {
		add_action('plugins_loaded', function() {
			global $wpdb;
			
			//Sets
			$rows_ar		 = get_option('plance_msf_rows');
			$notification_ar = get_option('plance_msf_notification');
			$label_ar		 = array();
			$label_birthday	 = '';

			foreach ($rows_ar as $name => $a)
			{
				if($a['show'] == 1)
				{
					$_ = $a;
					unset($_['title'], $_['show'], $_['order']);

					if($name == 'birthday')
					{
						$label_birthday	 = $a['title'];
						$fields_ar[$a['order'].'-1'] = array(
							'field' => 'birthday_day',
							'name'	=> 'msf_birthday_day',
							'title' => $a['title'],
							'rules'	=> $_,
						);
						$label_ar['msf_birthday_day'] = __('Day', 'plance');
						
						$fields_ar[$a['order'].'-2'] = array(
							'field' => 'birthday_month',
							'name'	=> 'msf_birthday_month',
							'title' => $a['title'],
							'rules'	=> $_,
						);
						$label_ar['msf_'.$name.'_month'] = __('Month', 'plance');
						
						$fields_ar[$a['order'].'-3'] = array(
							'field' => 'birthday_year',
							'name'	=> 'msf_birthday_year',
							'title' => $a['title'],
							'rules'	=> $_,
						);
						$label_ar['msf_birthday_year'] = __('Year', 'plance');
					}
					else
					{
						$fields_ar[$a['order']] = array(
							'field' => $name,
							'name'	=> 'msf_'.$name,
							'title' => $a['title'],
							'rules'	=> $_,
						);
						$label_ar['msf_'.$name] = $a['title'];
					}
				}
			}
			ksort($fields_ar);

			$Validate = Plance_Validate::factory(array_merge($_POST, $_FILES))
			 -> setLabels($label_ar)
			-> setMessages(array(
				'required'									=> __('"{field}" must not be empty', 'plance'),
				'email'										=> __('"{field}" must be a email', 'plance'),
				__CLASS__.'::validateBirthdayMin'			=> __('Minimum age "{param1}"', 'plance'),
				__CLASS__.'::validateBirthdayMax'			=> __('The maximum age limit "{param1}"', 'plance'),
				__CLASS__.'::validateBirthdayDayRequired'	=> __('You must select day', 'plance'),
				__CLASS__.'::validateBirthdayMonthRequired'	=> __('You must select month', 'plance'),
				__CLASS__.'::validateBirthdayYearRequired'	=> __('You must select year', 'plance'),
				'Upload::not_empty'							=> __('You must select file for "{field}"', 'plance'),
				'Upload::valid'								=> __('During upload file for "{field}" the error occurred', 'plance'),
				'Upload::type'								=> __('You upload wrong file type for "{field}"', 'plance'),
			));

			foreach ($fields_ar as $a)
			{
				switch ($a['field'])
				{
					case 'birthday_day':
						$rules_ar = array(
							__CLASS__.'::validateBirthdayDayRequired' => array()
						);
						if($a['rules']['required'] == 1)
						{
							$rules_ar['required'] = array();
						}
						if($a['rules']['min'] > 0)
						{
							$rules_ar[__CLASS__.'::validateBirthdayMin'] = array($a['rules']['min']);
						}
						if($a['rules']['max'] > 0)
						{
							$rules_ar[__CLASS__.'::validateBirthdayMax'] = array($a['rules']['max']);
						}
						$Validate -> setFilters($a['name'],array(
							'intval' => array()
						));
						$Validate -> setRules($a['name'], $rules_ar);
					break;
					case 'birthday_month':
						$Validate -> setFilters($a['name'],array(
							'intval' => array()
						));
						$Validate -> setRules($a['name'], array(
							__CLASS__.'::validateBirthdayMonthRequired' => array()
						));
					break;
					case 'birthday_year':
						$Validate -> setFilters($a['name'],array(
							'intval' => array()
						));
						$Validate -> setRules($a['name'], array(
							__CLASS__.'::validateBirthdayYearRequired' => array()
						));
					break;
					case 'email':
						$Validate -> setFilters($a['name'],array(
							'trim' => array()
						));
						$rules_ar = array(
							'email' => array(),
						);
						if($a['rules']['required'] == 1)
						{
							$Validate -> setRules($a['name'], array(
								'required' => array(),
							));
						}
						$Validate -> setRules($a['name'], $rules_ar);
					break;
					case 'file':
					case 'image':
						$rules_ar = array(
							'Upload::valid' => array()
						);
						if($a['rules']['required'] == 1)
						{
							$rules_ar['Upload::not_empty'] = array();
						}
						if($a['rules']['extension'] == true)
						{
							$rules_ar['Upload::type'] = array(explode(',', $a['rules']['extension']));
						}
						$Validate -> setRules($a['name'],$rules_ar);
					break;
					default:
						if($a['rules']['required'] == 1)
						{
							$Validate -> setRules($a['name'], array(
								'required' => array(),
							));
						}
						$Validate -> setFilters($a['name'], array(
							'trim' => array(),
							'strip_tags' => array(),
						));
					break;
				}
			}

			if(isset($_POST['__plance_msf_form']) &&  $Validate -> validate())
			{
				//Sets
				$data_ar	= $Validate -> getData();
				$birthday	= 0;
				$image		= NULL;
				$file		= NULL;
				$radio		= NULL;
				$select		= NULL;
				
				if(isset($rows_ar['radio']['list']) && $rows_ar['radio']['list'] && isset($data_ar['msf_radio']))
				{
					$radio_ar = explode(',', $rows_ar['radio']['list']);
					$radio_ar = array_map('trim', $radio_ar);
					$radio = $radio_ar[$data_ar['msf_radio']];
				}
				if(isset($rows_ar['select']['list']) && $rows_ar['select']['list'] && isset($data_ar['msf_select']))
				{
					$select_ar = explode(',', $rows_ar['select']['list']);
					$select_ar = array_map('trim', $select_ar);
					$select = $select_ar[$data_ar['msf_select']];
				}
				
				if(isset($data_ar['msf_image']) && $data_ar['msf_image']['size'])
				{
					$image = uniqid(rand(0, 100)).'.'.strtolower(pathinfo($data_ar['msf_image']['name'], PATHINFO_EXTENSION));
					Upload::save($data_ar['msf_image'], $image, PLANCE_MSF_PATH_TO_UPLOADS, 0777);
				}
				
				if(isset($data_ar['msf_file']) && $data_ar['msf_file']['size'])
				{
					$file = uniqid(rand(0, 100)).'.'.strtolower(pathinfo($data_ar['msf_file']['name'], PATHINFO_EXTENSION));
					Upload::save($data_ar['msf_file'], $file, PLANCE_MSF_PATH_TO_UPLOADS, 0777);
				}
				
				if(isset($data_ar['msf_birthday_day']) && 
					isset($data_ar['msf_birthday_month']) && 
					isset($data_ar['msf_birthday_year']) &&
					$data_ar['msf_birthday_day'] && 
					$data_ar['msf_birthday_month'] && 
					$data_ar['msf_birthday_year'])
				{
					$birthday = strtotime($data_ar['msf_birthday_day'].'.'.$data_ar['msf_birthday_month'].'.'.$data_ar['msf_birthday_year']);
				}
				
				$insert_row = array(
					'name'			=> isset($data_ar['msf_name']) ? $data_ar['msf_name'] : NULL,
					'surname'		=> isset($data_ar['msf_surname']) ? $data_ar['msf_surname'] : NULL,
					'patronymic'	=> isset($data_ar['msf_patronymic']) ? $data_ar['msf_patronymic'] : NULL,
					'company'		=> isset($data_ar['msf_company']) ? $data_ar['msf_company'] : NULL,
					'birthday'		=> $birthday,
					'phone'			=> isset($data_ar['msf_phone']) ? $data_ar['msf_phone'] : NULL,
					'email'			=> isset($data_ar['msf_email']) ? $data_ar['msf_email'] : NULL,
					'messenger'		=> isset($data_ar['msf_messenger']) ? $data_ar['msf_messenger'] : NULL,
					'site'			=> isset($data_ar['msf_site']) ? $data_ar['msf_site'] : NULL,
					'country'		=> isset($data_ar['msf_country']) ? $data_ar['msf_country'] : NULL,
					'city'			=> isset($data_ar['msf_city']) ? $data_ar['msf_city'] : NULL,
					'address'		=> isset($data_ar['msf_address']) ? $data_ar['msf_address'] : NULL,
					'credit_card'	=> isset($data_ar['msf_credit_card']) ? $data_ar['msf_credit_card'] : NULL,
					'sum'			=> isset($data_ar['msf_sum']) ? $data_ar['msf_sum'] : NULL,
					'comment'		=> isset($data_ar['msf_comment']) ? $data_ar['msf_comment'] : NULL,
					'image'			=> $image,
					'file'			=> $file,
					'radio'			=> $radio,
					'select'		=> $select,
					'checkbox'		=> isset($data_ar['msf_checkbox']) && $data_ar['msf_checkbox'] ? __('Yes', 'plance') : __('No', 'plance'),
					'date_create'	=> time(),
				);

				$replace_row = array();
				foreach($insert_row as $k => $v)
				{
					$replace_row['{'.$k.'}'] = $v;
				}
				
				$wpdb -> insert(
					$wpdb -> prefix.'plance_msf_user',
					$insert_row,
					array('%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s','%s','%s', '%s', '%s', '%d', '%d')
				);
				

				wp_mail(
					array(
						$notification_ar['admin_name'].' <'.$notification_ar['admin_email'].'>',
					),
					$notification_ar['message_subject'],
					strtr($notification_ar['message_template'], $replace_row),
					array(
					'From: '.$notification_ar['noreply_name'].' <'.$notification_ar['noreply_email'].'>',
				));

				if($notification_ar['flash_message'])
				{
					Plance_Flash::instance() -> redirect('//'.Plance_Request::currentURL(), $notification_ar['flash_message']);
				}
				wp_redirect('//'.Plance_Request::currentURL());
				exit;
			}

			Plance_Registry::set('notification_ar', $notification_ar);
			Plance_Registry::set('Validate', $Validate);
			Plance_Registry::set('fields_ar',$fields_ar);
		});
		
		add_action('wp_head', 	function()
		{
			echo '<style>';
			echo '.plance-msa-form .r-field {width:90%}';
			echo '</style>';
		});
		
		add_filter('the_content', function ($content) {
			$notification_ar = Plance_Registry::get('notification_ar');
			if(strstr($content, '['.$notification_ar['shortcode_name'].']'))
			{
				return str_replace(
					'['.$notification_ar['shortcode_name'].']',
					Plance_View::get(Plance_Registry::get('path_to_plugin').'app/view/index/form', array(
						'Validate'	=> Plance_Registry::get('Validate'),
						'fields_ar'	=> Plance_Registry::get('fields_ar'),
					)), 
					$content
				);
			}
			return $content;
		});
    }
			
	//===========================================================
	// VALIDATE
	//===========================================================
	
	public static function validateBirthdayDayRequired($day)
	{
		return $day != 0;
	}
	
	public static function validateBirthdayMonthRequired($month)
	{
		return $month != 0;
	}
	
	public static function validateBirthdayYearRequired($year)
	{
		return $year != 0;
	}
	
	public static function validateBirthdayMin($day, $min)
	{
		return self::_getAge() >= $min;
	}
	
	public static function validateBirthdayMax($day, $max)
	{
		return self::_getAge() <= $max;
	}
	
	/********************************************************************************************************************/
	/************************************************* PRIVATE METHODS **************************************************/
	/********************************************************************************************************************/
	
	private static function _getAge()
	{
		$d = Plance_Request::post('msf_birthday_day', 0, 'int');
		$m = Plance_Request::post('msf_birthday_month', 0, 'int');
		$y = Plance_Request::post('msf_birthday_year', 0, 'int');
		
		if($m > date('m') || $m == date('m') && $d > date('d'))
		{
			return (date('Y') - $y - 1);
		}
		else
		{
			return (date('Y') - $y);
		}
	}
}