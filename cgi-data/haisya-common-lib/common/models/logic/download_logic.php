<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ダウンロード用のロジック
 * 
 * @author ta-ando
 *
 */
class Download_logic extends Base_post_Model
{
	/**
	 * 製品に紐付いたその他ダウンロードを取得する。
	 * 
	 * @param unknown_type $post_id
	 */
	public function get_item_download_list($post_id)
	{
		$params = array(
		              'relation_data_type' => Relation_data_type::ITEM,
		              'relation_data_id' => $post_id,
		              'draft_flg' => Draft_flg::NOT_DRAFT
		          );

		$nds_pagination = new Nds_pagination(FALSE);

		$nds_pagination->add_order('main_category_kubun_code', 'ASC')
		               ->add_order('post_date', 'DESC')
		               ->add_order('id', 'DESC');

		$list =  $this->T_item_download->simple_select_for_front($params, $nds_pagination);

		//空であればFALSEを返す
		if (empty($list))
		{
			return FALSE;
		}

		$ret = array();

		//ファイルを取得する
		foreach ($list as $entity)
		{
			$tmp = (array)$entity;
			$tmp['doc_entity_list'] = $this->T_file->find_by_related_data(
			                                             Relation_data_type::ITEM_DOWNLOAD,
			                                             $entity->id,
			                                             File_type::DOCUMENT
			                                         );

			$ret[] = $tmp;
		}

		return $ret;
	}

	/**
	 * 製品に紐付いた断面図を取得する。
	 * 
	 * @param unknown_type $post_id
	 */
	public function get_item_cutaway_list($post_id)
	{
		$params = array(
		              'relation_data_type' => Relation_data_type::ITEM,
		              'relation_data_id' => $post_id,
		              'draft_flg' => Draft_flg::NOT_DRAFT
		          );

		$nds_pagination = new Nds_pagination(FALSE);

		$nds_pagination->add_order('post_date', 'DESC')
		               ->add_order('id', 'DESC');

		$list =  $this->T_item_cutaway->simple_select_for_front($params, $nds_pagination);

		$ret = array();
		
		if ( ! empty($list))
		{
			foreach ($list as $entity)
			{
				$tmp = (array)$entity;
				
				$nds_pagination = new Nds_pagination(FALSE);
				$nds_pagination->add_order('order_number', 'ASC');
				$nds_pagination->add_order('id', 'ASC');
				
				$params = array(
					'relation_data_type' => Relation_data_type::ITEM_CUTAWAY,
					'relation_data_id' => $entity->id
				);
		
				$file_list = $this->T_cutaway_file->select_for_manage($nds_pagination, $params);

				$tmp['cutway_file_list'] = $this->_convert_cutaway_file_list($file_list, $entity->cutway_upload_dir_path);
				
				$ret[] = $tmp;
			}
		}
		
		
		return $ret;
	}

	private function _check_file_exist($dir_path, $file_name, $file_extention)
	{
		$file_path = $dir_path.$file_name.$file_extention;

		return file_exists($file_path)
		       ? Valid_flg::VALID
		       : Valid_flg::INVALID;
	}

	
	/**
	 * 
	 */
	private function _convert_cutaway_file_list($list, $cutway_upload_dir_path)
	{
		$ret = array();
			
		foreach ($list as $file_entity)
		{
			$tmp = (array)$file_entity;

			$cutway_dir = config_item("item_download_cutaway_upload_dir_prefix").$cutway_upload_dir_path;

			$tmp["sfc_flg"] = $this->_check_file_exist($cutway_dir, $file_entity->file_name, '.sfc');
			$tmp["dxf_flg"] = $this->_check_file_exist($cutway_dir, $file_entity->file_name, '.dxf');
			$tmp["dwg_flg"] = $this->_check_file_exist($cutway_dir, $file_entity->file_name, '.dwg');
			$tmp["xls_flg"] = $this->_check_file_exist($cutway_dir, $file_entity->file_name, '.xls');
			$tmp["pdf_flg"] = $this->_check_file_exist($cutway_dir, $file_entity->file_name, '.pdf');
			$tmp["jpg_flg"] = $this->_check_file_exist($cutway_dir, $file_entity->file_name, '.jpg');

			$ret[] = $tmp;
		}

		return $ret;
	}

	/**
	 * カテゴリー名を取得する。
	 * 
	 * @param unknown_type $kubun_code 区分コード or 区分コードの配列
	 */
	function get_category_name($kubun_code)
	{
		return $this->M_kubun->get_joined_label_by_kubun_codes(
		                           Relation_data_type::ITEM_DOWNLOAD,
		                           Kubun_type::CATEGORY,
		                           $kubun_code
		                       );
	}
}