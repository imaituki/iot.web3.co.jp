<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 配車の新規登録を行うクラス
 * @author ta-ando
 *
 */
class Reserve_register extends Register_Controller
{
	const RESERVE_ID           = 'reserve_id';

	/** フォームで使用するパラメータ名 */
	const F_STAFF_ID           = 'staff_id';
	const F_RESERVE_STATUS     = 'reserve_status';
	const F_COLOR              = 'color';
	const F_RESERVE_DATE       = 'reserve_date';
	const F_RESERVE_TIME_START = 'reserve_time_start';
	const F_RESERVE_TIME_END   = 'reserve_time_end';
	const F_TIME_START         = 'time_start';
	const F_TIME_END           = 'time_end';
	const F_CONSTRUCTION_ID    = 'construction_id';
	const F_CAR_PROFILE_ID     = 'car_profile_id';
	const F_MEMO               = 'memo';

    var $time;

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
		$this->common_h3_tag      = "{$this->package_label}登録";
		$this->page_type          = Page_type::REGISTER;
		$this->current_main_menu  = $this->package_name;
		$this->main_model         = $this->T_reserve;
		$this->customer_model     = $this->M_customer;
		$this->car_profile_model  = $this->M_car_profile;
		$this->construction_model = $this->M_construction;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);


        // GET アクセスで time, given_date があれば変換して $this->data に埋める
        // -> これはカレンダー画面からの遷移を想定している
        $time = $this->input->get("time");
        $given_date = $this->input->get("given_date");
        if( $given_date && preg_match("/^\d{8}$/", $given_date) ){
            $y = substr($given_date, 0, 4);
            $m = substr($given_date, 4, 2);
            $d = substr($given_date, 6, 2);
            $given_datetime = mktime(0,0,0, $m, $d, $y);
            $this->data["reserve_date"] = date("Y-m-d", $given_datetime);
        }
        if( $time && preg_match("/^\d+$/", $time) ){
            $h     = $time / 10;
            $m     = ($time % 10 == 5) ? 30 : 0;
            $time += 15;
            $h_end = $time / 10;
            $m_end = ($time % 10 == 5) ? 30 : 0;
            $this->data[self::F_RESERVE_TIME_START] = sprintf("%02d:%02d", $h, $m);
            $this->data[self::F_RESERVE_TIME_END]   = sprintf("%02d:%02d", $h_end, $m_end);
        }

        $this->_initListArray();
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

        // 新規登録時は null とする
        $this->db_reserve_status = null;

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
		$id = $this->_do_db_logic();

		$this->_save_page_session(self::RESERVE_ID, $id);

		//完了画面表示用メソッドへリダイレクト
		redirect($this->_get_redirect_url_complete(), 'location', 301);
	}

	/**
	 * 完了画面を表示する
	 */
	function complete()
	{
		$this->reserve_id = $this->_get_page_session(self::RESERVE_ID);

		//常に表示させるデータをセット
		$this->_init_label($this->reserve_id);

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

        $this->cal_date = date("Ymd", strtotime($reserve_entity->reserve_date));
	}


	/**
	 * 入力チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _input_check()
	{
		$this->form_validation->set_rules(self::F_STAFF_ID           , '担当'             , 'trim|required|integer');
		$this->form_validation->set_rules(self::F_RESERVE_STATUS     , 'ステータス'       , 'trim|required|integer');
		$this->form_validation->set_rules(self::F_COLOR              , '表示カラー'       , 'trim|required|max_length[7]');
		$this->form_validation->set_rules(self::F_RESERVE_DATE       , '予約日'           , 'trim|required|max_length[10]');
		$this->form_validation->set_rules(self::F_RESERVE_TIME_START , '予約開始時刻'     , 'trim|required|max_length[5]');
		$this->form_validation->set_rules(self::F_RESERVE_TIME_END   , '予約終了時刻'     , 'trim|required|max_length[5]');
		$this->form_validation->set_rules(self::F_TIME_START         , '開始時刻'         , 'trim|callback_check_time|max_length[5]');
		$this->form_validation->set_rules(self::F_TIME_END           , '終了時刻'         , 'trim|callback_check_time|max_length[5]');
		$this->form_validation->set_rules(self::F_CONSTRUCTION_ID    , '工事コード'       , 'trim|required|max_length[5]');
        $this->form_validation->set_rules(self::F_CAR_PROFILE_ID     , 'ナンバープレート' , 'trim|integer');
        $this->form_validation->set_rules(self::F_MEMO               , '備考'             , 'trim|max_length[255]');
		return $this->form_validation->run();
	}

	/**
	 * 相関チェックを行う。
	 * @return TRUE:エラー無し、FALSE:エラー有り
	 */
	private function _relation_check()
	{
		$ret = TRUE;

        $reserve_time_start = $this->data[self::F_RESERVE_TIME_START];
        $reserve_time_end = $this->data[self::F_RESERVE_TIME_END];
        if( $reserve_time_start >= $reserve_time_end ){
            $ret = FALSE;
			$this->error_list['reserve_time_end'] = '予約終了時刻は予約開始時刻よりあとの時刻を指定して下さい';
        }
        $time_start = $this->data[self::F_TIME_START];
        $time_end = $this->data[self::F_TIME_END];
        if ($time_start || $time_end)
        {
            if(!$time_start){
                $ret = FALSE;
		    	$this->error_list['time_end'] = '実施開始時刻を入力して下さい';
            }
            else if(!$time_end){
                $ret = FALSE;
		    	$this->error_list['time_end'] = '実施終了時刻を入力して下さい';
            }
            else if( $time_start >= $time_end ){
                $ret = FALSE;
		    	$this->error_list['time_end'] = '実施終了時刻は実施開始時刻よりあとの時刻を指定して下さい';
            }
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

        return $new_user_id;
	}

	/**
	 * この画面で更新するメインテーブルをINSERTする
	 * 
	 * @param unknown_type $session_var
	 */
	private function _insert_table($session_var)
	{
		$entity                     = new T_reserve();
		$entity->staff_id           = $session_var[self::F_STAFF_ID];
		$entity->reserve_status     = $session_var[self::F_RESERVE_STATUS];
		$entity->color              = $session_var[self::F_COLOR];
		$entity->reserve_date       = $session_var[self::F_RESERVE_DATE];
		$entity->reserve_time_start = $session_var[self::F_RESERVE_TIME_START];
		$entity->reserve_time_end   = $session_var[self::F_RESERVE_TIME_END];
		$entity->time_start         = ($session_var[self::F_TIME_START]) ? $session_var[self::F_TIME_START] : null;
		$entity->time_end           = ($session_var[self::F_TIME_END]) ? $session_var[self::F_TIME_END] : null;
		$entity->construction_id    = $session_var[self::F_CONSTRUCTION_ID];
		$entity->car_profile_id     = $session_var[self::F_CAR_PROFILE_ID];
		$entity->memo               = $session_var[self::F_MEMO];

		return parent::_insert_main_table($entity, $session_var);
	}

    private function _initListArray()
    {
        $this->initDate();

        // プルダウン用
        $this->staff_id_list        = $this->_getStaffIdList();
        $this->construction_id_list = $this->M_construction->getConstructionCategoryIdList(true);
        $this->car_profile_id_list  = $this->M_car_profile->getCarProfileIdList(true);
        $this->reserve_time_list    = $this->_getTimeList();
        $this->reserve_status_list  = $this->_getStatusIdList();
        $this->reserve_color_list   = $this->_getStatusColorIdList();

        // 工事ID 設定時の担当・現場情報を埋める JavaScript 用
        $this->construction_array   = $this->M_construction->select_all();

        // JS 用
        $this->construction_type_id_list = $this->_getConstructionTypeIdList();
        $this->unit_price_id_list        = $this->_getUnitPriceIdList();
    }

    private function initDate()
    {
        $this->data["reserve_date"] = (!isset($this->data["reserve_date"]) || $this->data["reserve_date"] == "") ? date("Y-m-d") : $this->data["reserve_date"];
    }

    private function _getTimeList()
    {
        $list = array('' => '----');
        for($h = 6; $h < 20; $h++){
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
    private function _getStatusColorIdList()
    {
        return Reserve_color::get_dropdown_list_without_blank();    
    }
    private function _getStaffIdList()
    {
        return $this->M_user->getStaffIdList();
    }
    private function _getConstructionTypeIdList()
    {
        return $this->M_construction_type->getConstructionTypeIdList();
    }
    private function _getUnitPriceIdList()
    {
        // 工種と種別の関連情報が必要なため単価テーブルから取得する
        return $this->M_unit_price->getUnitPriceIdList();
    }
}
