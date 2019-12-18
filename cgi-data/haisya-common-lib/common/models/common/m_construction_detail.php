<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理画面-種別マスタのモデル
 * 
 * @author ta-ando
 *
 */
class M_construction_detail extends Base_model 
{
	var $construction_detail_code;
    var $construction_detail_name;
    var $weight;
    var $unit;

	/**
	 * 同じ種別コードのレコードが存在するかどうかを取得する。（登録）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_detail_code
	 * @return true:存在する、false:存在しない
	 */
	function is_construction_detail_code_exists($construction_detail_code)
	{

        //種別コード
        if( $construction_detail_code == "" ){
            throw new Exception("There is no construction_detail_code");
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('construction_detail_code', $construction_detail_code)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}
	/**
	 * 同じ種別コードのレコードが存在するかどうかを取得する。（編集）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_detail_code
	 * @param unknown_type $construction_detail_id
	 * @return true:存在する、false:存在しない
	 */
	function is_construction_detail_code_exists_edit($construction_detail_code, $construction_detail_id)
	{

        //種別コード
        if( $construction_detail_code == "" ){
            throw new Exception("There is no construction_detail_code");
        }
        //ID
        if( $construction_detail_id == "" ){
            throw new Exception("There is no construction_detail_id");
        }
        if( !is_numeric($construction_detail_id) ){
            throw new Exception("construction_detail_id is not numeric value, ".$construction_detail_id);
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('construction_detail_code', $construction_detail_code)
					->where('id !=', $construction_detail_id)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}

	/**
	 * 同じ種別名のレコードが存在するかどうかを取得する。（登録）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_detail_name
	 * @return true:存在する、false:存在しない
	 */
	function is_construction_detail_name_exists($construction_detail_name)
	{

        //種別名
        if( $construction_detail_name == "" ){
            throw new Exception("There is no construction_detail_name");
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('construction_detail_name', $construction_detail_name)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}
	/**
	 * 同じ種別名のレコードが存在するかどうかを取得する。（編集）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_detail_name
	 * @param unknown_type $construction_detail_id
	 * @return true:存在する、false:存在しない
	 */
	function is_construction_detail_name_exists_edit($construction_detail_name, $construction_detail_id)
	{

        //種別名
        if( $construction_detail_name == "" ){
            throw new Exception("There is no construction_detail_name");
        }
        //ID
        if( $construction_detail_id == "" ){
            throw new Exception("There is no construction_detail_id");
        }
        if( !is_numeric($construction_detail_id) ){
            throw new Exception("construction_detail_id is not numeric value, ".$construction_detail_id);
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('construction_detail_name', $construction_detail_name)
					->where('id !=', $construction_detail_id)
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
			FROM
				{$this->_table} AS MAIN
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;

		//種別コード
		if (isset($params['construction_detail_code'])  && is_not_blank($params['construction_detail_code']))
		{
			$sql .= '
				AND MAIN.construction_detail_code LIKE ?
			';

			$value_array[] = "%{$params['construction_detail_code']}%";
		}

		//種別名
		if (isset($params['construction_detail_name'])  && is_not_blank($params['construction_detail_name']))
		{
			$sql .= '
				AND MAIN.construction_detail_name LIKE ?
			';

			$value_array[] = "%{$params['construction_detail_name']}%";
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
	function getConstructionDetailIdList($with_no_val = false)
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
		$return = $this->db->query($sql, $value_array)->result();
        if( $with_no_val ){
            $data = array("0" => "----");
        } else {
            $data = array();
        }
        if( $return ){
            foreach($return as $val){
                $data[ $val->id ] = $val->construction_detail_name. " / ".$val->weight. " / ".$val->unit;
            }
        }

        return $data;
	}

	/**
	 * 単位配列を返す
	 */
	function getConstructionDetailUnitList()
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.id,
				MAIN.unit
			FROM
				{$this->_table} AS MAIN
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$return = $this->db->query($sql, $value_array)->result();

        $data = array(0 => '');
        if( $return ){
            foreach($return as $val){
                $data[ $val->id ] = $val->unit;
            }
        }

        return $data;
	}

	/**
	 * 表示用配列を返す
	 */
	function getDisplayList($name1, $name2 = null, $name3 = null)
	{

		$return = $this->db
                    ->select("id, {$name1}, {$name2}, {$name3}")
                    ->from($this->_table)
                    ->get()
                    ->result();

        $data[0] = '----';
        if( $return ){
            foreach($return as $val){
                $values = $val->$name1;
                if (!is_null($name2)) $values = $values . ' / ' . $val->$name2; 
                if (!is_null($name3)) $values = $values . ' / ' . $val->$name3; 
                $data[ $val->id ] = $values;
            }
        }

        return $data;
	}

}
