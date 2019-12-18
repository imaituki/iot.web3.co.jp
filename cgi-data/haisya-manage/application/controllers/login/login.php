<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * ログイン、ログアウトを行うクラス
 * * @author ta-ando
 *
 */
class Login extends Common_Controller 
{
	/** フォームで使用するパラメータ名 */
	const F_USER_CODE = 'user_code';
	const F_PASSWORD = 'password';

	/**
	 * コンストラクタ
	 * ・画面独自のライブラリ、ヘルパなどの読み込み
	 * ・画面で使用する変数情報をセット
	 */
	public function __construct()
	{
		parent::__construct();
		// これ以降にコードを書いていく

		/*
		 * 画面に固有の情報をセット
		 */

		$this->package_name = 'login';
		$this->common_h3_tag = 'ログイン';

		$this->page_type = Page_type::SIMPLE;
		$this->current_main_menu = $this->package_name;
		//フォームにセットするこのクラスのパス
		$class_name = strtolower(get_class($this));
		$this->common_form_action_base = "{$this->package_name}/{$class_name}/";

		//ページ固有のレイアウトを設定
		$this->layout['layout'] = "{$this->layout_dir}/layout_login";

		//HTTPのGET,POST情報を$this->dataに移送
		$this->_httpinput_to_data();
	}

	/**
	 * 初期表示を行う。
	 */
	public function index()
	{
		/*
		 * 初期処理
		 */

		$this->session->sess_destroy();

		$this->login_user = FALSE;
		$this->application_session_data = FALSE;

		$this->_load_tpl($this->_get_view_name(View_type::INDEX), $this->data);
	}

	/**
	 * ログイン処理を行う
	 */
	public function check()
	{
		if ( ! $this->_input_check())
		{
			$this->_load_tpl($this->_get_view_name(View_type::INDEX), $this->data);
			return;
		}

		if ( ! $this->_db_check()) 
		{
			$this->error_list['login_failed'] = 'ユーザIDとパスワードが一致しません';

			$this->_load_tpl($this->_get_view_name(View_type::INDEX), $this->data);
			return;
		}

		$this->_set_login_user_data();
		$this->_set_application_data();

		//トップ画面へリダイレクト
		redirect('top/top/', 'location', 301);
	}

	/**
	 * ログアウト処理
	 */
	public function logout()
	{
		//セッション情報を破棄
		$this->session->sess_destroy();

		//トップ画面へリダイレクト
		redirect('login/login/', 'location', 301);
	}

	/**
	 * 入力チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_USER_CODE, 'ユーザーコード', 'required');
		$this->form_validation->set_rules(self::F_PASSWORD, 'パスワード', 'required');

		return $this->form_validation->run();
	}

	/**
	 * DBのユーザID,パスワードと照合を行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _db_check()
	{
		$user_entity = $this->M_user->get_by_user_code($this->data[self::F_USER_CODE]);

		if ( ! $user_entity)
		{
			return FALSE;
		}

		//生成時と同じ方法でパスワードを作成する。
		$enc_pw = crypt($this->data[self::F_PASSWORD], $user_entity->password);	// 入力パスワードのエンコーディング

		if ($enc_pw != $user_entity->password)
		{
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * 認証に一致したユーザの情報をログインユーザ情報オブジェクトにセットして取得する。
	 */
	private function _set_login_user_data() 
	{
		$user_entity = $this->M_user->get_by_user_code($this->data[self::F_USER_CODE]);

		$login_user = new Login_user();
		$login_user->user_code = $user_entity->user_code;
		$login_user->user_name = $user_entity->user_name;
		$login_user->login_datetime = date('Y-m-d H:i:s');
		$login_user->account_type = (int)$user_entity->account_type;

		log_message(Log_const::INFO, "ログイン成功:ユーザー:{$this->data[self::F_USER_CODE]}");

		//セッションにユーザ情報をセット
		$this->session->set_userdata(self::SESSION_KEY_LOGIN_USER, $login_user);
	}

	/**
	 * アプリケーション
	 */
	private function _set_application_data() 
	{
		$application_session_data = new Application_session_data();
		$this->application_session_data = $application_session_data;

		//セッションにユーザ情報をセット
		$this->session->set_userdata(self::SESSION_KEY_APPLICATION_SESSION_DATA, $application_session_data);
	}
}