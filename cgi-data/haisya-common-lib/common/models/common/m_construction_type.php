<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理画面-工種マスタのモデル
 * 
 * @author ta-ando
 *
 */
class M_construction_type extends Base_model 
{
	/** 工種コード */
	var $construction_type_code;

	/** 分類ID */
	var $construction_category_id;

	/** 工種名 */
	var $construction_type_name;

	/** ID */
	//var $construction_type_id;

	/**
	 * 同じ工種コードのレコードが存在するかどうかを取得する。（登録）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_type_code
	 * @return true:存在する、false:存在しない
	 */
	function is_construction_type_code_exists($construction_type_code)
	{
        //工種コード
        if( $construction_type_code == "" ){
            throw new Exception("There is no construction_type_code");
        }
        if( !is_numeric($construction_type_code) ){
            throw new Exception("construction_type_code is not numeric value, ".$construction_type_code);
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('construction_type_code', $construction_type_code)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}
	/**
	 * 同じ工種コードのレコードが存在するかどうかを取得する。（編集）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_type_code
	 * @param unknown_type $construction_type_id
	 * @return true:存在する、false:存在しない
	 */
	function is_construction_type_code_exists_edit($construction_type_code, $construction_type_id)
	{
        //工種コード
        if( $construction_type_code == "" ){
            throw new Exception("There is no construction_type_code");
        }
        if( !is_numeric($construction_type_code) ){
            throw new Exception("construction_type_code is not numeric value, ".$construction_type_code);
        }
        //ID
        if( $construction_type_id == "" ){
            throw new Exception("There is no construction_type_id");
        }
        if( !is_numeric($construction_type_id) ){
            throw new Exception("construction_type_id is not numeric value, ".$construction_type_id);
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('construction_type_code', $construction_type_code)
					->where('id !=', $construction_type_id)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}

	/**
	 * 同じ工種名のレコードが存在するかどうかを取得する。（登録）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_type_name
	 * @return true:存在する、false:存在しない
	 */
	function is_construction_type_name_exists($construction_type_name)
	{
        //工種名
        if( $construction_type_name == "" ){
            throw new Exception("There is no construction_type_name");
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('construction_type_name', $construction_type_name)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}
	/**
	 * 同じ工種名のレコードが存在するかどうかを取得する。（編集）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_type_name
	 * @param unknown_type $construction_type_id
	 * @return true:存在する、false:存在しない
	 */
	function is_construction_type_name_exists_edit($construction_type_name, $construction_type_id)
	{
        //工種名
        if( $construction_type_name == "" ){
            throw new Exception("There is no construction_type_name");
        }
        //ID
        if( $construction_type_id == "" ){
            throw new Exception("There is no construction_type_id");
        }
        if( !is_numeric($construction_type_id) ){
            throw new Exception("construction_type_id is not numeric value, ".$construction_type_id);
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('construction_type_name', $construction_type_name)
					->where('id !=', $construction_type_id)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}

	/**
	 * 組み合せ（工種コード・分類・工種名）のレコードが存在するかどうかを取得する。（登録）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_type_code
	 * @param unknown_type $construction_category_id
	 * @param unknown_type $construction_type_name
	 * @return true:存在する、false:存在しない
	 */
	function is_construction_type_exists($construction_type_code, $construction_category_id, $construction_type_name)
	{
        //工種コード
        if( $construction_type_code == "" ){
            throw new Exception("There is no construction_type_code");
        }
        if( !is_numeric($construction_type_code) ){
            throw new Exception("construction_type_code is not numeric value, ".$construction_type_code);
        }
        //分類
        if( $construction_category_id == "" ){
            throw new Exception("There is no construction_category_id");
        }
        if( !is_numeric($construction_category_id) ){
            throw new Exception("construction_category_id is not numeric value, ".$construction_category_id);
        }
        //工種名
        if( $construction_type_name == "" ){
            throw new Exception("There is no construction_type_name");
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('construction_type_code', $construction_type_code)
					->where('construction_category_id', $construction_category_id)
					->where('construction_type_name', $construction_type_name)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}
	/**
	 * 組み合せ（工種コード・分類・工種名）のレコードが存在するかどうかを取得する。（編集）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_type_code
	 * @param unknown_type $construction_category_id
	 * @param unknown_type $construction_type_name
	 * @param unknown_type $construction_type_id
	 * @return true:存在する、false:存在しない
	 */
	function is_construction_type_exists_edit($construction_type_code, $construction_category_id, $construction_type_name, $construction_type_id)
	{
        //工種コード
        if( $construction_type_code == "" ){
            throw new Exception("There is no construction_type_code");
        }
        if( !is_numeric($construction_type_code) ){
            throw new Exception("construction_type_code is not numeric value, ".$construction_type_code);
        }
        //分類
        if( $construction_category_id == "" ){
            throw new Exception("There is no construction_category_id");
        }
        if( !is_numeric($construction_category_id) ){
            throw new Exception("construction_category_id is not numeric value, ".$construction_category_id);
        }
        //工種名
        if( $construction_type_name == "" ){
            throw new Exception("There is no construction_type_name");
        }
        //ID
        if( $construction_type_id == "" ){
            throw new Exception("There is no construction_type_id");
        }
        if( !is_numeric($construction_type_id) ){
            throw new Exception("construction_type_id is not numeric value, ".$construction_type_id);
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('construction_type_code', $construction_type_code)
					->where('construction_category_id', $construction_category_id)
					->where('construction_type_name', $construction_type_name)
					->where('id !=', $construction_type_id)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}

	/**
	 * 主キーのidではなく、ユーザーコードを元にレコードを取得する。
	 * 
	 * @param unknown_type $user_code
	 */
/*
	function get_by_user_code($user_code)
	{
		return $this->select_entity_by_params(
		                  array(
		                      'user_code' => $user_code
		                  )
		              );
	}
*/

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
			   ,CAT.construction_category_name
			FROM
				{$this->_table} AS MAIN
                    LEFT JOIN m_construction_category AS CAT ON CAT.id = MAIN.construction_category_id
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;

		//工種コード
		if (isset($params['construction_type_code'])  && is_not_blank($params['construction_type_code']))
		{
			$sql .= '
				AND MAIN.construction_type_code LIKE ?
			';

			$value_array[] = "%{$params['construction_type_code']}%";
		}

		//工種名
		if (isset($params['construction_type_name'])  && is_not_blank($params['construction_type_name']))
		{
			$sql .= '
				AND MAIN.construction_type_name LIKE ?
			';

			$value_array[] = "%{$params['construction_type_name']}%";
		}
/*
		//ユーザーコード
		if (isset($params['user_code'])  && is_not_blank($params['user_code']))
		{
			$sql .= '
				AND MAIN.user_code = ?
			';

			$value_array[] = $params['user_code'];
		}

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

/*
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
*/

		/*
		 * SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		 */

		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}

	/**
	 * プルダウン用配列を返す
	 */
	function getConstructionTypeIdList($with_no_val = false)
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.*,
				CATEGORY.construction_category_name
			FROM
				{$this->_table} AS MAIN
				LEFT JOIN m_construction_category AS CATEGORY
					ON CATEGORY.id = MAIN.construction_category_id
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$return = $this->db->query($sql, $value_array)->result();
        if( $with_no_val ){
            $data = array("0" => "----");
        } else {
            $data = array("" => "----");
            //$data = array();
        }
        if( $return ){
            foreach($return as $val){
                $data[ $val->id ] = $val->construction_category_name. " : ".$val->construction_type_name;
            }
        }

        return $data;
	}

}
