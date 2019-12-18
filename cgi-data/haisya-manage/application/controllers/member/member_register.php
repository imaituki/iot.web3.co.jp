<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 会員登録を行うクラス
 * @author ta-ando
 *
 */
class Member_register extends Post_register_Controller 
{
	const F_EMAIL = 'email';  // メールアドレス
	const F_EMAIL_CHECK = 'email_check';
	const F_PASSWORD = 'password';  // パスワード
	const F_NAME = 'name';  // 氏名
	const F_FURIGANA = 'furigana';  // フリガナ
	const F_PHONE_NUMBER = 'phone_number';  // 電話番号
	const F_FAX_NUMBER = 'fax_number';  // FAX番号
	const F_POSITION = 'position';  // 役職等
	const F_COMPANY_NAME = 'company_name';  // 企業・団体
	const F_PLACE = 'place';  // 住所
	const F_MEMBER_TYPE = 'member_type';  // 会員種別

	/* パラメータの追加があればここに記述 */

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

		$this->target_data_type = Relation_data_type::MEMBER;
		$this->package_name = 'member';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}登録";
		$this->page_type = Page_type::REGISTER;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_member;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//ネストする複数項目の宣言と初期化
		$this->_create_optional_form_key();
		$this->_init_optional_form_key();

		//関係テーブルのデータをDBからの呼び出す
		$this->_init_relation_data();

		/*
		 * この機能に必要な情報がセッションに保持されているか確認する。
		 */

		if ( ! $this->application_session_data->can_access_package($this->package_name))
		{
			show_error('不正な画面遷移が行われています。再度メニューから操作を行ってください。');
		}

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
	 * ファイルのアップロードを行い入力画面を表示する
	 */
	function upload_image()
	{
		$this->_upload_image();
		$this->_load_tpl($this->_get_view_name(View_type::INPUT), $this->data);
	}

	/**
	 * アップロードしたファイルの削除を行い、入力画面を表示する
	 */
	function delete_image()
	{
		$this->_delete_image();
		$this->_load_tpl($this->_get_view_name(View_type::INPUT), $this->data);
	}

	/**
	 * 入力チェックを行う。
	 */
	private function _input_check()
	{
		parent::_basic_input_check();

		//$this->form_validation->set_rules(self::F_MEMBER_TYPE, '会員種別', 'required|');
		//$this->form_validation->set_rules(self::F_EMAIL, 'メールアドレス', 'trim|required|valid_email|max_length[200]');
		//$this->form_validation->set_rules(self::F_EMAIL_CHECK, 'メールアドレス確認', 'trim|required|valid_email|max_length[200]');
		$this->form_validation->set_rules(self::F_PASSWORD, 'パスワード', 'trim|required|alpha_dash|max_length[25]|min_length[4]');

		//特別会員のみチェック内容を替える
		//$required_str = ($this->data[self::F_MEMBER_TYPE] == Member_type::SPECIAL)
		//                ? 'trim|required|'
		//                : '';
		$required_str = 'trim|required|';

		$this->form_validation->set_rules(self::F_NAME, '氏名', "{$required_str}max_length[200]");
		$this->form_validation->set_rules(self::F_FURIGANA, 'フリガナ', "{$required_str}callback_check_katakana|max_length[200]");
		$this->form_validation->set_rules(self::F_POSITION, '役職等', "{$required_str}max_length[200]");
		$this->form_validation->set_rules(self::F_COMPANY_NAME, '企業・団体', "{$required_str}max_length[200]");
		$this->form_validation->set_rules(self::F_PLACE, '住所', "max_length[200]");

		/* 入力チェックの追加があればここに記述 */

		return $this->form_validation->run();
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

		$main_entity = $this->_set_main_table_column_for_insert($session_var);
		$post_id = $this->_insert_main_table($main_entity, $session_var);

		/*
		 * 関連テーブルの更新処理
		 */

		$this->_delete_insert_relation($session_var, $post_id);
		$this->_insert_file($session_var, $post_id);

		$this->db->trans_complete();
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_relation_check()
	 */
	protected function _relation_check()
	{
		$ret = parent::_relation_check();

		//一致チェック
		if ($this->data[self::F_EMAIL] !== $this->data[self::F_EMAIL_CHECK])
		{
			$ret = FALSE;
			$this->error_list['mail_match'] = "メールアドレスが一致していません";
		}

		//メールアドレスの重複チェック
		if ($ret
		&& $this->main_model->is_user_exists($this->data[self::F_EMAIL]))
		{
			$ret = FALSE;
			$this->error_list['user_code_dupricate'] = '入力されたメールアドレスは既に登録されているため使用できません。';
		}

		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_set_main_table_column_for_insert()
	 */
	protected function _set_main_table_column_for_insert($session_var)
	{
		$main_entity = parent::_set_main_table_column_for_insert($session_var);

		$main_entity->email = $session_var[self::F_EMAIL];
		$main_entity->password = crypt($session_var[self::F_PASSWORD],  random_string('alpha', 2));
		$main_entity->name = $session_var[self::F_NAME];
		$main_entity->furigana = $session_var[self::F_FURIGANA];
		$main_entity->phone_number = $session_var[self::F_PHONE_NUMBER];
		$main_entity->fax_number = $session_var[self::F_FAX_NUMBER];
		$main_entity->position = $session_var[self::F_POSITION];
		$main_entity->company_name = $session_var[self::F_COMPANY_NAME];
		$main_entity->place = $session_var[self::F_PLACE];
		$main_entity->member_type = Member_type::SPECIAL;

		return $main_entity;
	}
}