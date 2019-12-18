<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * お知らせ編集を行うクラス
 * @author ta-ando
 *
 */
class Info_edit extends Post_register_Controller 
{
	const F_POST_LINK2 = 'post_link2';  // リンク2
	const F_POST_LINK_TEXT2 = 'post_link_text2';  // リンク用テキスト2
	const F_POST_LINK3 = 'post_link3';  // リンク3
	const F_POST_LINK_TEXT3 = 'post_link_text3';  // リンク用テキスト3
	const F_FREE_FORM_ID = 'free_form_id';  // 申し込みフォーム
	const F_ANNUAL = 'annual';  // 年度
	const F_EVENT_START_DATE = 'event_start_date';  // 開催日
	const F_EVENT_DATE_TEXT = 'event_date_text';  // 開催日補足テキスト
	const F_EVENT_TIME = 'event_time';  // 開催時間
	const F_EVENT_ACCEPT_END_DATE = 'event_accept_end_date';  // 申し込み締め切り日
	const F_EVENT_PLACE = 'event_place';  // 会場
	const F_INSTRUCTOR = 'instructor';  // 講師
	const F_TARGET_PERSON = 'target_person';  // 対象

	var $free_form_id_list;  // 申し込みフォーム用の選択項目リスト

	const F_EVENT_ACCEPT_FLG = 'event_accept_flg';  // 募集有無


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

		$this->target_data_type = Relation_data_type::INFO;
		$this->package_name = 'info';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->T_info;
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
		 * handle_relationメソッドへのアクセスがある場合はチェック不要
		 */

		if ( ! $this->application_session_data->can_access_package($this->package_name)
		&& ! $this->_is_method_match('handle_relation'))
		{
			show_error('不正な画面遷移が行われています。再度メニューから操作を行ってください。');
		}

		/*
		 * 編集対象のデータを取得して画面表示用に保持する。
		 */

		if ( ! $this->_is_method_match()
		&& ! $this->_is_method_match('handle_relation'))
		{
			$this->_load_entity_from_session();
		}

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);
	}

	/**
	 * 初期表示を行う。
	 * 
	 * @param unknown_type $post_id
	 */
	public function index($post_id)
	{
		$this->_init_edit_logic($post_id);

		$this->_load_entity_from_session();

		/*
		 * DBデータを読み込み、表示用にローカル変数にセットする。
		 */

		$this->_convert_load_data();
		$this->_load_relation($post_id);
		$this->_load_file($post_id);

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

		$this->form_validation->set_rules(self::F_POST_LINK2, 'リンク2', 'callback_check_url|max_length[200]');
		$this->form_validation->set_rules(self::F_POST_LINK_TEXT2, 'リンク用テキスト2', 'max_length[200]');
		$this->form_validation->set_rules(self::F_POST_LINK3, 'リンク3', 'callback_check_url|max_length[200]');
		$this->form_validation->set_rules(self::F_POST_LINK_TEXT3, 'リンク用テキスト3', 'max_length[200]');

		$this->form_validation->set_rules(self::F_FREE_FORM_ID, '申し込みフォーム', '');

		$this->form_validation->set_rules(self::F_ANNUAL, '年度', 'max_length[200]');

		$this->form_validation->set_rules(self::F_EVENT_START_DATE, '開催日', 'callback_check_date|max_length[200]');
		$this->form_validation->set_rules(self::F_EVENT_DATE_TEXT, '開催日補足テキスト', 'max_length[1000]');
		$this->form_validation->set_rules(self::F_EVENT_TIME, '開催時間', 'max_length[1000]');
		$this->form_validation->set_rules(self::F_EVENT_ACCEPT_END_DATE, '申し込み締め切り日', 'callback_check_date|max_length[200]');
		$this->form_validation->set_rules(self::F_EVENT_PLACE, '会場', 'max_length[1000]');
		$this->form_validation->set_rules(self::F_INSTRUCTOR, '講師', 'max_length[1000]');
		$this->form_validation->set_rules(self::F_TARGET_PERSON, '対象', 'max_length[1000]');

		$this->form_validation->set_rules(self::F_EVENT_ACCEPT_FLG, '募集有無', '');

		/* 入力チェックの追加があればここに記述 */

		return $this->form_validation->run();
	}

	/**
	 * DBへの更新処理を行うロジック
	 * 
	 */
	private function _do_db_logic()
	{
		$post_id = $this->_get_page_session(self::POST_ID);
		$session_var = $this->_get_page_session(parent::SESSION_KEY_INPUT_DATA);

		if ( ! $session_var)
		{
			show_error(parent::ERROR_MSG_SESSION_ERRROR);
		}

		$this->db->trans_start();

		/*
		 * メインのテーブルの更新処理
		 */

		$main_entity = $this->_set_main_table_column_for_update($session_var, $post_id);
		$this->_update_main_table($main_entity, $session_var);

		/*
		 * 関連テーブルの更新処理
		 */

		$this->_delete_insert_relation($session_var, $post_id);
		$this->_delete_file_and_record($session_var, $post_id);
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

		$this->annual_list = $this->Kubun_logic->get_common_kubun_list_dropdown(Kubun_type::ANNUAL_CODE);
		$this->free_form_list = $this->Free_form_logic->get_for_dropdown("==使用しない==");
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_set_main_table_column_for_update()
	 */
	protected function _set_main_table_column_for_update($session_var, $post_id)
	{
		$main_entity = parent::_set_main_table_column_for_update($session_var, $post_id);

		$main_entity->post_link2 = $session_var[self::F_POST_LINK2];
		$main_entity->post_link_text2 = $session_var[self::F_POST_LINK_TEXT2];
		$main_entity->post_link3 = $session_var[self::F_POST_LINK3];
		$main_entity->post_link_text3 = $session_var[self::F_POST_LINK_TEXT3];

		$main_entity->free_form_id = get_default_str($session_var[self::F_FREE_FORM_ID]);
		$main_entity->event_start_date = create_db_datetme_str($session_var[self::F_EVENT_START_DATE]);
		$main_entity->event_date_text = $session_var[self::F_EVENT_DATE_TEXT];
		$main_entity->event_time = $session_var[self::F_EVENT_TIME];
		$main_entity->event_accept_end_date = create_db_datetme_str($session_var[self::F_EVENT_ACCEPT_END_DATE]);
		$main_entity->event_place = $session_var[self::F_EVENT_PLACE];
		$main_entity->instructor = $session_var[self::F_INSTRUCTOR];
		$main_entity->target_person = $session_var[self::F_TARGET_PERSON];
		$main_entity->event_accept_flg = ($session_var[self::F_EVENT_ACCEPT_FLG] == Valid_flg::VALID)
		                                 ? Valid_flg::VALID
		                                 : Valid_flg::INVALID;

		/* 差分の更新カラムがあればここで更新前にセット */

		return $main_entity;
	}


	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_convert_label()
	 */
	protected function _convert_label()
	{
		parent::_convert_label();

		$this->label_list[self::F_ANNUAL] = $this->M_kubun->get_joined_label(
			                                                                    Relation_data_type::COMMON,
			                                                                    Kubun_type::ANNUAL_CODE,
			                                                                    $this->data[self::F_ANNUAL]
			                                                                );

		$this->label_list[self::F_FREE_FORM_ID] = $this->Free_form_logic->get_name(self::F_FREE_FORM_ID);
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_delete_insert_relation()
	 */
	protected function _delete_insert_relation($session_var, $post_id)
	{
		parent::_delete_insert_relation($session_var, $post_id);

		$this->T_relation->delete_insert_list(
		                       $this->target_data_type,
		                       $post_id,
		                       Relation_data_type::KUBUN,
		                       Kubun_type::ANNUAL_CODE,
		                       create_array_param($session_var[self::F_ANNUAL])
		                   );
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_load_relation()
	 */
	protected function _load_relation($post_id)
	{
		parent::_load_relation($post_id);

		$this->data[self::F_ANNUAL] = $this->T_relation->get_attribute_value_array(
			                                                       $this->target_data_type,
			                                                       $post_id,
			                                                       Relation_data_type::KUBUN,
			                                                       Kubun_type::ANNUAL_CODE
			                                                   );
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_convert_load_data()
	 */
	protected function _convert_load_data()
	{
		parent::_convert_load_data();

		//調整
		$this->data[self::F_EVENT_START_DATE] = format_date_to_pattern($this->target_entity->event_start_date, "Y/m/d");
		$this->data[self::F_EVENT_ACCEPT_END_DATE] = format_date_to_pattern($this->target_entity->event_accept_end_date, "Y/m/d");
	}
}