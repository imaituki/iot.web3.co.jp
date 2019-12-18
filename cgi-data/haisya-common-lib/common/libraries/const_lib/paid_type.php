<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 有料、無料の定数クラス
 * @author ta-ando
 *
 */
class Paid_type extends Base_const_lib
{
	const PAID = 'paid';
	const FREE = 'free';

	/** 有料、無料フラグのリスト */
	static $CONST_ARRAY = array(
		self::FREE => '無料',
		self::PAID => '有料',
	);

	/**
	 * 有料、無料ラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		$ret = parent::get_label(self::$CONST_ARRAY, $key);

		if ($ret == '')
		{
			return parent::get_label(self::$CONST_ARRAY, self::FREE);
		}
		else
		{
			return $ret;
		}
	}
}
