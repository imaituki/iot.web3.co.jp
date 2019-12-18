<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 連携資料項目登録を行うクラス
 * @author ta-ando
 *
 */
class Free_form_register extends Post_register_Controller 
{
	const F_TO_EMAIL = 'to_email';  // 送信先メールアドレス
	const F_TO_EMAIL_2 = 'to_email_2';  // 送信先メールアドレス2
	const F_FROM_EMAIL = 'from_email';  // 送信元メールアドレス
	const F_FROM_LABEL = 'from_label';  // 差出人
	const F_MAIL_SUBJECT = 'mail_subject';  // メール件名
	const F_CONFIRM_MESSAGE = 'confirm_message';  // 確認メール用メッセージ
	const F_MAIL_SIGNATURE = 'mail_signature';  // 署名


	/* パラメータの追加があればここに記述 */
	
	/** 画面に受け渡す変数 */ 
	const F_BASIC_FORM = 'basic_form'; //メールフォームの基本項目用接頭辞
	const F_OPTIONAL_FORM = 'optional_form'; //メールフォームの追加項目用接頭辞
	const F_MAIL_ADDRESS_LIST = 'mail_address_list';	// 申し込み先用メールアドレスエンティティのリスト
	const F_MAIL_ADDRESS_DROPDOWN_LIST = 'mail_address_dropdown_list';	// 差出人用メールアドレスエンティティのリスト(ドロップダウンで使用)

	/** 申し込みフォームの基本項目のソート順を保持する文字列 */
	const F_BASIC_COLUMN_ORDER_NUM_STR = 'basic_column_order_num_str';
	/** 申し込みフォームの追加項目のソート順を保持する文字列 */
	const F_OPTIONAL_COLUMN_ORDER_NUM_STR = 'optional_column_order_num_str';

	var $max_basic_form;
	var $max_optional_form;

	/** 複数項目のサブキー */
	static $sub_keys = array(
		'form_type',
		'require_flg',
		'title',
		'choices',
	);

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

		$this->target_data_type = Relation_data_type::FREE_FORM;
		$this->package_name = 'free_form';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}登録";
		$this->page_type = Page_type::REGISTER;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->T_free_form;
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

		$this->max_basic_form = Mail_form_type::get_max(Mail_form_type::BASIC);
		$this->max_optional_form = Mail_form_type::get_max(Mail_form_type::OPTION);

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

		$this->form_validation->set_rules(self::F_TO_EMAIL, '送信先メールアドレス', 'trim|required|valid_email|max_length[200]');
		$this->form_validation->set_rules(self::F_TO_EMAIL_2, '送信先メールアドレス2', 'valid_email|max_length[200]');
		$this->form_validation->set_rules(self::F_FROM_EMAIL, '送信元メールアドレス', 'valid_email|max_length[200]');
		$this->form_validation->set_rules(self::F_FROM_LABEL, '差出人', 'max_length[200]');
		$this->form_validation->set_rules(self::F_MAIL_SUBJECT, 'メール件名', 'max_length[200]');
		$this->form_validation->set_rules(self::F_CONFIRM_MESSAGE, '確認メール用メッセージ', 'max_length[1000]');
		$this->form_validation->set_rules(self::F_MAIL_SIGNATURE, '署名', 'max_length[1000]');

		/* 入力チェックの追加があればここに記述 */

		for ($i = 1; $i <= $this->max_optional_form; $i++) 
		{
			//連番のキーを作成
			$column_no = $i;
			$form_type_key = self::F_OPTIONAL_FORM."{$column_no}_form_type";

			if ($this->data[$form_type_key] !== Form_type::NONE)
			{
				$title_key = self::F_OPTIONAL_FORM."{$column_no}_title";
				$this->form_validation->set_rules($title_key, "項目名", 'trim|required|max_length[50]');	
			}
		}

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

		/*
		 * フォームの関連テーブル更新処理
		 */

		$this->_insert_form_item($session_var, $post_id, Mail_form_type::BASIC);
		$this->_insert_form_item($session_var, $post_id, Mail_form_type::OPTION);

		$this->db->trans_complete();
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_set_default_form_value()
	 */
	protected function _set_default_form_value()
	{
		parent::_set_default_form_value();

		$this->_set_default_value_basic_mailform();
		$this->_set_default_value_optional_mailform();

		//項目のデフォルトのソート順を作成する。
		$this->data[self::F_BASIC_COLUMN_ORDER_NUM_STR] = get_cardinal_joined_str(1,  $this->max_basic_form);
		$this->data[self::F_OPTIONAL_COLUMN_ORDER_NUM_STR] = get_cardinal_joined_str(1,  $this->max_optional_form);
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_create_optional_form_key()
	 */
	protected function _create_optional_form_key()
	{
		parent::_create_optional_form_key();

		//フォーム部品を追加
		$this->optional_keys = array_merge(
			$this->optional_keys,
			$this->_init_mailform_detail(Mail_form_type::BASIC),
			$this->_init_mailform_detail(Mail_form_type::OPTION)
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_relation_check()
	 */
	protected function _relation_check()
	{
		$ret = parent::_relation_check();

		/*
		 * メールフォームの追加項目用のチェック
		 */

		for ($i = 1; $i <= $this->max_optional_form; $i++) 
		{
			$column_no = $i;

			//連番のキーを作成
			$title_key = self::F_OPTIONAL_FORM."{$column_no}_title";
			$coices_key = self::F_OPTIONAL_FORM."{$column_no}_choices";
			$form_type_key = self::F_OPTIONAL_FORM."{$column_no}_form_type";
			$require_flg_key = self::F_OPTIONAL_FORM."{$column_no}_require_flg";

			//未使用項目はスキップ
			if (is_blank($this->data[$form_type_key]))
			{
				continue;
			}

			//ドロップダウン
			if ($this->data[$form_type_key] == Form_type::DROPDOWN
			&& is_blank($this->data[$coices_key]))
			{
				$ret = FALSE;
				$this->error_list[$coices_key] = '選択肢を入力してください';
			}

			//マルチチェックボックス
			if ($this->data[$form_type_key] == Form_type::MULTI_CHECKBOX
			&& is_blank($this->data[$coices_key]))
			{
				$ret = FALSE;
				$this->error_list[$coices_key] = '選択肢を入力してください';
			}

			//ラジオボタン
			if ($this->data[$form_type_key] == Form_type::RADIOBUTTON
			&& is_blank($this->data[$coices_key]))
			{
				$ret = FALSE;
				$this->error_list[$coices_key] = '選択肢を入力してください';
			}
		}

		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_convert_label()
	 */
	protected function _convert_label()
	{
		parent::_convert_label();

		//追加項目のみ
		for ($i = 1; $i <= $this->max_optional_form; $i++)
		{
			$column_no = $i;

			//連番のキーを作成
			$coices_key = self::F_OPTIONAL_FORM."{$column_no}_choices";

			if (is_blank($this->data[$coices_key]))
			{
				$this->label_list[$coices_key] = 'なし';
			}
			else
			{
				$ret = explode('|', $this->data[$coices_key]);
				$this->label_list[$coices_key] = count($ret) . '項目： ' . implode(', ', $ret);
			}
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_set_main_table_column_for_insert()
	 */
	protected function _set_main_table_column_for_insert($session_var)
	{
		$main_entity = parent::_set_main_table_column_for_insert($session_var);

		$main_entity->to_email = $session_var[self::F_TO_EMAIL];
		$main_entity->to_email_2 = $session_var[self::F_TO_EMAIL_2];
		$main_entity->from_email = $session_var[self::F_FROM_EMAIL];
		$main_entity->from_label = $session_var[self::F_FROM_LABEL];
		$main_entity->mail_subject = $session_var[self::F_MAIL_SUBJECT];
		$main_entity->confirm_message = $session_var[self::F_CONFIRM_MESSAGE];
		$main_entity->mail_signature = get_default_str($session_var[self::F_MAIL_SIGNATURE]);

		/* 差分の更新カラムがあればここで更新前にセット */

		return $main_entity;
	}

	/**
	 * フォームの項目をINSERTする処理。
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $free_form_id
	 */
	private function _insert_form_item($session_var, $free_form_id, $mail_form_type)
	{
		if ($mail_form_type === Mail_form_type::BASIC)
		{
			$order_str_key = self::F_BASIC_COLUMN_ORDER_NUM_STR;
			$max = Mail_form_type::get_max(Mail_form_type::BASIC);
			$form_prefix = self::F_BASIC_FORM;
		}
		else
		{
			$order_str_key = self::F_OPTIONAL_COLUMN_ORDER_NUM_STR;
			$max = Mail_form_type::get_max(Mail_form_type::OPTION);
			$form_prefix = self::F_OPTIONAL_FORM;
		}

		//INSERTをcolumn_no順にするために、並び順は配列のインデックスを取得してセットする。
		$order_array = explode(',', $session_var[$order_str_key]);

		for ($i = 1; $i <= $max; $i++)
		{
			$column_no = $i;

			//連番のキーを作成
			$title_key = "{$form_prefix}{$column_no}_title";
			$coices_key = "{$form_prefix}{$column_no}_choices";
			$form_type_key = "{$form_prefix}{$column_no}_form_type";
			$require_flg_key = "{$form_prefix}{$column_no}_require_flg";

			//並び順を取得
			$order = array_search($column_no, $order_array);

			$detail_entity = new T_free_form_item();
			$detail_entity->relation_data_type = $this->target_data_type;
			$detail_entity->relation_data_id = $free_form_id;
			$detail_entity->data_type = Relation_data_type::FREE_FORM_ITEM;
			$detail_entity->draft_flg = Draft_flg::NOT_DRAFT;
			$detail_entity->column_no = $column_no;
			$detail_entity->column_type = $mail_form_type;
			$detail_entity->order_number = $order;
			$detail_entity->title = $session_var[$title_key];
			$detail_entity->choices = ($mail_form_type == Mail_form_type::BASIC)
			                          ? ''
			                          : $session_var[$coices_key];

			$detail_entity->form_type = $session_var[$form_type_key];
			$detail_entity->valid_flg = ($session_var[$form_type_key] != Form_type::NONE)
			                            ? Valid_flg::VALID
			                            : Valid_flg::INVALID;
			$detail_entity->require_flg = ($session_var[$require_flg_key] == Valid_flg::VALID)
			                              ? Valid_flg::VALID
			                              : Valid_flg::INVALID;

			$detail_entity->insert($this->login_user->user_code);
		}
	}

	/**
	 * メールフォームの複数項目のアップロードフォームのキーをthis->dataにセットして初期値をセットする処理
	 * 戻り値で作成したキーの配列を返します。
	 * 
	 * @param unknown_type $mail_form_type
	 */
	private function _init_mailform_detail($mail_form_type)
	{
		if ($mail_form_type === Mail_form_type::BASIC)
		{
			$max = Mail_form_type::get_max(Mail_form_type::BASIC);
			$mail_form_type_prefix = self::F_BASIC_FORM;
		}
		else
		{
			$max = Mail_form_type::get_max(Mail_form_type::OPTION);
			$mail_form_type_prefix = self::F_OPTIONAL_FORM;
		}

		$oitional_keys = array();

		// メールフォーム用に複数項目あるフォーム用の初期化処理
		for ($i = 1; $i <= $max; $i++)
		{
			$column_no = $i;

			foreach (self::$sub_keys as $value)
			{
				$nest_key = "{$mail_form_type_prefix}{$column_no}_{$value}";

				$this->data[$nest_key] = '';
				$this->error_list[$nest_key] = '';

				//キーを保持
				$oitional_keys[] = $nest_key;
			}
		}

		return $oitional_keys;
	}

	/**
	 * メールフォームの基本項目用のデフォルト値をセット
	 */
	private function _set_default_value_basic_mailform()
	{
		$form_column_no_list = array();

		//デフォルト値をセットする
		for ($i = 1; $i <=  Mail_form_type::get_max(Mail_form_type::BASIC); $i++)
		{
			//column_noは1始まりの項目の順番と同じ
			$column_no = $i;

			//連番のキーを作成
			$title_key = self::F_BASIC_FORM."{$column_no}_title";
			$coices_key = self::F_BASIC_FORM."{$column_no}_choices";
			$form_type_key = self::F_BASIC_FORM."{$column_no}_form_type";
			$require_flg_key = self::F_BASIC_FORM."{$column_no}_require_flg";

			$this->data[$title_key] = Mail_form_column::get_basic_label($column_no);
			$this->data[$form_type_key] = in_array($column_no, Mail_form_column::$REQUIRED_BASIC)
			                                ? Form_type::FORM_USE
			                                : Form_type::NONE;
			$this->data[$require_flg_key] = in_array($column_no, Mail_form_column::$REQUIRED_BASIC)
			                                ? Valid_flg::VALID
			                                : Valid_flg::INVALID;

			//column_noを順に保持する(order順となる)
			$form_column_no_list[] = $column_no;
		}

		//メールフォーム項目の並び順としてcolumn_noをカンマつなぎにした文字列を画面に渡す
		$this->data[self::F_BASIC_COLUMN_ORDER_NUM_STR] = implode(',', $form_column_no_list);
	}

	/**
	 * メールフォームの追加項目用のデフォルト値をセット
	 */
	private function _set_default_value_optional_mailform()
	{
		$form_column_no_list = array();

		//デフォルト値をセットする
		for ($i = 1; $i <=  Mail_form_type::get_max(Mail_form_type::OPTION); $i++)
		{
			//column_noは1始まりの項目の順番と同じ
			$column_no = $i;

			//連番のキーを作成
			$title_key = self::F_OPTIONAL_FORM."{$column_no}_title";
			$coices_key = self::F_OPTIONAL_FORM."{$column_no}_choices";
			$form_type_key = self::F_OPTIONAL_FORM."{$column_no}_form_type";
			$require_flg_key = self::F_OPTIONAL_FORM."{$column_no}_require_flg";

			$this->data[$title_key] = "追加項目{$i}";
			$this->data[$form_type_key] = Form_type::NONE;
			$this->data[$require_flg_key] = Valid_flg::INVALID;

			//column_noを順に保持する(昇順となる)
			$form_column_no_list[] = $column_no;
		}

		//メールフォーム項目の並び順としてcolumn_noをカンマつなぎにした文字列を画面に渡す
		$this->data[self::F_OPTIONAL_COLUMN_ORDER_NUM_STR] = implode(',', $form_column_no_list);
	}
}