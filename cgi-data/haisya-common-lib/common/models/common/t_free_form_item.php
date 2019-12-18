<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 連携資料項目のモデル
 * 
 * @author ta-ando
 *
 */
class T_free_form_item extends Base_post_Model
{
	var $column_no;  // 項目番号
	var $column_type;  // 項目種別
	var $title;  // 項目名
	var $choices;  // 選択肢
	var $form_type;  // フォーム部品種別
	var $valid_flg;  // 有効フラグ
	var $require_flg;  // 必須フラグ

	/* カラムの追加があればここに記述 */

	/**
	 * このクラスのモデルのインスタンスを生成して返す
	 */
	public function create_model_instance()
	{
		return new self();
	}

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
		//基本的なSQLとパラメータを生成する。
		$basic_query_ret = parent::create_query_for_manage($params);

		$sql = $basic_query_ret['sql'];
		$value_array = $basic_query_ret['value_array'];

		/*
		 * テーブル独自の条件があればセット
		 */

		// SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}

	/**
	 * 公開画面用にSELECTを行うメソッド。
	 * $count_onlyフラグがTRUEの場合はSELECT COUNT(*)の結果を返す。
	 * 
	 * @param unknown_type $nds_pagination
	 * @param unknown_type $params
	 * @param unknown_type $count_only
	 */
	function select_for_front(Nds_pagination $nds_pagination, $params, $count_only = FALSE)
	{
		//基本的なSQLとパラメータを生成する。
		$basic_query_ret = parent::create_query_for_front($params);

		$sql = $basic_query_ret['sql'];
		$value_array = $basic_query_ret['value_array'];

		/*
		 * テーブル独自の条件があればセット
		 */

		// SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}

	/**
	 * 
	 * 
	 * @param unknown_type $free_form_id
	 * @param unknown_type $column_type
	 */
	public function find_list_by_form_id($free_form_id, $column_type) 
	{
		$params = array(
			"relation_data_type" => Relation_data_type::FREE_FORM,
			"relation_data_id" => $free_form_id,
			"column_type" => $column_type
		);
		
		return $this->select_by_params($params, FALSE, "order_number ASC");
	}
}