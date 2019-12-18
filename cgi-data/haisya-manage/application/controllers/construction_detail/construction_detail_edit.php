<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 種別の編集を行うクラス
 *
 * 種別は工種のサブカテゴリになっている。
 *
 */
class Construction_detail_edit extends Register_Controller 
{
	const CONSTRUCTION_DETAIL_ID = 'construction_detail_id';

	/** フォームで使用するパラメータ名 */
	const F_CONSTRUCTION_DETAIL_CODE = 'construction_detail_code';
	const F_CONSTRUCTION_DETAIL_NAME = 'construction_detail_name';
	const F_WEIGHT                   = 'weight';
	const F_UNIT                     = 'unit';

    /** 種別ID */
    var $class_id_list;

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

		$this->package_name = 'construction_detail';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_construction_detail;
//		$this->class_model = $this->M_class;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		/*
		 * セッションにデータがセットされていれば常時表示する用に読み込み
		 * indexへのアクセスは前回のセッションが残っている場合があるので除く。
		 */

		if ( ! $this->_is_method_match())
		{
			$construction_detail_id = $this->_get_page_session(self::CONSTRUCTION_DETAIL_ID);
			$this->_init_label($construction_detail_id);
		}

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);

//        $this->_initClassIdList();
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
		$this->_save_page_session(self::CONSTRUCTION_DETAIL_ID, $id);

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
	 * @param unknown_type $post_id
	 */
	private function _init_label($construction_detail_id)
	{
		if ($construction_detail_id !== FALSE)
		{
			$construction_detail_entity = $this->M_construction_detail->find($construction_detail_id);
		}
	}

	/**
	 * 入力チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_CONSTRUCTION_DETAIL_CODE, '種別コード', 'trim|required|max_length[25]');
		$this->form_validation->set_rules(self::F_CONSTRUCTION_DETAIL_NAME, '種別名', 'trim|max_length[25]');
		$this->form_validation->set_rules(self::F_WEIGHT, '重量', 'trim|max_length[25]');
		$this->form_validation->set_rules(self::F_UNIT, '単位', 'trim|max_length[25]');

		return $this->form_validation->run();
	}

	/**
	 * 相関チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _relation_check()
	{
		$ret = TRUE;

        $construction_detail_code = $this->data[self::F_CONSTRUCTION_DETAIL_CODE];
        $construction_detail_name = $this->data[self::F_CONSTRUCTION_DETAIL_NAME];
		$construction_detail_id = $this->_get_page_session(self::CONSTRUCTION_DETAIL_ID);

		if ($this->M_construction_detail->is_construction_detail_code_exists_edit($construction_detail_code, $construction_detail_id))
		{
			$ret = FALSE;
			$this->error_list['construction_detail_code_duplicate'] = '入力された種別コードは既に登録されています。';
		}
		if ($this->M_construction_detail->is_construction_detail_name_exists_edit($construction_detail_name, $construction_detail_id))
		{
			$ret = FALSE;
			$this->error_list['construction_detail_name_duplicate'] = '入力された種別名は既に登録されています。';
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
		$id = $this->_get_page_session(self::CONSTRUCTION_DETAIL_ID);
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
		// 顧客情報を取得する
		$entity = $this->M_construction_detail->find($id);

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
	 * @param unknown_type $construction_detail_id
	 */
	private function _update_table($session_var, $construction_detail_id)
	{
		//最新状態のデータを取得
		$entity = $this->M_construction_detail->find($construction_detail_id);

		if ( ! $entity)
		{
			show_error('データが存在しないため、更新処理を中止しました。');
			return;	//実際にはこのRETURNには到達しない 
		}

		//ユーザ入力値をセットしてUPDATE
		$entity->construction_detail_code  = $session_var[self::F_CONSTRUCTION_DETAIL_CODE];
		$entity->construction_detail_name  = $session_var[self::F_CONSTRUCTION_DETAIL_NAME];
		$entity->weight                    = $session_var[self::F_WEIGHT];
		$entity->unit                      = $session_var[self::F_UNIT];

		$this->_update_main_table($entity, $session_var);
	}

/*
    private function _initClassIdList()
    {
        $this->class_id_list = $this->M_class->getClassIdList();
    }
*/
}
