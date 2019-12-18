<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 勤怠を行うクラス
 * * @author ta-ando
 *
 */
class Top_attendance extends Register_Controller 
{
    const F_STAFF_ID = 'staff_id';
    const F_ATTENDANCE_ID = 'attendance_id';

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

		$this->package_name = 'top';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}勤怠";
		$this->page_type = Page_type::SIMPLE;
		$this->current_main_menu = 'home';
		$this->main_model = $this->T_attendance;
		$this->sub_model = FALSE;

		$this->_page_setting();

		/*
		 * この機能に必要な情報がセッションに保持されているか確認する
		 */

		if ( ! $this->application_session_data->can_access_package($this->package_name))
		{
			show_error('不正な画面遷移が行われています。再度メニューから操作を行ってください。');
		}

		//HTTPのGET,POST情報を$this->dataに移送
		$this->_httpinput_to_data();

        /** 勤怠 */
        $this->attendance = FALSE;

	}

	/**
	 * 初期表示を行う。
	 */
	public function index()
	{
		$this->_unset_page_session();
		/*
		 * 初期処理
		 */
		$this->_load_tpl($this->_get_view_name('attendance'), $this->data);

	}

	/**
	 * 出勤ボタン押下時の処理を行う。
	 * ・DB更新処理
	 * ・カレンダー画面にリダイレクト
	 * ※DB更新行うため、カレンダー画面へリダイレクトする。
	 */
	public function register()
	{
		//DB更新処理
		$id = $this->_do_db_logic();

		$this->_save_page_session(self::F_ATTENDANCE_ID, $id);

		//完了画面表示用メソッドへリダイレクト
        redirect(site_url('top/top/'), 'location', 301);

	}

	/**
	 * DBへの更新処理を行うロジック
	 * 
	 */
	private function _do_db_logic()
	{
        if($this->login_user->account_type == User_const::ACCOUNT_TYPE_COMMON){
            $staff_array = $this->M_user->getStaffByUserCode($this->login_user->user_code, User_const::ACCOUNT_TYPE_COMMON);
            foreach ($staff_array as $key => $val)
            {
		        $session_var[self::F_STAFF_ID] = $key;
            }
        }

		if ( ! $session_var)
		{
			show_error(parent::ERROR_MSG_SESSION_ERRROR);
		}

		$this->db->trans_start();

		/*
		 * メインのテーブルの更新処理
		 */

		$id = $this->_insert_table($session_var);

		$this->db->trans_complete();

        return $id;
	}

	/**
	 * この画面で更新するメインテーブルをINSERTする
	 * 
	 * @param unknown_type $session_var
	 */
	private function _insert_table($session_var)
	{
		$entity = new T_attendance();
		$entity->staff_id = $session_var[self::F_STAFF_ID];
		$entity->datetime = date('Y-m-d H:i:s');

		return parent::_insert_main_table($entity, $session_var);
	}

}
