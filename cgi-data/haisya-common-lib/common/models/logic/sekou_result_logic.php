<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 施工実績紹介用のロジック
 * 
 * @author ta-ando
 *
 */
class Sekou_result_logic extends Base_post_Model
{
	/**
	 * 製品に紐付いた施工実績記録を取得する。
	 * 
	 * @param unknown_type $post_id
	 */
	public function get_sekou_result_list($post_id)
	{
		$params = array(
		              'relation_data_type' => Relation_data_type::ITEM,
		              'relation_data_id' => $post_id,
		              'draft_flg' => Draft_flg::NOT_DRAFT
		          );

		$nds_pagination = new Nds_pagination(FALSE);
		$nds_pagination->add_order('post_date', 'DESC')
		               ->add_order('id', 'DESC');
		
		$list =  $this->T_item_sekou_results->simple_select_for_front($params, $nds_pagination);

		//空であればFALSEを返す
		if (empty($list))
		{
			return FALSE;
		}

		$ret = array();

		//表を取得する
		foreach ($list as $entity)
		{
			$tmp = (array)$entity;

			$tmp['image_entity_list'] = $this->T_file->find_by_related_data(
			                                                      Relation_data_type::ITEM_SEKOU_RESULTS,
			                                                      $entity->id,
			                                                      File_type::IMAGE
			                                                  );

			$tmp['doc_entity_list'] = $this->T_file->find_by_related_data(
			                                                      Relation_data_type::ITEM_SEKOU_RESULTS,
			                                                      $entity->id,
			                                                      File_type::DOCUMENT
			                                                  );

			$ret[] = $tmp;
		}

		return $ret;
	}
}
