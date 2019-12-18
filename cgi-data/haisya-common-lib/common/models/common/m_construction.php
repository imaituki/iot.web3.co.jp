<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理画面-単価マスタのモデル
 * 
 * @author ta-ando
 *
 */
class M_construction extends Base_model 
{

    const CONSTRUCTION_STATUS_END = 2;

	var $customer_id;

	/**
	 * 同じ工種のレコードが存在するかどうかを取得する。
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $construction_code
	 * @return true:存在する、false:存在しない
	 */

	function is_construction_code_exists($construction_code, $id = null)
	{

        if( $construction_code == "" ){
            throw new Exception("invalid construction_code");
        }

		$sel = $this->db
					->from($this->_table)
					->where('construction_code', $construction_code)
					->where('construction_status !=', self::CONSTRUCTION_STATUS_END)
					->where('del_flg', Del_flg::NOT_DELETE);

        if (!is_null($id))
        {
		    $sel = $this->db->where('id !=', $id);
        }

		$result = $sel->count_all_results();

		return ($result > 0);
	}
/*
	function is_construction_code_exists($construction_code, $id = null)
	{

        if( $construction_code == "" ){
            throw new Exception("invalid construction_code");
        }

		$result = $this->db
					->from($this->_table)
					->where('construction_code', $construction_code)
					->where('construction_status !=', self::CONSTRUCTION_STATUS_END)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}
*/

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

		if (isset($params['construction_name'])  && is_not_blank($params['construction_name']))
		{
			$sql .= '
				AND MAIN.construction_name LIKE ?
			';

			$value_array[] = "%{$params['construction_name']}%";
		}

		if (isset($params['construction_code'])  && is_not_blank($params['construction_code']))
		{
			$sql .= '
				AND MAIN.construction_code LIKE ?
			';

			$value_array[] = "%{$params['construction_code']}%";
		}

		if (isset($params['customer_id'])  && is_not_blank($params['customer_id']))
		{
			$sql .= '
				AND MAIN.customer_id = ?
			';

			$value_array[] = $params['customer_id'];
		}

        // ステータス
		if (isset($params['construction_status'])  && is_not_blank($params['construction_status']))
		{
            $sqlstatus = '';
            foreach ($params['construction_status'] AS $value)
            {
                if (empty($sqlstatus))
                {
        			$sqlstatus .= '
	        			AND (MAIN.construction_status = ?
		        	';
                } else {
        			$sqlstatus .= '
	        			OR MAIN.construction_status = ?
		        	';
                }

			    $value_array[] = "{$value}";
            }
            $sqlstatus .= ')';
   			$sql .= $sqlstatus;
		}

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
	function getConstructionCategoryIdList($with_no_val = false)
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.*,
                CUST.company_name,
                CUST.name
			FROM
				{$this->_table} AS MAIN
            LEFT JOIN m_customer as CUST
                ON CUST.id = MAIN.customer_id
			WHERE
				MAIN.del_flg = ?
            AND
				MAIN.construction_status = 1
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$return = $this->db->query($sql, $value_array)->result();
        if( $with_no_val ){
            $data = array("" => "----");
        } else {
            $data = array();
        }

        if( $return ){
            foreach($return as $val){
                $data[ $val->id ] = $val->construction_code . " / " . $val->company_name . " ". $val->name . " / " . $val->construction_name . " / ". $val->construction_address;
            }
        }

        return $data;
	}

    /**
     * 全データを取得
     *
     * del_flg = 0 のデータ全てを取得
     */
	function select_all()
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.*,
                CUST.company_name,
                CUST.company_furigana,
                CUST.name as incharge_name,
                CUST.furigana as incharge_furigana
			FROM
				{$this->_table} AS MAIN
            LEFT JOIN 
                m_customer AS CUST
            ON
                CUST.id = MAIN.customer_id
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;
		return $this->db->query($sql, $value_array)->result();
	}

    /**
     * ステータスの更新
     *
     */
	function changeConstructionStatus($ids, $status)
	{
        $data = array(
                        'construction_status' => $status
                    );

        $this->db->where_in('id', $ids)
                 ->update($this->_table, $data);
	}


    /**
     * ステータスの更新
     *
     */
	function updateConstructionStatus($id, $status)
	{
        $data = array(
                        'construction_status' => $status
                    );

        $this->db->where('id', $id)
                 ->update($this->_table, $data);
	}

}
