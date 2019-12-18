<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * アカウント種別の定数クラス
 * @author ta-ando
 *
 */
class Account_type extends Base_const_lib
{
	/** アカウント種別 */
	const SYSTEM_ADMIN = 500;
	const SYSTEM_GENERAL = 100;
	const PUBLIC_USER = 50;

	static $SYSTEM_ACCOUNT_ARRAY = array(
		self::SYSTEM_ADMIN => '管理者',
		self::SYSTEM_GENERAL => '一般ユーザー',
	);

	/**
	 * アカウント種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$SYSTEM_ACCOUNT_ARRAY, $key);
	}

	/**
	 * リストを取得する
	 * 要素:key(コード) => value(ラベル)
	 * ※1要素目は '' => '--'
	 * @param unknown_type $key
	 */
	public static function get_dropdown_list()
	{
		return parent::create_blank_first_list(self::$SYSTEM_ACCOUNT_ARRAY);
	}

	/**
	 * root管理者かどうかを取得する
	 * 
	 * @param unknown_type $account_type
	 */
	public static function is_system_admin($account_type)
	{
		return ($account_type === self::SYSTEM_ADMIN);
	}

	/**
	 * root管理者かどうかを取得する
	 * 
	 * @param unknown_type $account_type
	 */
	public static function is_over_system_admin($account_type)
	{
		return ($account_type >= self::SYSTEM_ADMIN);
	}

	/**
	 * 全体管理画面にログインできるユーザーかどうかを取得する
	 * 
	 * @param unknown_type $account_type
	 */
	public static function is_manage_page_user($account_type)
	{
		return ($account_type >= self::SYSTEM_GENERAL);
	}
}
