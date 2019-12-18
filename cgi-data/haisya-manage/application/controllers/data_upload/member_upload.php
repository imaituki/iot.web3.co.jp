<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 会員の一括アップロード
 * * @author ta-ando
 *
 */
class Member_upload extends Register_Controller
{
	/** CSVのインデックス用定数 */
	const HEADER_LINE_END = 1;
	const INDEX_MAX = 5;


	const F_PASSWORD = 'password';
	const F_COMPANY_NAME = 'company_name';
	const F_NAME = 'name';
	const F_FURIGANA = 'furigana';
	const F_POSITION = 'position';
	const F_EMAIL = 'email';
	
	const F_COMMIT_FLG = 'commit_flg';

	const F_LINE_COUNT = 'line_count';

	var $warning_list = array(); 

	/*
	 * 建物
	 */

	const F_RAILWAY_COMPANY = 'railway_company';
	const F_ROUTE = 'route';
	const F_STATION_NAME = 'station_name';
	const F_STATION_NAME_FURIGANA = 'station_name_furigana';


	
	var $insert_user_name;
	var $display_data = array();

	static $column_list = array(
		'target_flg',
		'id',
		self::F_PASSWORD,
		self::F_COMPANY_NAME,
		'aa',
		'aa',
		self::F_NAME,
		self::F_FURIGANA,
		self::F_POSITION,
		self::F_EMAIL,
	);
//コード
//会社・店舗名
//支店名
//エリア
//エリア予備
//住所
//住所2
//TEL
//URL
//FR
//MH
	
	var $index_array = array();

	/**
	 * 
	 */
	public function __construct()
	{
		parent::__construct();

		/*
		 * 画面に固有の情報をセット
		 */

		$this->target_data_type = Relation_data_type::MEMBER;
		$this->package_name = 'data_upload';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "会員の一括登録";
		$this->page_type = Page_type::REGISTER;
		$this->current_main_menu = $this->package_name;
		$this->current_sub_menu = "member_upload";
		$this->main_model = $this->M_member;

		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//ネストする複数項目の宣言と初期化
		$this->_create_optional_form_key();
		$this->_init_optional_form_key();

		//関係テーブルのデータをDBからの呼び出す
		$this->_init_relation_data();

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);

		//1回の登録で共通のキーを持つように時刻を登録者名とする。
		$this->insert_user_name = date('Y_m_d__H_i_s');

		// 項目名とインデックスの対応リストを作成
		for ($i = 0; $i < count(self::$column_list); $i++)
		{
			$key = self::$column_list[$i];
			$this->index_array[$key] = $i;
		}
	}

	/**
	 * 
	 */
	function index()
	{
		$this->_load_tpl("data_upload/member_upload_input_view", $this->data);
	}

	/**
	 * 入力チェックを行う。
	 */
	private function _input_check()
	{
		//$this->form_validation->set_rules(self::F_COMPANY_ID, '不動産会社', 'trim|required|max_length[200]');

		/* 入力チェックの追加があればここに記述 */

		//return $this->form_validation->run();
		return TRUE;
	}

	/**
	 * 
	 */
	protected function _relation_check()
	{
		$ret = TRUE;

		return $ret;
	}

	/**
	 * アップロード処理
	 */
	function submit()
	{
		//チェック処理
		if ( ! $this->_input_check()
		or ! $this->_relation_check())
		{
			$this->_load_tpl("data_upload/member_upload_input_view", $this->data);
			return;
		}

		try 
		{
			$this->_do_main();
		}
		catch (Exception $e)
		{
			$this->db->trans_rollback();
			show_error("システムエラーのため処理を中断しました。");
		}
	}

	/**
	 * 
	 */
	function _do_main()
	{
		header("Content-type: text/html; charset=utf-8");
	
		//$csv_file_path = './csv/station1.csv';
		$csv_file_path = APPPATH."/controllers/data_upload/csv/id_password2013.csv";

		//CSVのデータを加工して取得。
		$line_list = $this->_create_csv_line_list($csv_file_path);

		$this->db->trans_begin();

		$result_array = array();

		$id_params = array(
			'room_id' => '',
			'mansion_id' => '',
			'owner_id' => '',
		);

		$success_flg = TRUE;

		foreach ($line_list as $line)
		{
			try 
			{
				$result = $line;
				$id_params = $this->_do_db_logic($line, $id_params);

				$result_array[] = $result;
			}
			catch (Exception $e)
			{
				$success_flg = FALSE;
				//$this->error_list[] = $e;
				$this->error_list[] = $e->getMessage();
			}
		}

		if ($this->data[self::F_COMMIT_FLG] === Valid_flg::VALID 
		&& $success_flg)
		{
			$this->db->trans_commit();

			//完了画面表示用メソッドへリダイレクト
			redirect($this->_get_redirect_url_complete(), 'location', 301);
			return;
		}
		else
		{
			$this->db->trans_rollback();

			$this->_load_tpl("data_upload/member_upload_input_view", $this->data);
			return;
		}
	}
	
	/**
	 * 完了画面を表示する
	 */
	function complete()
	{
		$this->_load_tpl("data_upload/data_upload_complete_view", $this->data);
	}

	/**
	 * データを登録するコントローラ
	 * 
	 * @param unknown_type $line
	 * @param unknown_type $id_params
	 */
	private function _do_db_logic($line, $id_params)
	{
		$this->_insert_member($line);

		return $id_params;
	}

	/**
	 * 物件を登録する
	 * 
	 * @param unknown_type $line
	 * @param unknown_type $company_id
	 */
	private function _insert_member($line)
	{
		$entity = new M_member();
		$entity->relation_data_type = Relation_data_type::COMMON;
		$entity->relation_data_id = Relation_data_id::DEFAULT_ID;
		$entity->data_type = Relation_data_type::MEMBER;
		$entity->draft_flg = Draft_flg::NOT_DRAFT;
		$entity->del_flg = Del_flg::NOT_DELETE;

		$entity->name = $line[$this->index_array[self::F_NAME]];
		$entity->furigana = $line[$this->index_array[self::F_FURIGANA]];
		$entity->company_name = $line[$this->index_array[self::F_COMPANY_NAME]];
		$entity->email = $line[$this->index_array[self::F_EMAIL]];
		$entity->position = $line[$this->index_array[self::F_POSITION]];
		$entity->member_type = Member_type::NORMAL;
		$entity->password = crypt($line[$this->index_array[self::F_PASSWORD]],  random_string('alpha', 2));

		$entity->order_number = 50;
		$entity->post_date = create_db_datetme_str(date('Y/m/d'));

		$entity->insert($this->insert_user_name);

		//DBが採番したIDを取得
		return $this->db->insert_id();
	}

	/**
	 * 
	 * 
	 * @param unknown_type $line
	 * @param unknown_type $room_id
	 */
	private function _insert_station_relation($line, $station_id)
	{
		$entity = new T_route_station_relation();
		$entity->relation_data_type = Relation_data_type::COMMON;
		$entity->relation_data_id = Relation_data_id::DEFAULT_ID;
		$entity->data_type = Relation_data_type::ROUTE_STATION_RELATION;
		$entity->draft_flg = Draft_flg::NOT_DRAFT;
		$entity->del_flg = Del_flg::NOT_DELETE;
		$entity->station_id = $station_id;
		$entity->route_id = $this->_convert_route($line);
		
		$entity->insert($this->insert_user_name);

		//DBが採番したIDを取得
		return $this->db->insert_id();
	}


	/**
	 * 区分の変換
	 * 
	 * @param unknown_type $label
	 * @param unknown_type $value
	 * @param unknown_type $key_value_list
	 * @param unknown_type $line
	 * @throws Exception
	 */
	private function _convert_kubun($label, $value, $key_value_list, $line)
	{
		$value = trim($value);

		if (isset($key_value_list[$value]) 
		&& is_not_blank($key_value_list[$value]))
		{
			return $key_value_list[$value];
		}
		else if (is_not_blank($value))
		{
			//throw new Exception("{$line[self::F_LINE_COUNT]}行目の{$label}［{$value}］は存在しません");
			
			$this->warning_list["{$label}［{$value}］"] = '不足';
		}

		return null;
	}

	/**
	 * 複数選択項目を変換する。
	 * 
	 * @param unknown_type $line
	 * @param unknown_type $label
	 * @param unknown_type $key_value_list
	 * @param unknown_type $values
	 */
	private function _convert_multi_kubun($line, $label, $key_value_list, $values)
	{
		if (is_blank($values))
		{
			return FALSE;
		}

		$value_list = explode(',', $values);

		$ret_ids = array();

		foreach ($value_list as $value)
		{
			$ret = $this->_convert_kubun($label, $value, $key_value_list, $line);
			
			if ($ret)
			{
				$ret_ids[] = $ret;
			}
		}

		return $ret_ids;
	}

	/**
	 * CSVからデータを取得し、一行の項目を配列にしたものを保持するリストを作成する。
	 * 戻り値はそのリスト。
	 * 文字コードはUTF-8。
	 * 
	 * @param unknown_type $csv_file_path
	 */
	private function _create_csv_line_list($csv_file_path)
	{
		$all_list = array();
		$count = 0;

		$fp = fopen($csv_file_path, 'r');

		/*
		 * 行を取得。
		 */

		$line_list = array();

		$line_count = 0;

		//CSVの1行ずつを1行とみなしてループ処理(ダブルクォーテーション内の改行は無視する)
		while ($original_line = fgetcsv_reg($fp))
		{
			mb_convert_variables('UTF-8', 'SJIS-WIN', $original_line);

			$line = array_slice($original_line, 0, (count($this->index_array) + 1));
			unset($original_line);	//メモリ節約のため削除

			$line_count++;
			
			//ヘッダ行をスキップ
			if ($count < self::HEADER_LINE_END) 
			{
				$count++;
				continue;
			}

			//操作対象外の行をスキップ
			if ($line[$this->index_array['target_flg']] != '1')
			{
				continue;
			}

			$line[self::F_LINE_COUNT] = $line_count;

			$line_list[] = $line;
		}

		fclose($fp);

		return $line_list;
	}

	/**
	 * 
	 * 
	 * @param unknown_type $line
	 */
	private function _convert_railway_company($line)
	{
		$value = $line[$this->index_array[self::F_RAILWAY_COMPANY]];

		$key_value_list = $this->railway_company_id_list;

		return $this->_convert_kubun('鉄道会社', $value, $key_value_list, $line);
	}

	/**
	 * 
	 * 
	 * @param unknown_type $line
	 */
	private function _convert_route($line)
	{
		$value = $line[$this->index_array[self::F_ROUTE]];

		$key_value_list = $this->route_id_list;

		return $this->_convert_kubun('路線', $value, $key_value_list, $line);
	}
}