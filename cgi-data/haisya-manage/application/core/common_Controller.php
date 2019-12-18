<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * プロジェクト固有の親Controller
 * ※このクラスがロードされるのはcore/MY_Controller.phpのファイル一番下のrequire_once
 * @author ta-ando
 *
 */
class Common_Controller extends Base_Controller
{
	/** グローバルメニューのアクティブ制御フラグ */
	var $current_main_menu = '';
	var $current_sub_menu = '';

	/** 画面で扱うデータのデータ種別 */
	var $target_data_type;

	/** 画像, ファイルアップロード用（本番フォルダ） */
	var $destination_upload_dir = '';
	var $destination_upload_url = '';
	/** 画像, ファイルアップロード用（作業用フォルダ） */
	var $departure_upload_dir = '';
	var $departure_upload_url = '';

	/** 画面で扱うモデル */
	var $main_model = FALSE;
	var $sub_model = FALSE;

	/** 基本カテゴリーの使用を制御するメンバ */
	var $basic_category_use = TRUE;
	var $basic_category_multi_select = FALSE;
	var $label_basic_category;
	var $validate_rule_basic_category;
	var $basic_category_list;

	/** 固定ページを上部メニューで表示する際に使用するリスト */
	var $freetext_kubun_list = array();

    var $nds_manage_css;

    /** 勤怠 */
    var $attendance = TRUE;

    var $smartphone;
    const F_START = 'start';

	/**
	 * コンストラクタ
	 */
	public function __construct()
	{
		parent::__construct();

		/*
		 * 設定ファイルをロード
		 */

		$this->config->load('nds_system_manage_config');

		foreach(glob(APPPATH.'config/post_settings/*.php') as $file)
		{
			$config_file_name = str_replace('.php', '' ,basename($file));
			$this->config->load('post_settings/' . $config_file_name);
		}

		/*
		 * システム個別ライブラリを読み込み。
		 * 読み込み順序の制御が必要な場合はforeachより前に、該当のlibraryを記述すること。
		 * 2重に読み込んでもエラーにはならないので問題ない。
		 */

		$this->load->add_package_path(COMMON_LIB_PATH . 'common/');

		foreach(glob(COMMON_LIB_PATH . 'common/libraries/const_lib/*.php') as $file)
		{
			$library_name = str_replace('.php', '' ,basename($file));
			$this->load->library('const_lib/' . $library_name);
		}

		/*
		 * データベースのモデルをロード。
		 * 必ずlibraryより後にロードすること。
		 * ※ファイル名ではなく、先頭が大文字のクラス名であることに注意
		 */
		foreach(glob(COMMON_LIB_PATH . 'common/models/common/*.php') as $file)
		{
			$model_name = ucFirst(str_replace('.php', '' ,basename($file)));
			$this->load->model('common/' . $model_name);
		}

		/*
		 * ロジック用のモデルをロード。
		 * 必ずDB用のmodelより後にロードすること。
		 * ※ファイル名ではなく、先頭が大文字のクラス名であることに注意
		 */
		foreach(glob(COMMON_LIB_PATH . 'common/models/logic/*.php') as $file)
		{
			$model_name = ucFirst(str_replace('.php', '' ,basename($file)));
			$this->load->model('logic/' . $model_name);
		}

		// データベース接続
		$this->load->database();

		// ログインユーザ情報を取得する
		$this->login_user = $this->session->userdata(parent::SESSION_KEY_LOGIN_USER);

		// アプリケーション用のセッション情報
		$this->application_session_data = $this->session->userdata(parent::SESSION_KEY_APPLICATION_SESSION_DATA);

		//エラー囲みタグ
		$this->form_validation->set_error_delimiters(config_item('error_tag_start'), config_item('error_tag_end'));

		//レイアウトフォルダ名をセット
		$this->layout_dir = '01_template';

		// アクセス制限チェック
		parent::_check_auth(Service_code::COMMON);

		//$this->dataに初期値をセット
		parent::_set_data_default($this->layout_dir);

		/*
		 * メニューなど全ての画面で使用する情報を取得する
		 */

		$this->freetext_kubun_list = $this->M_kubun->get_key_value_list_by_kubun_code(
		                                                 Relation_data_type::FREETEXT,
		                                                 Kubun_type::CATEGORY
		                                             );
        // スマホの判定
        $objUA = new MY_User_agent();
        $this->nds_manage_css = ($objUA->is_smartphone()) ? "nds_manage_smartphone.css" : "nds_manage.css";
        $this->smartphone = $objUA->is_smartphone();
	}

	/**
	 * ページ固有の情報を設定します。
	 * 各ページのコンストラクタから呼び出して使用します。
	 * 固有情報のセットを行うためにCommon_controllerからではなく、個々のControllerから呼び出す必要があります。
	 * パッケージ名とクラス名に違いがある場合は引数でprefixを指定してください。
	 * 例）
	 * info/info_search/の場合は引数無し。
	 * company_info/info_search/の場合の引数$another_prefixに'info'をセットする。
	 * 
	 * @param unknown_type $another_prefix パッケージ名とクラス名に違いがある場合に使用するprefix
	 */
	protected function _page_setting($another_prefix = FALSE)
	{
		//フォームにセットするこのクラスのパス
		$class_name = strtolower(get_class($this));
		$this->common_form_action_base = "{$this->package_name}/{$class_name}/";

		$class_name_prefix = ( ! $another_prefix)
		                     ? $this->package_name
		                     : $another_prefix;

		//基本機能のURLを生成
		$this->page_path_register = "{$this->package_name}/{$class_name_prefix}_register/";
		$this->page_path_edit = "{$this->package_name}/{$class_name_prefix}_edit/";
		$this->page_path_detail = "{$this->package_name}/{$class_name_prefix}_detail/";
		$this->page_path_handle_relation = "{$this->package_name}/{$class_name_prefix}_edit/handle_relation/";
		$this->page_path_search = "{$this->package_name}/{$class_name_prefix}_search/";
		$this->page_path_search_again = "{$this->package_name}/{$class_name_prefix}_search/search_again/";
		$this->page_path_delete = "{$this->package_name}/{$class_name_prefix}_search/delete/";

		//アップロードファイルの作業用フォルダ(別フォルダにアップする場合は上書きして使用する)
		$this->departure_upload_dir = get_temp_upload_dir(TRUE);
		$this->departure_upload_url= base_url('tmp_images') . '/';

		//公開用のアップロード先フォルダ(別フォルダにアップする場合は上書きして使用する)
		$this->destination_upload_dir = $this->_get_upload_dir(
		                                           Relation_data_type::get_dir_name($this->target_data_type)
		                                       );

		$this->destination_upload_url = base_url($this->_get_upload_url(
		                                                      Relation_data_type::get_dir_name($this->target_data_type))
		                                        ) . '/';
	}

	/**
	 * 更新情報を登録する
	 * 
	 * @param unknown_type $wall_config
	 * @param unknown_type $wall_action
	 */
	private function _record_wall($wall_config)
	{
		$T_wall = new T_wall();
		$T_wall->service_code = $wall_config['service_code'];
		$T_wall->post_date = date('Y/m/d H:i:s');
		$T_wall->update_menu = $wall_config['update_menu'];
		$T_wall->update_data_id = $wall_config['update_data_id'];
		$T_wall->update_user_code = $this->login_user->user_code;
		$T_wall->insert($this->login_user->user_code);
		
		return $this->db->insert_id();
	}

	/**
	 * t_wallにログを記録する
	 * 
	 * @param unknown_type $wall_menu
	 * @param unknown_type $data_id
	 */
	protected function _record_log($wall_menu, $data_id = NULL)
	{
		$wall_config = array();
		$wall_config['service_code'] = Service_code::COMMON; 
		$wall_config['update_menu'] = $wall_menu;
		$wall_config['update_data_id'] = $data_id;

		//ウォールの基本データをINSERT
		$new_wall_id = $this->_record_wall($wall_config);
	}

	/**
	 * どのメソッドへのアクセスかを取得します。
	 * デフォルトはindexです。
	 * 
	 * @param unknown_type $method_name
	 * @param unknown_type $method_index
	 */
	protected function _is_method_match($method_name = 'index', $method_index = 3)
	{
		$segment = $this->uri->segment($method_index);

		if ($method_name === 'index')
		{
			//indexの場合はURL最後がスラッシュでindexが省略される場合があるので判定方法を別にする
			return (is_blank($segment)  or $segment === $method_name);
		}
		else
		{
			return ($segment === $method_name);
		}
	}

    /*
     * 当日の出勤を確認
     */
    protected function _check_attendance()
    {
        if($this->login_user->account_type == User_const::ACCOUNT_TYPE_COMMON){
            if (!$this->attendance_model->is_attendance_exists_date($this->M_user->getUserId($this->login_user->user_code), date('Y-m-d')))
            {
		        //勤怠へリダイレクト
		        redirect(site_url('top/top_attendance'), 'location', 301);
            }
        }
    }

}
