<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 全てのサービスで共通のController。
 * 
 * @author ta-ando
 *
 */
class Base_Controller extends MY_Controller 
{
	/** デフォルトのアクセスメソッド名 */
	const DEFAULT_METHOD_SEGMENT = 'index/';

	/** ログインユーザオブジェクトをセッションに保持するキー */
	const SESSION_KEY_LOGIN_USER = 'login_user';

	/** アプリケーション情報オブジェクトをセッションに保持するキー */
	const SESSION_KEY_APPLICATION_SESSION_DATA = 'application_session_data';

	/** 確認画面表示時などに使用するセッションキー */
	const SESSION_KEY_INPUT_DATA = 'input_data';

	/** 検索条件保持に使用するセッションキー */
	const SESSION_KEY_SERCH_COND_DATA = 'search_condition_data';

	/** エラーメッセージ */
	const ERROR_MSG_SESSION_ERRROR = 'システムでエラーが発生しました。';

	/** Viewのテンプレートのキー名 */
	const LAYOUT_LAYOUT = 'layout';
	const LAYOUT_HEADER = 'header';
	const LAYOUT_SUB_HEADER = 'sub_header';
	const LAYOUT_LEFT_MENU = 'left_menu';
	const LAYOUT_FOOTER = 'footer';
	const LAYOUT_MAIN_CONTENT = 'main_content';

// ---------------------------------------------------------------------------------------------------------------
//	 画面に表示する項目のキー名
// ---------------------------------------------------------------------------------------------------------------

	/** アップロードしたファイル名のキー */
	const F_TARGET_IMAGE_ID = 'target_image_id';

// ---------------------------------------------------------------------------------------------------------------
//	 フィールド
// ---------------------------------------------------------------------------------------------------------------

	/** VIEWの画面タイトル */
	var $common_h3_tag;

	/** VIEWのフォームで使用するactionへのパス */
	var $common_form_action_base;

	/** 検索画面などでGET条件のクエリ文字列を保持するプロパティ */
	var $get_query;

	/** アップロードしたファイル情報 */
	var $file_data;
	var $thumbnail_prefix = 's_';
	var $thumbnail_m_prefix = 'm_';
	var $thumbnail_ss_prefix = 'ss_';

	/** ページング用ライブラリ名 */
	var $nds_pagination;

	/** 表示可否フラグ TRUEの場合表示可 */
	var $display_flg;

	/** 汎用エラーメッセージ */
	var $error_msg;	

	/** SEO情報(HTMLのheadタグ内で使用する) */
	var $seo_title;
	var $seo_sub_title;
	var $seo_description;
	var $seo_keywords;

	/**
	 * ページの機能を保持する。
	 * 値はPage_typeクラスの定数をセットすること。
	 * 
	 * @var unknown_type
	 */
	var $page_type = '';

	/** 画面表示用の配列 */
	var $data = array();
	var $error_list = array();
	var $label_list = array();	//コード⇒ラベルへの変換が必要な場合に使用する
	var $layout = array();

	/** ログインユーザーオブジェクト */
	var $login_user;

	/** アプリケーション全体で使用するセッション保持オブジェクト */
	var $application_session_data;

	/** レイアウトファイル */
	var $layout_dir = '00_template';

	/** 
	 * 
	 * 機能単位で一意の値を持つコード。管理画面では基本的にディレクトリ名と一致する。
	 * 主にナビメニューのハイライトや、パスの生成、親データIDの取得などの際にキーとして使用する。
	 * 
	 * (例info, company_info, event, hom...)
	 **
	*/
	var $package_name = '';

	/** 画面に表示する機能の名称 */
	var $package_label = '';

	/** 機能単位のURL */
	var $page_path_search = '';
	var $page_path_search_again = '';
	var $page_path_register = '';
	var $page_path_edit = '';
	var $page_path_delete = '';
	var $page_path_detail = '';

// ---------------------------------------------------------------------------------------------------------------
//	 コンストラクタ、初期化処理
// ---------------------------------------------------------------------------------------------------------------

	/**
	 * コンストラクタ
	 */
	public function __construct()
	{
		parent::__construct();
		// これ以降にコードを書いていく


		$this->load->add_package_path(COMMON_LIB_PATH . 'base_setting/');
		$this->config->load('nds_common_config');

		/*
		 * Helperを読み込み
		 */

		$this->load->helper('url');
		$this->load->helper('string_util');
		$this->load->helper('func_util');
		$this->load->helper('validate_util');
		$this->load->helper('path_util');
		$this->load->helper('date_util');
		$this->load->helper('nds_util');
		$this->load->helper('nds_form');

		/*
		 * 主要共通ライブラリを読み込み。
		 * 読み込み順序の制御が必要な場合はforeachより前に、該当のlibraryを記述すること。
		 * 2重に読み込んでもエラーにはならないので問題ない。
		 */

		$this->load->library('base_const_lib');	//事前読み込み
		foreach(glob(COMMON_LIB_PATH . 'base_setting/libraries/*.php') as $file)
		{
			$library_name = str_replace('.php', '' ,basename($file));
			$this->load->library($library_name);
		}

		/*
		 * ライブラリを読み込み。
		 * 読み込み順序の制御が必要な場合はforeachより前に、該当のlibraryを記述すること。
		 * 2重に読み込んでもエラーにはならないので問題ない。
		 */

		foreach(glob(COMMON_LIB_PATH . 'base_setting/libraries/common_const_lib/*.php') as $file)
		{
			$library_name = str_replace('.php', '' ,basename($file));
			$this->load->library('common_const_lib/' . $library_name);
		}

		//library
		$this->load->library('session');
		$this->load->library('form_validation');
	}

	/**
	 * 画面表示用の配列に初期値をセットする。
	 * その際にセットされるキーは親クラス、自クラスにconstで宣言され、且つF_で始まる定数。
	 */
	protected function _set_data_default($layout_dir)
	{
		$class = new ReflectionClass(get_class($this));
		$const_array = $class->getConstants();

		//定数をキーにして初期値をセット
		foreach ($const_array as $key => $value)
		{
			if (strpos($key, 'F_') !== FALSE)
			{
				$this->data[$value] = '';
			}
		}

		$this->display_flg = TRUE;
		$this->common_h3_tag = '';
		$this->common_form_action_base = '';
		$this->data[Page_type::KEY] = Page_type::SIMPLE;

		// Viewのレイアウト用ファイルのデフォルト設定
		$this->_set_view_template($this->layout_dir);
	}

// ---------------------------------------------------------------------------------------------------------------
//	 データの変換、移送系のメソッド
// ---------------------------------------------------------------------------------------------------------------

	/**
	 * GETとPOSTにセットされている情報を$dataに移送する。
	 * GETとPOSTで送信されていないキーについては上書きはしない。
	 * 対象：画面が持つ定数のうち、F_{キー}で始まるもの、または$optional_keysで指定されたキー
	 */
	protected function _httpinput_to_data($optional_keys = FALSE)
	{
		$class = new ReflectionClass(get_class($this));
		$const_array = $class->getConstants();

		$ret = array();

		//定数をキーにして初期値をセット
		foreach ($const_array as $key => $value)
		{
			if (strpos($key, 'F_') !== FALSE
			&& $this->input->get_post($value) !== FALSE)
			{
				$this->data[$value] = $this->input->get_post($value);
			}
		}

		//F_始まりの定数以外のキーを取得する場合
		if ($optional_keys)
		{
			foreach ($optional_keys as $key)
			{
				if ($this->input->get_post($key) !== FALSE)
				{
					$this->data[$key] = $this->input->get_post($key);
				}
			}
		}
	}

	/**
	 * 配列にセットされている情報をkey=>valueとして$dataに移送する。
	 * 空の場合は移送しない。
	 */
	protected function _set_to_data($tmp_array = array())
	{
		//ユーザ入力値を画面表示用にセット
		foreach (array_keys($this->data) as $value)
		{
			if (isset($tmp_array[$value]) 
			&& is_not_blank($tmp_array[$value]))
			{
				$this->data[$value] = $tmp_array[$value];
			}
		}
	}

	/**
	 * フォームからPOSTで送信されたデータを配列にセットして取得する。
	 * その際にセットされるキーは親クラス、自クラスにconstで宣言され、且つF_で始まる定数。
	 * 
	 * @param unknown_type $optional_keys
	 */
	protected function _create_session_value($optional_keys = FALSE)
	{
		$class = new ReflectionClass(get_class($this));
		$const_array = $class->getConstants();

		$ret = array();

		//定数をキーにして初期値をセット
		foreach ($const_array as $key => $value)
		{
			if (strpos($key, 'F_') !== FALSE)
			{
				$escaped_Str = $this->input->get_post($value);

				if ( ! is_array($escaped_Str)
				&& strpos($escaped_Str, '\\') !== FALSE)
				{
					$escaped_Str = str_replace('\\', '￥', $escaped_Str);
				}

				$ret[$value] = (is_not_blank($escaped_Str)) 
				               ? $escaped_Str
				               : '';
			}
		}

		//定数宣言されていないキーを取得する
		if ($optional_keys)
		{
			foreach ($optional_keys as $key)
			{
				$escaped_Str = $this->input->get_post($key);

				if ( ! is_array($escaped_Str)
				&& strpos($escaped_Str, '\\') !== FALSE)
				{
					$escaped_Str = str_replace('\\', '￥', $escaped_Str);
				}

				$ret[$key] = (is_not_blank($escaped_Str)) 
				               ? $escaped_Str
				               : '';
			}
		}

		return $ret;
	}

	/**
	 * GETで渡されたパラメータからGET用の文字列を生成します。
	 * さらに追加したいパラメータのキーを配列で渡します。
	 * 
	 * @param unknown_type $array_keys
	 */
	protected function _create_condition_list($extra_keys = array())
	{
		$query_array = array();
		$class = new ReflectionClass(get_class($this));
		$const_array = $class->getConstants();

		/*
		 * 定数をキーにして初期値をセット
		 * ※$keyの方は定数名なので実際に配列のキーに使用されているものとは別である点に注意
		 */

		foreach ($const_array as $key => $value)
		{
			if (strpos($key, 'F_COND_') !== FALSE
			&& is_not_blank($this->data[$value]))
			{
				$query_array[$value] = $this->data[$value] ;
			}
		}

		//指定したパターンの定数以外のものが引数で渡されていればセット
		foreach ($extra_keys as $key)
		{
			$query_array[$key] = is_not_blank($this->data[$key]) ? $this->data[$key] : '';
		}

		return $query_array;
	}

// ---------------------------------------------------------------------------------------------------------------
//	 アクセス制限
// ---------------------------------------------------------------------------------------------------------------

	/**
	 * 認証チェック
	 * ・不正なログイン情報の場合はセッションを破棄して警告メッセージを表示。
	 * ・ログインが必要ないページではチェック無し。
	 * ・ログイン必須の画面で未ログインの場合はログイン必須エラーを表示する。
	 * ・
	 */
	protected function _check_auth()
	{
		//セッションからログイン情報を取得
		$login_user = $this->session->userdata(self::SESSION_KEY_LOGIN_USER);

		//ログインユーザーオブジェクトの型をチェック
		if (($login_user !== FALSE)
		&& ! $login_user instanceof Login_user) 
		{
			//セッション情報を破棄
			$this->session->sess_destroy();

			//エラーページを表示して処理終了
			show_error('不正な手順でログインされています。もう一度ログイン画面からログインしなおしてください。');
			return;	//実際にはこのRETURNには到達しない 
		}

		if (in_array($this->_get_page_code(), Auth_check::$NOT_LOGIN_REQUIRED)) 
		{
			return TRUE;
		}

		if ( ! $login_user)
		{
			//エラーページを表示して処理終了
			show_error('アクセスするにはログインが必要です');
			return;	//実際にはこのRETURNには到達しない 
		}
	}

	/**
	 * アカウント用管理画面の権限チェック
	 * 
	 */
	protected function _check_member_auth()
	{
		//セッションからログイン情報を取得
		$login_user = $this->session->userdata(self::SESSION_KEY_LOGIN_USER);

		//ログインユーザーオブジェクトの型をチェック
		if (($login_user !== FALSE)
		&& ! $login_user instanceof Login_account_user) 
		{
			//セッション情報を破棄
			$this->session->sess_destroy();

			//エラーページを表示して処理終了
			show_error('不正な手順でログインされています。もう一度ログイン画面からログインしなおしてください。');
			return;	//実際にはこのRETURNには到達しない 
		}

		if (in_array($this->_get_page_code(), Auth_check::$NOT_LOGIN_REQUIRED)) 
		{
			return TRUE;
		}

		//セッションからログイン情報を取得
		$login_user = $this->session->userdata(self::SESSION_KEY_LOGIN_USER);

		if ( ! $login_user)
		{
			//エラーページを表示して処理終了
			show_error('アクセスするにはログインが必要です');
			return;	//実際にはこのRETURNには到達しない 
		}
	}

// ---------------------------------------------------------------------------------------------------------------
//	 パス、URL関連
// ---------------------------------------------------------------------------------------------------------------

	/**
	 * サブフォルダ名を含む「コントローラーを特定する文字列」を取得する
	 */
	protected function _get_controller_code() 
	{
		return $this->uri->slash_segment(1) . strtolower(get_class($this)) . '/';
	}

	/**
	 * サブフォルダ名からメソッド名まで含んだ「画面を特定する文字列」を取得する
	 * 
	 */
	protected function _get_page_code() 
	{
		//メソッド名がindex()の場合に省略されるので、index()を追加する
		$third_segment = is_not_blank($this->uri->segment(3)) ? $this->uri->slash_segment(3)
															  : self::DEFAULT_METHOD_SEGMENT;

		return $this->uri->slash_segment(1) . strtolower(get_class($this)). '/' . $third_segment;
	}

	/**
	 * 完了画面表示用メソッドにリダイレクトするURLを取得する
	 */
	protected function _get_redirect_url_complete()
	{
		return $this->uri->slash_segment(1). strtolower(get_class($this)). '/'. 'complete/';
	}

	/**
	 * 管理画面のドキュメントルート内にある画像ファイルへのパスを生成する。
	 * 
	 * @param unknown_type $company_id
	 * @param unknown_type $dir_name
	 * @param unknown_type $delimiter
	 * @param unknown_type $last_separator_flg
	 * @param unknown_type $make_dir
	 */
	private function _create_upload_path($company_id, $dir_name, $delimiter = DIRECTORY_SEPARATOR,  $last_separator_flg = true, $make_dir = FALSE)
	{
		$upload_dir = 'upload_images' . $delimiter . $company_id . $delimiter . $dir_name;
	
		if ($make_dir && ! file_exists($upload_dir))
		{
			mkdir($upload_dir, 0777, TRUE);
		}

		return $last_separator_flg ? $upload_dir . $delimiter
								   : $upload_dir;
	}

	/**
	 * 指定した種類のファイルアップロード先のファイルシステム上の相対パスを取得する。
	 * フォルダが存在しなければ作成する
	 * 
	 * @param unknown_type $dir_type
	 * @param unknown_type $company_id
	 * @param unknown_type $last_separator_flg
	 */
	protected function _get_upload_dir($dir_type, $company_id = FALSE, $last_separator_flg = true)
	{
		//空の場合はデフォルト
		if ( ! $company_id)
		{
			$company_id = System_const::DEFAULT_DATA_TYPE_DIR_NAME;
		}

		return $this->_create_upload_path($company_id, $dir_type, DIRECTORY_SEPARATOR, $last_separator_flg, TRUE);
	}

	/**
	 * 指定した種類のファイルアップロード先のファイルシステム上の相対パスを取得する。
	 * フォルダが存在しなければ作成する
	 * 
	 * @param unknown_type $dir_type
	 * @param unknown_type $company_id
	 * @param unknown_type $last_separator_flg
	 */
	protected function _get_upload_url($dir_type, $company_id = FALSE, $last_separator_flg = true)
	{
		//空の場合はデフォルト
		if ( ! $company_id)
		{
			$company_id = System_const::DEFAULT_DATA_TYPE_DIR_NAME;
		}

		return $this->_create_upload_path($company_id, $dir_type, '/', $last_separator_flg, TRUE);
	}

// ---------------------------------------------------------------------------------------------------------------
//	 セッション関連
// ---------------------------------------------------------------------------------------------------------------

	/**
	 * 画面を特定するコードをキーにセッションに情報を保持する。
	 * セッション情報は多重配列になるようにkey=>valueでセットする。
	 * 
	 * @param unknown_type $arg_data
	 */
	protected function _save_page_session($key, $arg_data)
	{
		$current = $this->session->userdata($this->_get_controller_code());

		if ($current === FALSE || ! is_array($current))
		{
			$current = array($key => $arg_data);
		}
		else
		{
			$current = array_merge($current, array($key => $arg_data));
		}

		//セッションに保持
		$this->session->set_userdata($this->_get_controller_code(), $current);
	}

	/**
	 * 画面を特定するコードをキーにセッションから情報を取得する。
	 * セッション情報は多重配列になるようにkey=>valueでセットされている。
	 * 
	 * @param unknown_type $arg_data
	 */
	protected function _get_page_session($key) 
	{
		//セッションから取得
		$current = $this->session->userdata($this->_get_controller_code());

		return isset($current[$key]) ? $current[$key] : FALSE;
	}

	/**
	 * ページ識別子に紐付いたセッション情報を削除する。
	 */
	protected function _unset_page_session() 
	{
		//セッション情報を削除
		$this->session->unset_userdata($this->_get_controller_code());
	}

// ---------------------------------------------------------------------------------------------------------------
//	 Viewのレイアウト表示関連
// ---------------------------------------------------------------------------------------------------------------

	/**
	 * VIEWのレイアウト構造を持ったテンプレートに変数を展開して出力する
	 * 
	 * @param unknown_type $main_content_name
	 * @param unknown_type $data
	 */
	protected function _load_tpl($main_content_name, $data)
	{
		if ( ! isset($this->layout[self::LAYOUT_LAYOUT]))
		{
			show_error('レイアウトが存在しません。');
		}

		$tpl = array();

		foreach ($this->layout as $key => $value)
		{
			//レイアウトファイルは無視
			if ($key === self::LAYOUT_LAYOUT)
			{
				continue;
			}

			if (is_not_blank($value))
			{
				//ファイルがあれば
				if (file_exists(APPPATH . "views/{$value}.php"))
				{
					$tpl[$key] = $this->load->view($value, $data ,true);
				}
				else
				{
					$tpl[$key] = '';
				}
			}
		}

		//メインコンテンツをセット
		$tpl[self::LAYOUT_MAIN_CONTENT] = $this->load->view($main_content_name, $data ,true); 

		$this->load->view($this->layout[self::LAYOUT_LAYOUT], $tpl);
	}

	/**
	 * Viewにセットする情報を設定する
	 * 
	 * @param unknown_type $layout_dir
	 */
	private function _set_view_template($layout_dir)
	{
		$view_info = array();
		$this->layout[self::LAYOUT_LAYOUT] = "{$layout_dir}/layout_default";
		$this->layout[self::LAYOUT_HEADER] = "{$layout_dir}/header";
		$this->layout[self::LAYOUT_SUB_HEADER] = "{$layout_dir}/sub_header";
		$this->layout[self::LAYOUT_LEFT_MENU] = "{$layout_dir}/left_menu";
		$this->layout[self::LAYOUT_FOOTER] = "{$layout_dir}/footer";
	}

	/**
	 * VIEW用のテンプレートパーツの名称を取得する。
	 * @return Viewの相対パス
	 * @param unknown_type $type
	 */
	protected function _get_view_name($type)
	{
		if ($type === View_type::INDEX)
		{
			return $this->uri->slash_segment(1) . strtolower(get_class($this)). '_' . $type;
		}
		else
		{
			$class_name = strtolower(get_class($this));
			$class_name_split_array = explode('_', $class_name);

			if (count($class_name_split_array) > 1)
			{
				array_pop($class_name_split_array);
			}

			$view_prefix = implode('_', $class_name_split_array);

			return $this->uri->slash_segment(1) . $view_prefix . '_' .  $type;
		}
	}

// ---------------------------------------------------------------------------------------------------------------
//	 validator関連
// ---------------------------------------------------------------------------------------------------------------

	/**
	 * 日付のパターンチェック
	 * ※主に入力チェックからcallback_check_dateとして呼び出す
	 * @param unknown_type $str
	 */
	public function check_date($input)
	{
		if (is_blank($input))
		{
			return TRUE;
		}

		if ( ! is_date($input))
		{
			$this->form_validation->set_message('check_date', '%sはYYYY/MM/DD形式の日付で入力してください。');
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * ひらがなのパターンチェック
	 * ※主に入力チェックからcallback_check_furiganaとして呼び出す
	 * 
	 * @param unknown_type $input
	 */
	public function check_furigana($input)
	{
		if (is_blank($input))
		{
			return TRUE;
		}

		if ( ! is_hiragana($input))
		{
			$this->form_validation->set_message('check_furigana', '%sはふりがなで入力してください。');
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * カタカナのパターンチェック
	 * ※主に入力チェックからcallback_check_katakanaとして呼び出す
	 * 
	 * @param unknown_type $input
	 */
	public function check_katakana($input)
	{
		if (is_blank($input))
		{
			return TRUE;
		}

		if ( ! is_katakana($input))
		{
			$this->form_validation->set_message('check_katakana', '%sは全角カタカナで入力してください。');
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * アルファベット+記号のパターンチェック
	 * ※主に入力チェックからcallback_check_katakanaとして呼び出す
	 * 
	 * @param unknown_type $input
	 */
	public function check_alpha_symbol($input)
	{
		if (is_blank($input))
		{
			return TRUE;
		}

		if ( ! is_alpha_symbol($input))
		{
			$this->form_validation->set_message('check_alpha_symbol', '%sはアルファベットで入力してください。');
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * URLをチェックする
	 * ※主に入力チェックからcallback_check_urlとして呼び出す
	 * 
	 * @param unknown_type $text
	 */
	public function check_url($input)
	{
		if (is_blank($input))
		{
			return TRUE;
		}

		if ( ! is_url($input))
		{
			$this->form_validation->set_message('check_url', '%sはURL形式の文字列を入力してください。');
	        return FALSE;
		} 

		return TRUE;
	}

	/**
	 * 電話番号をチェックする
	 * ※主に入力チェックからcheck_phone_numberとして呼び出す
	 * 
	 * @param unknown_type $text
	 */
	public function check_phone_number($input)
	{
		if (is_blank($input))
		{
			return TRUE;
		}

		if ( ! is_phone_number($input))
		{
			$this->form_validation->set_message('check_phone_number', '%sは電話番号/FAX番号の形式ではありません。');
	        return FALSE;
		} 

		return TRUE;
	}

	/**
	 * 郵便番号をチェックする
	 * ※主に入力チェックからcheck_postal_codeとして呼び出す
	 * 
	 * @param unknown_type $text
	 */
	public function check_postal_code($input)
	{
		if (is_blank($input))
		{
			return TRUE;
		}

		if ( ! is_postal_code($input))
		{
			$this->form_validation->set_message('check_postal_code', '%sは郵便番号の形式ではありません。');
	        return FALSE;
		} 

		return TRUE;
	}

	/**
	 * 時間のパターンチェック
	 * ※主に入力チェックからcallback_check_timeとして呼び出す
	 * @param unknown_type $str
	 */
	public function check_time($input)
	{
		if (is_blank($input))
		{
			return TRUE;
		}

		if ( ! is_time($input))
		{
			$this->form_validation->set_message('check_time', '%sはHH:MM形式の時間で入力してください。');
			return FALSE;
		}

		return TRUE;
	}

	/**
	 * 整数又は小数のパターンチェック
	 * ※主に入力チェックからcallback_check_decimal_pointとして呼び出す
	 * @param unknown_type $str
	 */
	public function check_decimal_point($input)
	{
		if (is_blank($input))
		{
			return TRUE;
		}

		if ( ! is_decimal_point($input))
		{
			$this->form_validation->set_message('check_decimal_point', '%sは整数又は小数で入力してください。');
			return FALSE;
		}

		return TRUE;
	}

// ---------------------------------------------------------------------------------------------------------------
//	 ファイルアップロード関連
// ---------------------------------------------------------------------------------------------------------------

	/**
	 * 画像アップロードのデフォルト設定を取得する。
	 */
	protected function _get_upload_config_image()
	{
		//ファイルアップロード用ライブラリ設定
		$config = array();
		$config['allowed_types'] = config_item('upload_ext_img');
		$config['max_size'] = config_item('upload_max_size');
		$config['max_width'] = config_item('upload_max_width');
		$config['max_height'] = config_item('upload_max_height');

		return $config;
	}

// ---------------------------------------------------------------------------------------------------------------
//	 メール送信処理関連
// ---------------------------------------------------------------------------------------------------------------

	/**
	 * メール送信処理
	 * 
	 * @param unknown_type $to
	 * @param unknown_type $from_address
	 * @param unknown_type $from_name
	 * @param unknown_type $subject
	 * @param unknown_type $body
	 */
	protected function _sendmail($to, $from_address, $from_name, $subject, $body)
	{
		$return_path = NULL;

		//メールサーバ設定があれば設定。なければサーバ設定をそのまま使用する。
		if (is_not_blank(config_item('smtp_server'))) {
			ini_set("SMTP", config_item('smtp_server'));
		}

		if (is_not_blank(config_item('smtp_port'))) {
			ini_set("smtp_port", config_item('smtp_port'));
		}

		if (is_not_blank(config_item('mail_return_path'))) {
			$return_path = "-f" . config_item('mail_return_path');
		}

		//From用ヘッダを作成
		$add_header = "From:" . mb_encode_mimeheader($from_name, "UTF-8", "B", "")."<{$from_address}>";

		//メールを送信
		mb_send_mail($to, $subject, $body, $add_header, $return_path);
	}
}
