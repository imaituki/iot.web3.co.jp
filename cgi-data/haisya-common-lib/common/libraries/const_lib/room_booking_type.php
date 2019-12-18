<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 予約種別コードの定数クラス
 * @author ta-ando
 *
 */
class Room_booking_type extends Base_const_lib
{
	const AVAILABLE = 0;
	const BOOKING = 1;
	const NOT_AVAILABLE = 2;

	/**  申し込みフォーム使用フラグのリスト */
	static $CONST_ARRAY = array(
		self::AVAILABLE => '空き',
		self::BOOKING => '予約',
		self::NOT_AVAILABLE => '予約不可',
	);

	/**
	 * ラベルを取得する。
	 * 条件：コードの一致
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}
}
