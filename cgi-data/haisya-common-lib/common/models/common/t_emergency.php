<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 緊急時メッセージ用のモデル
 * 
 * @author ta-ando
 *
 */
class T_emergency extends Base_post_Model
{
	/**
	 * このクラスのモデルのインスタンスを生成して返す。
	 * ※このメソッドは実際にインスタンスを生成したいクラスに記述しないと機能しない。
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
}