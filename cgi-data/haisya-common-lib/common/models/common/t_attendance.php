<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理画面-勤怠
 * 
 * @author ta-ando
 *
 */
class T_attendance extends Base_model 
{
	/** スタッフID */
	var $staff_id;

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
				MAIN.*,
                U.user_name,
                U.user_furigana
			FROM
				{$this->_table} AS MAIN
                LEFT JOIN m_user AS U ON U.id = MAIN.staff_id
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;

		//ユーザー名
		if (isset($params['user_name'])  && is_not_blank($params['user_name']))
		{
			$sql .= '
				AND U.user_name LIKE ?
			';

			$value_array[] = "%{$params['user_name']}%";
		}

		//ユーザー名（フリガナ）
		if (isset($params['user_furigana'])  && is_not_blank($params['user_furigana']))
		{
			$sql .= '
				AND U.user_furigana LIKE ?
			';

			$value_array[] = "%{$params['user_furigana']}%";
		}

		//出勤日
		if (isset($params['date'])  && is_not_blank($params['date']))
		{
			$sql .= '
				AND MAIN.datetime between ?
				AND ?
			';

			$value_array[] = "{$params['date']} 00:00:00";
			$value_array[] = "{$params['date']} 23:59:59";
		}

/*
		//アカウント種別
		if (isset($params['account_type']) && is_not_blank($params['account_type']))  
		{
			$sql .= '
				AND MAIN.account_type = ?
			';

			$value_array[] = $params['account_type'];
		}

		//除外するユーザーコード
		if (isset($params['ignore_user_codes']) && is_array_has_content($params['ignore_user_codes']))
		{
			$questions = get_question_str($params['ignore_user_codes']);

			$sql .= "
				AND MAIN.user_code NOT IN ({$questions})
			";

			$value_array = array_merge($value_array, $params['ignore_user_codes']);
		}
*/

		/*
		 * キーワードのLIKE検索。
		 * 巨大なAND句を作成し、その中に複数のLIKE句をORでつなげる。
		 */

		if (isset($params['keyword']) && is_not_blank($params['keyword']))
		{
			$keyword_array = explode_for_like($params['keyword']);

			//検索対象のカラムを追加する場合は$like_arrayに追加するだけでOK
			$like_array = array(
			    ' MAIN.user_name LIKE ? '
			);

			$merged_like = array();

			//SQLを生成するため単語数×カラム数だけOR句を生成
			for ($i = 0; $i < count($keyword_array); $i++)
			{
				$merged_like = array_merge($merged_like, $like_array);
			}

			//全てのLIKE句をORで繋げた文字列を作成
			$merged_like_str = implode(' OR ', $merged_like);

			$sql .= " 
				AND (
					{$merged_like_str}
				)
			";

			//検索ワードの数 * カラム数だけ?と置き換える列をセットする
			foreach ($keyword_array as $like_tmp)
			{
				$lise_str = $this->db->escape_like_str($like_tmp);

				for ($i = 0; $i < count($like_array); $i++)
				{
					$value_array[] = "%{$lise_str}%";
				}
			}
		}

		/*
		 * SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		 */

		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}

    /**
	 * レコードが存在するかどうかを取得する。
     *
     * del_flg = 0 のデータ全てを取得
     */
	function is_attendance_exists($staff_id, $timestamp)
	{
		$value_array = array();

        $start = date('Y-m-d', $timestamp) . ' 00:00:00';
        $end   = date('Y-m-d', $timestamp) . ' 23:59:59';

		$sql = "
			SELECT
				MAIN.id
			FROM
				{$this->_table} AS MAIN
			WHERE
				MAIN.del_flg = ?
                AND MAIN.staff_id = ?
                AND MAIN.datetime between ?
                AND ?
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = "{$staff_id}";
		$value_array[] = "{$start}";
		$value_array[] = "{$end}";

        $result = $this->db->query($sql, $value_array)->num_rows();

		return ($result > 0);
    }
/*
	function is_attendance_exists($staff_id, $timestamp)
	{
        $start = date('Y-m-d', $timestamp) . ' 00:00:00';
        $end   = date('Y-m-d', $timestamp) . ' 23:59:59';
		$result = $this->db
					->from($this->_table)
					->where('staff_id', $staff_id)
					->where('insert_datetime >=', $start)
					->where('insert_datetime <=', $end)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
    }
*/

    /**
	 * レコードが存在するかどうかを取得する。
     *
     * del_flg = 0 のデータ全てを取得
     */
	function is_attendance_exists_date($staff_id, $date)
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.id
			FROM
				{$this->_table} AS MAIN
			WHERE
				MAIN.del_flg = ?
                AND MAIN.staff_id = ?
                AND MAIN.datetime between ?
                AND ?
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = "{$staff_id}";
		$value_array[] = "{$date} 00:00:00";
		$value_array[] = "{$date} 23:59:59";

        $result = $this->db->query($sql, $value_array)->num_rows();

		return ($result > 0);
    }
/*
	function is_attendance_exists_date($staff_id, $date)
	{
        $start = $date . ' 00:00:00';
        $end   = $date . ' 23:59:59';
		$result = $this->db
					->from($this->_table)
					->where('staff_id', $staff_id)
					->where('insert_datetime >=', $start)
					->where('insert_datetime <=', $end)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
    }
*/

	/**
	 * レコードが存在するかどうかを取得する。（編集）
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $staff_id
	 * @param unknown_type $date
	 * @return true:存在する、false:存在しない
	 */
	function is_attendance_exists_date_edit($id, $staff_id, $date)
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.id
			FROM
				{$this->_table} AS MAIN
			WHERE
                MAIN.id <> ?
				AND MAIN.del_flg = ?
                AND MAIN.staff_id = ?
                AND MAIN.datetime between ?
                AND ?
		";

		$value_array[] = "{$id}";
		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = "{$staff_id}";
		$value_array[] = "{$date} 00:00:00";
		$value_array[] = "{$date} 23:59:59";

        $result = $this->db->query($sql, $value_array)->num_rows();

		return ($result > 0);
	}

}
