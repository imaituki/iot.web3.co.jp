<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 区分値のロジック
 * 
 * @author ta-ando
 *
 */
class Kubun_logic extends Base_post_Model
{
	/**
	 * 区分値のドロップダウン用のリストを取得する。
	 * 
	 * @param unknown_type $kubun_type
	 * @param unknown_type $blank_label
	 */
	function get_common_kubun_list_dropdown($kubun_type, $blank_label = '--')
	{
		return $this->M_kubun->get_for_dropdown(
		                           Relation_data_type::COMMON,
		                           $kubun_type,
		                           $blank_label
		                       );
	}

	/**
	 * 区分値のチェックボックス用のリストを取得する。
	 * 
	 * @param unknown_type $kubun_type
	 */
	function get_common_kubun_list_checkbox($kubun_type)
	{
		return $this->M_kubun->get_key_value_list(
		                           Relation_data_type::COMMON,
		                           $kubun_type
		                       );
	}

	/**
	 * 区分値のチェックボックス用のリスト(区分コードがキー)を取得する。
	 * 
	 * @param unknown_type $kubun_type
	 */
	function get_common_kubun_list_checkbox_for_front($kubun_type)
	{
		return $this->M_kubun->get_key_value_list_by_kubun_code(
		                           Relation_data_type::COMMON,
		                           $kubun_type
		                       );
	}

	/**
	 * プログラムに関連付いた区分値のチェックボックス用のリスト(区分コードがキー)を取得する。
	 * 
	 * @param unknown_type $kubun_type
	 */
	function get_program_kubun_list_checkbox_for_front($kubun_type)
	{
		return $this->M_kubun->get_key_value_list_by_kubun_code(
		                           Relation_data_type::PROGRAM,
		                           $kubun_type
		                       );
	}

	/**
	 * 区分のラベルを作成する
	 * 
	 * @param unknown_type $kubun_type
	 * @param unknown_type $array_values
	 */
	function get_common_kubun_label($kubun_type, $array_values)
	{
		return $this->M_kubun->get_joined_label(
			                       Relation_data_type::COMMON,
			                       $kubun_type,
			                       $array_values
			                   );
	}

	/**
	 * 区分のラベルを作成する
	 * 
	 * @param unknown_type $kubun_type
	 * @param unknown_type $array_values
	 */
	function get_common_kubun_label_by_kubun_code($kubun_type, $array_values)
	{
		return $this->M_kubun->get_joined_label_by_kubun_codes(
			                       Relation_data_type::COMMON,
			                       $kubun_type,
			                       $array_values
			                   );
	}

	/**
	 * 関係テーブルから物件の区分情報を取得する。
	 * 
	 * @param unknown_type $post_id
	 * @param unknown_type $kubun_type
	 */
	function get_common_kubun($post_id, $kubun_type)
	{
		return $this->T_relation->get_attribute_value_array(
		                              Relation_data_type::COMMON,
			                          $post_id,
			                          Relation_data_type::KUBUN,
			                          $kubun_type
			                      );
	}

	/**
	 * お知らせに関連付いた区分値のチェックボックス用のリスト(区分コードがキー)を取得する。
	 * 
	 * @param unknown_type $kubun_type
	 */
	function get_info_kubun_list_checkbox_for_front($kubun_type)
	{
		return $this->M_kubun->get_key_value_list_by_kubun_code(
		                           Relation_data_type::INFO,
		                           $kubun_type
		                       );
	}
}