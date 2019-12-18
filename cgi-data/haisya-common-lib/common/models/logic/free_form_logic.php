<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 自由入力フォームのロジック
 * 
 * @author ta-ando
 *
 */
class Free_form_logic extends Base_post_Model
{
	/**
	 * 名前を取得する。
	 * 
	 * @param unknown_type $post_id
	 * @param unknown_type $full_label
	 */
	function get_name($post_id, $full_label = TRUE)
	{
		$entity = $this->T_free_form->find($post_id);

		if ($entity)
		{
			return ($full_label)
			         ? $entity->post_title ." ". $entity->post_sub_title
			         : $entity->post_title;
		}
		else
		{
			return '';
		}
	}

	/**
	 * ドロップダウン用のリストを取得する。
	 * 
	 * @param unknown_type $default_label
	 */
	function get_for_dropdown($default_label = '--')
	{
		$params = array();
		$params['id >'] = Free_form_const::MAIL_NEWS;	//指定したIDより後のもののみ。

		$list = $this->T_free_form->select_by_params($params, FALSE, $orderby_str = 'order_number DESC, id DESC');

		if (empty($list)) {
			return create_blank_first_list(array(), $default_label);
		}

		$ret = array();

		//戻り値用のリストを作成
		foreach ($list as $entity)
		{
			$ret[$entity->id] = $entity->post_title;
		}

		return create_blank_first_list($ret, $default_label);
	}
}