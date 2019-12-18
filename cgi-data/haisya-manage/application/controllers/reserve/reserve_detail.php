<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 配車作業の新規登録を行うクラス
 * @author ta-ando
 *
 */
class Reserve_detail extends Register_Controller
{
	/** フォームで使用するパラメータ名 */
	const F_RESERVE_ID           = 'reserve_id';
	const F_DETAIL_NUMBER        = 'detail_number';
	const F_CONSTRUCTION_TYPE_ID = 'construction_type_id';
	const F_UNIT_PRICE_ID        = 'unit_price_id';
	const F_CAR_CLASS_ID         = 'car_class_id';
	const F_COUNT_ESTIMATE       = 'count_estimate';
	const F_COUNT_ACTUAL         = 'count_actual';

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

		$this->package_name       = 'reserve';
		$this->package_label      = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag      = "{$this->package_label}詳細";
		$this->page_type          = Page_type::REGISTER;
		$this->current_main_menu  = $this->package_name;
		$this->main_model         = $this->T_reserve;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);

        // プルダウン用配列の初期化
        $this->_initListArray();

        $this->reserve_color_list = Reserve_color::$COLOR_ARRAY;
        $this->reserve_color_list[''] = "未設定"; // 運用前の未設定データ対応（運用時はこの行は削除すべき？）
	}

	/**
	 * 初期表示を行う。
	 */
	public function index($id = null)
	{
        $this->_loadReserveData($id);
        $this->_loadReserveDetailData($id);

        $this->cal_date = date("Ymd", strtotime($this->reserve_entity->reserve_date));

		$this->_unset_page_session();
		$this->_set_default_form_value();

		$this->_load_tpl($this->_get_view_name(View_type::DETAIL), $this->data);
	}

	/**
	 * 開始。
	 */
	public function start($id = null)
	{
		$this->_unset_page_session();
		$this->_save_page_session(self::F_RESERVE_ID, $id);

		//DB更新処理
		$this->_do_db_logic('start');

        redirect(site_url("reserve/reserve_detail/index/{$id}"), 'location', 301);
	}

	/**
	 * 終了。
	 */
	public function end($id = null)
	{
		$this->_unset_page_session();
		$this->_save_page_session(self::F_RESERVE_ID, $id);

		//DB更新処理
		$this->_do_db_logic('end');

		$this->_load_tpl($this->_get_view_name(View_type::SEARCH), $this->data);

        redirect(site_url("reserve/reserve_detail/index/{$id}"), 'location', 301);
	}

	/**
	 * DBへの更新処理を行うロジック
	 * 
	 */
	private function _do_db_logic($status)
	{
		//セッションから情報を取得
		$reserve_id = $this->_get_page_session(self::F_RESERVE_ID);

		if ( ! $reserve_id)
		{
			show_error(parent::ERROR_MSG_SESSION_ERRROR);
		}

		$this->db->trans_start();

		/*
		 * メインのテーブルの更新処理
		 */

		$this->main_model->update_time($reserve_id, $status);

		$this->db->trans_complete();
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
        if( $reserve_entity->staff_id == 0 && $reserve_entity->reserve_status == 9 ){ // 複製データ
            $staff_entity = new stdClass();
            $staff_entity->user_name = "未設定";
        } else {
            $staff_entity = $this->M_user->find($reserve_entity->staff_id);
            if ( ! $staff_entity ){
		    	show_error("担当者情報が取得出来ません。");
            }
        }
        $construction_entity = $this->M_construction->find($reserve_entity->construction_id);
        if ( ! $construction_entity ){
			show_error("工事情報が取得出来ません。");
        }
        $car_profile_entity = $this->M_car_profile->find($reserve_entity->car_profile_id);
        //if ( ! $car_profile_entity){
		//	show_error("車輌基本情報が取得出来ません。");
        //}
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

    /**
     * 作業情報取得
     */
    private function _loadReserveDetailData($reserve_id)
    {
        $this->reserve_detail_entities = $this->T_reserve_detail->find_by_reserve_id($reserve_id);
    }

    private function _initListArray()
    {
        //$this->staff_id_list        = $this->_getStaffIdList();
        //$this->construction_id_list = $this->M_construction->getConstructionCategoryIdList();
        //$this->car_profile_id_list  = $this->M_car_profile->getCarProfileIdList();
        //$this->reserve_time_list    = $this->_getTimeList();
        $this->reserve_status_list  = $this->_getStatusIdList();

        // 工事ID 設定時の担当・現場情報を埋める JavaScript 用
        $this->construction_array   = $this->M_construction->select_all();

        // 作業情報プルダウン用
        //$this->construction_type_id_list     = $this->_getConstructionTypeIdList();
        //$this->construction_detail_id_list   = $this->_getConstructionDetailIdList();
        //$this->construction_detail_unit_list = $this->_getConstructionDetailUnitList();
        //$this->disposal_id_list              = $this->_getDisposalIdList();
        //$this->unit_price_id_list            = $this->_getUnitPriceIdList();
        //$this->car_class_id_list             = $this->_getCarClassIdList();
        //$this->quantity_unit_label_list      = $this->_getQuantityUnitLabelList();
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
/*
    private function _getConstructionTypeIdList()
    {
        return $this->M_construction_type->getConstructionTypeIdList(true);
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
    private function _getConstructionDetailUnitList()
    {
        return $this->M_construction_detail->getConstructionDetailUnitList();
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
    private function _getConstructionDetailIdList()
    {
        return $this->M_construction_detail->getConstructionDetailIdList(true);
    }
    private function _getDisposalIdList()
    {
        return $this->M_disposal->getDisposalIdList(true);
    }
*/
}
