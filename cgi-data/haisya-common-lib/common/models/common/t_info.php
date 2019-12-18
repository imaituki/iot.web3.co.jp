<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * お知らせのモデル
 * 
 * @author ta-ando
 *
 */
class T_info extends Base_post_Model
{

	//var $site_type;  // 表示サイト

	var $post_link2;  // リンク2
	var $post_link_text2;  // リンク用テキスト2
	var $post_link3;  // リンク3
	var $post_link_text3;  // リンク用テキスト3



	//var $free_form_id;  // 申し込みフォーム

	var $annual;  // 年度


	var $event_start_date;  // 開催日
	var $event_date_text;  // 開催日補足テキスト
	var $event_time;  // 開催時間
	var $event_accept_end_date;  // 申し込み締め切り日
	var $event_place;  // 会場
	var $instructor;  // 講師
	var $target_person;  // 対象


	var $event_accept_flg;  // 募集有無


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

		//年月を指定
		if (isset($params['year_month']) && is_not_blank($params['year_month']))
		{
			$sql .= "
				AND DATE_FORMAT(MAIN.post_date, '%Y-%c') = ?
			";

			$value_array[] = $params['year_month'];
		}

		//年月を指定
		if (isset($params['accept_only']) && $params['accept_only'])
		{
			$sql .= "
				AND MAIN.event_accept_flg = ?
				AND (MAIN.event_accept_end_date >= CURRENT_DATE()
				     OR MAIN.event_accept_end_date IS NULL)
			";

			$value_array[] = Valid_flg::VALID;
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
	 * 月別アーカイブ表示用SQL
	 */
	function get_monthly_labels()
	{
		$value_array = array();

		$sql = "
			SELECT
				DATE_FORMAT(MAIN.post_date, '%Y-%c') as year_month_label
			FROM
				{$this->_table} AS MAIN
			WHERE
				MAIN.del_flg = ?
				AND MAIN.draft_flg = ?
				AND DATE(MAIN.post_date) <= CURRENT_DATE() 
				AND ( (DATE(MAIN.publish_end_date) >= CURRENT_DATE()) 
					OR (MAIN.publish_end_date IS NULL) )
			GROUP BY
				DATE_FORMAT(MAIN.post_date, '%Y-%c')
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = Draft_flg::NOT_DRAFT;

		/*
		 * ソート、件数を設定
		 */

		$nds_pagination = new Nds_pagination(FALSE);
		$nds_pagination->add_order('year_month_label', 'DESC');

		return $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}
}