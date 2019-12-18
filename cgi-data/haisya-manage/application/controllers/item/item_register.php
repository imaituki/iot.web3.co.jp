<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 製品登録を行うクラス
 * @author ta-ando
 *
 */
class Item_register extends Post_register_Controller 
{
	const F_PARENT_CATEGORY_IDS = 'parent_category_ids';  // カテゴリー2
	const F_OTHER_ATTRIBUTE_IDS = 'other_attribute_ids';  // 属性
	const F_TECHNOLOGY_IDS = 'technology_ids';  // 技術
	const F_DOWNLOAD_LIMITED_KUBUN_IDS = 'download_limited_kubun_ids';  // 特別会員限定ダウンロードコンテンツ

	const ITEM_SELECT = 'item_select';

	//製品選択の最大数
	var $item_select_max = 5;

	/* パラメータの追加があればここに記述 */

	var $access_count;  // アクセス数

	//key=>valueリスト
	var $item_list;
	var $download_file_category_list;
	var $other_attribute_list;

	var $technology_list;

	//確認画面で使用する親子関係を保持したラベルを保持する変数
	var $parent_children_label_list;

	//ソート順
	var $order_number_list = array(
		'10' => '10（最優先）',
		'9' => '9',
		'8' => '8',
		'7' => '7',
		'6' => '6',
		'5' => '5 (初期値)',
		'4' => '4',
		'3' => '3',
		'2' => '2',
		'1' => '1',
	);

	/**
	 * コンストラクタ
	 * ・画面独自のライブラリ、ヘルパなどの読み込み
	 * ・画面で使用する変数情報をセット
	 */
	public function __construct()
	{
		parent::__construct();

		/*
		 * 画面に固有の情報をセット
		 */

		$this->target_data_type = Relation_data_type::ITEM;
		$this->package_name = 'item';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}登録";
		$this->page_type = Page_type::REGISTER;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_item;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//ネストする複数項目の宣言と初期化
		$this->_create_optional_form_key();
		$this->_init_optional_form_key();

		//関係テーブルのデータをDBからの呼び出す
		$this->_init_relation_data();

		/*
		 * この機能に必要な情報がセッションに保持されているか確認する。
		 */

		if ( ! $this->application_session_data->can_access_package($this->package_name))
		{
			show_error('不正な画面遷移が行われています。再度メニューから操作を行ってください。');
		}

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);
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
		$this->_do_db_logic();

		//完了画面表示用メソッドへリダイレクト
		redirect($this->_get_redirect_url_complete(), 'location', 301);
	}

	/**
	 * 完了画面を表示する
	 */
	function complete()
	{
		//新しく取得したIDだけセッションから消さないように退避
		$post_id = $this->_get_page_session(self::POST_ID);
		$this->data[self::POST_ID] = $post_id;

		//セッションデータを削除
		$this->_unset_page_session();

		//再びセッションに保持
		$this->_save_page_session(self::POST_ID, $post_id);

		$this->_load_tpl($this->_get_view_name(View_type::COMPLETE), $this->data);
	}

	/**
	 * ファイルのアップロードを行い入力画面を表示する
	 */
	function upload_image()
	{
		$this->_upload_image();
		$this->_load_tpl($this->_get_view_name(View_type::INPUT), $this->data);
	}

	/**
	 * アップロードしたファイルの削除を行い、入力画面を表示する
	 */
	function delete_image()
	{
		$this->_delete_image();
		$this->_load_tpl($this->_get_view_name(View_type::INPUT), $this->data);
	}

	/**
	 * 入力チェックを行う。
	 */
	private function _input_check()
	{
		parent::_basic_input_check();

		//$this->form_validation->set_rules(self::F_ATTRIBUTE_IDS, '属性', 'max_length[200]');
		//$this->form_validation->set_rules(self::F_ACCESS_COUNT, 'アクセス数', 'max_length[200]');

		/* 入力チェックの追加があればここに記述 */

		for ($i=1; $i <= $this->item_select_max; $i++)
		{
			$this->form_validation->set_rules("related_item_id_{$i}", "製品の指定", 'integer');
		}

		return $this->form_validation->run();
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

		$main_entity = $this->_set_main_table_column_for_insert($session_var);
		$post_id = $this->_insert_main_table($main_entity, $session_var);

		/*
		 * 関連テーブルの更新処理
		 */

		$this->_delete_insert_relation($session_var, $post_id);
		$this->_insert_file($session_var, $post_id);

		/*
		 * データと同時に必要なデータ、フォルダなどを作成する。
		 */

		$this->_create_default_data($post_id);

		//セッションに保持
		$this->_save_page_session(self::POST_ID, $post_id);

		$this->db->trans_complete();
	}

	/**
	 * データと同時に作成する必要のあるデータ、フォルダを作成する。
	 * 
	 * @param unknown_type $post_id
	 */
	private function _create_default_data($post_id)
	{
		//断面図用のダウンロードフォルダを作成する
		//$this->_get_item_file_dir(
		//           $post_id, 
		//           'item_cutaway'
		//       );
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_config_setting()
	 */
	protected function _config_setting()
	{
		parent::_config_setting();

		$this->item_select_max = config_item("{$this->package_name}_item_select_max");
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_create_optional_form_key()
	 */
	protected function _create_optional_form_key()
	{
		parent::_create_optional_form_key();

		$this->optional_keys = array_merge(
			$this->optional_keys,
			$this->_create_modal_result_form_key($this->item_select_max)
		);
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_relation_check()
	 */
	protected function _relation_check()
	{
		$ret = parent::_relation_check();

		//製品の存在チェック
		for ($i=1; $i <= $this->item_select_max; $i++)
		{
			if (is_not_blank($this->data["related_item_id_{$i}"]))
			{
				$item = $this->M_item->find_with_relation_id(
				                           $this->data["related_item_id_{$i}"],
				                           $this->application_session_data->get_relation_data_type('item'),
				                           $this->application_session_data->get_relation_data_id('item')
				                       );
	  
				if ( ! $item)
				{
					$this->error_list["related_item_id_{$i}"] = 'データが存在していません';
					$ret = FALSE;
				}
			}
		}

		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_init_relation_data()
	 */
	protected function _init_relation_data()
	{
		parent::_init_relation_data();

		$this->item_list =  $this->Item_logic->get_for_dropdown();
		
		// 基本カテゴリーの情報を上書きする。親カテゴリーと子カテゴリーの関係を配列で取得する。
		$this->basic_category_list = $this->M_kubun->get_parent_child_list(
		                                                 $this->target_data_type,
		                                                 Kubun_type::PARENT_CATEGORY,
		                                                 Kubun_type::CATEGORY
		                                             );

		// ダウンロードファイルの種類を取得（チェックボックス用）
		$this->download_file_category_list = $this->M_kubun->get_key_value_list(
		                                                         Relation_data_type::ITEM_DOWNLOAD,
		                                                         Kubun_type::CATEGORY
		                                                     );

		$this->other_attribute_list = $this->M_kubun->get_key_value_list(
		                                                  $this->target_data_type,
		                                                  Kubun_type::OTHER_ATTRIBUTE
		                                              );

		$this->technology_list = $this->M_kubun->get_key_value_list(
		                                             $this->target_data_type,
		                                             Kubun_type::TECHNOLOGY
		                                         );
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_register_Controller::_set_default_form_value()
	 */
	protected function _set_default_form_value()
	{
		parent::_set_default_form_value();

		/*
		 * この機能独自の設定がある場合は以降に記述する
		 */

		$this->data[self::F_ORDER_NUMBER] = 5;
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_convert_label()
	 */
	protected function _convert_label()
	{
		parent::_convert_label();

		//ダウンロードファイルのカテゴリー
		$this->label_list[self::F_DOWNLOAD_LIMITED_KUBUN_IDS] = $this->M_kubun->get_joined_label(
		                                                                            Relation_data_type::ITEM_DOWNLOAD,
		                                                                            Kubun_type::CATEGORY,
		                                                                            $this->data[self::F_DOWNLOAD_LIMITED_KUBUN_IDS]
		                                                                        );

		$this->label_list[self::F_OTHER_ATTRIBUTE_IDS] = $this->M_kubun->get_joined_label(
		                                                                     $this->target_data_type,
		                                                                     Kubun_type::OTHER_ATTRIBUTE,
		                                                                     $this->data[self::F_OTHER_ATTRIBUTE_IDS]
		                                                                 );

		$this->label_list[self::F_TECHNOLOGY_IDS] = $this->M_kubun->get_joined_label(
		                                                                $this->target_data_type,
		                                                                Kubun_type::TECHNOLOGY,
		                                                                $this->data[self::F_TECHNOLOGY_IDS]
		                                                            );

		$this->parent_children_label_list = $this->M_kubun->get_parent_child_labels(
		                                                        $this->target_data_type,
		                                                        Kubun_type::PARENT_CATEGORY,
		                                                        Kubun_type::CATEGORY,
		                                                        $this->data[parent::F_BASIC_CATEGORY_IDS]
		                                                    );

		/*
		 * 製品の選択
		 */

		$labels = array();

		for ($i=1; $i <= $this->item_select_max; $i++)
		{
			if (is_not_blank($this->data["related_item_id_{$i}"]))
			{
				$labels[] = "「{$this->Item_logic->get_name($this->data["related_item_id_{$i}"])}」";
			}
		}

		$this->label_list[self::ITEM_SELECT] = implode(', ', $labels);
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_delete_insert_relation()
	 */
	protected function _delete_insert_relation($session_var, $post_id)
	{
		parent::_delete_insert_relation($session_var, $post_id);

		//ダウンロードファイルのカテゴリーをDELETE/INSERT
		$this->T_relation->delete_insert_list(
		                       $this->target_data_type,
		                       $post_id,
		                       Relation_data_type::KUBUN,
		                       Kubun_type::LIMITED_DOWNLOAD_FILE,
		                       create_array_param($session_var[self::F_DOWNLOAD_LIMITED_KUBUN_IDS])
		                   );

		$this->T_relation->delete_insert_list(
		                       $this->target_data_type,
		                       $post_id,
		                       Relation_data_type::KUBUN,
		                       Kubun_type::OTHER_ATTRIBUTE,
		                       create_array_param($session_var[self::F_OTHER_ATTRIBUTE_IDS])
		                   );

		$this->T_relation->delete_insert_list(
		                       $this->target_data_type,
		                       $post_id,
		                       Relation_data_type::KUBUN,
		                       Kubun_type::TECHNOLOGY,
		                       create_array_param($session_var[self::F_TECHNOLOGY_IDS])
		                   );

		/*
		 * 製品
		 */

		$item_ids = array();

		for ($i=1; $i <= $this->item_select_max; $i++)
		{
			if (is_not_blank($session_var["related_item_id_{$i}"]))
			{
				$item_ids[] = $session_var["related_item_id_{$i}"];
			}
		}

		$this->T_relation->delete_insert_list(
	                       $this->target_data_type,
	                       $post_id,
	                       Relation_data_type::KUBUN,
	                       Kubun_type::ITEM,
	                       create_array_param($item_ids)
	                   );
	}
}