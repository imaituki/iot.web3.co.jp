<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 区分マスタ
 * 
 * @author ta-ando
 *
 */
class M_kubun extends Base_model 
{
	var $relation_data_type;  // 関連データタイプ
	var $kubun_type;  // 区分種別
	var $kubun_code;  // コード(自動採番ではない区分コード)
	var $kubun_value;  // 区分値
	var $description;  // 詳細
	var $valid_flg;  // 有効フラグ
	var $delete_forbidden_flg;  // 削除不可フラグ
	var $order_number;	//ソート順
	var $icon_file_name;	//アイコンファイル名
	var $icon_file_name2;	//アイコンファイル名2

	/**
	 * 管理画面用にSELECTを行うメソッド。
	 * $count_onlyフラグがTRUEの場合はSELECT COUNT(*)の結果を返す。
	 * 
	 * @param unknown_type $nds_pagination
	 * @param unknown_type $params
	 * @param unknown_type $count_only
	 */
	function select_for_manage(Nds_pagination $nds_pagination, $params, $count_only = FALSE)
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.*
			FROM
				{$this->_table} AS MAIN
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;

		//id
		if (isset($params['id']) && is_not_blank($params['id']))
		{
			$sql .= '
				AND MAIN.id = ?
			';

			$value_array[] = $params['id'];
		}

		//公開/非公開
		if (isset($params['draft_flg']) && is_not_blank($params['draft_flg']))
		{
			$sql .= '
				AND MAIN.draft_flg = ?
			';

			$value_array[] = $params['draft_flg'];
		}

		// 関連データ種別
		if (isset($params['kubun_relation_data_type']) && is_not_blank($params['kubun_relation_data_type']))
		{
			$sql .= '
				AND MAIN.relation_data_type = ?
			';

			$value_array[] = $params['kubun_relation_data_type'];
		}

		// 区分種別
		if (isset($params['kubun_type']) && is_not_blank($params['kubun_type']))
		{
			$sql .= '
				AND MAIN.kubun_type = ?
			';

			$value_array[] = $params['kubun_type'];
		}

		/*
		 * SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		 */

		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}

	/**
	 * エンティティを取得する。
	 * idのみでの検索を他のカラムを同時に条件とすることで厳密にしている。
	 * 条件：関連データ種別、区分種別、idの一致
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $id
	 */
	public function find_by_id($relation_data_type, $kubun_type, $id) 
	{
		return $this->select_entity_by_params(
		                  array(
		                      'id' => $id,
		                      'relation_data_type' => $relation_data_type,
		                      'kubun_type' => $kubun_type,
		                  )
		              );
	}

	/**
	 * idのリストを元にエンティティのリストを取得する。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $kubun_ids
	 */
	public function find_by_ids($relation_data_type, $kubun_type, $kubun_ids)
	{
		if (is_blank($kubun_ids)) 
		{
			return array();
		}

		$tmp_ids = is_array($kubun_ids) 
			       ? $kubun_ids
			       : array($kubun_ids);

		$ret_list = array();

		foreach ($tmp_ids as $id)
		{
			$entity = $this->find_by_id($relation_data_type, $kubun_type, $id);

			if ($entity) 
			{
				$ret_list[] = $entity;
			}
		}

		return $ret_list;
	}

	/**
	 * エンティティを取得する
	 * 条件：区分コードの一致
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $kubun_code
	 */
	public function find_by_kubun_code($relation_data_type, $kubun_type, $kubun_code) 
	{
		return $this->select_entity_by_params(
		                  array(
		                      'kubun_code' => $kubun_code,
		                      'relation_data_type' => $relation_data_type,
		                      'kubun_type' => $kubun_type,
		                  )
		              );
	}

	/**
	 * リストを取得する
	 * 要素：エンティティ
	 * 条件：区分種別の一致
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 */
	public function find_by_kubun_type($relation_data_type, $kubun_type) 
	{
		return $this->select_by_params(
		                  array(
		                      'relation_data_type' => $relation_data_type,
		                      'kubun_type' => $kubun_type,
		                  ),
		                  FALSE, 
		                  'order_number ASC, kubun_code ASC'
		              );
	}

	/**
	 * 指定した区分の有効でないデータも含めてリストを取得する。
	 * 条件：関連データ種別、区分種別の一致
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 */
	private function _get_all_list($relation_data_type, $kubun_type) 
	{
		return $this->select_by_params(
		                  array(
		                      'relation_data_type' => $relation_data_type,
		                      'kubun_type' => $kubun_type,
		                  ),
		                  FALSE,
		                  'order_number ASC, kubun_code ASC'
		              );
	}

	/**
	 * 指定した区分有効なデータのみのリストを取得する。
	 * 条件：関連データ種別、区分種別の一致
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 */
	private function _get_valid_list($relation_data_type, $kubun_type) 
	{
		return $this->select_by_params(
		                  array(
		                      'relation_data_type' => $relation_data_type,
		                      'kubun_type' => $kubun_type,
		                      'valid_flg' => Valid_flg::VALID,
		                  ),
		                  FALSE,
		                  'order_number ASC, kubun_code ASC'
		              );
	}

	/**
	 * $key=>$value形式のリストを取得する。
	 * $keyとなるカラムを引数で指定可能。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $enable_only
	 * @param unknown_type $key_column
	 */
	function get_key_value_list($relation_data_type, $kubun_type, $enable_only = TRUE, $key_column = 'id')
	{
		$list = ($enable_only === TRUE)
		        ? $this->_get_valid_list($relation_data_type, $kubun_type)
		        : $this->_get_all_list($relation_data_type, $kubun_type);

		if (empty($list)) {
			return FALSE;
		}

		//戻り値用のリストを作成
		foreach ($list as $entity)
		{
			$ret[$entity->$key_column] = $entity->kubun_value;
		}

		return $ret;
	}

	/**
	 * リストを取得する。
	 * 要素：key(kubun_code) => value(name)
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $valid_only
	 */
	function get_key_value_list_by_kubun_code($relation_data_type, $kubun_type, $valid_only = TRUE)
	{
		//カラム名のみ指定して委譲
		return $this->get_key_value_list($relation_data_type, $kubun_type, $valid_only, 'kubun_code');
	}

	/**
	 * ドロップダウン用のリストを取得する。
	 * 要素：key(id) => value(name)
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $blank_label
	 * @param unknown_type $valid_only
	 */
	function get_for_dropdown($relation_data_type, $kubun_type, $blank_label = '--', $valid_only = TRUE)
	{
		return create_blank_first_list(
		           $this->get_key_value_list(
		                      $relation_data_type,
		                      $kubun_type,
		                      $valid_only
		                  ),
		           $blank_label
		           );
	}

	/**
	 * keyがkubun_codeであるドロップダウン用のリストを取得する。
	 * 要素：key(kubun_code) => value(name)
	 * ※1要素目は '' => '--'
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $valid_only
	 */
	function get_for_dropdown_by_kubun_code($relation_data_type, $kubun_type, $valid_only = TRUE)
	{
		return create_blank_first_list(
		           $this->get_key_value_list_by_kubun_code(
		                      $relation_data_type,
		                      $kubun_type,
		                      $valid_only
		                  )
		           );
	}

	/**
	 * 区分管理画面で使用するドロップダウン用のリストを取得する。
	 * idだけでの区分かを分かるようにラベルを加工している。
	 * @return string
	 */
	function get_for_dropdown_for_manage()
	{
		$tmp = array();
		$tmp[''] = '--';

		$list = $this->find_all();

		if ( ! $list)
		{
			return $tmp;
		}

		foreach ($list as $entity)
		{
			$relation = Relation_data_type::get_label($entity->relation_data_type);
			$kubun = Kubun_type::get_label($entity->kubun_type);

			$tmp[$entity->id] =  "{$relation}_{$kubun}_{$entity->kubun_value}";
		}

		return $tmp;
	}

	/**
	 * kubun_valueを取得する。
	 * 条件：idの一致
	 * 
	 * @param unknown_type $id
	 */
	function get_label_by_id($relation_data_type, $kubun_type, $id)
	{
		$ret = $this->find_by_id($relation_data_type, $kubun_type, $id);

		return ($ret !== FALSE) 
		       ? $ret->kubun_value 
		       : '';
	}

	/**
	 * kubun_valueを取得する。
	 * 条件：kubun_codeの一致
	 * 
	 * @param unknown_type $id
	 */
	function get_label_by_kubun_code($relation_data_type, $kubun_type, $kubun_code)
	{
		$ret = $this->find_by_kubun_code($relation_data_type, $kubun_type, $kubun_code);

		return ($ret !== FALSE) 
		       ? $ret->kubun_value 
		       : '';
	}

	/**
	 * idの配列をラベルの配列に変換した配列を取得する
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $kubun_ids
	 */
	public function convert_list_to_label_list($relation_data_type, $kubun_type, $kubun_ids)
	{
		if (is_blank($kubun_ids)) 
		{
			return array();
		}

		$tmp_ids = is_array($kubun_ids) 
			       ? $kubun_ids
			       : array($kubun_ids);

		$tmp_labels = array();

		foreach ($tmp_ids as $id)
		{
			$tmp_label = $this->get_label_by_id($relation_data_type, $kubun_type, $id);

			if (is_not_blank($tmp_label)) 
			{
				$tmp_labels[] = $tmp_label;
			}
		}

		return $tmp_labels;
	}

	/**
	 * 区分コードの配列をラベルの配列に変換した配列を取得する
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $kubun_ids
	 */
	public function convert_kubun_codes_to_labels($relation_data_type, $kubun_type, $kubun_codes)
	{
		if (is_blank($kubun_codes)) 
		{
			return array();
		}

		$tmp_codes = is_array($kubun_codes) 
			       ? $kubun_codes
			       : array($kubun_codes);

		$tmp_labels = array();

		foreach ($tmp_codes as $kubun_code)
		{
			$tmp_label = $this->get_label_by_kubun_code($relation_data_type, $kubun_type, $kubun_code);

			if (is_not_blank($tmp_label)) 
			{
				$tmp_labels[] = $tmp_label;
			}
		}

		return $tmp_labels;
	}

	/**
	 * idの配列をもとに区分コードのリストを取得する。
	 * 要素：区分コード
	 * 条件：idが一致するもの
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $kubun_ids
	 */
	public function convert_id_list_to_kubun_code_list($relation_data_type, $kubun_type, $kubun_ids)
	{
		if (is_blank($kubun_ids)) 
		{
			return array();
		}

		//配列でなければ配列に変換
		$temp_ids = is_array($kubun_ids) 
			       ? $kubun_ids
			       : array($kubun_ids);

		$ret = array();

		foreach ($temp_ids as $id)
		{
			$temp_kubun_code = $this->get_kubun_code($relation_data_type, $kubun_type, $id);

			if (is_not_blank($temp_kubun_code)) 
			{
				$ret[] = $temp_kubun_code;
			}
		}

		return $ret;
	}

	/**
	 * 区分コードの配列をidの配列に変換した配列を取得する
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $kubun_codes
	 */
	public function convert_kubun_codes_to_ids($relation_data_type, $kubun_type, $kubun_codes)
	{
		if (is_blank($kubun_codes)) 
		{
			return array();
		}

		$tmp_codes = is_array($kubun_codes) 
			       ? $kubun_codes
			       : array($kubun_codes);

		$tmp_ids = array();

		foreach ($tmp_codes as $kubun_code)
		{
			$tmp_id = $this->convert_kubun_code_to_id($relation_data_type, $kubun_type, $kubun_code);

			if (is_not_blank($tmp_id)) 
			{
				$tmp_ids[] = $tmp_id;
			}
		}

		return $tmp_ids;
	}

	/**
	 * idのリストを渡して取得した区分値のリストをデリミタで連結して取得する。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $kubun_ids
	 * @param unknown_type $glue
	 */
	public function get_joined_label($relation_data_type, $kubun_type, $kubun_ids, $glue = ', ')
	{
		$label_array = $this->convert_list_to_label_list($relation_data_type, $kubun_type, $kubun_ids);
		return implode($glue, $label_array);
	}

	/**
	 * 区分コードのリストを渡して取得した区分値のリストをデリミタで連結して取得する。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $kubun_codes
	 * @param unknown_type $glue
	 */
	public function get_joined_label_by_kubun_codes($relation_data_type, $kubun_type, $kubun_codes, $glue = ', ')
	{
		$label_array = $this->convert_kubun_codes_to_labels($relation_data_type, $kubun_type, $kubun_codes);
		return implode($glue, $label_array);
	}

	/**
	 * IDを区分コードに変換して取得する。
	 * 条件：区分コードの一致
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $kubun_code
	 */
	public function convert_kubun_code_to_id($relation_data_type, $kubun_type, $kubun_code)
	{
		$entity = $this->find_by_kubun_code($relation_data_type, $kubun_type, $kubun_code);

		return ($entity)
		       ? $entity->id
		       : FALSE;
	}

	/**
	 * 区分コードをIDに変換して取得する。
	 * 条件：IDの一致
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $kubun_type
	 * @param unknown_type $kubun_code
	 */
	public function convert_id_to_kubun_code($relation_data_type, $kubun_type, $id)
	{
		$entity = $this->find_by_id($relation_data_type, $kubun_type, $id);

		return ($entity)
		       ? $entity->kubun_code
		       : FALSE;
	}

	/**
	 * 親子関係のあるカテゴリーを親子関係を保った配列として取得する。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $parent_kubun_type
	 * @param unknown_type $child_kubun_type
	 */
	public function get_parent_child_list($relation_data_type, $parent_kubun_type, $child_kubun_type)
	{
		$parent_category_list = $this->find_by_kubun_type(
		                                     $relation_data_type,
		                                     $parent_kubun_type
		                                 );

		$child_category_list = $this->find_by_kubun_type(
		                                     $relation_data_type,
		                                     $child_kubun_type
		                                 );

		$ret_list = array();

		foreach ($parent_category_list as $parent_entity)
		{
			$child_element = array();
			$child_list = array();

			foreach ($child_category_list as $child_entity)
			{
				if ($parent_entity->id === $child_entity->parent_kubun_id)
				{
					$child_list[] = $child_entity;
				}
			}

			$child_element['parent_entity'] = $parent_entity;
			$child_element['child_list'] = $child_list;

			$ret_list["id_{$parent_entity->id}"] = $child_element;
		}

		return $ret_list;
	}

	/**
	 * 親子関係のあるカテゴリーの子カテゴリーのラベルを親子関係を保った配列として取得する。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $parent_kubun_type
	 * @param unknown_type $child_kubun_type
	 * @param unknown_type $child_kubun_ids
	 */
	public function get_parent_child_labels($relation_data_type, $parent_kubun_type, $child_kubun_type, $child_kubun_ids)
	{
		$parent_category_list = $this->find_by_kubun_type(
		                                     $relation_data_type,
		                                     $parent_kubun_type
		                                 );

		$ret_list = array();

		$input_ids_entity_list = $this->find_by_ids(
		                                    $relation_data_type,
		                                    $child_kubun_type,
		                                    $child_kubun_ids
		                                );

		//$key_value_list = array();

		foreach ($parent_category_list as $parent_entity)
		{
			$child_element = array();
			$child_list = array();

			foreach ($input_ids_entity_list as $child_entity)
			{
				if ($parent_entity->id === $child_entity->parent_kubun_id)
				{
					$child_list[] = $child_entity->kubun_value;
				}
			}

			$child_element['parent_entity'] = $parent_entity;
			$child_element['child_label_list'] = $child_list;

			$ret_list["id_{$parent_entity->id}"] = $child_element;
		}

		return $ret_list;
	}
}