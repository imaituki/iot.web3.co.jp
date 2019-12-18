<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 認証チェック用の情報クラス
 * 
 * @author ta-ando
 *
 */
class Auth_check
{
	//ログインしていない状態でアクセス可能なメソッドのリスト
	public static $NOT_LOGIN_REQUIRED = array(
		'//index/', //すべてのトップ
		'/welcome/index/',
		'login/',
		'login/show/',
		'login/index/',
		'login/check/',
		'login/logout/',
		'login/login/index/',
		'login/login/show/',
		'login/login/check/',
		'login/login/logout/',
		'app1st_login/app1st_login/index/',
		'app1st_login/app1st_login/check/',
		'app1st_login/app1st_login/logout/',
		'app2nd_login/app2nd_login/index/',
		'app2nd_login/app2nd_login/check/',
		'app2nd_login/app2nd_login/logout/',
		'thumbnail/thumbnail_viewer/show/',
		'data_convert/data_convert/index/'
	);
}
