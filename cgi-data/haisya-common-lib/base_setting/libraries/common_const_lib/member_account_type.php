<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * アカウント管理用のアカウント種別の定数クラス
 * @author ta-ando
 *
 */
class Member_Account_type extends Base_const_lib
{
	/** アカウント種別 */
	const MEMBER_ADMIN = 80;
	const MEMBER_GENERAL = 60;

	static $MEMBER_ACCOUNT_ARRAY = array(
		self::MEMBER_ADMIN => 'サイト管理者',
		self::MEMBER_GENERAL => '一般ユーザー',
	);

	/**
	 * アカウント種別のラベルを取得する
	 * 
	 * @param unknown_type $key
	 */
	public static function get_label($key)
	{
		return parent::get_label(self::$MEMBER_ACCOUNT_ARRAY, $key);
	}

	/**
	 * リストを取得する
	 * 要素:key(コード) => value(ラベル)
	 * ※1要素目は '' => '--'
	 * @param unknown_type $key
	 */
	public static function get_dropdown_list()
	{
		return parent::create_blank_first_list(self::$MEMBER_ACCOUNT_ARRAY);
	}

	/**
	 * root管理者かどうかを取得する
	 * 
	 * @param unknown_type $account_type
	 */
	public static function is_member_admin($account_type)
	{
		return ($account_type === self::MEMBER_ADMIN);
	}

	/**
	 * root管理者かどうかを取得する
	 * 
	 * @param unknown_type $account_type
	 */
	public static function is_over_member_admin($account_type)
	{
		return ($account_type >= self::MEMBER_ADMIN);
	}

	/**
	 * 全体管理画面にログインできるユーザーかどうかを取得する
	 * 
	 * @param unknown_type $account_type
	 */
	public static function is_manage_page_user($account_type)
	{
		return ($account_type >= self::MEMBER_GENERAL);
	}
}
