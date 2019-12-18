<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 画像の表示方法の定数クラス
 * @author ta-ando
 *
 */
class Image_display_type extends Base_const_lib
{
	const FIXED = '0';
	const FREE = '1';

	/** 有効フラグのリスト */
	static $CONST_ARRAY = array(
		self::FIXED => '定型パターン配置',
		self::FREE => '自由配置',
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
