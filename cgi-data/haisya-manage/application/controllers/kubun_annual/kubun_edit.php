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
	const F_VALID_FLG = 'valid_flg';  // 区分種別

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

		$this->package_name = 'kubun_annual';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->_page_setting('kubun');

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//関係テーブルのデータをDBからの呼び出す
		$this->_init_relation_data();

		if ( ! $this->_is_method_match())
		{
			$kubun_id = $this->_get_page_session(self::KUBUN_ID);
			$this->_load_main_table($kubun_id);
		}

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

		$this->data = array_merge($this->data, (array)$this->target_entity);

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
	 * 入力チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		//$this->form_validation->set_rules(self::F_VALID_FLG, '有効', 'required');

		//return $this->form_validation->run();
		return TRUE;
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

		$this->_update_kubun_table($session_var, $kubun_id);

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

		$this->target_entity = $entity;
	}

	/**
	 * この画面で更新するメインテーブルをUPDATEする
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $kubun_id
	 */
	private function _update_kubun_table($session_var, $kubun_id)
	{
		$entity = $this->M_kubun->find($kubun_id);

		if ( ! $entity)
		{
			show_error('データが存在しないため、更新処理を中止しました。');
			return;	//実際にはこのRETURNには到達しない 
		}

		$entity->valid_flg = ($session_var[self::F_VALID_FLG] == Valid_flg::VALID)
		                     ? Valid_flg::VALID
		                     : Valid_flg::INVALID;

		$this->M_kubun->update($this->login_user->user_code, $entity);
	}


	/**
	 * セッションに保持しているIDを元にこの画面で操作するデータのエンティティを取得する。
	 */
	protected function _load_entity_from_session()
	{
		$post_id = $this->_get_page_session(self::POST_ID);

		// 記事を取得
		$entity = $this->main_model->find_with_relation_id(
		                             $post_id,
		                             $this->application_session_data->get_relation_data_type($this->package_name),
		                             $this->application_session_data->get_relation_data_id($this->package_name)
		                         );

		if ( ! $entity) 
		{
			//エラーページを表示して処理終了
			show_error('データが存在しません');
			return;	//実際にはこのRETURNには到達しない 
		}

		$this->target_entity = $entity;
	}
}