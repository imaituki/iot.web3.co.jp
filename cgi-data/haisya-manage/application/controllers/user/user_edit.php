<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * ユーザーの編集を行うクラス
 * * @author ta-ando
 *
 */
class User_edit extends Register_Controller 
{
	const USER_ID = 'user_id';

	/** フォームで使用するパラメータ名 */
	const F_USER_CODE='user_code';
	const F_USER_NAME='user_name';
	const F_USER_FURIGANA='user_furigana';
	const F_PASSWORD='password';
	const F_ACCOUNT_TYPE='account_type';

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

		$this->package_name = 'user';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_user;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//乱数の生成で使用するHelper
		$this->load->helper('string');

		/*
		 * セッションにデータがセットされていれば常時表示する用に読み込み
		 * indexへのアクセスは前回のセッションが残っている場合があるので除く。
		 */

		if ( ! $this->_is_method_match())
		{
			$user_id = $this->_get_page_session(self::USER_ID);
			$this->_init_label($user_id);
		}

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);
	}

	/**
	 * 初期表示を行う。
	 */
	public function index($id)
	{
		if ( ! is_num($id))
		{
			//WYSIWYGエディタでのパス間違いなどで/show/img/EEEE.jpgなどのパスがリクエストされた場合に、IDが上書きされる不具合が発生するのを防ぐ。
			show_404();
		}

		/*
		 * 初期処理
		 */

		$this->_unset_page_session();
		$this->_save_page_session(self::USER_ID, $id);

		/*
		 * DBデータを読み込み、表示用にローカル変数にセットする。
		 */

		$this->_load_main_table($id);

		//パスワードは空とする
		$this->data[self::F_PASSWORD] = '';

		//常に表示させるデータをセット
		$this->_init_label($id);

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
	 * 常に表示するラベルをセットする。
	 * 
	 * @param unknown_type $post_id
	 */
	private function _init_label($user_id)
	{
		if ($user_id !== FALSE)
		{
			$user_entity = $this->M_user->find($user_id);

			$this->data[self::F_USER_CODE] = $user_entity->user_code;
		}
	}

	/**
	 * 入力チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_USER_NAME, 'ユーザー名', 'trim|required|max_length[25]');
		$this->form_validation->set_rules(self::F_USER_FURIGANA, 'ユーザー名（フリガナ）', 'trim|required|callback_check_katakana|max_length[40]');
		$this->form_validation->set_rules(self::F_PASSWORD, 'パスワード', 'alpha_dash|max_length[25]|min_length[4]');
		$this->form_validation->set_rules(self::F_ACCOUNT_TYPE, 'アカウント種別', 'trim|required');

		return $this->form_validation->run();
	}

	/**
	 * 相関チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _relation_check()
	{
		$ret = TRUE;

		return $ret;
	}

	/**
	 * DBへの更新処理を行うロジック
	 * 
	 */
	private function _do_db_logic()
	{
		//セッションから情報を取得
		$id = $this->_get_page_session(self::USER_ID);
		$session_var = $this->_get_page_session(parent::SESSION_KEY_INPUT_DATA);

		if ( ! $session_var)
		{
			show_error(parent::ERROR_MSG_SESSION_ERRROR);
		}

		$this->db->trans_start();

		/*
		 * メインのテーブルの更新処理
		 */

		$this->_update_table($session_var, $id);

		$this->db->trans_complete();
	}

	/**
	 * 画面でメインに使用するテーブルを読み込み保持する。
	 * 
	 * @param unknown_type $id
	 */
	private function _load_main_table($id)
	{
		// ユーザ情報を取得する
		$entity = $this->M_user->find($id);

		if ( ! $entity) 
		{
			show_error("データが存在しません");
			exit;
		}

		if ( ! $this->login_user->is_nds_root()
		&& $entity->user_code === System_const::NDS_ROOT_USER)
		{
			show_error("このユーザーを編集する権限がありません。");
			exit;
		}

		$this->data = array_merge($this->data, (array)$entity);

		return $entity;
	}

	/**
	 * この画面で扱うメインテーブルの更新処理
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $user_id
	 */
	private function _update_table($session_var, $user_id)
	{
		//最新状態のデータを取得
		$entity = $this->M_user->find($user_id);

		if ( ! $entity)
		{
			show_error('データが存在しないため、更新処理を中止しました。');
			return;	//実際にはこのRETURNには到達しない 
		}

		//ユーザ入力値をセットしてUPDATE
		$entity->user_name = $session_var[self::F_USER_NAME];
		$entity->user_furigana = $session_var[self::F_USER_FURIGANA];
		$entity->account_type = $session_var[self::F_ACCOUNT_TYPE];

		//パスワードは入力があった場合のみ変更
		if (is_not_blank($session_var[self::F_PASSWORD]))
		{
			$entity->password = crypt($session_var[self::F_PASSWORD],  random_string('alpha', 2));
		}

		$this->_update_main_table($entity, $session_var);
	}
}
