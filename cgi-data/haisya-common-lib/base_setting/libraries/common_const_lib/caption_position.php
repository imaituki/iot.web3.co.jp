<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * キャプション表示位置の定数クラス
 * @author ta-ando
 * 
 */
class Caption_position extends Base_const_lib
{
	/** 位置 */
	const TOP_SIDE = 1;
	const BOTTOM_SIDE = 2;
	const LEFT_SIDE = 3;
	const RIGHT_SIDE = 4;

	/** key=>valueのリスト */
	static $CONST_ARRAY = array(
		self::BOTTOM_SIDE => '画像の下',
		self::TOP_SIDE => '画像の上',
		self::LEFT_SIDE => '画像の左',
		self::RIGHT_SIDE => '画像の右',
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
}
