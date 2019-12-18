<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 配車の編集を行うクラス
 *
 */
class Reserve_detail_edit extends Register_Controller 
{
	const RESERVE_DETAIL_ID    = 'reserve_detail_id';

	/** フォームで使用するパラメータ名 */
	const F_RESERVE_ID             = 'reserve_id';
	const F_DETAIL_NUMBER          = 'detail_number';
	const F_CONSTRUCTION_TYPE_ID   = 'construction_type_id';
	const F_CONSTRUCTION_DETAIL_ID = 'construction_detail_id';
	const F_DISPOSAL_ID            = 'disposal_id';
	const F_UNIT_PRICE_ID          = 'unit_price_id';
	const F_CAR_CLASS_ID           = 'car_class_id';
	const F_COUNT_ESTIMATE         = 'count_estimate';
	const F_COUNT_ACTUAL           = 'count_actual';

    var $reserve_id;
    var $detail_number;


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

		$this->package_name = 'reserve_detail';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->T_reserve_detail;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		/*
		 * セッションにデータがセットされていれば常時表示する用に読み込み
		 * indexへのアクセスは前回のセッションが残っている場合があるので除く。
		 */

		if ( ! $this->_is_method_match())
		{
			$reserve_detail_code = $this->_get_page_session(self::RESERVE_DETAIL_ID);
			$this->_init_label($reserve_detail_code);
		}

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);

        $this->_initListArray();

        $this->reserve_color_list = Reserve_color::$COLOR_ARRAY;
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
		$this->_save_page_session(self::RESERVE_DETAIL_ID, $id);

		/*
		 * DBデータを読み込み、表示用にローカル変数にセットする。
		 */

		$this->_load_main_table($id);

        // 予約情報取得
        $this->_loadReserveData( $this->data["reserve_id"] );

        // 作業番号
        $this->detail_number = $this->data["detail_number"];

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
        $this->_loadReserveData($this->data["reserve_id"]);

        $construction_type_id   = $this->data["construction_type_id"];
        $construction_detail_id = $this->data["construction_detail_id"];
        $disposal_id            = $this->data["disposal_id"];
        $car_class_id           = $this->data["car_class_id"];

        $_POST["unit_price_id"]      = $this->_getUnitPriceId($construction_type_id, $construction_detail_id, $disposal_id, $car_class_id);
        $this->data["unit_price_id"] = $_POST["unit_price_id"];

        // 作業番号
        $this->detail_number = $this->data["detail_number"];

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
		$session_var = $this->_get_page_session(parent::SESSION_KEY_INPUT_DATA);
        $this->_loadReserveData( $this->data["reserve_id"] );
		$this->_do_back();
        $this->detail_number = $this->data["detail_number"];
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
		$session_var = $this->_get_page_session(parent::SESSION_KEY_INPUT_DATA);
        $this->reserve_id = $session_var['reserve_id'];

		//セッションデータを削除
		$this->_unset_page_session();

		$this->_load_tpl($this->_get_view_name(View_type::COMPLETE), $this->data);
	}

	/**
	 * 常に表示するラベルをセットする。
	 * 
	 * @param unknown_type $post_id
	 */
	private function _init_label($reserve_code)
	{
		if ($reserve_code !== FALSE)
		{
			$reserve_entity = $this->T_reserve->find($reserve_code);
		}
	}

	/**
	 * 入力チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_RESERVE_ID           , '予約ID'       , 'trim|required|integer');
		$this->form_validation->set_rules(self::F_DETAIL_NUMBER        , '作業番号'     , 'trim|required|integer');
		$this->form_validation->set_rules(self::F_CONSTRUCTION_TYPE_ID , '工種ID'       , 'trim|required|integer');
		$this->form_validation->set_rules(self::F_UNIT_PRICE_ID        , '単価ID'       , 'trim|integer');
		$this->form_validation->set_rules(self::F_CAR_CLASS_ID         , '車輌扱いID'   , 'trim|required|integer');
		$this->form_validation->set_rules(self::F_COUNT_ESTIMATE       , '数量（予定）' , 'trim|callback_check_decimal_point');
		$this->form_validation->set_rules(self::F_COUNT_ACTUAL         , '数量（実績）' , 'trim|callback_check_decimal_point');
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
		//セッションから情報を取得
		$id = $this->_get_page_session(self::RESERVE_DETAIL_ID);
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
		$entity = $this->main_model->find($id);

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
	 * @param unknown_type $reserve_id
	 */
	private function _update_table($session_var, $reserve_id)
	{
		//最新状態のデータを取得
		$entity = $this->T_reserve_detail->find($reserve_id);

		if ( ! $entity)
		{
			show_error('データが存在しないため、更新処理を中止しました。');
			return;	//実際にはこのRETURNには到達しない 
		}

		//ユーザ入力値をセットしてUPDATE
		$entity->reserve_id             = $session_var[self::F_RESERVE_ID];
		$entity->detail_number          = $session_var[self::F_DETAIL_NUMBER];
		$entity->construction_type_id   = $session_var[self::F_CONSTRUCTION_TYPE_ID];
		$entity->construction_detail_id = $session_var[self::F_CONSTRUCTION_DETAIL_ID];
		$entity->disposal_id            = $session_var[self::F_DISPOSAL_ID];
		$entity->unit_price_id          = $session_var[self::F_UNIT_PRICE_ID];
		$entity->car_class_id           = $session_var[self::F_CAR_CLASS_ID];
		$entity->count_estimate         = $session_var[self::F_COUNT_ESTIMATE];
		$entity->count_actual           = $session_var[self::F_COUNT_ACTUAL];

		$this->_update_main_table($entity, $session_var);
	}

    /**
     * 予約情報取得
     *
     * 作業の親となる予約情報と関連する情報を取得する
     */
    private function _loadReserveData($id)
    {
        if( is_blank( $id ) ){
			show_error("予約情報が指定されていません。");
        }

        $this->reserve_id = (int) $id;

        $reserve_entity = $this->T_reserve->find($this->reserve_id);
        if ( ! $reserve_entity ){
			show_error("予約情報が取得出来ません。");
        }
        $staff_entity = $this->M_user->find($reserve_entity->staff_id);
        if ( ! $staff_entity ){
			show_error("担当者情報が取得出来ません。");
        }
        $construction_entity = $this->M_construction->find($reserve_entity->construction_id);
        if ( ! $construction_entity ){
			show_error("工事情報が取得出来ません。");
        }
        $car_profile_entity = $this->M_car_profile->find($reserve_entity->car_profile_id);
        $customer_entity = $this->M_customer->find($construction_entity->customer_id);
        if ( ! $customer_entity){
			show_error("顧客情報が取得出来ません。");
        }

        $this->reserve_entity      = $reserve_entity;
        $this->staff_entity        = $staff_entity;
        $this->construction_entity = $construction_entity;
        $this->car_profile_entity  = $car_profile_entity;
        $this->customer_entity     = $customer_entity;
    }

    private function _initListArray()
    {
        $this->staff_id_list        = $this->_getStaffIdList();
        $this->construction_id_list = $this->M_construction->getConstructionCategoryIdList();
        $this->car_profile_id_list  = $this->M_car_profile->getCarProfileIdList();
        $this->reserve_time_list    = $this->_getTimeList();
        $this->reserve_status_list  = $this->_getStatusIdList();

        // 工事ID 設定時の担当・現場情報を埋める JavaScript 用
        $this->construction_array   = $this->M_construction->select_all();

        // 作業情報プルダウン用
        $this->construction_type_id_list     = $this->_getConstructionTypeIdList();
        $this->construction_detail_id_list   = $this->_getConstructionDetailIdList();
        $this->construction_detail_unit_list = $this->_getConstructionDetailUnitList();
        $this->disposal_id_list              = $this->_getDisposalIdList();
        $this->unit_price_id_list            = $this->_getUnitPriceIdList();
        $this->car_class_id_list             = $this->_getCarClassIdList();
        $this->quantity_unit_label_list      = $this->_getQuantityUnitLabelList();
    }

    private function _getTimeList()
    {
        $list = array();
        for($h = 7; $h < 24; $h++){
            foreach( array(0, 30) as $m ){
                $time = sprintf("%02d:%02d", $h, $m);
                $list[ $time ] = $time;
            }
        }
        return $list;
    }
    private function _getStatusIdList()
    {
        return Reserve_status::get_dropdown_list_without_blank();    
    }
    private function _getStaffIdList()
    {
        return $this->M_user->getStaffIdList();
    }
    private function _getConstructionTypeIdList()
    {
        return $this->M_construction_type->getConstructionTypeIdList(true);
    }
    private function _getConstructionDetailIdList()
    {
        return $this->M_construction_detail->getConstructionDetailIdList(true);
    }
    private function _getConstructionDetailUnitList()
    {
        return $this->M_construction_detail->getConstructionDetailUnitList();
    }
    private function _getDisposalIdList()
    {
        return $this->M_disposal->getDisposalIdList(true);
    }
    private function _getUnitPriceIdList()
    {
        // 工種と種別の関連情報が必要なため単価テーブルから取得する
        return $this->M_unit_price->getUnitPriceIdList();
    }
    private function _getCarClassIdList()
    {
        return $this->M_car_class->getCarClassIdList(true);
    }
    // 新規の作業番号を取得する
    private function _getDetailNumber()
    {
        if( !$this->detail_number ){
            $detail_entities = $this->T_reserve_detail->find_by_reserve_id($this->reserve_id);

            $last_idx      = count($detail_entities) - 1;
            $detail_number = null;

            if($detail_entities){
                $this->detail_number = $detail_entities[ $last_idx ]->detail_number + 1;
            } else {
                $this->detail_number = 1;
            }
        }
        return $this->detail_number;
    }

    // 数量の単位名一覧
    private function _getQuantityUnitLabelList()
    {
        $unit_price_entities = $this->M_unit_price->getUnitPriceIdList(true);
        foreach( $unit_price_entities  as $data ){
            $unit_label_array[ $data->construction_type_id ] = $data->unit;
        }
        return $unit_label_array;
    }
    // 単価ID を取得
    //
    // 工種ID, 種別ID, 処理場ID から単価データIDを取得する
    private function _getUnitPriceId($construction_type_id, $construction_detail_id, $disposal_id, $car_class_id)
    {
        $unit_price_entity = $this->M_unit_price->getUnitPrice($construction_type_id, $construction_detail_id, $disposal_id, $car_class_id);
        $entity_num = count($unit_price_entity);
        if( $unit_price_entity && $entity_num == 1 ){
            return $unit_price_entity[0]->id;
        }
        else if( $entity_num > 1 ){
            show_error("(工種、種別、処理場、車輌扱い) = ($construction_type_id, $construction_detail_id, $disposal_id, $car_class_id) のデータが {$entity_num} 個あります");
        }
        return 0;
    }
}
