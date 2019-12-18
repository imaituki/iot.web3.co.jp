<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 製品の表用のロジック
 * 
 * @author ta-ando
 *
 */
class Item_free_table_logic extends Base_post_Model
{
	/**
	 * 名前を取得する。
	 * 
	 * @param unknown_type $post_id
	 */
	function get_name($post_id)
	{
		$entity = $this->T_item_free_table->find($post_id);

		return ($entity)
		       ? $entity->post_title
		       : '';
	}

	/**
	 * ドロップダウン用のリストを取得する。
	 * 
	 * @param unknown_type $default_label
	 */
	function get_for_dropdown($default_label = '--')
	{
		$params = array(
			'relation_data_type' => $this->application_session_data->get_relation_data_type($this->package_name),
			'relation_data_id' => $this->application_session_data->get_relation_data_id($this->package_name)
		);

		return $this->T_item_free_table->create_dropdown_list_with_blank(
		                                     $default_label,
		                                     'id',
		                                     'post_title',
		                                     $params
		                                 );
	}
}