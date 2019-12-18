<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 支払いステータスの定数クラス
 * @author ta-ando
 *
 */
class Pay_status extends Base_const_lib
{
	const FREE = 1;	//無料
	const PAY = 2;	//有料

	/** リスト */
	static $CONST_ARRAY = array(
		self::FREE => '無料',
		self::PAY => '有料',
	);

	/**
	 * ラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}

	/**
	 * ラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_dropdown_list()
	{
		return parent::create_blank_first_list(self::$CONST_ARRAY);
	}
}
