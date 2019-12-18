<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ログインユーザーの情報を保持するDTO
 * 
 * @author ta-ando
 *
 */
class Member_login_user
{
	var $member_id;

	var $email;

	var $name;

	var $member_type;

	var $login_datetime;

	/**
	 * エヌディエスの管理者ユーザーかどうかを取得します
	 */
	public function is_nds_root()
	{
		return FALSE;
	}

	/**
	 *	管理者ユーザーかどうかを取得します
	 */
	public function is_admin()
	{
		return FALSE;
	}

	/**
	 * ログイン中のサービスとログイン情報が一致しているかを取得します。
	 * 
	 * @param unknown_type $system_code
	 */
	public function is_login_system($system_code)
	{
		return FALSE;
	}
}
