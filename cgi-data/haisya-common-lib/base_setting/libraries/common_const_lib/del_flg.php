<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 削除フラグの定数クラス
 * @author ta-ando
 *
 */
class Del_flg extends Base_const_lib
{
	const DELETE = '1';
	const NOT_DELETE = '0';

	/** 削除フラグのリスト */
	static $CONST_ARRAY = array(
		self::DELETE => '削除',
		self::NOT_DELETE => '未削除',
	);

	/**
	 * 削除フラグのラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}
}
