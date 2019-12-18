<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 工事の新規登録を行うクラス
 * @author ta-ando
 *
 */
class Construction_register extends Register_Controller
{
	/** フォームで使用するパラメータ名 */
	const F_CONSTRUCTION_CODE    = 'construction_code';
	const F_CUSTOMER_ID          = 'customer_id';
	const F_CONSTRUCTION_NAME    = 'construction_name';
	const F_CONSTRUCTION_ADDRESS = 'construction_address';
	const F_CONSTRUCTION_STATUS  = 'construction_status';
	const F_LATITUDE             = 'latitude';
	const F_LONGITUDE            = 'longitude';

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

		$this->package_name = 'construction';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}登録";
		$this->page_type = Page_type::REGISTER;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_construction;
		$this->customer_model = $this->M_customer;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);

        $this->_initListArray();

        $this->construction_status_list = Construction_status::$CONST_ARRAY;
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
        $this->data[self::F_CONSTRUCTION_STATUS] = '1';
	}

	/**
	 * 入力チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_CONSTRUCTION_CODE, '工事コード', 'trim|required|max_length[10]');
		$this->form_validation->set_rules(self::F_CUSTOMER_ID, '顧客名', 'trim|required|integer|max_length[20]');
		$this->form_validation->set_rules(self::F_CONSTRUCTION_NAME, '現場名', 'trim|required|max_length[255]');
		$this->form_validation->set_rules(self::F_CONSTRUCTION_ADDRESS, '住所', 'trim|required|max_length[255]');
		$this->form_validation->set_rules(self::F_CONSTRUCTION_STATUS, '状態', 'trim|required|integer|max_length[11]');
		$this->form_validation->set_rules(self::F_LATITUDE, '緯度', 'trim|max_length[255]');
		$this->form_validation->set_rules(self::F_LONGITUDE, '経度', 'trim|max_length[255]');

		return $this->form_validation->run();
	}

	/**
	 * 相関チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _relation_check()
	{
		$ret = TRUE;

        $construction_code = $this->data[self::F_CONSTRUCTION_CODE];
		if ($this->M_construction->is_construction_code_exists($construction_code))
		{
			$ret = FALSE;
			$this->error_list['construction_code_duplicate'] = '入力された工事コードは既に登録されています。';
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
		$entity = new M_construction();
		$entity->construction_code    = $session_var[self::F_CONSTRUCTION_CODE];
		$entity->customer_id          = $session_var[self::F_CUSTOMER_ID];
		$entity->construction_name    = $session_var[self::F_CONSTRUCTION_NAME];
		$entity->construction_address = $session_var[self::F_CONSTRUCTION_ADDRESS];
		$entity->construction_status  = $session_var[self::F_CONSTRUCTION_STATUS];
		$entity->latitude             = $session_var[self::F_LATITUDE];
		$entity->longitude            = $session_var[self::F_LONGITUDE];

		return parent::_insert_main_table($entity, $session_var);
	}

    private function _initListArray()
    {
        $this->customer_id_list   = $this->M_customer->getCustomerIdList(true);
    }
}
