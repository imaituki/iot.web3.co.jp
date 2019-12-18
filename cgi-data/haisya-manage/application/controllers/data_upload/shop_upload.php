<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 店舗の一括アップロード
 * * @author ta-ando
 *
 */
class Shop_upload extends Register_Controller
{
	/** CSVのインデックス用定数 */
	const HEADER_LINE_END = 1;
	const INDEX_MAX = 5;

	const F_MANAGEMENT_CODE = 'management_code';  // 管理コード
	const F_POST_TITLE = 'post_title';  // 記事タイトル
	const F_POST_SUB_TITLE = 'post_sub_title';  // 記事サブタイトル
	const F_POST_CONTENT = 'post_content';  // 記事本文
	const F_POST_LINK = 'post_link';  // リンク
	
	const F_AREA = 'area';  // エリア
	const F_PLACE = 'place';  // 住所
	const F_PLACE2 = 'place2';  // 住所2
	const F_PHONE_NUMBER = 'phone_number';  // TEL
	const F_PREFECTURE_CODE = 'prefecture_code';  // 都道府県
	const F_SITE_TYPE = 'site_type';  // 表示サイト
	const F_LATITUDE = 'latitude';  // 緯度
	const F_LONGITUDE = 'longitude';  // 経度
	
	const F_PASSWORD = 'password';
	const F_COMPANY_NAME = 'company_name';
	const F_NAME = 'name';
	const F_FURIGANA = 'furigana';
	const F_POSITION = 'position';
	const F_EMAIL = 'email';

	const SITE_TYPE_MEINHEIM = 'site_type_meinheim';
	const SITE_TYPE_FABRIQ_REPORT = 'site_type_fabriq_report';

	var $area_list;  // エリア用の選択項目リスト
	var $prefecture_code_list;  // 都道府県用の選択項目リスト
	var $site_type_list;  // 表示サイト用の選択項目リスト
	
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
		self::F_MANAGEMENT_CODE,
		self::F_POST_TITLE,
		self::F_POST_SUB_TITLE,
		self::F_AREA,
		'aa',
		self::F_PLACE,
		self::F_PLACE2,
		self::F_PHONE_NUMBER,
		self::F_POST_LINK,
		self::SITE_TYPE_FABRIQ_REPORT,
		self::SITE_TYPE_MEINHEIM,
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

		$this->target_data_type = Relation_data_type::SHOP;
		$this->package_name = 'data_upload';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "店舗の一括登録";
		$this->page_type = Page_type::REGISTER;
		$this->current_main_menu = $this->package_name;
		$this->current_sub_menu = "member_upload";
		$this->main_model = $this->M_shop;

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
		$this->_load_tpl("data_upload/shop_upload_input_view", $this->data);
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
		$csv_file_path = APPPATH."/controllers/data_upload/csv/shop_list.csv";

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
		$entity = new M_shop();
		$entity->relation_data_type = Relation_data_type::COMMON;
		$entity->relation_data_id = Relation_data_id::DEFAULT_ID;
		$entity->data_type = Relation_data_type::SHOP;
		$entity->draft_flg = Draft_flg::NOT_DRAFT;
		$entity->del_flg = Del_flg::NOT_DELETE;

		$entity->post_title = $line[$this->index_array[self::F_POST_TITLE]];
		$entity->post_sub_title = $line[$this->index_array[self::F_POST_SUB_TITLE]];
		$entity->management_code = $line[$this->index_array[self::F_MANAGEMENT_CODE]];
		$entity->phone_number = $line[$this->index_array[self::F_PHONE_NUMBER]];

		$entity->place = $line[$this->index_array[self::F_PLACE]];
		$entity->place2 = $line[$this->index_array[self::F_PLACE2]];
		$entity->post_link =$line[$this->index_array[self::F_POST_LINK]]; 

		$entity->area = $this->_convert_area($line);
		$entity->prefecture_code = $this->_convert_prefecture($line);
		
		$entity->order_number = 50;
		$entity->post_date = create_db_datetme_str(date('Y/m/d'));

		$map_info = $this->_get_map($line[$this->index_array[self::F_PLACE]]);
		if (isset($map_info['latitude']) && isset($map_info['longitude']))
		{
			$entity->latitude = (float)$map_info['latitude'];
			$entity->longitude = (float)$map_info['longitude'];
		}

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
	private function _insert_shohp_relation($line, $shop_id)
	{
		/*
		 * 表示サイト
		 */

		$site_types = array();

		if ($line[$this->index_array[self::SITE_TYPE_FABRIQ_REPORT]] == '●')
		{
			$site_types[] = $this->site_type_list['FABRIQ REPORT'];
		}

		if ($line[$this->index_array[self::SITE_TYPE_MEINHEIM]] == '●')
		{
			$site_types[] = $this->site_type_list['MEINHEIM'];
		}

		if ( ! empty($site_types))
		{
			$this->T_relation->delete_insert_list(
                       Relation_data_type::SHOP,
                       $shop_id,
                       Relation_data_type::KUBUN,
                       Kubun_type::SITE_TYPE,
                       create_array_param($site_types)
                   );
		}

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
	 * (non-PHPdoc)
	 * @see Register_Controller::_init_relation_data()
	 */
	protected function _init_relation_data()
	{
		parent::_init_relation_data();

		$this->site_type_list = array_flip($this->Kubun_logic->get_common_kubun_list_checkbox(Kubun_type::SITE_TYPE));
		$this->area_list = array_flip($this->Kubun_logic->get_common_kubun_list_dropdown(Kubun_type::AREA, '選択してください'));
		$this->prefecture_code_list = array_flip($this->Kubun_logic->get_common_kubun_list_dropdown(Kubun_type::PREFECTURE, '選択してください'));
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