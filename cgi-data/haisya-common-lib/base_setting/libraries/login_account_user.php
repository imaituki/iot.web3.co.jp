<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ログインユーザーの情報を保持するDTO
 * 
 * @author ta-ando
 *
 */
class Login_account_user
{
	var $user_code;

	var $user_name;

	var $account_type;

	var $login_datetime;

	/** ログインしている関連データ種別 */
	var $relation_data_type;

	/** ログインしている関連データID */
	var $relation_data_id;

	/** ログインしている関連データIDの表示用ラベル */
	var $relation_data_label;

	/** ログインしているサービスのコード */
	var $system_code;

	/**
	 *	管理者ユーザーかどうかを取得します
	 */
	public function is_admin()
	{
		return Member_Account_type::is_member_admin($this->account_type);
	}
}
