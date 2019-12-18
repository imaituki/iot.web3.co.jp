<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 関連紐付けテーブル
 * 
 * @author ta-ando
 *
 */
class T_relation extends Base_model
{
	var $parent_relation_data_type;  // 親の関連データタイプ
	var $parent_relation_data_id;  // 親の関連データID
	var $child_relation_data_type;  // 子の関連データタイプ
	var $child_kubun_type;
	var $child_relation_data_id;  // 子の関連データID

	/**
	 * 一括してDELETE/INSERTする処理。
	 * 要素：child_relation_data_id
	 * 削除条件：$parent_relation_data_typeの一致
	 *           && $parent_relation_data_idの一致
	 *           && $child_relation_data_typeの一致
	 *           && $child_kubun_typeの一致
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $parent_relation_data_id
	 * @param unknown_type $child_relation_data_type
	 * @param unknown_type $child_kubun_type
	 * @param unknown_type $child_relation_data_ids
	 */
	function delete_insert_list($parent_relation_data_type, $parent_relation_data_id, $child_relation_data_type, $child_kubun_type, $child_relation_data_ids)
	{
		//物理削除
		$this->delete_relation(
		           $parent_relation_data_type,
		           $parent_relation_data_id,
		           $child_relation_data_type,
		           $child_kubun_type
		       );

		if ( ! is_array_has_content($child_relation_data_ids)) 
		{
			return ;
		}

		foreach ($child_relation_data_ids as $child_id)
		{
			$attr_entity = new T_relation();
			$attr_entity->parent_relation_data_type = $parent_relation_data_type;
			$attr_entity->parent_relation_data_id = $parent_relation_data_id;
			$attr_entity->child_relation_data_type = $child_relation_data_type;
			$attr_entity->child_kubun_type = $child_kubun_type;
			$attr_entity->child_relation_data_id = $child_id;
			$attr_entity->insert();
		}
	}

	/**
	 * 一括してDELETEする処理。
	 * 条件：$parent_relation_data_typeの一致
	 *       && $parent_relation_data_idの一致
	 *       && $child_relation_data_typeの一致
	 *       && $child_kubun_typeの一致
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $parent_relation_data_id
	 * @param unknown_type $child_relation_data_type
	 * @param unknown_type $child_kubun_type
	 */
	function delete_relation($parent_relation_data_type, $parent_relation_data_id, $child_relation_data_type, $child_kubun_type)
	{
		$this->db->from($this->_table);
		$this->db->where('parent_relation_data_type', $parent_relation_data_type);
		$this->db->where('parent_relation_data_id', $parent_relation_data_id);
		$this->db->where('child_relation_data_type', $child_relation_data_type);
		$this->db->where('child_kubun_type', $child_kubun_type);
		$this->db->delete();
	}

	/**
	 * 一意のIDに紐付いているデータを一括して論理削除する処理。
	 * 条件：$parent_relation_data_typeの一致
	 *       && $parent_relation_data_idの一致
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $parent_relation_data_id
	 */
	function logical_delete_all_child_relation($parent_relation_data_type, $parent_relation_data_id)
	{
		$this->db->from($this->_table);
		$this->db->where('parent_relation_data_type', $parent_relation_data_type);
		$this->db->where('parent_relation_data_id', $parent_relation_data_id);
		$result = $this->db->get()->result();

		if ($result && ! empty($result))
		{
			foreach ($result as $entity)
			{
				$this->logical_delete($entity->id);
			}
		}
	}

	/**
	 * リストを取得する
	 * 要素：child_relation_data_id
	 * 条件：$parent_relation_data_typeの一致
	 *       && $parent_relation_data_idの一致
	 *       && $child_relation_data_typeの一致
	 *       && $child_kubun_typeの一致
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $parent_relation_data_id
	 * @param unknown_type $child_relation_data_type
	 * @param unknown_type $child_kubun_type
	 */
	function get_attribute_value_array($parent_relation_data_type, $parent_relation_data_id, $child_relation_data_type, $child_kubun_type)
	{
		$entity_list = $this->find_relation($parent_relation_data_type, $parent_relation_data_id, $child_relation_data_type, $child_kubun_type);

		if (empty($entity_list))
		{
			return FALSE;
		}

		$sub_attribute_code_array = array();

		foreach ($entity_list as $entity)
		{
			$sub_attribute_code_array[] = $entity->child_relation_data_id;
		}

		return $sub_attribute_code_array;
	}

	/**
	 * リストを取得する。
	 * 要素：エンティティ
	 * 要素：child_relation_data_id
	 * 条件：$parent_relation_data_typeの一致
	 *       && $parent_relation_data_idの一致
	 *       && $child_relation_data_typeの一致
	 *       && $child_kubun_typeの一致
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $parent_relation_data_id
	 * @param unknown_type $child_relation_data_type
	 * @param unknown_type $child_kubun_type
	 */
	function find_relation($parent_relation_data_type, $parent_relation_data_id, $child_relation_data_type, $child_kubun_type)
	{
		return $this->select_by_params(
		                  array(
		                      'parent_relation_data_type' => $parent_relation_data_type,
		                      'parent_relation_data_id' => $parent_relation_data_id,
		                      'child_relation_data_type' => $child_relation_data_type,
		                      'child_kubun_type' => $child_kubun_type,
		                  )
		              );
	}

	/**
	 * 一意となる条件でエンティティが存在するかどうかを取得する。
	 * 
	 * @param unknown_type $parent_relation_data_type
	 * @param unknown_type $parent_relation_data_id
	 * @param unknown_type $child_relation_data_type
	 * @param unknown_type $child_kubun_type
	 * @param unknown_type $child_relation_data_id
	 */
	function is_entity_exist($parent_relation_data_type, $parent_relation_data_id, $child_relation_data_type, $child_kubun_type, $child_relation_data_id)
	{
		return $this->is_exists_by_params(
		                  array(
		                      'parent_relation_data_type' => $parent_relation_data_type,
		                      'parent_relation_data_id' => $parent_relation_data_id,
		                      'child_relation_data_type' => $child_relation_data_type,
		                      'child_kubun_type' => $child_kubun_type,
		                      'child_relation_data_id' => $child_relation_data_id,
		                  )
		              );
	}
}