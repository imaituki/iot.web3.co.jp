<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 単価の編集を行うクラス
 *
 */
class Unit_price_edit extends Register_Controller 
{
	const UNIT_PRICE_ID = 'unit_price_id';

	/** フォームで使用するパラメータ名 */
	const F_CONSTRUCTION_TYPE_ID   = 'construction_type_id';
	const F_CONSTRUCTION_DETAIL_ID = 'construction_detail_id';
	const F_DISPOSAL_ID            = 'disposal_id';
	const F_CAR_CLASS_ID           = 'car_class_id';
	const F_UNIT_PRICE             = 'unit_price';
	const F_POINT                  = 'point';

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

		$this->package_name = 'unit_price';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_unit_price;
		$this->construction_type_model     = $this->M_construction_type;
		$this->construction_detail_model   = $this->M_construction_detail;
		$this->disposal_model              = $this->M_disposal;
		$this->car_class_model             = $this->M_car_class;
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
			$unit_price_id = $this->_get_page_session(self::UNIT_PRICE_ID);
			$this->_init_label($unit_price_id);
		}

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);

        $this->_initListArray();
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
		$this->_save_page_session(self::UNIT_PRICE_ID, $id);

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
	 * @param unknown_type unit_price_id
	 */
	private function _init_label($unit_price_id)
	{
		if ($unit_price_id !== FALSE)
		{
			$unit_price_id_entity = $this->M_construction_category->find($unit_price_id);
		}
	}

	/**
	 * 入力チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_CONSTRUCTION_TYPE_ID, '工種', 'trim|required|max_length[25]');
		$this->form_validation->set_rules(self::F_CONSTRUCTION_DETAIL_ID, '種別', 'trim|required|max_length[25]');
		$this->form_validation->set_rules(self::F_DISPOSAL_ID, '処理場', 'trim|max_length[25]');
		$this->form_validation->set_rules(self::F_CAR_CLASS_ID, '車輌扱い', 'trim|max_length[25]');
		$this->form_validation->set_rules(self::F_UNIT_PRICE, '単価', 'trim|required|max_length[25]');
		$this->form_validation->set_rules(self::F_POINT, 'ポイント', 'trim|required|max_length[25]');

		return $this->form_validation->run();
	}

	/**
	 * 相関チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _relation_check()
	{
		$ret = TRUE;

        $construction_type_id = $this->data[self::F_CONSTRUCTION_TYPE_ID];
        $construction_detail_id = $this->data[self::F_CONSTRUCTION_DETAIL_ID];
        $disposal_id = $this->data[self::F_DISPOSAL_ID];
        $car_class_id = $this->data[self::F_CAR_CLASS_ID];
		$unit_price_id = $this->_get_page_session(self::UNIT_PRICE_ID);

		if ($this->M_unit_price->is_unit_price_exists_edit($construction_type_id, $construction_detail_id, $disposal_id, $car_class_id, $unit_price_id))
		{
			$ret = FALSE;
			$this->error_list['unit_price_duplicate'] = '入力された工種、種別、処理場、車輌扱いの組は既に登録されています。';
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
		$id = $this->_get_page_session(self::UNIT_PRICE_ID);
		$session_var = $this->_get_page_session(parent::SESSION_KEY_INPUT_DATA);

		if ( ! $session_var)
		{
			show_error(parent::ERROR_MSG_SESSION_ERRROR);
		}

		$this->db->trans_start();

		/*
		 * メインのテーブルの更新処理
		 */

		$this->M_unit_price->logical_delete($id);
		$new_id = $this->_insert_table($session_var);
		//$this->_update_table($session_var, $id);

		$this->db->trans_complete();
	}

	/**
	 * 画面でメインに使用するテーブルを読み込み保持する。
	 * 
	 * @param unknown_type $id
	 */
	private function _load_main_table($id)
	{
		// 単価情報を取得する
		$entity = $this->M_unit_price->find($id);

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
	 * @param unknown_type $unit_price_id
	 */
	private function _update_table($session_var, $unit_price_id)
	{
		//最新状態のデータを取得
		$entity = $this->M_unit_price->find($unit_price_id);

		if ( ! $entity)
		{
			show_error('データが存在しないため、更新処理を中止しました。');
			return;	//実際にはこのRETURNには到達しない 
		}

		//単価入力値をセットしてUPDATE
		$entity->construction_type_id = $session_var[self::F_CONSTRUCTION_TYPE_ID];
		$entity->construction_detail_id = $session_var[self::F_CONSTRUCTION_DETAIL_ID];
		$entity->disposal_id = $session_var[self::F_DISPOSAL_ID];
		$entity->car_class_id = $session_var[self::F_CAR_CLASS_ID];
		$entity->unit_price = $session_var[self::F_UNIT_PRICE];
		$entity->point = $session_var[self::F_POINT];

		$this->_update_main_table($entity, $session_var);
	}

	/**
	 * この画面で更新するメインテーブルをINSERTする
	 * 
	 * @param unknown_type $session_var
	 */
	private function _insert_table($session_var)
	{
		$entity = new M_unit_price();
		$entity->construction_type_id = $session_var[self::F_CONSTRUCTION_TYPE_ID];
		$entity->construction_detail_id = $session_var[self::F_CONSTRUCTION_DETAIL_ID];
		$entity->disposal_id = $session_var[self::F_DISPOSAL_ID];
		$entity->car_class_id = $session_var[self::F_CAR_CLASS_ID];
		$entity->unit_price = $session_var[self::F_UNIT_PRICE];
		$entity->point = $session_var[self::F_POINT];

		return parent::_insert_main_table($entity, $session_var);
	}

    private function _initListArray()
    {
        $this->construction_type_id_list   = $this->M_construction_type->getConstructionTypeIdList(true);
        $this->construction_detail_id_list = $this->M_construction_detail->getConstructionDetailIdList(true);
        $this->disposal_id_list            = $this->M_disposal->getDisposalIdList(true);
        $this->car_class_id_list           = $this->M_car_class->getCarClassIdList(true);
    }

}
