<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ログインユーザーの情報を保持するDTO
 * 
 * @author ta-ando
 *
 */
class Login_user
{
	var $user_code;

	var $user_name;

	var $account_type;

	var $login_datetime;

	/** ログインしているサービスのコード */
	var $system_code;

	/**
	 * エヌディエスの管理者ユーザーかどうかを取得します
	 */
	public function is_nds_root()
	{
		return ($this->user_code === System_const::NDS_ROOT_USER);
	}

	/**
	 *	管理者ユーザーかどうかを取得します
	 */
	public function is_admin()
	{
		return Account_type::is_system_admin($this->account_type);
	}

	/**
	 * ログイン中のサービスとログイン情報が一致しているかを取得します。
	 * 
	 * @param unknown_type $system_code
	 */
	public function is_login_system($system_code)
	{
		if (Account_type::is_manage_page_user($this->account_type))
		{
			return TRUE;
		}

		return ($this->system_code === $system_code);
	}
}
