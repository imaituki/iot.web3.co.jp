<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理画面-単価マスタのモデル
 * 
 * @author ta-ando
 *
 */
class M_unit_price extends Base_model 
{
	var $car_class_id;
	var $disposal_id;
	var $construction_type_id;
	var $construction_detail_id;

	/**
	 * 組み合せ（工種、種別、処理場、車輌扱い）の組み合せがレコードが存在するかどうかを取得する。（登録）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_type_id
	 * @param unknown_type $construction_detail_id
	 * @param unknown_type $disposal_id
	 * @param unknown_type $car_class_id
	 * @return true:存在する、false:存在しない
	 */
	function is_unit_price_exists($construction_type_id, $construction_detail_id, $disposal_id, $car_class_id)
	{

        //if( $car_class_id == "" || !is_numeric($car_class_id)){
        //    throw new Exception("invalid car_class_id");
        //}
        //if( $disposal_id == "" || !is_numeric($disposal_id)){
        //    throw new Exception("invalid disposal_id");
        //}
        if( $construction_type_id == "" || !is_numeric($construction_type_id)){
            throw new Exception("invalid construction_type_id");
        }
        if( $construction_detail_id == "" || !is_numeric($construction_detail_id)){
            throw new Exception("invalid construction_detail_id");
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('car_class_id', $car_class_id)
					->where('disposal_id', $disposal_id)
					->where('construction_type_id', $construction_type_id)
					->where('construction_detail_id', $construction_detail_id)
					->where('del_flg', Del_flg::NOT_DELETE)
					->count_all_results();

		return ($result > 0);
	}

	/**
	 * 組み合せ（工種、種別、処理場、車輌扱い）の組み合せがレコードが存在するかどうかを取得する。（編集）
	 * 削除フラグは考慮しない
	 * 
	 * @param unknown_type $construction_type_id
	 * @param unknown_type $construction_detail_id
	 * @param unknown_type $disposal_id
	 * @param unknown_type $car_class_id
	 * @param unknown_type $unit_price_id
	 * @return true:存在する、false:存在しない
	 */
	function is_unit_price_exists_edit($construction_type_id, $construction_detail_id, $disposal_id, $car_class_id, $unit_price_id)
	{

        //if( $car_class_id == "" || !is_numeric($car_class_id)){
        //    throw new Exception("invalid car_class_id");
        //}
        //if( $disposal_id == "" || !is_numeric($disposal_id)){
        //    throw new Exception("invalid disposal_id");
        //}
        if( $construction_type_id == "" || !is_numeric($construction_type_id)){
            throw new Exception("invalid construction_type_id");
        }
        if( $construction_detail_id == "" || !is_numeric($construction_detail_id)){
            throw new Exception("invalid construction_detail_id");
        }

		/*
		 * 削除フラグを考慮しない点に注意する
		 */

		$result = $this->db
					->from($this->_table)
					->where('car_class_id', $car_class_id)
					->where('disposal_id', $disposal_id)
					->where('construction_type_id', $construction_type_id)
					->where('construction_detail_id', $construction_detail_id)
					->where('id !=', $unit_price_id)
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
		";

		$value_array[] = Del_flg::NOT_DELETE;

		//工種ID
		if (isset($params['construction_type_id'])  && is_not_blank($params['construction_type_id']))
		{
			$sql .= '
				AND MAIN.construction_type_id LIKE ?
			';

			$value_array[] = "{$params['construction_type_id']}";
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
	function getConstructionCategoryIdList()
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
        $data = array();
        if( $return ){
            foreach($return as $val){
                $data[ $val->id ] = $val->construction_category_name. " : ".$val->unit_price_name;
            }
        }

        return $data;
	}
    /**
     * 工種に応じた種別のプルダウン用配列を返す
     *
     * null を渡したら全て返す
     *
     * @params boolean $return_entities 返却は生のentityの配列か
     * @return mixed
     */
	function getUnitPriceIdList($return_entities = false)
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.*,
                DISP.disposal_name,
				CD.construction_detail_code,
				CD.construction_detail_name,
				CD.weight,
				CD.unit
			FROM
				{$this->_table} AS MAIN
				LEFT JOIN m_construction_detail AS CD
					ON CD.id = MAIN.construction_detail_id
				LEFT JOIN m_disposal AS DISP
					ON DISP.id = MAIN.disposal_id
			WHERE
				MAIN.del_flg = ?
		";
		$value_array[] = Del_flg::NOT_DELETE;

		$return = $this->db->query($sql, $value_array)->result();

        // 生データのまま返す
        if( $return_entities ){
            return $return;
        }

        // 加工して返す(作業登録のプルダウン用）
        $data = array();
        if( $return ){
            foreach($return as $val){

                $id            = $val->id;
                $c_type_id     = $val->construction_type_id;
                $c_detail_name = $val->construction_detail_name;
                $disposal_name = $val->disposal_name;
                $unit          = $val->unit;

                if( !$disposal_name ){
                    $disposal_name = "----";
                }

                $data[ $c_type_id ][ $id ] = $c_detail_name . " / ".$unit. " / ". $disposal_name;
            }
        }

        return $data;
	}
    /**
     * 工種、種別、処理場、車輌扱いから単価情報を返す
     */
	function getUnitPrice($construction_type_id = null, $construction_detail_id = null, $disposal_id = null, $car_class_id = null)
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

        if( $construction_type_id !== null && $construction_type_id >= 0 ){
            $sql .= " AND MAIN.construction_type_id = ?";
		    $value_array[] = (int) $construction_type_id;
        }
        if( $construction_detail_id !== null && $construction_detail_id >= 0 ){
            $sql .= " AND MAIN.construction_detail_id = ?";
		    $value_array[] = (int) $construction_detail_id;
        }
        if( $disposal_id !== null && $disposal_id >= 0 ){
            $sql .= " AND MAIN.disposal_id = ?";
		    $value_array[] = (int) $disposal_id;
        }
        if( $car_class_id !== null && $car_class_id >= 0 ){
            $sql .= " AND MAIN.car_class_id = ?";
		    $value_array[] = (int) $car_class_id;
        }

		return $this->db->query($sql, $value_array)->result();
    }
}
