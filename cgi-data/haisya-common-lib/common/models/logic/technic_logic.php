<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 技術情報用のロジック
 * 
 * @author ta-ando
 *
 */
class Technic_logic extends Base_post_Model
{
	/**
	 * カテゴリー名を取得する。
	 * 
	 * @param unknown_type $kubun_code 区分コード or 区分コードの配列
	 */
	function get_topic_category_name($kubun_code)
	{
		return $this->M_kubun->get_joined_label_by_kubun_codes(
		                           Relation_data_type::TECHNIC,
		                           Kubun_type::CATEGORY,
		                           $kubun_code
		                       );
	}
}