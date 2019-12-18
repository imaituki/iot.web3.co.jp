<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 製品記事用のロジック
 * 
 * @author ta-ando
 *
 */
class Item_free_logic extends Base_post_Model
{
	/**
	 * 製品に紐付いた記事を取得する。
	 * 
	 * @param unknown_type $post_id
	 */
	public function get_free_data($post_id)
	{
		$params = array(
		              'relation_data_type' => Relation_data_type::ITEM,
		              'relation_data_id' => $post_id,
		              'draft_flg' => Draft_flg::NOT_DRAFT
		          );

		$nds_pagination = new Nds_pagination(FALSE);
		$nds_pagination->add_order('order_number', 'DESC')
		               ->add_order('main_category_kubun_code', 'ASC')
		               ->add_order('post_date', 'DESC')
		               ->add_order('id', 'DESC');
		
		$free_list =  $this->T_item_free->simple_select_for_front($params, $nds_pagination);

		//空であればFALSEを返す
		if (empty($free_list))
		{
			return FALSE;
		}

		$ret = array();

		//表を取得する
		foreach ($free_list as $entity)
		{
			$tmp = (array)$entity;
			$tmp['free_table_list'] = $this->get_free_table_data($entity->id);
			
			$tmp['image_entity_list'] = $this->T_file->find_by_related_data(
			                                                      Relation_data_type::ITEM_FREE,
			                                                      $entity->id,
			                                                      File_type::IMAGE
			                                                  );

			$tmp['doc_entity_list'] = $this->T_file->find_by_related_data(
			                                                      Relation_data_type::ITEM_FREE,
			                                                      $entity->id,
			                                                      File_type::DOCUMENT
			                                                  );

			$ret[] = $tmp;
		}

		return $ret;
	}

	/**
	 * 製品に紐付いた表データを取得する。
	 * 
	 * @param unknown_type $post_id (記事のID)
	 */
	public function get_free_table_data($post_id)
	{
		$relation_list = $this->Relation_logic->get_item_related_free_table_list($post_id);

		if (empty($relation_list))
		{
			return FALSE;
		}

		$ret = array();

		foreach ($relation_list as $relation_entity)
		{
			$free_table_entity = $this->T_item_free_table->find_released($relation_entity->child_relation_data_id);
	
			if ($free_table_entity)
			{
				$ret[] = $free_table_entity;
			}
		}

		return $ret;
	}

	/**
	 * 記事のカテゴリーを取得する。
	 * 
	 * @param unknown_type $category_kubun_code
	 */
	public function get_category_label($category_kubun_code)
	{
		 return $this->M_kubun->get_label_by_kubun_code(
			                       Relation_data_type::ITEM_FREE,
			                       Kubun_type::CATEGORY,
			                       $category_kubun_code
			                   );
	}
}