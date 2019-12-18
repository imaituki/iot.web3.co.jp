<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 会員種別の定数クラス
 * @author ta-ando
 *
 */
class Member_type extends Base_const_lib
{
	/** 会員種別 */
	const SPECIAL = 80;
	const NORMAL = 60;

	static $CONST_ARRAY = array(
		self::NORMAL => '一般会員',
		self::SPECIAL => '特別会員',
	);

	/**
	 * アカウント種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}

	/**
	 * リストを取得する
	 * 要素:key(コード) => value(ラベル)
	 * ※1要素目は '' => '--'
	 * @param unknown_type $key
	 */
	public static function get_dropdown_list()
	{
		return parent::create_blank_first_list(self::$CONST_ARRAY);
	}
}
