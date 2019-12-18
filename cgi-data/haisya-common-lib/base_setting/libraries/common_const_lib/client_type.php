<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * クライアント種別の定数クラス
 * @author ta-ando
 *
 */
class Client_type extends Base_const_lib
{
	const PC = 'pc';
	const SMART_PHONE = 'smart_phone';
	const MOBILE = 'mobile';

	/** クライアント種別のリスト */
	static $CONST_ARRAY = array(
		self::PC => 'PC',
		self::SMART_PHONE => 'スマートフォン',
		self::MOBILE => '携帯',
	);

	/**
	 * クライアント種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$CONST_ARRAY, $key);
	}
}
