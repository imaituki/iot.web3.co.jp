<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 管理画面-TOP カレンダー
 * 
 * @author ta-ando
 *
 */
class T_calendar extends Base_model 
{
    /**
     * 当日の予定を取得
     *
     * del_flg = 0 のデータ全てを取得
     */
	function getReserveData($timestamp = null, $staff_id = 0)
	{
		$value_array = array();

        $date = ($timestamp == null) ? date("Y-m-d") : date("Y-m-d", $timestamp);

		$sql = "
			SELECT
				MAIN.*
               ,U.user_name
               ,C.construction_name
               ,C.construction_address
               ,C.latitude
               ,C.longitude
			FROM
				t_reserve MAIN
                    LEFT JOIN m_user U ON MAIN.staff_id = U.id
                    LEFT JOIN m_construction C ON MAIN.construction_id = C.id
			WHERE
				MAIN.del_flg = ?
            AND
                MAIN.reserve_date = ?
            AND
                MAIN.reserve_status < ?
		";
        if ($staff_id > 0) $sql .= " AND MAIN.staff_id = ?";

		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = $date;
		$value_array[] = 9;
        if ($staff_id > 0) $value_array[] = $staff_id;

		return $this->db->query($sql, $value_array)->result();
    }

    /**
     * 予定の時間を更新
     */
	function setReserveDatatime($start, $end, $id)
	{
		$data = array(
                        'reserve_time_start' => date('H:i:s', $start),
                        'reserve_time_end'   => date('H:i:s', $end)
                    );

        $this->db->where('id', $id)
             ->update('t_reserve', $data);
    }

}
