<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 表組み登録を行うクラス
 * @author ta-ando
 *
 */
class Setting_register extends Post_register_Controller 
{
	const F_CURRENT_SPECIAL_TYPE = 'current_special_type';  // 表示する特集カテゴリー

	const F_SPECIAL_START_DATE = 'special_start_date';  // 特集の表示開始日
	const F_SPECIAL_END_DATE = 'special_end_date';  // 特集の表示終了日

	/* パラメータの追加があればここに記述 */

	var $special_category_list;

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

		$this->target_data_type = Relation_data_type::SETTING;
		$this->package_name = 'setting';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}登録";
		$this->page_type = Page_type::REGISTER;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_setting;
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

		$this->form_validation->set_rules(self::F_CURRENT_SPECIAL_TYPE, '表示する特集カテゴリー', '');

		$this->form_validation->set_rules(self::F_SPECIAL_START_DATE, '特集の表示開始日', 'required|callback_check_date');
		$this->form_validation->set_rules(self::F_SPECIAL_END_DATE, '特集の表示終了日', 'required|callback_check_date');

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
	 * @see Register_Controller::_init_relation_data()
	 */
	protected function _init_relation_data()
	{
		parent::_init_relation_data();

		// 特集のカテゴリーを取得（チェックボックス用）
		$this->special_category_list = $this->M_kubun->get_for_dropdown(
		                                                   Relation_data_type::SPECIAL,
		                                                   Kubun_type::CATEGORY
		                                               );
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_convert_label()
	 */
	protected function _convert_label()
	{
		parent::_convert_label();

		//カテゴリー
		$this->label_list[self::F_CURRENT_SPECIAL_TYPE] = $this->M_kubun->get_joined_label(
		                                                                      Relation_data_type::SPECIAL,
		                                                                      Kubun_type::CATEGORY,
		                                                                      $this->data[self::F_CURRENT_SPECIAL_TYPE]
		                                                                  );
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_relation_check()
	 */
	protected function _relation_check()
	{
		$ret = parent::_relation_check();

		$special_start_date_timestamp = strtotime($this->data[self::F_SPECIAL_START_DATE]);
		$special_end_date_timestamp = strtotime($this->data[self::F_SPECIAL_END_DATE]);

		if ($special_end_date_timestamp < $special_start_date_timestamp)
		{
			$ret = FALSE;
			$this->error_list['special_end_date_reverse_date_error'] = "{$this->label_publish_end_date}と{$this->label_post_date}の日付が逆転しています。";
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

		$main_entity->current_special_type = $session_var[self::F_CURRENT_SPECIAL_TYPE];
		$main_entity->special_start_date = create_db_datetme_str($session_var[self::F_SPECIAL_START_DATE]);
		$main_entity->special_end_date = create_db_datetme_str($session_var[self::F_SPECIAL_END_DATE]);

		/* 差分の更新カラムがあればここで更新前にセット */
		return $main_entity;
	}
}