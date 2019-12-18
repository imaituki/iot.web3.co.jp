<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 企業種別の定数クラス
 * @author ta-ando
 *
 */
class Company_type extends Base_const_lib
{
	const PLACE = 'place';
	const SHOP = 'shop';
	const COMPANY = 'company';

	/** クライアント種別のリスト */
	static $CONST_ARRAY = array(
		self::PLACE => '施設/観光地',
		self::SHOP => '店舗',
		self::COMPANY => '企業',
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

	/**
	 * ラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_dropdown_list()
	{
		return parent::create_blank_first_list(self::$CONST_ARRAY);
	}
}
