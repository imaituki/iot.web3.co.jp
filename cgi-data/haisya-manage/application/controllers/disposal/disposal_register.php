<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 処理場の新規登録を行うクラス
 * @author ta-ando
 *
 */
class Disposal_register extends Register_Controller
{
	/** フォームで使用するパラメータ名 */
	const F_DISPOSAL_NAME='disposal_name';
	const F_DISPOSAL_FURIGANA='disposal_furigana';
	const F_PHONE_NUMBER='phone_number';
	const F_FAX_NUMBER='fax_number';
	const F_POSTAL_CODE='postal_code';
	const F_ADDRESS='address';

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

		$this->package_name = 'disposal';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}登録";
		$this->page_type = Page_type::REGISTER;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_disposal;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);
	}

	/**
	 * 初期表示を行う。
	 */
	public function index()
	{
		$this->_unset_page_session();
		$this->_set_default_form_value();

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
	 * フォームの初期値をセットする。
	 */
	protected function _set_default_form_value()
	{
		parent::_set_default_form_value();

		/*
		 * この機能独自の設定がある場合は以降に記述する
		 */
	}

	/**
	 * 入力チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_DISPOSAL_NAME, '処理場', 'trim|required|max_length[25]');
		$this->form_validation->set_rules(self::F_DISPOSAL_FURIGANA, '処理場(フリガナ)', 'trim|required|callback_check_katakana|max_length[25]');
		$this->form_validation->set_rules(self::F_PHONE_NUMBER, '電話番号', 'trim|callback_check_phone_number|max_length[13]');
		$this->form_validation->set_rules(self::F_FAX_NUMBER, 'FAX番号', 'trim|callback_check_phone_number|max_length[13]');
		$this->form_validation->set_rules(self::F_POSTAL_CODE, '郵便番号', 'trim|max_length[8]');
		$this->form_validation->set_rules(self::F_ADDRESS, '住所', 'trim|max_length[100]');

		return $this->form_validation->run();
	}

	/**
	 * 相関チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _relation_check()
	{
		$ret = TRUE;

		if ($this->M_disposal->is_disposal_exists($this->data[self::F_DISPOSAL_NAME]))
		{
			$ret = FALSE;
			$this->error_list['disposal_name_duplicate'] = '入力された処理場は既に登録されています。';
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

		$new_user_id= $this->_insert_table($session_var);

		$this->db->trans_complete();
	}

	/**
	 * この画面で更新するメインテーブルをINSERTする
	 * 
	 * @param unknown_type $session_var
	 */
	private function _insert_table($session_var)
	{
		$entity = new M_disposal();
		$entity->disposal_name = $session_var[self::F_DISPOSAL_NAME];
		$entity->disposal_furigana = $session_var[self::F_DISPOSAL_FURIGANA];
		$entity->phone_number = $session_var[self::F_PHONE_NUMBER];
		$entity->fax_number = $session_var[self::F_FAX_NUMBER];
		$entity->postal_code = $session_var[self::F_POSTAL_CODE];
		$entity->address = $session_var[self::F_ADDRESS];

		return parent::_insert_main_table($entity, $session_var);
	}
}
