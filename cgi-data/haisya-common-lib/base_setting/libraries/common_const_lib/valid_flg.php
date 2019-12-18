<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 有効フラグの定数クラス
 * @author ta-ando
 *
 */
class Valid_flg extends Base_const_lib
{
	const VALID = '1';
	const INVALID = '0';

	/** 有効フラグのリスト */
	static $CONST_ARRAY = array(
		self::VALID => '有効',
		self::INVALID => '無効',
	);

	/**
	 * 有効フラグのラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}
}
