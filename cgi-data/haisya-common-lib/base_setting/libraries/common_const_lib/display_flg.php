<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 表示フラグの定数クラス
 * @author ta-ando
 *
 */
class Display_flg extends Base_const_lib
{
	const DISPLAY = '1';
	const NOT_DISPLAY = '0';

	/** 有無フラグのリスト */
	static $CONST_ARRAY = array(
		self::DISPLAY => '表示する',
		self::NOT_DISPLAY => '表示しない',
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
	 * 空白の選択肢を含むドロップダウン用のkey=>valueのリストを取得する。
	 * 
	 * @param unknown_type $blank_label
	 */
	public static function get_for_dropdown($blank_label = '--')
	{
		return parent::create_blank_first_list(self::$CONST_ARRAY, $blank_label);
	}
}
