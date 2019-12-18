<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 定数用クラスの親クラス
 * @author ta-ando
 *
 */
class Base_const_lib
{
	/**
	 * ラベルを取得する
	 * 
	 * @param unknown_type $const_array
	 * @param unknown_type $key
	 */
	protected static function get_label($const_array, $key = '')
	{
		return ( ! isset($const_array[$key])) ? '' : $const_array[$key];
	}

	/**
	 * リストを取得する。
	 * 要素：空の要素を含む、key(id) => value(company_name)の連想配列
	 * 
	 * @param unknown_type $list
	 * @param unknown_type $blank_label
	 */
	protected function create_blank_first_list($list, $blank_label = '--')
	{
		//ヘルパーに委譲
		return create_blank_first_list($list, $blank_label);
	}
}
