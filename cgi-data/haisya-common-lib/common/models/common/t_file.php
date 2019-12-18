<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ファイル情報
 * 
 * @author ta-ando
 *
 */
class T_file extends Base_model
{
	var $relation_data_type;  // 関連データタイプ
	var $relation_data_id;  // 関連データID
	var $seq_no;  // 連番
	var $order_num;  // 並び順
	var $file_type;  // ファイル種別
	var $file_name;  // ファイル名
	var $title;  //表示用ファイル名（タイトル）
	var $caption;  // キャプション
	var $paragraph_title;  //章タイトル
	var $caption_position;	//キャプションの表示位置
	var $image_size;	//画像サイズ

	/**
	 * 連番を取得する
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 */
	function get_next_seq_no($relation_data_type, $relation_data_id)
	{
		$value_array = array();

		$sql = "
			SELECT
				COALESCE(MAX(seq_no), 0) + 1 AS new_seq_no
			FROM
				{$this->_table}
			WHERE
				relation_data_type = ?
				AND relation_data_id = ?
		";

		$value_array[] = $relation_data_type;
		$value_array[] = $relation_data_id;

		$query = $this->db->query($sql, $value_array);
		$result = $query->result();

		return  ($result !== FALSE && count($result) > 0) 
		        ? $result[0]->new_seq_no
		        : 1;
	}

	/**
	 * リストを取得する。
	 * 要素：エンティティ
	 * 条件：関連データ種別の一致、関連データID、ファイル種別の一致
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 * @param unknown_type $file_type
	 */
	function find_by_related_data($relation_data_type, $relation_data_id, $file_type)
	{
		return $this->select_by_params(
		                  array(
		                      'relation_data_type' => $relation_data_type,
		                      'relation_data_id' => $relation_data_id,
		                      'file_type' => $file_type,
		                  ),
		                  FALSE,
		                  'order_num ASC, seq_no ASC'
		              );
	}

	/**
	 * 一括で削除する。
	 * 条件：関連データ種別の一致、関連データID、ファイル種別の一致
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 * @param unknown_type $file_type
	 */
	function delete_by_related_data($relation_data_type, $relation_data_id, $file_type)
	{
		$this->db->from($this->_table);
		$this->db->where('relation_data_type', $relation_data_type);
		$this->db->where('relation_data_id', $relation_data_id);
		$this->db->where('file_type', $file_type);
		$this->db->delete();
	}

	/**
	 * ファイル種別に関係なく、一括で論理削除する。
	 * 条件：関連データ種別の一致、関連データID、ファイル種別の一致
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 */
	function logical_delete_by_relation_data($relation_data_type, $relation_data_id)
	{
		$this->db->from($this->_table);
		$this->db->where('relation_data_type', $relation_data_type);
		$this->db->where('relation_data_id', $relation_data_id);
		$result = $this->db->get()->result();

		if ($result && ! empty($result))
		{
			foreach ($result as $entity)
			{
				$this->logical_delete($entity->id);
			}
		}
	}
}