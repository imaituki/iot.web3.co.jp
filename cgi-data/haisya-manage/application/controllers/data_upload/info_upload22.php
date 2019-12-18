<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * お知らせの一括アップロード
 * * @author ta-ando
 *
 */
class Info_upload22 extends Register_Controller
{
	var $csv_file_relative_path = "/controllers/data_upload/csv/22.csv";
	
	/** CSVのインデックス用定数 */
	const HEADER_LINE_END = 1;
	const INDEX_MAX = 5;

	const F_MANAGEMENT_CODE = 'management_code';  // 管理コード
	const F_POST_TITLE = 'post_title';  // 記事タイトル
	const F_POST_SUB_TITLE = 'post_sub_title';  // 記事サブタイトル
	const F_POST_CONTENT = 'post_content';  // 記事本文
	const F_POST_LINK = 'post_link';  // リンク
	const F_POST_LINK_TEXT = 'post_link_text';  // リンク


	const F_POST_LINK2 = 'post_link2';  // リンク2
	const F_POST_LINK_TEXT2 = 'post_link_text2';  // リンク用テキスト2
	const F_POST_LINK3 = 'post_link3';  // リンク3
	const F_POST_LINK_TEXT3 = 'post_link_text3';  // リンク用テキスト3
	const F_FREE_FORM_ID = 'free_form_id';  // 申し込みフォーム
	const F_ANNUAL = 'annual';  // 年度
	const F_EVENT_START_DATE = 'event_start_date';  // 開催日
	const F_EVENT_DATE_TEXT = 'event_date_text';  // 開催日補足テキスト
	const F_EVENT_TIME = 'event_time';  // 開催時間
	const F_EVENT_ACCEPT_END_DATE = 'event_accept_end_date';  // 申し込み締め切り日
	const F_EVENT_PLACE = 'event_place';  // 会場
	const F_INSTRUCTOR = 'instructor';  // 講師
	const F_TARGET_PERSON = 'target_person';  // 対象
	


	var $area_list;  // エリア用の選択項目リスト
	var $prefecture_code_list;  // 都道府県用の選択項目リスト
	var $site_type_list;  // 表示サイト用の選択項目リスト
	
	const F_COMMIT_FLG = 'commit_flg';

	const F_LINE_COUNT = 'line_count';

	var $warning_list = array(); 


	const CSV_ID = 'csv_id';

	var $insert_user_name;
	var $display_data = array();

	const COL_I = 'col_i';
	const COL_J = 'col_j';
	const COL_K = 'col_k';
	const COL_L = 'col_l';
	const COL_M = 'col_m';
	const COL_N = 'col_n';

	const PDF = 'pdf';
	
	static $column_list = array(
		'target_flg',
		self::CSV_ID,
		self::F_POST_TITLE,
		self::F_POST_LINK_TEXT,
		self::F_POST_LINK,
		self::F_POST_LINK_TEXT2,
		self::F_POST_LINK2,
		self::F_POST_LINK_TEXT3,
		self::F_POST_LINK3,
		
		self::COL_I,
		self::COL_J,
		
		self::F_POST_SUB_TITLE,
		
		self::COL_K,
		self::COL_L,
		self::COL_M,
		self::COL_N,
		
		self::F_EVENT_START_DATE,
		self::F_EVENT_PLACE,
		self::F_TARGET_PERSON,
		'bosyuu',
		self::PDF,
	);

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

		$this->target_data_type = Relation_data_type::INFO;
		$this->package_name = 'data_upload';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "22お知らせの一括登録";
		$this->page_type = Page_type::REGISTER;
		$this->current_main_menu = $this->package_name;
		$this->current_sub_menu = "member_upload";
		$this->main_model = $this->T_info;

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
		$this->_load_tpl("data_upload/info_upload22_input_view", $this->data);
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
			$this->_load_tpl("data_upload/shop_upload_input_view", $this->data);
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
		$csv_file_path = APPPATH . $this->csv_file_relative_path;

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

			$this->_load_tpl("data_upload/shop_upload_input_view", $this->data);
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
		$shop_id = $this->_insert_shop($line);

		$this->_insert_shohp_relation($line, $shop_id);
		
		return $id_params;
	}

	/**
	 * 物件を登録する
	 * 
	 * @param unknown_type $line
	 * @param unknown_type $company_id
	 */
	private function _insert_shop($line)
	{
		$entity = new T_info();
		$entity->relation_data_type = Relation_data_type::COMMON;
		$entity->relation_data_id = Relation_data_id::DEFAULT_ID;
		$entity->data_type = Relation_data_type::INFO;
		$entity->draft_flg = Draft_flg::NOT_DRAFT;
		$entity->del_flg = Del_flg::NOT_DELETE;

		$list = explode("\n", $line[$this->index_array[self::F_POST_TITLE]]);

		$for_title = array_shift($list);

		/*
		 * カラムが足りないのでURLを追加
		 */

		$list[] = $line[$this->index_array[self::COL_K]];
		$list[] = $line[$this->index_array[self::COL_L]];
		$list[] = $line[$this->index_array[self::COL_M]];
		$list[] = $line[$this->index_array[self::COL_N]];

		if ( ! empty($list) && is_array($list))
		{
			$post_content = implode("\n", $list);
		}
		else
		{
			$post_content = $for_title;
		}
		
		$entity->post_title = $for_title; //$line[$this->index_array[self::F_POST_TITLE]];
		$entity->post_content = $post_content;
		$entity->post_sub_title = $line[$this->index_array[self::F_POST_SUB_TITLE]];

		$entity->target_person = $line[$this->index_array[self::F_TARGET_PERSON]];

		$entity->post_link = $line[$this->index_array[self::F_POST_LINK]];
		$entity->post_link_text = $line[$this->index_array[self::F_POST_LINK_TEXT]];
		$entity->post_link2 =$line[$this->index_array[self::F_POST_LINK2]];
		$entity->post_link_text2 =$line[$this->index_array[self::F_POST_LINK_TEXT2]];

		$entity->event_date_text = $line[$this->index_array[self::F_EVENT_START_DATE]];
		$entity->event_accept_flg = Valid_flg::INVALID;
		
		$entity->order_number = 50;
		$entity->post_date = create_db_datetme_str(date('Y/m/d', strtotime ('-2 year')));

		$entity->insert($this->insert_user_name);

		//DBが採番したIDを取得
		return $this->db->insert_id();
	}

	/**
	 * 
	 * 
	 * @param unknown_type $line
	 * @param unknown_type $mansion_id
	 */
	private function _insert_shohp_relation($line, $post_id)
	{
		$kubun_id = $this->M_kubun->convert_kubun_code_to_id(
			Relation_data_type::COMMON,
			Kubun_type::ANNUAL_CODE,
			Kubun_code_annual::H22
		);

		$this->T_relation->delete_insert_list(
		                       $this->target_data_type,
		                       $post_id,
		                       Relation_data_type::KUBUN,
		                       Kubun_type::ANNUAL_CODE,
		                       create_array_param($kubun_id)
		                   );

		$kubun_id = $this->M_kubun->convert_kubun_code_to_id(
			Relation_data_type::INFO,
			Kubun_type::CATEGORY,
			Kubun_code_info_category::SEMINAR
		);

		$this->T_relation->delete_insert_list(
		                       $this->target_data_type,
		                       $post_id,
		                       Relation_data_type::KUBUN,
		                       Kubun_type::CATEGORY,
		                       create_array_param($kubun_id)
		                   );

		/*
		 * ファイル
		 */

		if (is_not_blank($line[$this->index_array[self::PDF]]))
		{
			$tmp_entity = new T_file();
			$tmp_entity->relation_data_type = $this->target_data_type;
			$tmp_entity->relation_data_id = $post_id;
			$tmp_entity->seq_no = 1;
			$tmp_entity->order_num = 1;
			$tmp_entity->file_type = File_type::DOCUMENT;
			$tmp_entity->file_name = $line[$this->index_array[self::PDF]];
	
			$tmp_entity->insert($this->login_user->user_code);
		}
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_init_relation_data()
	 */
	protected function _init_relation_data()
	{
		parent::_init_relation_data();

//		$this->site_type_list = array_flip($this->Kubun_logic->get_common_kubun_list_checkbox(Kubun_type::SITE_TYPE));
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
	 * 区分の変換
	 * 
	 * @param unknown_type $label
	 * @param unknown_type $value
	 * @param unknown_type $key_value_list
	 * @param unknown_type $line
	 * @throws Exception
	 */
	private function _convert_like_match_kubun($label, $value, $key_value_list, $line)
	{
		$value = trim($value);

		foreach ($key_value_list as $label_key => $code_value)
		{
			if (strpos($value, $label_key) !== FALSE)
			{
				return $code_value;
			}
			else if (is_blank($value))
			{
				return $key_value_list['Web'];
			}
			else if (strpos($value, '大阪市') !== FALSE)
			{
				return $key_value_list['大阪府'];
			}
		}

		$this->warning_list["{$label}［{$value}］"] = '不足';

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
	private function _convert_prefecture($line)
	{
		$value = $line[$this->index_array[self::F_PLACE]];

		$key_value_list = $this->prefecture_code_list;

		return $this->_convert_like_match_kubun('都道府県', $value, $key_value_list, $line);
	}

	/**
	 * 
	 * 
	 * @param unknown_type $line
	 */
	private function _convert_area($line)
	{
		/*
		 * まず県の区分コードを取得する。
		 */

		$value = $line[$this->index_array[self::F_PLACE]];
		$pref_kubun_id = $this->_convert_like_match_kubun('都道府県', $value, $this->prefecture_code_list, $line);

		
		$key_value_list = $this->area_list;
		
		//区分IDから区分コードに変換。
		$pref_kubun_code = $this->M_kubun->convert_id_to_kubun_code(Relation_data_type::COMMON, Kubun_type::PREFECTURE, $pref_kubun_id);

		$value = "";

		switch ($pref_kubun_code) {
			case 1:
				$value =  '北海道';
				break;
			case 2:
			case 3:
			case 4:
			case 5:
			case 6:
			case 7:
				$value =  '東北地方';
				break;
			case 8:
			case 9:
			case 10:
			case 11:
			case 12:
			case 13:
			case 14:
				$value =  '関東地方';
				break;
			case 15:
			case 16:
			case 17:
			case 18:
			case 19:
			case 20:
			case 21:
			case 22:
			case 23:
				$value =  '中部地方';
				break;
			case 24:
			case 25:
			case 26:
			case 27:
			case 28:
			case 29:
			case 30:
				$value =  '近畿地方';
				break;
			case 31:
			case 32:
			case 33:
			case 34:
			case 35:
				$value =  '中国地方';
				break;
			case 36:
			case 37:
			case 38:
			case 39:
				$value =  '四国地方';
				break;
			case 40:
			case 41:
			case 42:
			case 43:
			case 44:
			case 45:
			case 46:
			case 47:
				$value =  '九州地方';
				break;
			case 48:
				$value =  'WEBショップ';
				break;

			default:

			break;
		}

		if ($this->_convert_kubun('エリア', $value, $key_value_list, $line) == NULL)
		{
			echo $pref_kubun_id;
			exit;
		}
		
		$key_value_list = $this->area_list;
		return $this->_convert_kubun('エリア', $value, $key_value_list, $line);
	}

	/**
	 * GoogleマップAPIを使用して緯度経度を取得する。
	 * 
	 * @param unknown_type $place
	 */
	private function _get_map($place)
	{
		$zoom = 16;

		$address = $place;
		$req = 'http://maps.google.com/maps/api/geocode/xml';
		$req .= '?address='.urlencode($address);
		$req .= '&sensor=false';
		
		$xml = simplexml_load_file($req) or die('XML parsing error');
		
		$ret = array();
		
		if ($xml->status == 'OK') {
		  $location = $xml->result->geometry->location;
		  $ret['latitude'] = $location->lat;
		  $ret['longitude'] = $location->lng;
		}

		return $ret;
	}
}