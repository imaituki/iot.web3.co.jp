<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理画面-配車管理のテーブル
 * 
 * @author ta-ando
 *
 */
class T_reserve extends Base_model 
{

    const NON_ASSIGNED_STAFF_ID = 0;

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
			   ,USR.user_name
			   ,CON.construction_code
               ,CON.construction_status
			   ,CAR.number_plate
			FROM
				{$this->_table} AS MAIN
                    LEFT JOIN m_user AS USR ON USR.id = MAIN.staff_id
                    LEFT JOIN m_construction AS CON ON CON.id = MAIN.construction_id
                    LEFT JOIN m_car_profile AS CAR ON CAR.id = MAIN.car_profile_id
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;

        list($sql, $value_array) = $this->_and_where($params, $sql, $value_array);

		/*
		 * SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		 */

		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}
    /**
     * 全データを取得
     *
     * del_flg = 0 のデータ全てを取得
     */
	function getStaffSchedule($staff_id, $date = null, $start_show_time = null, $end_show_time = null)
	{
		$value_array = array();

        $date = ($date == null) ? date("Y-m-d") : $date;


        $wheres[] = "MAIN.del_flg = ?";
        $wheres[] = "MAIN.staff_id = ?";
        $wheres[] = "MAIN.reserve_date = ?";
		$value_array[] = (int) Del_flg::NOT_DELETE;
		$value_array[] = (int) $staff_id;
		$value_array[] = (string) $date;

        // 担当者が指定されている場合（＝複製以外）
        if( $staff_id != self::NON_ASSIGNED_STAFF_ID ){
            $wheres[] = "MAIN.reserve_status < ?";
		    $value_array[] = (int) Reserve_status::COPY;
        }

        $where = implode(" AND ", $wheres);

		$sql = "
			SELECT
				MAIN.*,
                CON.construction_code,
                CON.construction_name,
                CON.construction_address,
                CON.latitude,
                CON.longitude,
                CUS.company_name,
                CUS.name
			FROM
				{$this->_table} AS MAIN
                LEFT JOIN m_construction CON ON MAIN.construction_id = CON.id
                LEFT JOIN m_customer CUS ON CON.customer_id = CUS.id
			WHERE " . $where . "
            ORDER BY MAIN.reserve_date asc, MAIN.reserve_time_start asc
		";

		return $this->db->query($sql, $value_array)->result();
    }
    /**
     * 担当者が未設定のスケジュールを取得
     */
    public function getNonAssignedSchedule($date = null, $start_show_time = null, $end_show_time = null)
    {
        return $this->getStaffSchedule(self::NON_ASSIGNED_STAFF_ID, $date, $start_show_time, $end_show_time);
    }

	/**
	 * unit_price_idが0の件数を取得
	 * 
	 * @param unknown_type $params
	 */
	function is_unit_price_exists($params)
	{

		$value_array = array();

		$sql = "
			SELECT
			    MAIN.id
			FROM
				{$this->_table} AS MAIN
                    LEFT JOIN t_reserve_detail AS T1 ON MAIN.id = T1.reserve_id
                    LEFT JOIN m_construction AS CON ON MAIN.construction_id = CON.id
			WHERE
				MAIN.del_flg = ? AND T1.unit_price_id = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = 0;

        list($sql, $value_array) = $this->_and_where($params, $sql, $value_array);

        $result =  $this->db->query($sql, $value_array)->result();
		return (count($result) > 0) ? true : false;

	}

	/**
	 * CSV用のSELECTを行うメソッド。
	 * 
	 * @param unknown_type $params
	 */
	function getCsvData(Nds_pagination $nds_pagination, $params)
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.id
			   ,MAIN.staff_id
			   ,T2.user_name
			   ,MAIN.reserve_date
               ,MAIN.reserve_time_start
               ,MAIN.reserve_time_end
               ,MAIN.time_start
               ,MAIN.time_end
               ,CON.construction_code
               ,CON.customer_id
               ,T4.company_name
               ,CON.construction_name
               ,CON.construction_address
               ,T1.car_class_id
               ,T5.number_plate
               ,T6.car_class_name
               ,T7.construction_type_code
               ,T8.construction_category_name
               ,T7.construction_type_name
               ,T9.construction_detail_code
               ,T9.construction_detail_name
               ,T9.weight
               ,T9.unit
               ,T1.count_estimate
               ,T1.count_actual
               ,T1.disposal_id
               ,T10.disposal_name
               ,MAIN.memo
               ,T11.point
               ,round(T11.point * T1.count_actual, 6) AS point_total
               ,T11.unit_price
               ,T11.unit_price * T1.count_actual AS price_total
			FROM
				{$this->_table} AS MAIN
                    LEFT JOIN t_reserve_detail AS T1 ON MAIN.id = T1.reserve_id
                    LEFT JOIN m_user AS T2 ON MAIN.staff_id = T2.id
                    LEFT JOIN m_construction AS CON ON MAIN.construction_id = CON.id
                    LEFT JOIN m_customer AS T4 ON CON.customer_id = T4.id 
                    LEFT JOIN m_car_profile AS T5 ON MAIN.car_profile_id = T5.id 
                    LEFT JOIN m_car_class AS T6 ON T1.car_class_id = T6.id 
                    LEFT JOIN m_construction_type AS T7 ON T1.construction_type_id = T7.id
                    LEFT JOIN m_construction_category AS T8 ON T7.construction_category_id = T8.id
                    LEFT JOIN m_construction_detail AS T9 ON T1.construction_detail_id = T9.id
                    LEFT JOIN m_disposal AS T10 ON T1.disposal_id = T10.id
                    LEFT JOIN m_unit_price AS T11 ON T1.unit_price_id = T11.id
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;

        list($sql, $value_array) = $this->_and_where($params, $sql, $value_array);

        return $this->db->query($sql, $value_array)->result();
    }

	/**
	 * PDF用のSELECTを行うメソッド。
	 * 
	 * @param unknown_type $params
	 */
	function getPdfReserveData($params)
	{
		$value_array = array();

		$sql = "
			SELECT
			     MAIN.*
                ,T0.user_name
                ,T1.count_actual
                ,T2.construction_category_id
                ,T2.construction_type_code
                ,T2.construction_type_name
                ,T3.number_plate
                ,T4.construction_code
                ,T4.construction_name
                ,T4.construction_address
                ,T5.disposal_name
                ,T6.point 
                ,T7.car_class_name 
                ,T8.construction_detail_name 
                ,T8.weight
                ,T9.construction_category_name
                ,(SELECT datetime FROM t_attendance WHERE staff_id = MAIN.staff_id AND DATE_FORMAT(datetime,'%Y-%m-%d') = MAIN.reserve_date) AS datetime
			FROM
				{$this->_table} AS MAIN
                    LEFT JOIN m_user AS T0 ON T0.id = MAIN.staff_id
                    LEFT JOIN t_reserve_detail AS T1 ON T1.reserve_id = MAIN.id
                    LEFT JOIN m_construction_type AS T2 ON T2.id = T1.construction_type_id
                    LEFT JOIN m_car_profile AS T3 ON T3.id = MAIN.car_profile_id
                    LEFT JOIN m_construction AS T4 ON T4.id = MAIN.construction_id
                    LEFT JOIN m_disposal AS T5 ON T5.id = T1.disposal_id
                    LEFT JOIN m_unit_price AS T6 ON T6.id = T1.unit_price_id
                    LEFT JOIN m_car_class AS T7 ON T7.id = T1.car_class_id
                    LEFT JOIN m_construction_detail AS T8 ON T8.id = T1.construction_detail_id
                    LEFT JOIN m_construction_category AS T9 ON T9.id = T2.construction_category_id
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;

        list($sql, $value_array) = $this->_and_where($params, $sql, $value_array);

        return $this->db->query($sql, $value_array)->result();
    }

	/*
	 * 検索条件
	 */
    private function _and_where($params, $sql, $value_array)
    {
        // 工事コード
		if (isset($params['construction_code'])  && is_not_blank($params['construction_code']))
		{
			$sql .= '
				AND CON.construction_code LIKE ?
			';

			$value_array[] = "%{$params['construction_code']}%";
		}

        // 担当
		if (isset($params['staff_id'])  && is_not_blank($params['staff_id']))
		{
			$sql .= '
				AND MAIN.staff_id = ?
			';

			$value_array[] = "{$params['staff_id']}";
		}

        // 顧客
		if (isset($params['customer_id'])  && is_not_blank($params['customer_id']))
		{
			$sql .= '
				AND CON.customer_id = ?
			';

			$value_array[] = "{$params['customer_id']}";
		}

        // 予定日
		if (isset($params['reserve_date'])  && is_not_blank($params['reserve_date']))
		{
			$sql .= '
				AND MAIN.reserve_date = ?
			';

			$value_array[] = "{$params['reserve_date']}";
		}

        // 予定日（開始）
		if (isset($params['reserve_date_start'])  && is_not_blank($params['reserve_date_start']))
		{
			$sql .= '
				AND MAIN.reserve_date >= ?
			';

			$value_array[] = "{$params['reserve_date_start']}";
		}

        // 予定日（終了）
		if (isset($params['reserve_date_end'])  && is_not_blank($params['reserve_date_end']))
		{
			$sql .= '
				AND MAIN.reserve_date <= ?
			';

			$value_array[] = "{$params['reserve_date_end']}";
		}

        // ステータス
		if (isset($params['reserve_status'])  && is_not_blank($params['reserve_status']))
		{
            $sqlstatus = '';
            foreach ($params['reserve_status'] AS $value)
            {
                if (empty($sqlstatus))
                {
        			$sqlstatus .= '
	        			AND (MAIN.reserve_status = ?
		        	';
                } else {
        			$sqlstatus .= '
	        			OR MAIN.reserve_status = ?
		        	';
                }

			    $value_array[] = "{$value}";
            }
            $sqlstatus .= ')';
   			$sql .= $sqlstatus;
		}

        return array($sql, $value_array);
    }

	/*
	 * 作業(開始・終了)時間を登録
	 */
    function update_time($id, $mode)
    {
        switch ($mode)
        {
        case 'start':
            $col = 'time_start';
            $status = 1;
            break;
        case 'end':
            $col = 'time_end';
            $status = 2;
            break;
        default:
            break;
        }

		$value_array = array();

		$sql = "
			UPDATE
                {$this->_table}
			SET
				{$col} = CURRENT_TIME(),
                reserve_status = {$status}
			WHERE
				id = ?
		";

		$value_array[] = "{$id}";

        return $this->db->query($sql, $value_array);
    }

	/*
	 * 当日の数量、ポイントを登録し、当月の累計値を返す
	 *
	 * @param array $data 当日の数量、ポイントの配列
	 * @param array $id staff_id
	 * @param array $date reserve_date
	 * @return array 当月の累計値
	 */
    function update_num_and_point($data, $id, $date)
    {

		$value_array = array();

		$sql = "
			UPDATE
                t_attendance
			SET
                soil_2t = {$data['soil_2t']},
	            soil_4t = {$data['soil_4t']},
	            soil_point = {$data['soil_point']},
	            cement_1 = {$data['cement_1']},
	            cement_2 = {$data['cement_2']},
	            cement_point = {$data['cement_point']},
	            other_point = {$data['other_point']},
	            today_point = {$data['today_point']},
				update_datetime = CURRENT_TIME()
			WHERE
				staff_id = ? AND DATE_FORMAT(datetime,'%Y-%m-%d') = ?
		";

		$value_array[] = "{$id[0]}";
		$value_array[] = "{$date[0]}";

        $this->db->query($sql, $value_array);

        return $this->_get_total_num_and_point($id, $date);
    }

	/*
	 * 当月の数量、ポイントの累計値を返す
	 *
	 * @param array $date 日付
	 * @param array $date 日付
	 * @return array 当月の累計値
	 */
    private function _get_total_num_and_point($id, $date)
    {

		$value_array = array();
        $start_date = date('Y-m-01', strtotime($date[0] . ' 00:00:00'));
        $end_date   = date($date[0] . ' 23:59:59');

		$sql = "
			SELECT
                COUNT(id) AS total_count,
                SUM(soil_2t) AS total_soil_2t,
                SUM(soil_4t) AS total_soil_4t,
                SUM(soil_point) AS total_soil_point,
                SUM(cement_1) AS total_cement_1,
                SUM(cement_2) AS total_cement_2,
                SUM(cement_point) AS total_cement_point,
                SUM(other_point) AS total_other_point,
                SUM(today_point) AS total_today_point
			FROM
                t_attendance
			WHERE
				del_flg = 0 AND 
				staff_id = ? AND 
                datetime between ? AND ?
		";

		$value_array[] = "{$id[0]}";
		$value_array[] = "{$start_date}";
		$value_array[] = "{$end_date}";

        return $this->db->query($sql, $value_array)->row();
    }

}
