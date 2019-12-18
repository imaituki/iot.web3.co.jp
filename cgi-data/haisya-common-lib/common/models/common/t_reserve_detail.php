<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理画面-配車管理(作業）のテーブル
 * 
 * @author ta-ando
 *
 */
class T_reserve_detail extends Base_model 
{

    private $point;
    private $price;


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

        /*
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
        */
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
     * 予約ID から取得
     */
    public function find_by_reserve_id( $reserve_id )
    {
		$value_array = array();

		$sql = "
			SELECT
				MAIN.*
			   ,TYP.construction_type_name
			   ,CAT.construction_category_name
			   ,DET.construction_detail_name
			   ,DET.weight
			   ,DET.unit
			   ,DIS.disposal_name
			   ,CAR.car_class_name
			FROM
				{$this->_table} AS MAIN
                    LEFT JOIN m_construction_type AS TYP ON TYP.id = MAIN.construction_type_id
                    LEFT JOIN m_construction_category AS CAT ON CAT.id = TYP.construction_category_id
                    LEFT JOIN m_construction_detail AS DET ON DET.id = MAIN.construction_detail_id
                    LEFT JOIN m_disposal AS DIS ON DIS.id = MAIN.disposal_id
                    LEFT JOIN m_car_class AS CAR ON CAR.id = MAIN.car_class_id
			WHERE
				MAIN.del_flg = ?
            AND
                reserve_id = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = (int)$reserve_id;

		return $this->db->query($sql, $value_array)->result();
    }

    function getMainConstructionCategory($id)
    {
		$value_array = array();

		$sql = "
			SELECT
				TYPE.construction_category_id
			FROM
				{$this->_table} AS MAIN
                LEFT JOIN m_construction_type AS TYPE ON MAIN.construction_type_id = TYPE.id
			WHERE
				MAIN.reserve_id = ?
            ORDER BY
                MAIN.detail_number ASC
            limit 1
		";

		$value_array[] = (int)$id;

		return $this->db->query($sql, $value_array)->row();
    }

    public function getPointTotalAndPriceTotal($ret)
    {
        $point = 0;
        $price = 0;

        $data = $this->getPointAndPrice($ret);

        if (is_array($data))
        {
            foreach($data as $key => $val)
            {
                $point += $val['total_point'];
                $price += $val['total_price'];
            }
        }

        return array(
                     'point' => $point,
                     'price' => $price
                    );
    }

    public function getPointAndPrice($ret)
    {
        $data = array();
        foreach ($ret as $val)
        {
            list($val['total_point'], $val['total_price']) = $this->_setPointAndPrice($val['id']);
            $data[] = $val;
        }

        return $data;
    }

    private function _setPointAndPrice($id)
    {

		$value_array = array();

		$sql = "
			SELECT
                 MAIN.count_actual
                ,UP.point
                ,UP.unit_price
			FROM
				{$this->_table} AS MAIN
                LEFT JOIN m_unit_price AS UP ON MAIN.unit_price_id = UP.id
			WHERE
				MAIN.del_flg = ? AND MAIN.reserve_id = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = (int)$id;

		$ret = $this->db->query($sql, $value_array)->result();

        $this->point = 0;
        $this->price = 0;
        if (is_array($ret)){
            foreach ($ret as $val)
            {
                $this->point += $val->point * $val->count_actual;
                $this->price += $val->unit_price * $val->count_actual;
            }
        }

        return array($this->point, $this->price);
    }

    public function getUnitPriceId($ret)
    {
        $data = array();
        foreach ($ret as $val)
        {
            $val['none'] = $this->_isUnitPriceIdCount($val['id']);
            $data[] = $val;
        }
        return $data;
    }

	/**
	 * @return true:存在する、false:存在しない
	 */
    private function _isUnitPriceIdCount($id)
    {
		$result = $this->db
					->from($this->_table)
					->where('reserve_id', $id)
					->where('unit_price_id', 0)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
    }
}
