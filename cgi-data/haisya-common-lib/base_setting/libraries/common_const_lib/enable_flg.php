<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 有効/無効フラグの定数クラス
 * @author ta-ando
 *
 */
class Enable_flg extends Base_const_lib
{
	const ENABLE = '1';
	const DISABLE = '0';

	/** 有効/無効フラグのリスト */
	static $CONST_ARRAY = array(
		self::ENABLE => '使用する',
		self::DISABLE => '使用しない',
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
			return parent::get_label(self::$CONST_ARRAY, self::DISABLE);
		}
		else
		{
			return $ret;
		}
	}
}
