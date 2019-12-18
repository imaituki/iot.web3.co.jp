<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 製品用のロジック
 * 
 * @author ta-ando
 *
 */
class Item_logic extends Base_post_Model
{
	/**
	 * 名前を取得する。
	 * 
	 * @param unknown_type $post_id
	 * @param unknown_type $full_label
	 */
	function get_name($post_id, $full_label = TRUE)
	{
		$entity = $this->M_item->find($post_id);

		if ($entity)
		{
			return ($full_label)
			         ? "{$entity->post_title} / {$entity->post_sub_title}"
			         : $entity->post_title;
		}
		else
		{
			return '';
		}
	}

	/**
	 * ドロップダウン用のリストを取得する。
	 * 
	 * @param unknown_type $default_label
	 */
	function get_for_dropdown($default_label = '--')
	{
		$params = array();
		$list = $this->M_item->select_by_params($params, FALSE, $orderby_str = 'order_number DESC, id DESC');

		if (empty($list)) {
			return FALSE;
		}

		$ret = array();

		//戻り値用のリストを作成
		foreach ($list as $entity)
		{
			$ret[$entity->id] = "{$entity->post_title} / {$entity->post_sub_title}";
		}

		return create_blank_first_list($ret, $default_label);
	}

	/**
	 * 製品の関連製品を取得する。
	 * 
	 * @param unknown_type $post_id
	 */
	public function get_related_item_data($post_id)
	{
		$item_list =  $this->Relation_logic->get_item_related_item_entity_list($post_id);

		//空であればFALSEを返す
		if (empty($item_list))
		{
			return FALSE;
		}

		$ret = array();

		//表を取得する
		foreach ($item_list as $relation_entity)
		{
			$item = $this->M_item->find_released($relation_entity->child_relation_data_id);

			if ( ! $item)
			{
				continue;
			}

			$tmp = (array)$item;

			$tmp['image_entity_list'] = $this->T_file->find_by_related_data(
			                                                      Relation_data_type::ITEM,
			                                                      $item->id,
			                                                      File_type::IMAGE
			                                                  );

			$ret[] = $tmp;
		}

		return $ret;
	}

	/**
	 * 
	 */
	function get_category_count_list()
	{
		$kubun_count = $this->_get_category_kubun_list(Kubun_type::CATEGORY);

		$kubun_array = array();

		if ( ! empty($kubun_count))
		{
			foreach ($kubun_count as $kubun)
			{
				$kubun_array['kubun'.$kubun->kubun_code] = $kubun->item_count;
			}
		}

		return $kubun_array;
	}


	/**
	 * 
	 */
	function get_technic_count_list()
	{
		$kubun_count = $this->_get_category_kubun_list(Kubun_type::TECHNOLOGY);

		$kubun_array = array();

		if ( ! empty($kubun_count))
		{
			foreach ($kubun_count as $kubun)
			{
				$kubun_array['kubun'.$kubun->kubun_code] = $kubun->item_count;
			}
		}

		return $kubun_array;
	}

	/**
	 * 
	 */
	private function _get_category_kubun_list($kubun_type)
	{
		$params = array();
		
		$sql = "
			SELECT 
				kubun_code,
				count(*) AS item_count
			FROM
				v_relation_kubun as MAIN
			WHERE
				parent_relation_data_type = ?
				AND child_relation_data_type = ?
				AND child_kubun_type = ?
				AND EXISTS (
					SELECT
						 *
					FROM 
						m_item ITEM
					WHERE
						ITEM.id = MAIN.parent_relation_data_id
						AND ITEM.draft_flg = ?
						AND ITEM.del_flg = ?
					
				)
			GROUP BY
				kubun_code";

		$params[] = Relation_data_type::ITEM;
		$params[] = Relation_data_type::KUBUN;
		$params[] = $kubun_type;
		$params[] = Draft_flg::NOT_DRAFT;
		$params[] = Del_flg::NOT_DELETE;

		$nds_pagination = new Nds_pagination(FALSE);
		$nds_pagination->add_order('kubun_code', 'ASC');

		return $this->_do_paging_select($nds_pagination, $sql, $params);
	}

	/**
	 * 
	 * 
	 * @param unknown_type $item_id
	 * @param unknown_type $file_kubun_code
	 */
	function is_file_kubun_permitted($item_id, $file_kubun_code)
	{
		//製品に設定されたアクセス権限を取得する
		$forbidden_file_kubun_list = $this->V_relation_kubun->find_relation(
		                                             Relation_data_type::ITEM, 
		                                             $item_id, 
		                                             Kubun_type::LIMITED_DOWNLOAD_FILE
		                                         );

		foreach ($forbidden_file_kubun_list as $forbidden_entity)
		{
			if ($forbidden_entity->kubun_code == $file_kubun_code)
			{
				return FALSE;
			}
		}

		return TRUE;
	}

	/**
	 * 
	 */
	function get_download_category_count_list()
	{
		$kubun_count = $this->_get_kubun_list_having_download(Kubun_type::CATEGORY);

		$kubun_array = array();

		if ( ! empty($kubun_count))
		{
			foreach ($kubun_count as $kubun)
			{
				$kubun_array['kubun'.$kubun->kubun_code] = $kubun->item_count;
			}
		}

		return $kubun_array;
	}

	/**
	 * 
	 */
	function get_download_technic_count_list()
	{
		$kubun_count = $this->_get_kubun_list_having_download(Kubun_type::TECHNOLOGY);

		$kubun_array = array();

		if ( ! empty($kubun_count))
		{
			foreach ($kubun_count as $kubun)
			{
				$kubun_array['kubun'.$kubun->kubun_code] = $kubun->item_count;
			}
		}

		return $kubun_array;
	}

	/**
	 * 
	 * 
	 * @param unknown_type $kubun_type
	 */
	private function _get_kubun_list_having_download($kubun_type)
	{
		$params = array();
		
		$sql = "
			SELECT 
				kubun_code,
				count(*) AS item_count
			FROM
				v_relation_kubun as MAIN
			WHERE
				parent_relation_data_type = ?
				AND child_relation_data_type = ?
				AND child_kubun_type = ?
				AND EXISTS (
					SELECT
						 *
					FROM 
						m_item ITEM
					WHERE
						ITEM.id = MAIN.parent_relation_data_id
						AND ITEM.draft_flg = ?
						AND ITEM.del_flg = ?
				)
				AND (
					EXISTS (
						SELECT
							 *
						FROM 
							t_item_cutaway CUTAWAY
						WHERE
							CUTAWAY.relation_data_type = ?
							AND CUTAWAY.relation_data_id = MAIN.parent_relation_data_id
							AND CUTAWAY.draft_flg = ?
							AND CUTAWAY.del_flg = ?
					)
					OR
					EXISTS (
						SELECT
							 *
						FROM 
							t_item_sekou_results SEKOU
						WHERE
							SEKOU.relation_data_type = ?
							AND SEKOU.relation_data_id = MAIN.parent_relation_data_id
							AND SEKOU.draft_flg = ?
							AND SEKOU.del_flg = ?
					)
					OR
					EXISTS (
						SELECT
							 *
						FROM 
							t_item_download DOWNLOAD
						WHERE
							DOWNLOAD.relation_data_type = ?
							AND DOWNLOAD.relation_data_id = MAIN.parent_relation_data_id
							AND DOWNLOAD.draft_flg = ?
							AND DOWNLOAD.del_flg = ?
					)
				)
			GROUP BY
				kubun_code";

		$params[] = Relation_data_type::ITEM;
		$params[] = Relation_data_type::KUBUN;
		$params[] = $kubun_type;
		$params[] = Draft_flg::NOT_DRAFT;
		$params[] = Del_flg::NOT_DELETE;
		$params[] = Relation_data_type::ITEM;
		$params[] = Draft_flg::NOT_DRAFT;
		$params[] = Del_flg::NOT_DELETE;
		$params[] = Relation_data_type::ITEM;
		$params[] = Draft_flg::NOT_DRAFT;
		$params[] = Del_flg::NOT_DELETE;
		$params[] = Relation_data_type::ITEM;
		$params[] = Draft_flg::NOT_DRAFT;
		$params[] = Del_flg::NOT_DELETE;
		$nds_pagination = new Nds_pagination(FALSE);
		$nds_pagination->add_order('kubun_code', 'ASC');

		return $this->_do_paging_select($nds_pagination, $sql, $params);
	}

}