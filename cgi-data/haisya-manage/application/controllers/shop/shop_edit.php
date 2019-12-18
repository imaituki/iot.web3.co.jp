<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 店舗編集を行うクラス
 * @author ta-ando
 *
 */
class Shop_edit extends Post_register_Controller 
{
	const F_MANAGEMENT_CODE = 'management_code';  // 管理コード
	const F_AREA = 'area';  // エリア
	const F_PLACE = 'place';  // 住所
	const F_PLACE2 = 'place2';  // 住所2
	const F_PHONE_NUMBER = 'phone_number';  // TEL
	const F_PREFECTURE_CODE = 'prefecture_code';  // 都道府県
	const F_SITE_TYPE = 'site_type';  // 表示サイト
	const F_LATITUDE = 'latitude';  // 緯度
	const F_LONGITUDE = 'longitude';  // 経度

	var $area_list;  // エリア用の選択項目リスト
	var $prefecture_code_list;  // 都道府県用の選択項目リスト
	var $site_type_list;  // 表示サイト用の選択項目リスト

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

		$this->target_data_type = Relation_data_type::SHOP;
		$this->package_name = 'shop';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_shop;
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

		$this->form_validation->set_rules(self::F_MANAGEMENT_CODE, '管理コード', 'max_length[200]');
		$this->form_validation->set_rules(self::F_AREA, 'エリア', 'required');
		$this->form_validation->set_rules(self::F_PLACE, '住所', 'max_length[200]');
		$this->form_validation->set_rules(self::F_PLACE2, '建物等', 'max_length[200]');
		$this->form_validation->set_rules(self::F_PHONE_NUMBER, 'TEL', 'callback_check_phone_number|max_length[200]');

		$this->form_validation->set_rules(self::F_PREFECTURE_CODE, '都道府県', 'required');

		$this->form_validation->set_rules(self::F_SITE_TYPE, '表示サイト', '');

		$this->form_validation->set_rules(self::F_LATITUDE, '緯度', 'numeric|max_length[200]');
		$this->form_validation->set_rules(self::F_LONGITUDE, '経度', 'numeric|max_length[200]');

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

		$this->site_type_list = $this->Kubun_logic->get_common_kubun_list_checkbox(Kubun_type::SITE_TYPE);
		$this->area_list = $this->Kubun_logic->get_common_kubun_list_dropdown(Kubun_type::AREA, '選択してください');
		$this->prefecture_code_list = $this->Kubun_logic->get_common_kubun_list_dropdown(Kubun_type::PREFECTURE, '選択してください');
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_load_relation()
	 */
	protected function _load_relation($post_id)
	{
		parent::_load_relation($post_id);

		//カテゴリー
		$this->data[self::F_SITE_TYPE] = $this->T_relation->get_attribute_value_array(
			                                                       $this->target_data_type,
			                                                       $post_id,
			                                                       Relation_data_type::KUBUN,
			                                                       Kubun_type::SITE_TYPE
			                                                   );
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_convert_label()
	 */
	protected function _convert_label()
	{
		parent::_convert_label();

		$this->label_list[self::F_AREA] = $this->M_kubun->get_joined_label(
		                                                                Relation_data_type::COMMON,
		                                                                Kubun_type::AREA,
		                                                                $this->data[self::F_AREA]
		                                                            );

		$this->label_list[self::F_PREFECTURE_CODE] = $this->M_kubun->get_joined_label(
		                                                                Relation_data_type::COMMON,
		                                                                Kubun_type::PREFECTURE,
		                                                                $this->data[self::F_PREFECTURE_CODE]
		                                                            );

		$this->label_list[self::F_SITE_TYPE] = $this->M_kubun->get_joined_label(
		                                                                Relation_data_type::COMMON,
		                                                                Kubun_type::SITE_TYPE,
		                                                                $this->data[self::F_SITE_TYPE]
		                                                            );
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_set_main_table_column_for_update()
	 */
	protected function _set_main_table_column_for_update($session_var, $post_id)
	{
		$main_entity = parent::_set_main_table_column_for_update($session_var, $post_id);

		$main_entity->management_code = $session_var[self::F_MANAGEMENT_CODE];
		$main_entity->place = $session_var[self::F_PLACE];
		$main_entity->place2 = $session_var[self::F_PLACE2];
		$main_entity->phone_number = $session_var[self::F_PHONE_NUMBER];
		$main_entity->area = $session_var[self::F_AREA];
		$main_entity->prefecture_code = $session_var[self::F_PREFECTURE_CODE];
		$main_entity->latitude = get_default_str($session_var[self::F_LATITUDE]);
		$main_entity->longitude = get_default_str($session_var[self::F_LONGITUDE]);

		/* 差分の更新カラムがあればここで更新前にセット */

		return $main_entity;
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
		                       Kubun_type::SITE_TYPE,
		                       create_array_param($session_var[self::F_SITE_TYPE])
		                   );
	}
}