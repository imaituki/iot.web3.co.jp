<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 区分値の編集を行うクラス
 * @author ta-ando
 *
 */
class Kubun_edit extends Register_Controller 
{
	const KUBUN_ID = 'kubun_id';

	/** 画面で使用するパラメータ名 */
	const F_PARENT_KUBUN_ID = 'parent_kubun_id';  // 親区分ID
	const F_RELATION_DATA_TYPE = 'relation_data_type';  // 関連データタイプ
	const F_KUBUN_TYPE = 'kubun_type';  // 区分種別
	const F_KUBUN_CODE = 'kubun_code';  // 区分コード
	const F_KUBUN_VALUE = 'kubun_value';  // 区分値
	const F_DESCRIPTION = 'description';  // 詳細
	const F_ORDER_NUMBER = 'order_number';  // ソート順
	const F_ICON_FILE_NAME = 'icon_file_name';  // アイコンファイル名
	const F_ICON_FILE_NAME2 = 'icon_file_name2';  // アイコンファイル名2

	var $kubun_id_list = array();

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

		$this->package_name = 'kubun';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_kubun;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//関係テーブルのデータをDBからの呼び出す
		$this->_init_relation_data();

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);
	}

	/**
	 * 初期表示を行う。
	 * 
	 * @param unknown_type $kubun_id
	 */
	public function index($kubun_id)
	{
		/*
		 * 初期処理
		 */

		$this->_unset_page_session();
		$this->_save_page_session(self::KUBUN_ID, $kubun_id);

		/*
		 * DBデータを読み込み、表示用にローカル変数にセットする。
		 */

		$this->_load_main_table($kubun_id);

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
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_PARENT_KUBUN_ID, '親区分ID', 'integer|max_length[200]');
		$this->form_validation->set_rules(self::F_RELATION_DATA_TYPE, '関連データタイプ', 'required|integer|max_length[200]');
		$this->form_validation->set_rules(self::F_KUBUN_TYPE, '区分種別', 'required|integer|max_length[200]');
		$this->form_validation->set_rules(self::F_KUBUN_CODE, '区分コード', 'required|integer|max_length[200]');
		$this->form_validation->set_rules(self::F_KUBUN_VALUE, '区分値', 'required|max_length[200]');
		$this->form_validation->set_rules(self::F_DESCRIPTION, '詳細', 'max_length[2000]');
		$this->form_validation->set_rules(self::F_ORDER_NUMBER, 'ソート順', 'required|integer|max_length[200]');
		$this->form_validation->set_rules(self::F_ICON_FILE_NAME, 'アイコンファイル名', 'max_length[200]');
		$this->form_validation->set_rules(self::F_ICON_FILE_NAME2, 'アイコンファイル名2', 'max_length[200]');

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
		$kubun_id = $this->_get_page_session(self::KUBUN_ID);
		$session_var = $this->_get_page_session(parent::SESSION_KEY_INPUT_DATA);

		if ( ! $session_var)
		{
			show_error(parent::ERROR_MSG_SESSION_ERRROR);
		}

		$this->db->trans_start();

		/*
		 * メインのテーブルの更新処理
		 */

		$this->_update_table($session_var, $kubun_id);

		$this->db->trans_complete();
	}

	/**
	 * 画面でメインに使用するテーブルを読み込み保持する。
	 * 
	 * @param unknown_type $id
	 */
	private function _load_main_table($id)
	{
		$entity = $this->M_kubun->find($id);

		if ( ! $entity) 
		{
			//エラーページを表示して処理終了
			show_error('データが存在しません');
			return;	//実際にはこのRETURNには到達しない 
		}

		$this->data = array_merge($this->data, (array)$entity);
	}

	/**
	 * 画面表示用にラベルに変換する処理
	 */
	protected function _convert_label()
	{
		parent::_convert_label();
	}

	/**
	 * この画面で更新するメインテーブルをUPDATEする
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $kubun_id
	 */
	private function _update_table($session_var, $kubun_id)
	{
		$entity = $this->M_kubun->find($kubun_id);

		if ( ! $entity)
		{
			show_error('データが存在しないため、更新処理を中止しました。');
			return;	//実際にはこのRETURNには到達しない 
		}

		$entity->parent_kubun_id = is_not_blank($session_var[self::F_PARENT_KUBUN_ID])
		                           ? $session_var[self::F_PARENT_KUBUN_ID]
		                           : 0;
		$entity->relation_data_type = $session_var[self::F_RELATION_DATA_TYPE];
		$entity->kubun_type = $session_var[self::F_KUBUN_TYPE];
		$entity->kubun_code = $session_var[self::F_KUBUN_CODE];
		$entity->kubun_value = $session_var[self::F_KUBUN_VALUE];
		$entity->description = $session_var[self::F_DESCRIPTION];
		$entity->order_number = $session_var[self::F_ORDER_NUMBER];
		$entity->icon_file_name = $session_var[self::F_ICON_FILE_NAME];
		$entity->icon_file_name2 = $session_var[self::F_ICON_FILE_NAME2];
		$entity->valid_flg = Valid_flg::VALID;
		$entity->delete_forbidden_flg = Valid_flg::INVALID;

		parent::_update_main_table($entity, $session_var);
	}
}