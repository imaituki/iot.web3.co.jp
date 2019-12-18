<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 組織種別の定数クラス
 * @author ta-ando
 *
 */
class Organization_type extends Base_const_lib
{
	const COMPANY = 1;	//企業
	const SHOP = 2;	//店舗
	const PLACE = 3;	//観光地

	/** リスト */
	static $CONST_ARRAY = array(
		self::COMPANY => '企業',
		self::SHOP => '店舗',
		self::PLACE => '施設/観光地',
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
	 * ラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_dropdown_list()
	{
		return parent::create_blank_first_list(self::$CONST_ARRAY);
	}
}
