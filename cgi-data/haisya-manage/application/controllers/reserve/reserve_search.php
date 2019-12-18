<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 配車の検索を行うクラス
 * * @author ta-ando
 *
 */
class Reserve_search extends Search_Controller 
{
	/** フォームで使用するパラメータ名 */
	const F_COND_CONSTRUCTION_CODE  = 'cond_construction_code';
	const F_COND_STAFF_ID           = 'cond_staff_id';
	const F_COND_RESERVE_DATE_START = 'cond_reserve_date_start';
	const F_COND_RESERVE_DATE_END   = 'cond_reserve_date_end';
	const F_COND_RESERVE_DATE       = 'cond_reserve_date';
	const F_COND_RESERVE_STATUS     = 'cond_reserve_status';
	const F_COND_CUSTOMER_ID        = 'cond_customer_id';

    /** 顧客ID */
    var $customer_id_list;

	/*
	 * コンストラクタ
	 */
	public function __construct()
	{
		parent::__construct();

		/*
		 * 画面に固有の情報をセット
		 */

		//$this->target_data_type = Relation_data_type::INFO;
		//$this->target_post_type = Post_type::INFO;
		$this->package_name = 'reserve';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}検索";
		$this->page_type = Page_type::SEARCH;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->T_reserve;
		$this->sub_model = FALSE;
		$this->delete_model = $this->T_reserve;
		$this->customer_model     = $this->M_customer;

		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//ソート可能なカラム
		$this->valid_sort_key = array(
			'reserve_date',
		);

		//独自のソート順
		$this->first_sort_key = 'reserve_date';
		$this->first_sort_order = 'DESC';
		$this->second_sort_key = 'staff_id';
		$this->second_sort_order = 'ASC';
		$this->third_sort_key = 'reserve_time_start';
		$this->third_sort_order = 'ASC';

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
		$this->_unset_page_session();
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

        list($this->list, $this->total) = $this->_do_search($page, $this->max_list);
		$this->_load_tpl($this->_get_view_name(View_type::SEARCH), $this->data);
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

        $reserve_detail_entities = $this->_getReserveDetails( $id );

		/*
		 * 削除処理
		 */

		$this->db->trans_start();

        // 作業が登録されていたら作業を全て論理削除
        if( $reserve_detail_entities ){
            foreach($reserve_detail_entities as $reserve_detail_entity){
                $this->T_reserve_detail->logical_delete( $reserve_detail_entity->id );
            }
        }

        // 予約情報を論理削除
		$this->T_reserve->logical_delete($id);

		$this->db->trans_complete();

        $this->search_again();
		//完了画面表示用メソッドへリダイレクト
		//redirect($this->_get_redirect_url_complete(), 'location', 301);
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

        // $max=FALSE にしてページャの影響を受けないようにする（必ず、$max=n より先）
        // ポイント計と請求金額計を取得
        if ($this->_is_params_val_exists($params))
        {
            $nds_pagination = $this->_create_pagination(FALSE, $page);
            $total = $this->_do_search_for_manage($this->main_model, $nds_pagination, $params);
            $total = $this->_setPointTotalAndPriceTotal($this->_convert_list($total));
        } else {
            $total = array('point' => 0,
                           'price' => 0);
        }

        // 検索結果を取得
		$nds_pagination = $this->_create_pagination($max, $page);
        $list = $this->_do_search_for_manage($this->main_model, $nds_pagination, $params);
        $list = $this->_setPointAndPrice($this->_convert_list($list));
        $list = $this->_setUnitPriceIdCheck($list);

        return array($list, $total);

	}

    private function _is_params_val_exists($params)
    {
        $exists = FALSE;
        foreach($params as $val)
        {
            if (!empty($val))
            {
                $exists = TRUE;
                break;
            }
        }
        return $exists;
    }

	/**
	 * SQLで使用する検索条件を作成して取得する。
	 * 他の機能との互換性がないので親クラスの_get_condition_params()は使用しない
	 */
	private function _get_reserve_condition_params()
	{
		$params = array();
		$params['construction_code']  =  $this->data[self::F_COND_CONSTRUCTION_CODE];
		$params['reserve_date_start'] =  $this->data[self::F_COND_RESERVE_DATE_START];
		$params['reserve_date_end']   =  $this->data[self::F_COND_RESERVE_DATE_END];
		$params['reserve_date']       =  $this->data[self::F_COND_RESERVE_DATE];
		$params['reserve_status']     =  $this->data[self::F_COND_RESERVE_STATUS];
		$params['customer_id']        =  $this->data[self::F_COND_CUSTOMER_ID];

        //一般ユーザー
        if( $this->login_user->account_type != User_const::ACCOUNT_TYPE_ADMIN ){
            $user_entity = $this->M_user->get_by_user_code($this->login_user->user_code);
            $params['staff_id'] = (int)$user_entity->id;
        //管理者
        } else {
		    $params['staff_id'] =  $this->data[self::F_COND_STAFF_ID];
        }

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
        // プルダウン用
        $this->staff_id_list        = $this->_getStaffIdList();
        $this->construction_id_list = $this->M_construction->getConstructionCategoryIdList();
        $this->car_profile_id_list  = $this->M_car_profile->getCarProfileIdList();
        $this->reserve_status_list  = $this->_getStatusIdList();
        $this->customer_id_list   = $this->M_customer->getCustomerIdList(true);

        // 予約情報複製対応
        $this->staff_id_list[0]     = "未設定";
    }

    private function _getStatusIdList()
    {
        return Reserve_status::get_dropdown_list_without_blank();    
    }

    private function _getStaffIdList()
    {
        return $this->M_user->getStaffIdList();
    }

    private function _setPointAndPrice($ret)
    {
        return $this->T_reserve_detail->getPointAndPrice($ret);
    }

    private function _setUnitPriceIdCheck($ret)
    {
        return $this->T_reserve_detail->getUnitPriceId($ret);
    }

    private function _setPointTotalAndPriceTotal($ret)
    {
        return $this->T_reserve_detail->getPointTotalAndPriceTotal($ret);
    }

    /**
     * 配車予約に紐尽く作業を取得
     */
    private function _getReserveDetails($reserve_id)
    {
        return $this->T_reserve_detail->find_by_reserve_id( $reserve_id );
    }

	/**
	 * 指定された条件でCSVで出力する
	 */
	public function csv()
	{
		//検索に必要な情報を作成
		$params = $this->_get_reserve_condition_params();

        if ($this->main_model->is_unit_price_exists($params))
        {
			$this->error_list['unit_price_duplicate'] = '単価設定に無い組み合せがあります。';
		    $page = $this->_set_search_again_condition();
		    $this->search($page);
            return;
        }

        $page = 1; $max = FALSE;
		$nds_pagination = $this->_create_pagination($max, $page);
		$search_list = $this->main_model->getCsvData($nds_pagination, $params);
		$ret_array = $this->Csv_logic->convert_for_csv($search_list, $this->package_name);

		$this->_do_download_csv(
		           "{$this->package_name}_".date('YmdHis').".csv",
		           $ret_array['header'],
		           $ret_array['content']
		       );

	}


	/**
	 * 指定された条件でPDFを出力する
	 */
	public function pdf()
	{
		//検索に必要な情報を作成
		$params = $this->_get_reserve_condition_params();
        if (empty($params['staff_id']))
        {
			$this->error_list['unit_price_duplicate'] = '担当が選択されていません。';
        }
        elseif (empty($params['reserve_date']))
        {
			$this->error_list['unit_price_duplicate'] = '予定日が入力されていません。';
        }
        elseif (!$this->T_attendance->is_attendance_exists_date($params['staff_id'], $params['reserve_date']))
        {
			$this->error_list['unit_price_duplicate'] = '指定した予定日には出勤していません。';
        }
        elseif ($this->main_model->is_unit_price_exists($params))
        {
			$this->error_list['unit_price_duplicate'] = '単価設定に無い組み合せがあります。';
        }
        else
        {
            $reserve = $this->main_model->getPdfReserveData($params);
            if (empty($reserve))
            {
    			$this->error_list['unit_price_duplicate'] = '指定された日には予定がありません。';
            }
        }

        if (!empty($this->error_list))
        {
            $page = $this->_set_search_again_condition();
	        $this->search($page);
            return;
        }

        if (!empty($reserve))
        {
            $this->Tcpdf_logic->set_pdf($reserve);
	    }
	}

}
