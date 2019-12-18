<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 特集用のロジック
 * 
 * @author ta-ando
 *
 */
class Special_logic extends Base_post_Model
{
	/**
	 * 最新の特集記事のカテゴリーコードを取得する。
	 * 
	 */
	function get_latest_post_category_code()
	{
		/*
		 * 登録日が最新の1件を取得する。
		 */

		$params = array();

		$nds_pagination = new Nds_pagination(1);
		$nds_pagination->add_order('post_date', 'DESC')
		               ->add_order('id', 'DESC');

		$list = $this->T_special->simple_select_for_front($params, $nds_pagination);

		/*
		 * カテゴリーの区分コードを取得
		 */

		if ( ! empty($list))
		{
			$kubun_entity = $this->V_relation_kubun->find_relation_entity(
			                                           Relation_data_type::SPECIAL,
			                                           $list[0]->id,
			                                           Kubun_type::CATEGORY
			                                       );

			return $kubun_entity
			       ? $kubun_entity->kubun_code
			       : FALSE;                         
		}
	}

	/**
	 * カテゴリー名を取得する。
	 * 
	 * @param unknown_type $kubun_code 区分コード or 区分コードの配列
	 */
	function get_topic_category_name($kubun_code)
	{
		return $this->M_kubun->get_joined_label_by_kubun_codes(
		                           Relation_data_type::SPECIAL,
		                           Kubun_type::CATEGORY,
		                           $kubun_code
		                       );
	}
}