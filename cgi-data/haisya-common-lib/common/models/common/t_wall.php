<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理画面の行動ログテーブル
 * 
 * @author ta-ando
 *
 */
class T_wall extends Base_model 
{
	var $service_code;
	var $update_menu;
	var $update_data_id;
	var $update_user_code;
	var $post_date;

	/**
	 * LIMIT / OFFSET を使用してSELECTする
	 * 
	 * @param unknown_type $paging_array
	 * @param unknown_type $params
	 * @param unknown_type $count_only
	 */
	function select_limit_offset($paging_array, $params, $count_only = FALSE)
	{
		$this->db->from($this->_table);
		$this->db->where('del_flg', Del_flg::NOT_DELETE);

		if ( ! $count_only)
		{
			$this->db->limit($paging_array['limit'], $paging_array['offset']);
			$this->db->order_by($paging_array['order_by_array']);
			return $this->db->get()->result();
		}
		else
		{
			return $this->db->count_all_results();
		}
	}
}