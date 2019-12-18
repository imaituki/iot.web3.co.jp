<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * アクセスカウンターのクラスです。
 * @author ta-ando
 *
 */
class T_simple_counter extends Base_model 
{
	var $relation_data_type;  // 関連データタイプ
	var $relation_data_id;  // 関連データID
	var $access_count;

	/**
	 * アクセスカウントをインクリメントする。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 */
	public function access($relation_data_type, $relation_data_id)
	{
		$ret = $this->db->from($this->_table)
					->where('relation_data_type', $relation_data_type)
					->where('relation_data_id', $relation_data_id)
					->where('del_flg', Del_flg::NOT_DELETE)
					->limit(1)
					->get()
					->result();

		if ( ! $ret)
		{
			$this->relation_data_type = $relation_data_type;
			$this->relation_data_id = $relation_data_id;
			$this->access_count = 1;
			$this->insert('system');
		}
		else
		{
			$entity = $ret[0];
			$entity->access_count += 1;
			$this->update('system', $entity);
		}
	}

	/**
	 * 指定したIDのデータのカウント数を取得する
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 */
	public function get_access_count($relation_data_type, $relation_data_id)
	{
		$ret = $this->select_entity_by_params(
		                  array(
		                      'relation_data_type' => $relation_data_type,
		                      'relation_data_id' => $relation_data_id,
		                  )
		              );

		return ( ! $ret)
		       ? 0
		       : $ret->access_count;
	}
}