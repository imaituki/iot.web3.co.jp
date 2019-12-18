<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * お知らせトピックス用のロジック
 * 
 * @author ta-ando
 *
 */
class Info_logic extends Base_post_Model
{
	/**
	 * カテゴリー名を取得する。
	 * 
	 * @param unknown_type $kubun_code 区分コード or 区分コードの配列
	 */
	function get_topic_category_name($kubun_code)
	{
		return $this->M_kubun->get_joined_label_by_kubun_codes(
		                           Relation_data_type::INFO,
		                           Kubun_type::CATEGORY,
		                           $kubun_code
		                       );
	}

	/**
	 * 
	 * 
	 * @param unknown_type $post_id
	 * @param unknown_type $site_type_kubun_code
	 */
	function get_prev_and_next($post_id, $site_type_kubun_code)
	{
		$params = array();
		$params['kubun_code_condition_list'] = array(
			Kubun_type::SITE_TYPE => create_array_param($site_type_kubun_code),
		);

		$nds_pagination = new Nds_pagination(FALSE);
		$nds_pagination->add_order("post_date", "DESC");
		$nds_pagination->add_order("id", "DESC");

		$list = $this->T_info->select_for_front($nds_pagination, $params);

		$ret =array(
			      "prev_id" => FALSE,
			      "next_id" => FALSE
			  );
		
		if ( ! $list)
		{
			return $ret;
		}

		$target_id_index = 0;

		//元の記事のインデックスを取得する。
		for ($i = 0; $i < count($list); $i++)
		{
			if ($list[$i]->id == $post_id)
			{
				$target_id_index = $i;
				break;
			}
		}

		$ret["prev_id"] = isset($list[($target_id_index - 1)])
		               ? $list[($target_id_index - 1)]->id
		               : FALSE;

		$ret["next_id"] = isset($list[($target_id_index + 1)])
		               ? $list[($target_id_index + 1)]->id
		               : FALSE;

		return $ret;
	}

	/**
	 * イベントが応募期間であるかどうかを取得する
	 * 
	 * @param unknown_type $post_id
	 */
	public function is_event_accept($post_id)
	{
		$value_array = array();
		
		$sql = "
			SELECT
				*
			FROM
				t_info AS MAIN
			WHERE
				MAIN.del_flg = ?
				AND MAIN.draft_flg = ?
				AND MAIN.id = ?
				AND MAIN.event_accept_flg = ?
				AND (MAIN.event_accept_end_date >= CURRENT_DATE()
				     OR MAIN.event_accept_end_date IS NULL)
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = Draft_flg::NOT_DRAFT;
		$value_array[] = $post_id;
		$value_array[] = Valid_flg::VALID;

		$ret = $this->db->query($sql, $value_array)->result();

		return ( ! empty($ret));
	}
}