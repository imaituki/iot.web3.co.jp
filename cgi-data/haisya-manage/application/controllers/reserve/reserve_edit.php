<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 配車の編集を行うクラス
 *
 */
class Reserve_edit extends Register_Controller 
{
	const RESERVE_ID           = 'reserve_id';
    const COPY_ID              = 'copy_id'; // コピーによって生成された ID
    const DB_RESERVE_STATUS    = 'db_reserve_status';

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

		$this->package_name = 'reserve';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}編集";
		$this->page_type = Page_type::EDIT;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->T_reserve;
		$this->customer_model = $this->M_customer;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		/*
		 * セッションにデータがセットされていれば常時表示する用に読み込み
		 * indexへのアクセスは前回のセッションが残っている場合があるので除く。
		 */

		if ( ! $this->_is_method_match())
		{
			$reserve_code = $this->_get_page_session(self::RESERVE_ID);
            if( $reserve_code )
            {
			    $this->_init_label($reserve_code);
            }
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

        // copy() により遷移してきた場合の対応
		$this->copy_id = $this->_get_page_session(self::COPY_ID);
        if( $this->copy_id > 0 ){
            $this->onload_js = '$(function(){
                $("#dialog_complete").dialog({
                    resizable: false,
                    modal: true,
                    buttons: {
                        "閉じる": function() {
                            $(this).dialog("close");
                        }
                    }
                });
            });';
        } else {
            $this->onload_js = null;
        }

		/*
		 * 初期処理
		 */

		$this->_unset_page_session();
		$this->_save_page_session(self::RESERVE_ID, $id);
        $this->reserve_id = $id;

		/*
		 * DBデータを読み込み、表示用にローカル変数にセットする。
		 */

		$this->_load_main_table($id);
		$this->_save_page_session(self::DB_RESERVE_STATUS, $this->data["reserve_status"]);

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
        $this->reserve_id        = $this->_get_page_session(self::RESERVE_ID);
        $this->db_reserve_status = $this->_get_page_session(self::DB_RESERVE_STATUS);
		//チェック処理
		if ( ! $this->_input_check()
		or ! $this->_relation_check())
		{
            $this->onload_js = null;
			$this->_load_tpl($this->_get_view_name(View_type::INPUT), $this->data);
			return;
		}

		//セッションに情報を保持
		$this->_save_page_session(
		    parent::SESSION_KEY_INPUT_DATA,
		    $this->_create_session_value($this->optional_keys)
		);

        $this->data["id"] = $this->_get_page_session(self::RESERVE_ID);
		$this->_load_tpl($this->_get_view_name(View_type::CONF), $this->data);
	}

	/**
	 * 入力データを保持して入力画面に戻ります
	 */
	function back()
	{
        $this->reserve_id = $this->_get_page_session(self::RESERVE_ID);
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

		$id = $this->_get_page_session(self::RESERVE_ID);
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

		//セッションデータを削除
		$this->_unset_page_session();

		$this->_load_tpl($this->_get_view_name(View_type::COMPLETE), $this->data);
	}

    /**
     * 複製
     */
    function copy($id)
    {
		$this->_load_main_table($id);
        $this->data["id"]             = null;
        $this->data["staff_id"]       = 0; // 担当者を未設定にする(null だと DB 上必須項目なので SQL エラーとなる)
        $this->data["reserve_status"] = 9; // 複製ステータスにする
        $reserve_detail_entities      = $this->_getReserveDetailEntities($id);
        $reserve_detail_array         = array();

		$this->db->trans_start();
		$new_id = $this->_insert_table($this->data);
        foreach($reserve_detail_entities as $entity){

            $entity_array = (array) $entity;
            $entity_array["reserve_id"]     = $new_id;
            $entity_array["count_estimate"] = null;
            $entity_array["count_actual"]   = null;
            $this->_insert_reserve_detail_table($entity_array);

        }
		$this->db->trans_complete();
		$this->_save_page_session(self::COPY_ID, $new_id);
		redirect(site_url("/reserve/reserve_edit/index")."/".$new_id, 'location', 301);
    }

    /**
     * 配車更新
     */
    function haisha_update()
    {
        $reserve_id = $this->input->post("reserve_id");
        $staff_id   = $this->input->post("staff_id");
        $start_time = $this->input->post("start_time"); // 整数,  9:00 なら 90
        $end_time   = $this->input->post("end_time");   // 整数, 12:30 なら 125

        // TODO: haisha_update バリデーション
        //if( $this->_haisha_update_validate() ){
        //  header("HTTP/1.0 403 Forbidden"); 
        //  echo "Invalid parameter";
        //  exit;
        //}

        $this->reserve_id = $reserve_id;
		/*
		 * DBデータを読み込み、表示用にローカル変数にセットする。
		 */
		$this->_load_main_table($reserve_id);

        // 複製ステータスかつスタッフ未設定レコードだった場合はステータスを予約に変更
        if( $this->data["staff_id"] == 0 && $this->data["reserve_status"] == Reserve_status::COPY ){
            $this->data["reserve_status"] = Reserve_status::SCHEDULE;
        }

        $this->data["staff_id"]           = $staff_id;
        $this->data["reserve_time_start"] = $this->_getTimeByHaishaTime($start_time);
        $this->data["reserve_time_end"]   = $this->_getTimeByHaishaTime($end_time);


		$this->db->trans_start();
		$this->_update_table($this->data, $reserve_id);
		$this->db->trans_complete();

        //echo "更新しました";
        exit;
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
		$this->form_validation->set_rules(self::F_STAFF_ID           , '担当'             , 'trim|integer');
		$this->form_validation->set_rules(self::F_RESERVE_STATUS     , 'ステータス'       , 'trim|required|integer');
		$this->form_validation->set_rules(self::F_COLOR              , '表示カラー'       , 'trim|max_length[7]');
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

        $staff_id       = $this->data[ self::F_STAFF_ID ];
        $color          = $this->data[ self::F_COLOR ];
        $time_start     = $this->data[ self::F_TIME_START ];
        $time_end       = $this->data[ self::F_TIME_END ];

        // 管理者で複製レコードを編集するとき「以外」はチェックする
        if( $this->db_reserve_status != Reserve_status::COPY || $this->login_user->account_type != User_const::ACCOUNT_TYPE_ADMIN ){

            // 必須チェック
            if( $staff_id == "" ){
                $ret = FALSE;
                $this->error_list['staff_id'] = '担当 欄は必須です。';
            }
            if( $color == "" ){
                $ret = FALSE;
                $this->error_list['color'] = '表示カラー 欄は必須です。';
            }

            // 条件付き必須チェック：終了ステータスにするとき（なっているとき）
            if( $this->data[ self::F_RESERVE_STATUS ] == Reserve_status::CLOSE ){
                if( $time_start == ""){
                    $ret = FALSE;
                    $this->error_list['time_start'] = '開始時刻 欄は必須です。';
                }
                if( $time_end == ""){
                    $ret = FALSE;
                    $this->error_list['time_end'] = '終了時刻 欄は必須です。';
                }
            }

            // 時刻整合性チェック
            $reserve_time_start = $this->data[self::F_RESERVE_TIME_START];
            $reserve_time_end = $this->data[self::F_RESERVE_TIME_END];
            if( $reserve_time_start >= $reserve_time_end ){
                $ret = FALSE;
		    	$this->error_list['reserve_time_end'] = '予約終了時刻は予約開始時刻よりあとの時刻を指定して下さい';
            }
            $time_start = $this->data[self::F_TIME_START];
            $time_end = $this->data[self::F_TIME_END];
            if ($time_start && $time_end)
            {
                if( $time_start >= $time_end ){
                    $ret = FALSE;
		        	$this->error_list['time_end'] = '実施終了時刻は実施開始時刻よりあとの時刻を指定して下さい';
                }
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
		//セッションから情報を取得
		$id = $this->_get_page_session(self::RESERVE_ID);
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
		$entity = $this->T_reserve->find($id);

		if ( ! $entity) 
		{
			show_error("データが存在しません");
			exit;
		}

        $entity->reserve_time_start = substr($entity->reserve_time_start, 0, 5);
        $entity->reserve_time_end   = substr($entity->reserve_time_end, 0, 5);
        $entity->time_start         = substr($entity->time_start, 0, 5);
        $entity->time_end           = substr($entity->time_end, 0, 5);

		$this->data = array_merge($this->data, (array)$entity);

		return $entity;
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

	/**
	 * この画面で扱うメインテーブルの更新処理
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $reserve_id
	 */
	private function _update_table($session_var, $reserve_id)
	{
		//最新状態のデータを取得
		$entity = $this->T_reserve->find($reserve_id);

		if ( ! $entity)
		{
			show_error('データが存在しないため、更新処理を中止しました。');
			return;	//実際にはこのRETURNには到達しない 
		}

		//ユーザ入力値をセットしてUPDATE
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

		$this->_update_main_table($entity, $session_var);
	}

	/**
	 * この画面で更新する作業テーブルをINSERTする
	 * 
	 * @param unknown_type $session_var
	 */
	private function _insert_reserve_detail_table($session_var)
	{
		$entity                         = new T_reserve_detail();
		$entity->reserve_id             = $session_var["reserve_id"];
		$entity->detail_number          = $session_var["detail_number"];
		$entity->construction_type_id   = $session_var["construction_type_id"];
		$entity->construction_detail_id = $session_var["construction_detail_id"];
		$entity->disposal_id            = $session_var["disposal_id"];
		$entity->unit_price_id          = $session_var["unit_price_id"];
		$entity->car_class_id           = $session_var["car_class_id"];
		$entity->count_estimate         = $session_var["count_estimate"];
		$entity->count_actual           = $session_var["count_actual"];

		return parent::_insert_main_table($entity, $session_var);
	}

    /**
     * 予約情報取得
     *
     * 作業の親となる予約情報と関連する情報を取得する
     */
    private function _getReserveDetailEntities($reserve_id)
    {
        if( is_blank( $reserve_id ) ){
			show_error("予約情報が指定されていません。");
        }

        return $this->T_reserve_detail->find_by_reserve_id($reserve_id);
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

        // 作業情報プルダウン用
        $this->construction_type_id_list = $this->_getConstructionTypeIdList();
        $this->unit_price_id_list        = $this->_getUnitPriceIdList();
        $this->car_class_id_list         = $this->_getCarClassIdList();
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
    private function _getCarClassIdList()
    {
        return $this->M_car_class->getCarClassIdList(true);
    }
    private function _getTimeByHaishaTime($time)
    {
        if( $time && preg_match("/^\d+$/", $time) ){
            $h     = $time / 10;
            $m     = ($time % 10 == 5) ? 30 : 0;
            return sprintf("%02d:%02d", $h, $m);
        } else {
            return false;
        }
    }
}
