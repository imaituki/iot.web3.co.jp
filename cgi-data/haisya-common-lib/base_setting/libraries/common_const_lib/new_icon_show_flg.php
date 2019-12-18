<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Newフラグ表示に使用する定数クラス
 * @author ta-ando
 *
 */
class New_icon_show_flg extends Base_const_lib
{
	const SHOW = '1';
	const NOT_SHOW = '0';

	/** 有効/無効フラグのリスト */
	static $CONST_ARRAY = array(
		self::SHOW => '表示',
		self::NOT_SHOW => '表示しない',
	);

	/**
	 * 有効/無効ラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		$ret = parent::get_label(self::$CONST_ARRAY, $key);

		if ($ret == '')
		{
			return parent::get_label(self::$CONST_ARRAY, self::NOT_SHOW);
		}
		else
		{
			return $ret;
		}
	}
}
