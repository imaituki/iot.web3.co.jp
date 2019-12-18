<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 応募テーブル
 * 
 * @author ta-ando
 *
 */
class T_apply extends Base_post_Model 
{
	var $free_form_id;

	var $name;
	var $company_name;
	var $position;
	var $furigana;
	var $email;
	var $postal_code1;
	var $postal_code2;
	var $place;
	var $phone_number;
	var $other_inquiry;
	var $optional_form1;
	var $optional_form2;
	var $optional_form3;
	var $optional_form4;
	var $optional_form5;
	var $optional_form6;
	var $optional_form7;
	var $optional_form8;
	var $optional_form9;
	var $optional_form10;
	var $optional_form11;
	var $optional_form12;
	var $optional_form13;
	var $optional_form14;
	var $optional_form15;
	var $optional_form16;
	var $optional_form17;
	var $optional_form18;
	var $optional_form19;
	var $optional_form20;
	var $optional_form21;
	var $optional_form22;
	var $optional_form23;
	var $optional_form24;
	var $optional_form25;
	var $optional_form26;
	var $optional_form27;
	var $optional_form28;
	var $optional_form29;
	var $optional_form30;

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

		//フォームを指定
		if (isset($params['free_form_id']) && is_not_blank($params['free_form_id']))
		{
			$sql .= "
				AND MAIN.free_form_id = ?
			";

			$value_array[] = $params['free_form_id'];
		}

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

		//年月を指定
		if (isset($params['year_month']) && is_not_blank($params['year_month']))
		{
			$sql .= "
				AND DATE_FORMAT(MAIN.post_date, '%Y-%c') = ?
			";

			$value_array[] = $params['year_month'];
		}

		/*
		 * テーブル独自の条件があればセット
		 */

		// SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}
}