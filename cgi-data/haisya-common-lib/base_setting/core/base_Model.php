<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Model
 * ※このクラスがロードされるのは各プロジェクトのcore/MY_Model.phpのファイル一番下のrequire_once
 * @author localdisk 
 * @property CI_DB_active_record $db
*/
class Base_Model extends CI_Model
{
	/** 自動採番によるサロゲートキー */
	var $id;

	/** 削除フラグ */
	var $del_flg = 0;

	/** 登録ユーザ */
	var $insert_user;

	/** 登録日時 */
	var $insert_datetime;

	/** 更新ユーザ */
	var $update_user;

	/** 更新日時 */
	var $update_datetime;

	const ID = "id";

	const DEL_FLG = "del_flg";

	/** 管理カラム */
	static $MANAGE_COLUMN = array(
		'id',
		'del_flg',
		'insert_user',
		'insert_datetime',
		'update_user',
		'update_datetime',
	);

	/**
	* table name
	* 
	* @var string
	*/
	protected $_table;

	/**
	* constructor
	*/
	public function __construct() 
	{
		parent::__construct();
		$this->_table = strtolower(get_class($this));
	}

	/**
	* now
	* 
	* @return string
	*/
	public function now() 
	{
		return date('Y-m-d H:i:s');
	}

	/**
	* insert
	* 
	* @return integer 
	*/
	public function insert($user_code = "system", $data = null) 
	{
		$now = $this->now();

		if ($data === null)
		{
			$data = $this;
		}

		$data->id =null;

		$data->insert_user = $user_code;
		$data->insert_datetime = $now;
		$data->update_datetime = $now;
		$ret = $this->db
				->insert($this->_table, $data);
	
		if ($ret === FALSE) 
		{
			return FALSE;
		}
		return $this->db->insert_id();
	}

	/**
	* update
	* 
	* @param integer|string $id
	*/
	public function update($user_code = "system", $data = null) 
	{
		if ($data === null)
		{
			$data = $this;
		}

		$now = $this->now();

		$data->update_user = $user_code;
		$data->update_datetime = $now;
	
		$ret = $this->db
				->where('id', $data->id)
				->update($this->_table, $data);

		if ($ret === FALSE)
		{
			return FALSE;
		}
	}

	/**
	* delete
	* 
	* @param integer|strng $id 
	*/
	public function delete($id) 
	{
		$this->db
			->where('id', $id)
			->delete($this->_table);
	}

	/**
	 * 配列で渡されたパラメータを元にシンプルなSQLを作成し、レコードを物理削除する。
	 * $paramsは連想配列のキーにカラム名、値に検索条件をセットしたものを想定している。
	 * 
	 * @param unknown_type $params
	 */
	public function delete_by_params($params)
	{
		$this->db->from($this->_table);

		foreach ($params as $key => $value)
		{
			$this->db->where($key, $value);
		}

		$this->db->delete();
	}

	/**
	* 論理削除
	* 
	* @param integer|strng $id 
	*/
	public function logical_delete($id, $user_code = "system") 
	{
		$this->db->set('del_flg', Del_flg::DELETE);
		$this->db->set('update_user', $user_code);
		$this->db->where('id', $id);
		$this->db->update($this->_table);
	}

	/**
	 * 配列で渡されたパラメータを元にシンプルなSQLを作成し、検索結果のリストを取得する。
	 * $paramsは連想配列のキーにカラム名、値に検索条件をセットしたものを想定している。
	 * 
	 * @param unknown_type $params
	 * @param unknown_type $limit
	 * @param unknown_type $orderby_str
	 */
	public function select_by_params($params, $limit = FALSE, $orderby_str = 'id ASC')
	{
		$this->db->from($this->_table);
		$this->db->where('del_flg', Del_flg::NOT_DELETE);

		foreach ($params as $key => $value)
		{
			$this->db->where($key, $value);
		}

		if (is_num($limit))
		{
			$this->db->limit($limit);
		}

		$this->db->order_by($orderby_str);

		return $this->db->get()->result();
	}

	/**
	 * 配列で渡されたパラメータを元にシンプルなSQLを作成し、検索結果のリストから1エンティティを取得する。
	 * $paramsは連想配列のキーにカラム名、値に検索条件をセットしたものを想定している。
	 * 
	 * @param unknown_type $params
	 */
	public function select_entity_by_params($params)
	{
		$result = $this->select_by_params($params);

		return empty($result)
		       ? FALSE
		       : $result[0];
	}

	/**
	 * 指定したカラムの値を取得する。
	 * 
	 * @param unknown_type $post_id
	 * @param unknown_type $column_name
	 */
	protected function select_column($post_id, $column_name)
	{
		$entity = $this->select_entity_by_params(
		                     array('id' => $post_id)
		                 );

		return isset($entity->$column_name)
		       ? $entity->$column_name
		       : '';
	}

	/**
	 * 配列で渡されたパラメータを元にシンプルなSQLを作成し、検索結果が存在するかどうかをbooleanで取得する。
	 * $paramsは連想配列のキーにカラム名、値に検索条件をセットしたものを想定している。
	 * 
	 * @param unknown_type $params
	 * @return TRUE:存在する, FALSE:存在しない
	 */
	public function is_exists_by_params($params)
	{
		$result = $this->select_by_params($params);

		return (! empty($result));
	}

	/**
	* find_all
	* 
	* @return array
	*/
	public function find_all() 
	{
		return $this->select_by_params(
		                  array()
		              );
	}

	/**
	* find_list
	* 
	* @param  integer|string $limit
	* @return array
	*/
	public function find_list($limit = 10) 
	{
		return $this->select_by_params(
		                  array(),
		                  $limit
		              );
	}

	/**
	* idカラムを条件にエンティティを1つ取得する
	* 
	* @param  integer|string $id
	* @return stdClass
	*/
	public function find($id) 
	{
		return $this->select_entity_by_params(
		                  array('id' => $id)
		              );
	}

	/**
	* idカラムを条件にエンティティを1つ取得する。
	* 未削除かつ、公開可のエンティティのみを取得する。
	* ※draft_flgを持つテーブルの場合にのみ使用すること。
	* @param  integer|string $id
	* @return stdClass
	*/
	public function find_released($id) 
	{
		return $this->select_entity_by_params(
		                  array(
		                      'id' => $id, 
		                      'draft_flg' => Draft_flg::NOT_DRAFT
		                  )
		              );
	}

	/**
	 * idカラムと関連IDを条件にエンティティを1つ取得する。
	 * ※relation_data_type, relation_data_idを持つテーブルの場合にのみ使用すること。
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 */
	public function find_with_relation_id($id, $relation_data_type, $relation_data_id)
	{
		return $this->select_entity_by_params(
		                  array(
		                      'id' => $id, 
		                      'relation_data_type' => $relation_data_type,
		                      'relation_data_id' => $relation_data_id,
		                  )
		              );
	}

	/**
	 * idカラムと関連IDを条件にエンティティを1つ取得する。
	 * 未削除かつ、公開可のエンティティのみを取得する。
	 * ※relation_data_type, relation_data_id, draft_flgを持つテーブルの場合にのみ使用すること。
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 */
	public function find_released_with_relation_id($id, $relation_data_type, $relation_data_id)
	{
		return $this->select_entity_by_params(
		                  array(
		                      'id' => $id,
		                      'draft_flg' => Draft_flg::NOT_DRAFT,
		                      'relation_data_type' => $relation_data_type,
		                      'relation_data_id' => $relation_data_id,
		                  )
		              );
	}

	/**
	 * idカラムと関連IDを条件にエンティティが存在するかどうかを取得する。
	 * ※relation_data_type, relation_data_idを持つテーブルの場合にのみ使用すること。
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 */
	public function is_relation_exists($id, $relation_data_type, $relation_data_id)
	{
		return $this->is_exists_by_params(
		                  array(
		                      'id' => $id, 
		                      'relation_data_type' => $relation_data_type,
		                      'relation_data_id' => $relation_data_id,
		                  )
		              );
	}

	/**
	 * リストを取得する。
	 * 要素：エンティティ
	 * ソート順：データの更新日時の降順
	 * 
	 * @param Nds_pagination $nds_pagination, 
	 */
	function find_current_update_record(Nds_pagination $nds_pagination, $params = array())
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.*,
				CASE 
					WHEN MAIN.update_datetime IS NOT NULL 
						THEN MAIN.update_datetime 
					ELSE
						MAIN.insert_datetime 
					END AS current_handling_datetime
			FROM
				{$this->_table} AS MAIN
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Del_flg::NOT_DELETE;

		//関連データタイプとID
		if (isset($params['relation_data_type']) && is_not_blank($params['relation_data_type'])
		&& isset($params['relation_data_id']) && is_not_blank($params['relation_data_id']))
		{
			$sql .= '
				AND MAIN.relation_data_type = ?
				AND MAIN.relation_data_id = ?
			';

			$value_array[] = $params['relation_data_type'];
			$value_array[] = $params['relation_data_id'];
		}

		/*
		 * ソート順は固定。LIMIT/OFFSETは$nds_paginationから取得
		 */

		$paging_array = $nds_pagination->get_sql_paging_condition();

		$sql .= "
			ORDER BY
				current_handling_datetime DESC
		";

		if ($paging_array['limit'] > 0) 
		{
			$sql .= '
				LIMIT ?
				OFFSET ?
			';
			$value_array[] = $paging_array['limit'];
			$value_array[] = $paging_array['offset'];
		}

		return $this->db->query($sql, $value_array)->result();
	}

	/**
	 * 関連データで絞った中で、更新されたのが最新のデータを取得する。
	 * 
	 */
	function get_last_update_datetime($params = array())
	{
		$nds_pagination = new Nds_pagination(1, 1);

		$ret_list = $this->find_current_update_record($nds_pagination, $params);

		return ($ret_list) 
		       ? $ret_list[0]->current_handling_datetime
		       : '';
	}

	/**
	 * IDで指定したエンティティから指定したカラムの値を取得する。
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $column_name
	 */
	function find_and_get_column($id, $column_name)
	{
		$entity = $this->find($id);
		return ($entity && isset($entity->$column_name))
		       ? $entity->$column_name
		       : "";
	}

	/**
	 * ドロップダウンでの使用を想定したkeyとvalueを持ったリストを作成する。
	 * keyとvalueはDBのカラムを指定できる。
	 * 
	 * @param unknown_type $key_column
	 * @param unknown_type $value_column
	 * @param unknown_type $params
	 */
	function create_dropdown_list($key_column = 'id', $value_column = 'post_title', $params = array())
	{
		$list = $this->select_by_params($params);

		if (empty($list)) {
			return FALSE;
		}

		//戻り値用のリストを作成
		foreach ($list as $entity)
		{
			$ret[$entity->$key_column] = $entity->$value_column;
		}

		return $ret;
	}

	/**
	 * ドロップダウンでの使用を想定したkeyとvalueを持ち、先頭にブランク要素を持つリストを作成する。
	 * keyとvalueはDBのカラムを指定できる。
	 * 
	 * @param unknown_type $default_label
	 * @param unknown_type $key_column
	 * @param unknown_type $value_column
	 * @param unknown_type $params
	 */
	function create_dropdown_list_with_blank($default_label, $key_column = 'id', $value_column = 'post_title', $params = array())
	{
		$list = $this->create_dropdown_list($key_column, $value_column, $params);
		return create_blank_first_list($list, $default_label);
	}

	/**
	 * ページング、ソート順などをSQLにセットしてSELECTを実行する補助メソッド。
	 * エンティティのリストを取得します。
	 * 
	 * @param Nds_pagination $nds_pagination
	 * @param unknown_type $sql
	 * @param unknown_type $value_array
	 */
	protected function _do_paging_select(Nds_pagination $nds_pagination, $sql, $value_array)
	{
		$paging_array = $nds_pagination->get_sql_paging_condition();

		//ORDER BYでSELECTの追加カラムを使用するために一度ラップする。
		$sql = "SELECT * FROM ({$sql}) AS LAP_MAIN ";

		$sql .= "
			ORDER BY
				{$paging_array['order_by_array']}
		";

		if ($paging_array['limit'] > 0) 
		{
			$sql .= '
				LIMIT ?
				OFFSET ?
			';
			$value_array[] = $paging_array['limit'];
			$value_array[] = $paging_array['offset'];
		}

		//通常のSELECTを行う
		return $this->db->query($sql, $value_array)->result();
	}

}
