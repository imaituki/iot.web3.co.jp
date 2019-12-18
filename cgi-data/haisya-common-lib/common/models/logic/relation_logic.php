<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 関連用のロジック
 * 
 * @author ta-ando
 *
 */
class Relation_logic extends Base_post_Model
{
	/**
	 * 営業所トピックスの関連製品リストを取得する
	 * 
	 * @param unknown_type $post_id
	 */
	function get_topic_related_item_entity_list($post_id)
	{
		return $this->T_relation->find_relation(
		                              Relation_data_type::TOPIC,
		                              $post_id,
		                              Relation_data_type::KUBUN,
		                              Kubun_type::ITEM
		                          );
	}

	/**
	 * 技術の関連製品を取得する
	 * 
	 * @param unknown_type $post_id
	 */
	function get_technic_related_item_entity_list($post_id)
	{
		return $this->T_relation->find_relation(
		                              Relation_data_type::TECHNIC,
		                              $post_id,
		                              Relation_data_type::KUBUN,
		                              Kubun_type::ITEM
		                          );
	}

	/**
	 * 特集の関連製品を取得する。
	 * 
	 * @param unknown_type $post_id
	 */
	function get_special_related_item_entity_list($post_id)
	{
		return $this->T_relation->find_relation(
		                              Relation_data_type::SPECIAL,
		                              $post_id,
		                              Relation_data_type::KUBUN,
		                              Kubun_type::ITEM
		                          );
	}

	/**
	 * 製品の関連製品を取得する
	 * 
	 * @param unknown_type $post_id
	 */
	function get_item_related_item_entity_list($post_id)
	{
		return $this->T_relation->find_relation(
		                              Relation_data_type::ITEM,
		                              $post_id,
		                              Relation_data_type::KUBUN,
		                              Kubun_type::ITEM
		                          );
	}

	/**
	 * 記事に紐付いた表を取得する
	 * 
	 * @param unknown_type $post_id
	 */
	function get_item_related_free_table_list($post_id)
	{
		return $this->T_relation->find_relation(
		                              Relation_data_type::ITEM_FREE,
		                              $post_id,
		                              Relation_data_type::KUBUN,
		                              Kubun_type::FREE_TABLE
		                          );
	}

	function get_limited_download_file_category_codes($item_id)
	{
		$kubun_entity = $this->V_relation_kubun->find_relation(
		                                             Relation_data_type::ITEM, 
		                                             $item_id, 
		                                             Kubun_type::LIMITED_DOWNLOAD_FILE
		                                         );
	}
}
