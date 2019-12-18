<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 言語種別の定数クラス
 * @author ta-ando
 *
 */
class Language extends Base_const_lib
{
	/** 言語種別 */
	const ENGLISH = 'eng';
	const JAPANESE = 'jpn';

	/** 言語種別のリスト */
	static $CONST_ARRAY = array(
		self::ENGLISH => '英語',
		self::JAPANESE => '日本語',
	);

	/**
	 * 言語種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}
}
