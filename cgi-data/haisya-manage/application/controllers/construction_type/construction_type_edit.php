<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 工種の編集を行うクラス
 *
 */
class Construction_type_edit extends Register_Controller 
{
	const CONSTRUCTION_TYPE_ID = 'construction_type_id';

	/** フォームで使用するパラメータ名 */
	const F_CONSTRUCTION_TYPE_CODE   = 'construction_type_code';
	const F_CONSTRUCTION_CATEGORY_ID = 'construction_category_id';
	const F_CONSTRUCTION_TYPE_NAME   = 'construction_type_name';

    /** 分類ID */
    var $construction_category_id_list;

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

		$this->package_name = 'construction_type';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_construction_type;
		$this->construction_category_model = $this->M_construction_category;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		/*
		 * セッションにデータがセットされていれば常時表示する用に読み込み
		 * indexへのアクセスは前回のセッションが残っている場合があるので除く。
		 */

		if ( ! $this->_is_method_match())
		{
			$construction_type_id = $this->_get_page_session(self::CONSTRUCTION_TYPE_ID);
			$this->_init_label($construction_type_id);
		}

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);

        $this->_initConstructionCategoryIdList();
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
		$this->_save_page_session(self::CONSTRUCTION_TYPE_ID, $id);

		/*
		 * DBデータを読み込み、表示用にローカル変数にセットする。
		 */

		$this->_load_main_table($id);

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
	 * @param unknown_type $construction_type_id
	 */
	private function _init_label($construction_type_id)
	{
		if ($construction_type_id !== FALSE)
		{
			$construction_type_entity = $this->M_construction_type->find($construction_type_id);
		}
	}

	/**
	 * 入力チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_CONSTRUCTION_TYPE_CODE, '工種コード', 'trim|required|max_length[25]');
		$this->form_validation->set_rules(self::F_CONSTRUCTION_CATEGORY_ID, '分類名', 'trim|required|max_length[25]');
		$this->form_validation->set_rules(self::F_CONSTRUCTION_TYPE_NAME, '工種名', 'trim|required|max_length[25]');

		return $this->form_validation->run();
	}

    /** * 相関チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _relation_check()
	{
		$ret = TRUE;

        $construction_type_code = $this->data[self::F_CONSTRUCTION_TYPE_CODE];
        $construction_category_id = $this->data[self::F_CONSTRUCTION_CATEGORY_ID];
        $construction_type_name = $this->data[self::F_CONSTRUCTION_TYPE_NAME];
		$construction_type_id = $this->_get_page_session(self::CONSTRUCTION_TYPE_ID);

        //工種コード
		if ($this->M_construction_type->is_construction_type_code_exists_edit($construction_type_code, $construction_type_id))
		{
			$ret = FALSE;
			$this->error_list['construction_type_code_duplicate'] = '入力された工種コードは既に登録されています。';
		}
        //工種名
		if ($this->M_construction_type->is_construction_type_name_exists_edit($construction_type_name, $construction_type_id))
		{
			$ret = FALSE;
			$this->error_list['construction_type_name_duplicate'] = '入力された工種名は既に登録されています。';
		}
        //組み合せ（工種コード・分類・工種名）
		if ($this->M_construction_type->is_construction_type_exists_edit($construction_type_code, $construction_category_id, $construction_type_name, $construction_type_id))
		{
			$ret = FALSE;
			$this->error_msg = '入力された組み合せ（工種コード・分類・工種名）は既に登録されています。';
		}

		return $ret;
	}

	/**
	 * DBへの更新処理を行うロジック
	 * 
	 */
	private function _do_db_logic()
	{
		//セッションから情報を取得
		$id = $this->_get_page_session(self::CONSTRUCTION_TYPE_ID);
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
		// 工種情報を取得する
		$entity = $this->M_construction_type->find($id);

		if ( ! $entity) 
		{
			show_error("データが存在しません");
			exit;
		}

		$this->data = array_merge($this->data, (array)$entity);

		return $entity;
	}

	/**
	 * この画面で扱うメインテーブルの更新処理
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $construction_type_id
	 */
	private function _update_table($session_var, $construction_type_id)
	{
		//最新状態のデータを取得
		$entity = $this->M_construction_type->find($construction_type_id);

		if ( ! $entity)
		{
			show_error('データが存在しないため、更新処理を中止しました。');
			return;	//実際にはこのRETURNには到達しない 
		}

		//ユーザ入力値をセットしてUPDATE
		$entity->construction_type_code = $session_var[self::F_CONSTRUCTION_TYPE_CODE];
		$entity->construction_category_id = $session_var[self::F_CONSTRUCTION_CATEGORY_ID];
		$entity->construction_type_name = $session_var[self::F_CONSTRUCTION_TYPE_NAME];

		$this->_update_main_table($entity, $session_var);
	}

    private function _initConstructionCategoryIdList()
    {
        $this->construction_category_id_list = $this->M_construction_category->getConstructionCategoryIdList(true);
    }

}
