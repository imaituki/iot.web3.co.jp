<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 配車のカレンダー表示を行うクラス
 * * @author ta-ando
 *
 */
class Top extends Search_Controller 
{
	/** フォームで使用するパラメータ名 */
	const F_COND_RESERVE_CODE = 'cond_reserve_code';
	const F_COND_RESERVE_NAME = 'cond_reserve_name';

    const COOKIE_VIEW_CALENDAR  = 'cookie_view_calendar';
    const COOKIE_VIEW_STAFF_ALL = 'cookie_view_staff_all';
    const COOKIE_STICKY_FLAG    = 'cookie_sticky_flag';

    /** スタッフ未設定のレコードの仮想スタッフID ベース値 */
    const NON_ASSIGNED_STAFF_ID_BASE = 99999999;
    const NON_ASSIGNED_STAFF_ID_HEAD = 90000000;

    /** 顧客ID */
    var $customer_id_list;

    var $given_date;

	/*
	 * コンストラクタ
	 */
	public function __construct()
	{
		parent::__construct();

        $this->load->helper('cookie');

		/*
		 * 画面に固有の情報をセット
		 */

		$this->package_name      = 'top';
//		$this->package_label     = config_item("{$this->package_name}_package_name_label");
//		$this->common_h3_tag     = "{$this->package_label}カレンダー";
		$this->page_type         = Page_type::SEARCH;
//		$this->current_main_menu = $this->package_name;
		$this->main_model        = $this->T_reserve;
		$this->sub_model         = FALSE;
		$this->delete_model      = $this->T_reserve;
		$this->customer_model    = $this->M_customer;
        $this->attendance_model  = $this->T_attendance;

		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//ソート可能なカラム
		$this->valid_sort_key = array(
			'reserve_code',
		);

		//独自のソート順
		$this->first_sort_key = 'id';
		$this->first_sort_order = 'ASC';

		/*
		 * この機能に必要な情報がセッションに保持されているか確認する
		 */

		if ( ! $this->application_session_data->can_access_package($this->package_name))
		{
			show_error('不正な画面遷移が行われています。再度メニューから操作を行ってください。');
		}

		//HTTPのGET,POST情報を$this->dataに移送
		$this->_httpinput_to_data();

        $this->_initListArray();

	}

	/**
	 * 初期表示を行う。
	 */
	public function index()
	{
        $this->_set_checkbox_cookie();
        $this->_check_attendance();
        $given_date = $this->_getGivenDate();
        $this->date = date("Ymd", $given_date);
        $this->cal_data  = $this->getCalData( $given_date );
		$this->_unset_page_session();
        $this->platform = $this->get_platform();
		return $this->search();
	}

	/**
	 * ページングを行う
	 * 
	 * @param unknown_type $page
	 */
	public function page($page = 1)
	{
		$this->search($page);
	}

	/**
	 * セッションに保持している検索条件、ページ情報を使用して検索を行う。
	 * 主に「戻る」ボタンでの使用を想定。
	 */
	public function search_again()
	{
		$page = $this->_set_search_again_condition();

		$this->search($page);
	}

	/**
	 * ソートを行う。
	 * ・1ページ目に戻す。
	 * ・GETでもcond_sort_key, cond_sort_orderが渡されて$this->dataにセットされているので、上書きする。 
	 * 
	 * @param unknown_type $sort_key
	 * @param unknown_type $sort_order
	 */
	public function sort($sort_key, $sort_order)
	{
		$this->data[self::F_COND_SORT_KEY] = $sort_key;
		$this->data[self::F_COND_SORT_ORDER] = $sort_order;
		$this->search(1);
	}

	/**
	 * 検索を行う
	 * 
	 * @param unknown_type $page
	 */
	public function search($page = 1)
	{
		if ( ! is_num($page))
		{
			show_404();
		}

		$ret = $this->_do_search($page, $this->max_list);
		$this->list = $this->_convert_list($ret);

		$this->_load_tpl($this->_get_view_name('calendar'), $this->data);
	}

	/**
	 * 削除ボタン押下時の処理を行う。
	 * データの物理削除を行う。
	 * ※DB更新を行うため、完了画面へリダイレクトする。
	 */
	function delete($id = '')
	{
		//必須情報が不足している場合は完了画面Viewにエラーを表示
		if (is_blank($id))
		{
			$this->error_list['delete'] = 'IDを指定してください';
			$this->_load_tpl($this->_get_view_name(View_type::COMPLETE), $this->data);
			return;
		}

		/*
		 * 削除処理
		 */

		$this->db->trans_start();
		$this->T_reserve->delete($id);

		$this->db->trans_complete();

		//完了画面表示用メソッドへリダイレクト
		redirect($this->_get_redirect_url_complete(), 'location', 301);
	}

	/**
	 * 完了画面を表示する
	 */
	function complete()
	{
		$this->_unset_page_session();
		$this->_load_tpl($this->_get_view_name(View_type::COMPLETE), $this->data);
	}

	/**
	 * 検索のロジック
	 * 
	 * @param unknown_type $page
	 * @param unknown_type $max
	 */
	private function _do_search($page, $max = FALSE)
	{
		$this->_create_and_save_condition($page);

		//検索に必要な情報を作成
		$params = $this->_get_reserve_condition_params();
		$nds_pagination = $this->_create_pagination($max, $page);

		return $this->_do_search_for_manage($this->main_model, $nds_pagination, $params);
	}

	/**
	 * SQLで使用する検索条件を作成して取得する。
	 * 他の機能との互換性がないので親クラスの_get_condition_params()は使用しない
	 */
	private function _get_reserve_condition_params()
	{
		$params = array();
		$params['reserve_code'] =  $this->data[self::F_COND_RESERVE_CODE];
		$params['reserve_name'] =  $this->data[self::F_COND_RESERVE_NAME];

		return $params;
	}

	/**
	 * SELECT結果を表示用に整形する
	 * 
	 * @param unknown_type $list
	 */
	private function _convert_list($list)
	{
		$ret = array();

		//オブジェクトのリストを配列のリストに変換
		$arraylist = convert_objlist_to_arraylist($list);

		foreach ($arraylist as $tmp)
		{
			$ret[] = $tmp;
		}

		return $ret;
	}

    private function _initListArray()
    {
        $this->initDate();

        // プルダウン用
        $this->staff_id_list        = $this->_getStaffIdList();
        $this->construction_id_list = $this->M_construction->getConstructionCategoryIdList();
        $this->car_profile_id_list  = $this->M_car_profile->getCarProfileIdList();
        $this->reserve_time_list    = $this->_getTimeList();
        $this->reserve_status_list  = $this->_getStatusIdList();

        // 工事ID 設定時の担当・現場情報を埋める JavaScript 用
        $this->construction_array   = $this->M_construction->select_all();
    }

    private function initDate()
    {
        $this->data["reserve_date"] = (!isset($this->data["reserve_date"]) || $this->data["reserve_date"] == "") ? date("Y-m-d") : $this->data["reserve_date"];
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

    /**
     * スマートフォン用配車一覧表示
     *
     */
    public function haisha_list(){
    	
    	$start_show_time = Reserve_const::CALENDAR_START_TIME;
    	$end_show_time = Reserve_const::CALENDAR_END_TIME;
    	
    	$context = array();
    	
    	//if(!empty($_GET["staff_id"])){
    	//	$staff_id = $_GET["staff_id"];
    	//}else{
    	//	$staff_id =$_SESSION['staff_id'];
    	//}
    	
        if( $this->login_user->account_type == User_const::ACCOUNT_TYPE_ADMIN ){
            $staff_array = $this->M_user->getStaffByUserCode(null, null);
        } else {
            $staff_array = $this->M_user->getStaffByUserCode($this->login_user->user_code, User_const::ACCOUNT_TYPE_COMMON);
        }
        $this->staff_array = $staff_array;
        $this->selected_staff_id = $this->_selectedStaff();
    	
        $given_date = $this->_getGivenDate();
        $this->next_day = date("Ymd", strtotime("+1 day",$given_date));
        $this->prev_day = date("Ymd", strtotime("-1 day",$given_date));
        $this->given_date_ymd = date("Ymd", $given_date);
        $this->given_date_ja = date("Y年m月d日", $given_date);

        $schedules[ $this->selected_staff_id ]["schedule"] = $this->T_reserve->getStaffSchedule($this->selected_staff_id, date("Y-m-d",$given_date));
        $this->schedules = $this->convScheduleForSmartphoneView( $schedules, $given_date );
    	
        $tpl = "top/top_index_smp.php";
        echo $this->load->view($tpl, $this->data, true);
        exit;
    }
    /**
     * PC用スケジュールデータ取得 & 加工
     */
    public function haisha_table()
    {
        $this->_set_checkbox_cookie();
    	$start_show_time = Reserve_const::CALENDAR_START_TIME;
    	$end_show_time   = Reserve_const::CALENDAR_END_TIME;
    	$week_ja         = array("日","月","火","水","木","金","土");

        // 表示日の UNIX_TIMESTAMP を取得
        $given_date = $this->_getGivenDate();

        // 表示スタッフの配列を取得
        if( $this->login_user->account_type == User_const::ACCOUNT_TYPE_ADMIN ){
            $staff_array = $this->M_user->getStaffByUserCode(null, null);
        } else {
            $staff_array = $this->M_user->getStaffByUserCode($this->login_user->user_code, User_const::ACCOUNT_TYPE_COMMON);
        }

        // 当日スケジュールの時間軸
        $_result_line[] = date("m/d", $given_date) . '(' . $week_ja[date("w",$given_date)] . ')';
    	for( $k = $start_show_time; $k < $end_show_time; $k = $k + 10 ){ //時間のループ
            $_result_line[] = ($k / 10);
        }
        $this->cal_header = $_result_line;

        // スタッフ毎にスケジュール情報を取得
        $schedules = null;
        $target_date = date("Y-m-d", $given_date);
        foreach( $staff_array as $staff_id => $staff_name){
            $schedules[ $staff_id ]["staff_name"] = $staff_name;
            $schedules[ $staff_id ]["schedule"] = $this->T_reserve->getStaffSchedule($staff_id, date("Y-m-d",$given_date));
        }
        // スタッフ未割り当てのスケジュールを一つずつ追加
        $non_assigned_schedules = $this->T_reserve->getNonAssignedSchedule(date("Y-m-d",$given_date));
        foreach($non_assigned_schedules as $i => $schedule ){
            $schedules[ self::NON_ASSIGNED_STAFF_ID_BASE - $i ]["staff_name"] = "未設定";
            $schedules[ self::NON_ASSIGNED_STAFF_ID_BASE - $i ]["schedule"]   = array($schedule);
        }
        // スケジュールを表示用配列にコンバート
        $this->schedules = $this->convScheduleForView( $schedules, $given_date );
        
        $tpl = "top/top_index.php";
        echo $this->load->view($tpl, $this->data, true);
        exit;
	

    }
    /**
     * スケジュールデータをテーブル表示用に変換
     */
    private function convScheduleForView($schedules, $given_date) // {{{
    {
		$start_show_time     = Reserve_const::CALENDAR_START_TIME;
		$end_show_time       = Reserve_const::CALENDAR_END_TIME;
		$week_ja             = array("日","月","火","水","木","金","土");
        $j                   = 0;

        $given_timestamp     = $this->_getTimestampByGivendate( $given_date );

        foreach( $schedules as $staff_id => $data ){

            $result          = null;
            $cell_data       = array();// ユーザ毎の一日の情報
    		$l               = 0;      // 当日何個目の予約か
            $attendance_flag = $this->T_attendance->is_attendance_exists( $staff_id, $given_timestamp );

    		for( $k = $start_show_time; $k < $end_show_time; $k = $k + 5 ){
    		
                $_cell_data   = null; // 表示セル情報
                $css_bg_color = "#fff"; // 当該セルの背景色

                $exist_schedule    = count($data[ "schedule" ]) && array_key_exists($l, $data[ "schedule" ]);
                if( $exist_schedule ){
                    $target_reserve_id           = $data[ "schedule" ][ $l ]->id;
                    $target_start_time           = $data[ "schedule" ][ $l ]->reserve_time_start;
                    $target_end_time             = $data[ "schedule" ][ $l ]->reserve_time_end;
                    $target_status               = $data[ "schedule" ][ $l ]->reserve_status;
                    $target_construction_code    = $data[ "schedule" ][ $l ]->construction_code;
                    $target_construction_name    = $data[ "schedule" ][ $l ]->construction_name;
                    $target_construction_address = $data[ "schedule" ][ $l ]->construction_address;
                    $lat                         = $data[ "schedule" ][ $l ]->latitude;
                    $lng                         = $data[ "schedule" ][ $l ]->longitude;
                    $memo                        = $data[ "schedule" ][ $l ]->memo;
                }

    			if( $exist_schedule //対象の日に予約がある
    				&& $target_start_time <= sprintf("%02d:%02d:00", floor($k / 10), $k % 10 * 6)
    				&& $target_end_time    > sprintf("%02d:%02d:00", floor($k / 10), $k % 10 * 6)
                ){

                    $css_bg_color = Reserve_color::$COLOR_CODE_ARRAY[$data[ "schedule" ][ $l ]->color];

    				$time_array = explode(":", $target_start_time);
    				$start_time = intval($time_array[0]) * 10 + intval($time_array[1]) / 6;
    				
    				$time_array = explode(":", $target_end_time);
    				$end_time = intval($time_array[0]) * 10 + intval($time_array[1]) / 6;
    				
    				$sub = ($end_time - $k) / 5;

                    // 新しい書式
                    $const_code = htmlspecialchars(stripslashes($target_construction_code)) . "（" . $this->reserve_status_list[$target_status] . "）";
                    //$const_code = htmlspecialchars(stripslashes($target_construction_code));// . "（" . $this->reserve_status_list[$target_status] . "）";
                    $const_name = htmlspecialchars(stripslashes($target_construction_name));
                    $const_addr = htmlspecialchars(stripslashes($target_construction_address));
                    //$status_label = $this->reserve_status_list[ $target_status ];
                    $link_text  = $const_code. " / " . $this->my_substr($const_name). " / " . $const_addr;
                    //$link_text  = $const_code. " / " . $status_label . " / " . $this->my_substr($const_name). " / " . $const_addr;
                    //$map_text   = $this->my_substr($const_addr);
                    //$link_text  = $const_code. "<br>" . $status_label . "<br>" . $this->my_substr($const_name, ($sub * 4 - 1)). "<br>";
                    //$map_text   = $this->my_substr($const_addr, ($sub * 4 - 1));
                    $title_text = $const_code. " / " . $const_name. " / " . $const_addr;

                    // ツールチップ情報
                    $tooltip    = array();
                    $tooltip[]  = $const_code;
                    //$tooltip[]  = $status_label;
                    $tooltip[]  = $const_name;
                    $tooltip[]  = $const_addr;
                    if( $memo ) {
                        $tooltip[]  = "----<br>".nl2br($memo);
                    }

                    // セル情報
                    $_cell_data = array(
                        "title"      => $title_text,
                        "memo"       => $this->my_substr($memo),
                        "tooltip"    => implode("<br>", $tooltip),
                        "class"      => "timetable_filled bgc",
                        "colspan"    => $sub,
                        "inner_html" => $link_text,
                        "link_url"   => site_url("/reserve/reserve_detail/index/".$target_reserve_id),
                        //"map_label"  => $map_text,
                        "mouse_event" => array(
                            //"onclick"     => "mouseClickTimetable_filled(event,$target_reserve_id)",
                            "onmousedown" => "mouseDownTimetable_filled($target_reserve_id, $start_time, $end_time)",
                        ),
                    );

                    // CSS 計算用に現在の k を保存
    				$this_k = $k;
                    // 結合した分だけ k を進める
    				$k      = $k + ($sub - 1) * 5;
                    // 次の予定へポインタを移動
    				$l++;
    				
    			} else {//対象に予約はない
    			
                    // 新しい書式
                    $_cell_data = array(
    				    "title"      => sprintf("%02d:%02d", floor($k / 10), $k % 10 * 6) . '～" ',
                        "class"      => "timetable",
                        "colspan"    => 1,
                        "inner_html" => '',
                        "link_url"   => '',
                        "map_label"  => '',
                        "mouse_event" => array(
                            "onclick"     => "mouseClickTimetable(".date("Ymd", $given_date).", ".$staff_id.", ". $k .")",
                            //"onmousedown" => "mouseDownTimetable(".date("Ymd", $given_date).", ".$staff_id.", ".$k.")",
                            "onmousemove" => "mouseMoveTimetable(".$staff_id.", ".$k.")",
                            "onmouseup"   => "mouseUpTimetable(event, ".date("Ymd", $given_date).", ".$staff_id.", ".$k.")",
                        ),
                    );

                    // CSS 計算用に現在の k を保存
    				$this_k = $k;
    			}

                // データ有り無しに関係ない共通項目
                $_cell_data["id"] = 'timetable' . date("Ymd", $given_date) . '_' . $staff_id . '_' . $k . '" ';
                $_cell_data["date_ymd"] = date("Ymd", $given_date);
                $_cell_data["staff_id"] = $staff_id;
                $_cell_data["hour_key"] = $k;
    			if($j==0){
                    $_cell_data["style"]["border-top"] = "double 3px #f2a7b8";
                }
    			if( $this_k==90 || $this_k==120 || $this_k==150 || $this_k==180 ) {
    				$_cell_data["style"]["border-left"] = 'double 3px #f2a7b8';
    			} elseif( $this_k % 2 == 0 ) {
    				$_cell_data["style"]["border-left"] = 'solid 1px #ccc';
    			} else {
                    $_cell_data["style"]["border-left"] = 'dashed 1px #ccc /* '.$k.' */';
    			}
                $_cell_data["style"]["background-color"] =  $css_bg_color;



                $cell_data[] = $_cell_data;
    		}
            $schedules[ $staff_id ][ "cell_data" ]  = $cell_data;
            $schedules[ $staff_id ][ "attend" ]     = $attendance_flag;
            $j++;
        }
        return $schedules;
	} // }}}
    /**
     * スケジュールデータを表示用に変換
     */
    private function convScheduleForSmartphoneView($schedules, $given_date) // {{{
    {
		$start_show_time     = Reserve_const::CALENDAR_START_TIME;
		$end_show_time       = Reserve_const::CALENDAR_END_TIME;
        $given_timestamp     = $this->_getTimestampByGivendate( $given_date );
        $j                   = 0;
	
        foreach( $schedules as $staff_id => $data ){
            $result          = null;
            $cell_data       = array();// ユーザ毎の一日の情報
    		$l               = 0;      // 当日何個目の予約か
            $attendance_flag = $this->T_attendance->is_attendance_exists( $staff_id, $given_timestamp );
            $sub             = 1;

    		for( $k = $start_show_time; $k < $end_show_time; $k = $k + 5 ){
                $_cell_data   = null; // 表示セル情報
                $css_bg_color = null; // 当該セルの背景色

                $exist_schedule    = count($data[ "schedule" ]) && array_key_exists($l, $data[ "schedule" ]);
                if( $exist_schedule ){
                    $target_reserve_id           = $data[ "schedule" ][ $l ]->id;
                    $target_start_time           = $data[ "schedule" ][ $l ]->reserve_time_start;
                    $target_end_time             = $data[ "schedule" ][ $l ]->reserve_time_end;
                    $target_status               = $data[ "schedule" ][ $l ]->reserve_status;
                    $target_construction_code    = $data[ "schedule" ][ $l ]->construction_code;
                    $target_construction_name    = $data[ "schedule" ][ $l ]->construction_name;
                    $target_construction_address = $data[ "schedule" ][ $l ]->construction_address;
                    $lat                         = $data[ "schedule" ][ $l ]->latitude;
                    $lng                         = $data[ "schedule" ][ $l ]->longitude;
                    $memo                        = $data[ "schedule" ][ $l ]->memo;
                }


                // デフォルトの属性値等
                $_cell_data["in_rowspan"]     = false; // データ表示セルのときはセル表示をスキップさせるフラグ(<td> を表示しない)
                $_cell_data["is_time_header"] = false; // 時刻表示セル(<th>)かどうかを判断するフラグ
                $_cell_data["time_string"]    = null;  // 時刻文字列 (例, 10:30)
                $_cell_data["link_url"]       = null;
                $_cell_data["memo"]           = null;
                $_cell_data["title"]          = null;
                $_cell_data["rowspan"]        = null;
                $_cell_data["class"]          = null;
                $_cell_data["id"]             = null;
                $_cell_data["mouse_event"] = array(
                    "onclick"     => "mouseClickTimetable(".date("Ymd", $given_date).", ".$staff_id.", ". $k .")",
                    "onmousemove" => "mouseMoveTimetable(".$staff_id.", ".$k.")",
                    "onmouseup"   => "mouseUpTimetable(event, ".date("Ymd", $given_date).", ".$staff_id.", ".$k.")",
                );

                if( $k % 10 == 0 ){
                    $_cell_data["is_time_header"] = true;
                    $_cell_data["time_string"]    = sprintf("%02d:%02d", floor($k / 10), $k % 10 * 6);
                }

    			if( $exist_schedule //対象の日に予約がある
    				&& $target_start_time <= sprintf("%02d:%02d:00", floor($k / 10), $k % 10 * 6)
    				&& $target_end_time    > sprintf("%02d:%02d:00", floor($k / 10), $k % 10 * 6)
                ){

                    //$css_bg_color = $data[ "schedule" ][ $l ]->color;
                    $css_bg_color = Reserve_color::$COLOR_CODE_ARRAY[$data[ "schedule" ][ $l ]->color];

					$time_array = explode(":", $target_start_time);
					$start_time = intval($time_array[0]) * 10 + intval($time_array[1]) / 6;
					$time_array = explode(":", $target_end_time);
					$end_time   = intval($time_array[0]) * 10 + intval($time_array[1]) / 6;
					$sub        = ($end_time - $k) / 5;

                    $const_code = htmlspecialchars(stripslashes($target_construction_code)) . "（" . $this->reserve_status_list[$target_status] . "）";
                    $const_name = htmlspecialchars(stripslashes($target_construction_name));
                    $const_addr = htmlspecialchars(stripslashes($target_construction_address));
                    $link_text  = $const_code. " / " . $this->my_substr($const_name). " / " . $const_addr;
//                    $map_text   = $this->my_substr($const_addr);
//                    $link_text  = $const_code. "<br>" . $this->my_substr($const_name, ($sub * 4 - 1)). "<br>";
//                    $map_text   = $this->my_substr($const_addr, ($sub * 4 - 1));
                    $title_text = $const_code. " / " . $const_name. " / " . $const_addr;

                    $_cell_data["in_rowspan"]  = false;
                    $_cell_data["link_url"]    = site_url("/reserve/reserve_detail/index/".$target_reserve_id);
                    $_cell_data["memo"]        = htmlspecialchars($memo);
                    $_cell_data["title"]       = $link_text;
                    $_cell_data["id"]          = "timetable".date("Ymd", $given_date) . '_' . $staff_id. '_' . $k;
                    $_cell_data["class"]       = "timetable_filled";
                    $_cell_data["rowspan"]     = $sub;
                    $_cell_data["mouse_event"] = array(
                        //"onclick"     => "mouseClickTimetable_filled(event,$target_reserve_id)",
                        //"onmousedown" => "mouseDownTimetable_filled($target_reserve_id, $start_time, $end_time)",
                    );


			        $l++;
                } elseif ( $sub == 1 ){
                    $_cell_data["in_rowspan"] = false;
                    $_cell_data["id"]         = "timetable".date("Ymd", $given_date) . '_' . $staff_id. '_' . $k;
                    $_cell_data["class"]      = "timetable";
                    $_cell_data["rowspan"]    = 1;
                } else {
                    $_cell_data["in_rowspan"] = true; // rowspan で結合している区間は <td> 出力をスキップ
                    $sub--;
                }

                // 最終的な色設定
                $_cell_data["style"]["background-color"] =  $css_bg_color;

                $cell_data[] = $_cell_data;
            }
            $schedules[ $staff_id ][ "cell_data" ] = $cell_data;
            $j++;
	    }
        return $schedules;
	} // }}}

    /**
     * 表示するカレンダーデータ
     */
    public function getCalData($given_date)
    {
		$context["next_month"]     = date("Ymd", strtotime("+1 month",$given_date));
		$context["given_month_ja"] = date("Y年m月", $given_date);
		$context["given_date_ja"]  = date("Y年m月d日", $given_date);
		$context["prev_month"]     = date("Ymd", strtotime("-1 month",$given_date));
		$context["next_day"]       = date("Ymd", strtotime("+1 day",$given_date));
		$context["prev_day"]       = date("Ymd", strtotime("-1 day",$given_date));
	    
	    
	    for( $i = 0; $i < 6; $i++ ){//１ヶ月の最大週の数６回ループする
	    	
	    	for( $j = 0; $j < 7; $j++ ){//一週間を回すループ
	    		
	    		//１日の曜日を取得
	    		$first_day = mktime(0, 0, 0, date('m', $given_date), 1, date('Y', $given_date));
	    		$date      = $i * 7 + $j - date("w", $first_day) + 1;
	    	
	    		
	    		if($date > 0 and $date <= date('t', $first_day)){
	    			
	    			$context["calender"][$i][$j] = '<a href="#" onClick="submit_contact(' . date("Ymd", $first_day + ($date * 86164)) . ');return false;">' . $date . '</a>';//$i * 7 + $j;
	    			
	    		}else{
	    			
	    			$context["calender"][$i][$j] = "&nbsp;";
	    		}
	    		
	    	}
	    	
	    }
        return $context;
    }

    /**
     * 表示する日付を取得する
     */
    private function _getGivenDate()
    {
    	if(array_key_exists("date", $_GET) && is_numeric($_GET["date"])){
    		$given_date = mktime(0,0,0, substr($_GET["date"],4,2), substr($_GET["date"],6,2), substr($_GET["date"],0,4));
    	}else{
    		$given_date = mktime(0,0,0);
    	}
        return $given_date;
    }
    /**
     * 与えられた日付を unix timestamp に変換
     */
    private function _getTimestampByGivendate($given_date)
    {
        $t = $given_date;
        if( preg_match("/^\d{8}$/", $given_date ) ){
            $y = (int)substr($given_date, 0, 4);
            $m = (int)substr($given_date, 4, 2);
            $d = (int)substr($given_date, 6, 2);

            $t = mktime(0, 0, 0, $m, $d, $y);
        }
        return $t;

    }
    /**
     * 文字列をまるめる
     */
    private function my_substr($text)
    {
        return mb_strimwidth($text, 0, 36, "...");
    }
/*
    private function my_substr($text, $len)
    {
        if ( strlen($text) > $len ){
            return mb_strimwidth($text, 0, $len - 3)." ...";
        }
        else {
            return $text;
        }
    }
*/

    /**
     *
     */
    public function get_platform(){
    
    	//携帯UA取得
    	$agent = $_SERVER["HTTP_USER_AGENT"];
    	
    	if(preg_match("/^DoCoMo\/[12]\.0.*?c([0-9]+)/i", $agent, $match)){
    		
    		if($match[1]<500){
    		
    			return "K-imode1";// i-mode1.0
    		
    		}else{
    		
    			return "K-imode2";// i-mode2.0
    		
    		}
    		
    	}elseif(preg_match("/^(J\-PHONE|Vodafone|MOT\-[CV]980|SoftBank)\//i", $agent)){
    	
        	return "K-softbank";// softbank
    		
    	}elseif(preg_match("/^KDDI\-/i", $agent) || preg_match("/UP\.Browser/i", $agent)){
    	
    		return "K-ezweb";// ezweb
    		
    	}elseif(preg_match("/iPhone|iPad|iPod/i", $agent)){
    	
        	return "S-iphone";// iPhone
    			
    	}elseif(preg_match("/Android/i", $agent)){
    	
        	return "S-android";// Android
    			
    	}elseif(preg_match("/Windows Phone/i", $agent)){
    	
        	return "S-windowsphone";// Windows Phone
    			
    	}elseif(preg_match("/BlackBerry/i", $agent)){
    	
        	return "S-blackberry";// BlackBerry
    		
    	}elseif(preg_match("/^PDXGW/i", $agent) || preg_match("/(DDIPOCKET|WILLCOM);/i", $agent)){
    	
        	return "S-willcom";// willcom
    		
    	}else{
    	
    		return "P";// PC
    		
    	}
    }

    private function _selectedStaff()
    {
        $staff_id = null;
        // 一般ユーザの時は自身のもののみを対象とする
        if( $this->login_user->account_type == User_const::ACCOUNT_TYPE_COMMON ){
            $staff_entity = $this->M_user->getStaffByUserCode($this->login_user->user_code);
            list($staff_id, $staff_name) = each($staff_entity);
        }
        // 管理者の時は POST されたり GET だったりする
        else if( $this->input->post('staff_id') ){
            $staff_id = $this->input->post('staff_id');
        }
        else if( $this->input->get('staff_id') ){
            $staff_id = $this->input->get('staff_id');
        }
        else if( $this->staff_array && is_array($this->staff_array) ){
            foreach($this->staff_array as $id => $name){
                $staff_id = $id;
                break;
            }
        }
        return $staff_id;
    }

    /**
     * カレンダー表示レイアウトのチェックボックス管理用セッション
     */
    private function _set_checkbox_cookie()
    {
		$this->cookie_view_calendar  = array_key_exists(self::COOKIE_VIEW_CALENDAR,  $_COOKIE) ? (int)$this->input->cookie( self::COOKIE_VIEW_CALENDAR )  : 0;
		$this->cookie_view_staff_all = array_key_exists(self::COOKIE_VIEW_STAFF_ALL, $_COOKIE) ? (int)$this->input->cookie( self::COOKIE_VIEW_STAFF_ALL ) : 1;
		$this->cookie_sticky_flag    = array_key_exists(self::COOKIE_STICKY_FLAG,    $_COOKIE) ? (int)$this->input->cookie( self::COOKIE_STICKY_FLAG )    : 0;
//var_dump($this->cookie_view_calendar);
//var_dump($this->cookie_view_staff_all);
//var_dump($this->cookie_sticky_flag);
    }
}
