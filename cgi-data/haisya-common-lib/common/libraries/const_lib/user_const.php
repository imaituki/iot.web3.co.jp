<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ユーザの定数クラス
 * @author ta-ando
 *
 */
class User_const extends Base_const_lib
{
	const ACCOUNT_TYPE_COMMON = 100;
	const ACCOUNT_TYPE_ADMIN  = 500;

	/** アカウントタイプのリスト */
	static $CONST_ARRAY = array(
		self::ACCOUNT_TYPE_COMMON => '一般ユーザ',
		self::ACCOUNT_TYPE_ADMIN  => '管理者',
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

	/**
	 * ラベルを取得する（brank label なし)
	 * 
	 * @param unknown_type $key
	 */
    public static function get_dropdown_list_without_blank()
    {
        return self::$CONST_ARRAY;
    }
}
