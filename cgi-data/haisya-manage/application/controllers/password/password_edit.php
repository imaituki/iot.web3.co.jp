<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * パスワードの変更を行うクラス
 * * @author ta-ando
 *
 */
class Password_edit extends Register_Controller 
{
	/** フォームで使用するパラメータ名 */
	const F_OLD_PASSWORD = 'old_password';
	const F_NEW_PASSWORD = 'new_password';
	const F_NEW_PASSWORD_RETYPE = 'new_password_retype';

	/**
	 * コンストラクタ
	 * ・画面独自のライブラリ、ヘルパなどの読み込み
	 * ・画面で使用する変数情報をセット
	 */
	public function __construct()
	{
		parent::__construct();

		/*
		 * 画面に固有の情報をセット
		 */

		$this->package_name = 'password';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_user;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//関係テーブルのデータをDBからの呼び出す
		$this->_init_relation_data();

		//乱数の生成で使用するHelper
		$this->load->helper('string');

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);
	}

	/**
	 * 初期表示を行う。
	 */
	public function index()
	{
		/*
		 * 初期処理
		 */

		$this->_unset_page_session();

		$this->_load_tpl($this->_get_view_name(View_type::INPUT), $this->data);
	}

	/**
	 * 確認画面の表示を行う。
	 * ・入力チェックでエラーが存在する場合は入力画面を再表示する。
	 * ・セッションにデータを保持
	 * ・確認画面を表示する。
	 */
	public function conf()
	{
		//チェック処理
		if ( ! $this->_input_check()
		or ! $this->_relation_check())
		{
			$this->_load_tpl($this->_get_view_name(View_type::INPUT), $this->data);
			return;
		}

		//セッションに情報を保持
		$this->_save_page_session(
		    parent::SESSION_KEY_INPUT_DATA,
		    $this->_create_session_value($this->optional_keys)
		);

		// ラベルに変換する
		$this->_convert_label();

		$this->_load_tpl($this->_get_view_name(View_type::CONF), $this->data);
	}

	/**
	 * 入力データを保持して入力画面に戻ります
	 */
	function back()
	{
		$this->_do_back();
		$this->_load_tpl($this->_get_view_name(View_type::INPUT), $this->data);
	}

	/**
	 * 実行ボタン押下時の処理を行う。
	 * ・DB更新処理
	 * ・完了画面にリダイレクト
	 * ※DB更新行うため、完了画面へリダイレクトする。
	 */
	function submit()
	{
		//DB更新処理
		$this->_do_db_logic();

		//完了画面表示用メソッドへリダイレクト
		redirect($this->_get_redirect_url_complete(), 'location', 301);
	}

	/**
	 * 完了画面を表示する
	 */
	function complete()
	{
		//セッションデータを削除
		$this->_unset_page_session();

		$this->_load_tpl($this->_get_view_name(View_type::COMPLETE), $this->data);
	}

	/**
	 * nds_system_manage_config.phpに記述されているページ用の設定を読み込みます。
	 */
	protected function _config_setting()
	{
		parent::_config_setting();

		/*
		 * この機能独自の設定がある場合は以降に記述する
		 */
	}

	/**
	 * 関係テーブルのデータをDBから読み取り画面のメンバに保持する。
	 */
	protected function _init_relation_data()
	{
		//parent::_init_relation_data();

		$this->kubun_id_list = $this->M_kubun->get_for_dropdown_for_manage();
	}

	/**
	 * 入力チェックを行う。
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_OLD_PASSWORD, '現在のパスワード', 'trim|required|alpha_numeric|max_length[25]');
		$this->form_validation->set_rules(self::F_NEW_PASSWORD, '新しいパスワード', 'trim|required|alpha_numeric|max_length[25]');
		$this->form_validation->set_rules(self::F_NEW_PASSWORD_RETYPE, '新しいパスワード(確認用)', 'trim|required|alpha_numeric|max_length[25]');

		return $this->form_validation->run();
	}

	/**
	 * 相関チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _relation_check()
	{
		$ret = TRUE;

		//パスワードの一致チェック
		if ($this->data[self::F_NEW_PASSWORD] !== $this->data[self::F_NEW_PASSWORD_RETYPE])
		{
			$ret = FALSE;
			$this->error_list['new_password_match_error'] = '新しいパスワードが新しいパスワード(確認用)と一致しません。';
		}

		/*
		 * 旧パスワードのチェック
		 */
		
		$user_entity = $this->M_user->get_by_user_code($this->login_user->user_code);

		if ( ! $user_entity)
		{
			show_error('ログインしているユーザーのデータが存在しないため、更新処理を中止しました。');
		}

		//生成時と同じ方法でパスワードを作成する。
		$enc_pw = crypt($this->data[self::F_OLD_PASSWORD], $user_entity->password);	// 入力パスワードのエンコーディング

		if ($enc_pw !== $user_entity->password)
		{
			$ret = FALSE;
			$this->error_list['old_password_match_error'] = '現在のパスワードが間違っています。';
			
		}

		return $ret;
	}

	/**
	 * DBへの更新処理を行うロジック
	 * 
	 */
	private function _do_db_logic()
	{
		$session_var = $this->_get_page_session(parent::SESSION_KEY_INPUT_DATA);

		if ( ! $session_var)
		{
			show_error(parent::ERROR_MSG_SESSION_ERRROR);
		}

		$this->db->trans_start();

		/*
		 * メインのテーブルの更新処理
		 */

		$this->_update_table($session_var);

		$this->db->trans_complete();
	}

	/**
	 * この画面で扱うメインのテーブルの更新処理
	 * 
	 * @param unknown_type $session_var
	 */
	private function _update_table($session_var)
	{
		$entity = $this->M_user->get_by_user_code($this->login_user->user_code);

		if ( ! $entity)
		{
			show_error('データが存在しないため、更新処理を中止しました。');
			return;	//実際にはこのRETURNには到達しない 
		}

		$entity->password = crypt($session_var[self::F_NEW_PASSWORD],  random_string('alpha', 2));

		$this->_update_main_table($entity, $session_var);
	}
}