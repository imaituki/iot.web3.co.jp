<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 関係テーブルに区分マスタをINNER JOIN したVIEW。
 * 
 * @author ta-ando
 *
 */
class V_relation_kubun extends Base_model 
{
	/**
	 * リストを取得する。
	 * 要素：エンティティ
	 * 要素：child_relation_data_id
	 * 条件：$parent_relation_data_typeの一致
	 *       && $parent_relation_data_idの一致
	 *       && $child_kubun_typeの一致
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $parent_relation_data_id
	 * @param unknown_type $child_kubun_type
	 */
	function find_relation($parent_relation_data_type, $parent_relation_data_id, $child_kubun_type)
	{
		return $this->select_by_params(
		                  array(
		                      'parent_relation_data_type' => $parent_relation_data_type,
		                      'parent_relation_data_id' => $parent_relation_data_id,
		                      'child_kubun_type' => $child_kubun_type,
		                  )
		              );
	}

	/**
	 * エンティティを取得する。
	 * データが1対1で関連付けられている保証がある場合に使用してください。
	 * 要素：child_relation_data_id
	 * 条件：$parent_relation_data_typeの一致
	 *       && $parent_relation_data_idの一致
	 *       && $child_kubun_typeの一致
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $parent_relation_data_id
	 * @param unknown_type $child_kubun_type
	 */
	function find_relation_entity($parent_relation_data_type, $parent_relation_data_id, $child_kubun_type)
	{
		return $this->select_entity_by_params(
		                  array(
		                      'parent_relation_data_type' => $parent_relation_data_type,
		                      'parent_relation_data_id' => $parent_relation_data_id,
		                      'child_kubun_type' => $child_kubun_type,
		                  )
		              );
	}

	/**
	 * リストを取得する。
	 * $parent_relation_data_idを指定していないので、親テーブルのレコードが複数取得される。
	 * 要素：エンティティ
	 * 条件：$parent_relation_data_typeの一致
	 *       && $child_kubun_typeの一致
	 *       && $kubun_codeの一致
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $child_kubun_type
	 * @param unknown_type $kubun_code
	 */
	function get_list_by_kubun_code($parent_relation_data_type, $child_kubun_type, $kubun_code)
	{
		return $this->select_by_params(
		                  array(
		                      'parent_relation_data_type' => $parent_relation_data_type, 
		                      'child_kubun_type' => $child_kubun_type,
		                      'kubun_code' => $kubun_code,
		                  )
		              );
	}

	/**
	 * エンティティを取得する。
	 * $parent_relation_data_idを指定していないので、本来は親テーブルのレコードが複数取得されるが、
	 * このメソッドではそのうち1件のみを取得する。
	 * ※1件のみの取得で整合性が取れる場合にのみ使用すること。
	 * 例）固定ページなど
	 * 条件：$parent_relation_data_typeの一致
	 *       && $child_kubun_typeの一致
	 *       && $kubun_codeの一致
	 *       
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $child_kubun_type
	 * @param unknown_type $kubun_code
	 */
	function get_one_entity_by_kubun_code($parent_relation_data_type, $child_kubun_type, $kubun_code)
	{
		return $this->select_entity_by_params(
		                  array(
		                      'parent_relation_data_type' => $parent_relation_data_type, 
		                      'child_kubun_type' => $child_kubun_type,
		                      'kubun_code' => $kubun_code,
		                  )
		              );
	}

	/**
	 * 区分値を配列として取得する。
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $parent_relation_data_id
	 * @param unknown_type $child_kubun_type
	 */
	public function get_labels($parent_relation_data_type, $parent_relation_data_id, $child_kubun_type)
	{
		$relation_kubun_entities = $this->find_relation(
		                                      $parent_relation_data_type,
		                                      $parent_relation_data_id,
		                                      $child_kubun_type
		                                  );

		if ( ! $relation_kubun_entities)
		{
			return '';
		}

		$labels = array();

		foreach ($relation_kubun_entities as $relation_kubun_entity)
		{
			$labels[] = $relation_kubun_entity->kubun_value;
		}

		return $labels;
	}

	/**
	 * 区分値をデリミタで連結して取得する。
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $parent_relation_data_id
	 * @param unknown_type $child_kubun_type
	 * @param unknown_type $glue
	 */
	public function get_joined_labels($parent_relation_data_type, $parent_relation_data_id, $child_kubun_type, $glue = ',')
	{
		$labels = $this->V_relation_kubun->get_labels(
				                                       $parent_relation_data_type,
				                                       $parent_relation_data_id,
				                                       $child_kubun_type
				                                   );

		return implode($glue, $labels);
	} 
}