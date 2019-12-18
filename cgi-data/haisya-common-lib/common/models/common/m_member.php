<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 会員のモデル
 * 
 * @author ta-ando
 *
 */
class M_member extends Base_post_Model
{
	var $email;  // メールアドレス
	var $password;  // パスワード
	var $name;  // 氏名
	var $furigana;  // フリガナ
	var $phone_number;  // 電話番号
	var $fax_number;  // FAX番号
	var $position;  // 役職等
	var $company_name;  // 企業・団体
	var $place;  // 住所
	var $member_type;  // 会員種別

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
		//キーワード検索の追加条件を作成する。
		$add_keyword_condition = array();
		$add_keyword_condition[] = 'MAIN.name LIKE ? ';
		$add_keyword_condition[] = 'MAIN.furigana LIKE ? ';

		//基本的なSQLとパラメータを生成する。
		$basic_query_ret = parent::create_query_for_manage($params, $add_keyword_condition);

		$sql = $basic_query_ret['sql'];
		$value_array = $basic_query_ret['value_array'];

		//会員種別
		if (isset($params['member_type']) && is_not_blank($params['member_type']))
		{
			$sql .= '
				AND MAIN.member_type = ?
			';

			$value_array[] = $params['member_type'];
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

		/*
		 * テーブル独自の条件があればセット
		 */

		// SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}

	/**
	 * メールアドレスが一致するユーザーが存在するかどうかを取得する
	 * 
	 * @param unknown_type $email
	 */
	function is_user_exists($email)
	{
		return $this->is_exists_by_params(array('email' => $email));
	}

	/**
	 * メールアドレスが一致するユーザーを取得する
	 * 
	 * @param unknown_type $email
	 */
	function find_by_email($email)
	{
		return $this->select_entity_by_params(array('email' => $email));
	}
}