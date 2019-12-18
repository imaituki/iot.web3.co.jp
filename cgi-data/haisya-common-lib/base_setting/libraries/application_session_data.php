<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * アプリケーションで必要な情報を保持するクラス。セッションに保存して使用する。
 * 
 * @author ta-ando
 *
 */
class Application_session_data
{
	/** 各データを操作する際に保持しておく必要のある関連データIDを保持する連想配列
	 *  '' => ''
	 * 
	 */
	var $relation_data_ids = array();
	var $relation_data_entities = array();

	/**
	 * 子データを操作中かどうかを取得する。
	 */
	public function is_handling_child()
	{
		return ! empty($this->relation_data_ids);
	}

	/**
	 * 保持用の配列に関連データ種別をキーにして関連データIDをセットする。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 */
	public function set_relation_data_id($relation_data_type, $relation_data_id)
	{
		$this->relation_data_ids["relation_data_type_{$relation_data_type}"] = $relation_data_id;
	}

	/**
	 * 保持用の配列に関連データ種別をキーにしてエンティティをセットする。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $entity
	 */
	public function set_relation_data_entity($relation_data_type, $entity)
	{
		$this->relation_data_entities["relation_data_type_{$relation_data_type}"] = $entity;
	}

	/**
	 * 関連データ種別をキーにして保持している関連データIDを取得する。
	 * 
	 * @param unknown_type $relation_data_type
	 */
	public function get_stored_id($relation_data_type)
	{
		return isset($this->relation_data_ids["relation_data_type_{$relation_data_type}"])
		       ? $this->relation_data_ids["relation_data_type_{$relation_data_type}"]
		       : FALSE;
	}

	/**
	 * 関連データ種別をキーにして保持しているエンティティを取得する。
	 * 
	 * @param unknown_type $relation_data_type
	 */
	public function get_stored_entity($relation_data_type)
	{
		return isset($this->relation_data_entities["relation_data_type_{$relation_data_type}"])
		       ? $this->relation_data_entities["relation_data_type_{$relation_data_type}"]
		       : FALSE;
	}

	/**
	 * 関連データ種別をキーにして保持している関連データIDを取得する。
	 * 
	 * @param unknown_type $relation_data_type
	 */
	public function remove_stored_data($relation_data_type)
	{
		 unset($this->relation_data_ids["relation_data_type_{$relation_data_type}"]);
		 unset($this->relation_data_entities["relation_data_type_{$relation_data_type}"]);
	}

	/**
	 * 必要とされる関連データのIDを保持しているかどうかを取得する。
	 * パッケージが必要とする関連データ種別は設定ファイルに書かれている。
	 * 
	 * @param unknown_type $package_name
	 */
	public function can_access_package($package_name)
	{
		$relation_data_type = config_item("{$package_name}_relation_data_type");

		if (is_blank($relation_data_type))
		{
			return TRUE;
		}

		return is_not_blank($this->get_stored_id($relation_data_type));
	}

	/**
	 * 指定したパッケージのデータが紐付くべき関連データ種別を取得する。
	 * 
	 * @param unknown_type $package_name
	 */
	public function get_relation_data_type($package_name)
	{
		$relation_data_type = config_item("{$package_name}_relation_data_type");

		return is_not_blank($relation_data_type)
		       ? $relation_data_type
		       : Relation_data_type::COMMON;
	}

	/**
	 * 保持している指定したパッケージのデータが紐付く関連データIDを取得する。
	 * 
	 * @param unknown_type $package_name
	 */
	public function get_relation_data_id($package_name)
	{
		$relation_data_type = config_item("{$package_name}_relation_data_type");

		if (is_blank($relation_data_type))
		{
			return Relation_data_id::DEFAULT_ID;
		}

		if (is_not_blank($this->get_stored_id($relation_data_type)))
		{
			return $this->get_stored_id($relation_data_type);
		}
		else
		{
			show_error("不正な画面遷移が行われています。メニューから再度やりなおしてください。");
		}
	}
}
