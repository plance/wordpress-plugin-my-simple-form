<?php

defined('ABSPATH') or die('No script kiddies please!');

/**
 * Create table
 */
class Plance_MSF_Helper_Table_User extends WP_List_Table
{
	public $url_page;
	
    /**
     * Подготавливаем колонки таблицы для их отображения
     *
     */
    public function prepare_items()
    {
		global $wpdb;
		
		/* Определяем общее количество записей в БД */
		$total_items = $wpdb -> get_var("
			SELECT COUNT(`id`)
			FROM `{$wpdb -> prefix}plance_msf_user`
			{$this -> _getSqlWhere()}
		");
		
		//Sets
		$per_page = $this -> get_items_per_page('pl_msf_per_page', 10);
		
		/* Устанавливаем данные для пагинации */
        $this -> set_pagination_args(array(
            'total_items' => $total_items,
            'per_page'    => $per_page
        ));

		/* Получаем данные для формирования таблицы */
        $data = $this -> table_data();
		
		$this -> _column_headers = $this -> get_column_info();
		
		/* Устанавливаем данные таблицы */
        $this -> items = $data;
    }
 
    /**
     * Название колонок таблицы
     *
     * @return array
     */
    public function get_columns()
    {
		$rows_ar		 = get_option('plance_msf_rows');
		
        return array(
			'cb'		 => '<input type="checkbox" />',
            'id'		 => __('ID', 'plance'),
            'name'		 => $rows_ar['name']['title'],
            'surname'	 => $rows_ar['surname']['title'],
            'company'	 => $rows_ar['company']['title'],
            'phone'		 => $rows_ar['phone']['title'],
            'email'		 => $rows_ar['email']['title'],
            'country'	 => $rows_ar['country']['title'],
            'city'		 => $rows_ar['city']['title'],
            'credit_card'=> $rows_ar['credit_card']['title'],
			'birthday'	 => $rows_ar['birthday']['title'],
            'date_create'=> __('Date create', 'plance'),
        );
    }
 
    /**
     * Массив названий колонок по которым выполняется сортировка
     *
     * @return array
     */
    public function get_sortable_columns()
    {
        return array(
			'id'			=> array('id', false),
			'name'			=> array('name', false),
			'surname'		=> array('surname', false),
			'company'		=> array('company', false),
			'birthday'		=> array('birthday', false),
			'country'		=> array('country', false),
			'city'			=> array('country', false),
			'date_create'	=> array('date_create', false),
		);
    }
 
    /**
     * Данные таблицы
     *
     * @return array
     */
    private function table_data()
    {
		global $wpdb;
		
		//Sets
		$per_page = $this -> get_pagination_arg('per_page');
		$order_ar = $this -> get_sortable_columns();
		$orderby = 'date_create';
		$order = 'DESC';
		
		if(isset($_GET['order']) && isset($order_ar[$_GET['order']]))
		{
			$orderby = $_GET['order'];
		}
		
		if(isset($_GET['order']))
		{
			$order = $_GET['order'] == 'asc' ? 'asc' : 'desc';
		}
		
		$sql = "SELECT *
			FROM `{$wpdb -> prefix}plance_msf_user`
			{$this -> _getSqlWhere()}
			ORDER BY `{$orderby}` {$order}
			LIMIT ".(($this -> get_pagenum() - 1) * $per_page).", {$per_page}
		";

        return $wpdb -> get_results($sql, ARRAY_A);
    }
 
	/**
	 * Отображается в случае отсутствии данных
	 */
	public function no_items()
	{
	  echo __('Data not found', 'plance');
	}
	
	/**
	 * Возвращает массив опций для групповых действий
	 * @return array
	 */
	function get_bulk_actions()
	{
		return array(
			'delete' => __('delete', 'plance'),
		);
	}
	
    /**
     * Возвращает содержимое колонки
     *
     * @param  array $item массив данных таблицы
     * @param  string $column_name название текущей колонки
     *
     * @return mixed
     */
    public function column_default($item, $column_name)
    {
        switch($column_name)
		{
			case 'id':
			case 'company':
			case 'phone':
			case 'email':
			case 'country':
			case 'city':
			case 'credit_card':
				return $item[$column_name] ? $item[$column_name] : '-';
        }
    }
	
	/**
	 * Создает чекбокс
	 * @param array $item
	 * @return string
	 */
	function column_cb($item)
	{
		return '<input type="checkbox" name="id[]" value="'.$item['id'].'" />';
	}
	
	public function column_name($item)
	{
		return '<a href="?page='.$this -> url_page.'&action=view&id='.$item['id'].'">'.($item['name'] ? $item['name'] : '-').'</a> '.$this -> row_actions(array(
			'delete' => '<a href="?page='.$this -> url_page.'&action=delete&id='.$item['id'].'">'.__('delete', 'plance').'</a>',
		));
	}
	
	public function column_surname($item)
	{
		return '<a href="?page='.$this -> url_page.'&action=view&id='.$item['id'].'">'.($item['surname'] ? $item['surname'] : '-').'</a> '.$this -> row_actions(array(
			'delete' => '<a href="?page='.$this -> url_page.'&action=delete&id='.$item['id'].'">'.__('delete', 'plance').'</a>',
		));
	}
	
	public function column_birthday($item)
	{
		return $item['birthday'] ? date(get_option('date_format', 'd.m.Y'), $item['birthday']) : ' - ';
	}
	
	public function column_date_create($item)
	{
		return date(get_option('date_format', 'd.m.Y').' '.get_option('time_format', 'H:i'), $item['date_create']);
	}
	
	/********************************************************************************************************************/
	/************************************************* PRIVATE METHODS **************************************************/
	/********************************************************************************************************************/
	
	/**
	 * Get "where" for sql
	 * @global wpdb $wpdb
	 * @return string
	 */
	private function _getSqlWhere()
	{
		global $wpdb;
		
		$where = '';
		
		if(isset($_GET['s']) && $_GET['s'])
		{
			$where = 'WHERE '.join(' OR ', array(
				"`title` LIKE  '%".$wpdb -> _real_escape($_GET['s'])."%'",
				"`meta_title` LIKE  '%".$wpdb -> _real_escape($_GET['s'])."%'",
				"`meta_description` LIKE  '%".$wpdb -> _real_escape($_GET['s'])."%'",
				"`url` LIKE  '%".$wpdb -> _real_escape($_GET['s'])."%'",
				"`description` LIKE  '%".$wpdb -> _real_escape($_GET['s'])."%'",
			));
		}
		
		return $where;
	}
}