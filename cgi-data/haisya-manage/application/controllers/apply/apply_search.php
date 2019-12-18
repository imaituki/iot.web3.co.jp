<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 応募の検索を行うクラス
 * * @author ta-ando
 *
 */
class Apply_search extends Post_search_Controller 
{
	const EVENT_ID = 'event_id';
	var $event_id;
	var $apply_total;

	/*
	 * コンストラクタ
	 */
	public function __construct()
	{
		parent::__construct();

		/*
		 * 画面に固有の情報をセット
		 */

		$this->target_data_type = Relation_data_type::APPLY;
		$this->package_name = 'apply';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}一覧";
		$this->page_type = Page_type::SEARCH;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->T_apply;
		$this->sub_model = FALSE;
		$this->delete_model = $this->T_apply;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//ソート可能なカラム
		$this->valid_sort_key = array(
			'id',
			'post_date',
			'post_title',
			'draft_flg',
		);

		//独自のソート順
		$this->first_sort_key = 'post_date';
		$this->first_sort_order = 'DESC';

		/*
		 * この機能に必要な情報がセッションに保持されているか確認する
		 */

		if ( ! $this->application_session_data->can_access_package($this->package_name))
		{
			show_error('不正な画面遷移が行われています。再度メニューから操作を行ってください。');
		}

		if ( ! $this->_is_method_match())
		{
			$this->event_id = $this->_get_page_session(self::EVENT_ID);

			if ( ! $this->event_id)
			{
				show_error("イベントが指定されていません。");
			}
		}

		//関係テーブルのデータをDBからの呼び出す
		$this->_init_relation_data();

		//HTTPのGET,POST情報を$this->dataに移送
		$this->_httpinput_to_data();
	}

	/**
	 * 初期表示を行う。
	 */
	public function index($event_id)
	{
		$this->_unset_page_session();

		if ( ! $this->T_info->find($event_id))
		{
			show_error("イベントが選択されていません。");
		}

		$this->_save_page_session(self::EVENT_ID, $event_id);
		$this->event_id = $event_id;

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

		$this->apply_total = $this->_count_apply();

		$this->_load_tpl($this->_get_view_name(View_type::SEARCH), $this->data);
	}

	/**
	 * カウントする
	 */
	private function _count_apply()
	{
		$params = array();
		$params['relation_data_type'] = Relation_data_type::INFO;
		$params['relation_data_id'] = $this->_get_page_session(self::EVENT_ID);

		return $this->main_model->select_for_manage(new Nds_pagination(FALSE), $params, TRUE);
	}
	
	/**
	 * 削除ボタン押下時の処理を行う。
	 * ※DB更新を行うため、完了画面へリダイレクトする。
	 */
	function delete($id = '')
	{
		$this->_do_delete($id);
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
		$params = $this->_get_condition_params();
		$nds_pagination = $this->_create_pagination($max, $page);

		return $this->_do_search_for_manage($this->main_model, $nds_pagination, $params);
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
			//カテゴリー
			$tmp['basic_category_label'] = $this->_get_basic_category_label($tmp['id']);

			$ret[] = $tmp;
		}

		return $ret;
	}

	/**
	 * (non-PHPdoc)
	 * @see Search_Controller::_get_condition_params()
	 */
	protected function _get_condition_params()
	{
		$params = parent::_get_condition_params();

		$params['relation_data_type'] = Relation_data_type::INFO;
		$params['relation_data_id'] = $this->event_id;

		return $params;
	}

	/**
	 * 指定された条件でCSVで出力する
	 */
	public function download_csv()
	{
		//ソート順を変更
		$this->first_sort_key = 'post_date';
		$this->first_sort_order = 'ASC';
		$this->second_sort_key = 'id';
		$this->second_sort_order = 'ASC';

		$search_list = $this->_do_search(1);
		$ret_array = $this->_convert_for_csv($search_list);

		$this->_do_download_csv(
		           "{$this->package_label}.csv",
		           $ret_array['header'],
		           $ret_array['content']
		       );
	}

	/**
	 * (non-PHPdoc)
	 * ※オーバーロードし、親クラスのメソッドは使用せず隠蔽する。
	 * @see Post_search_Controller::_convert_for_csv()
	 */
	protected function _convert_for_csv($list)
	{
		/*
		 * ヘッダを作成
		 */

		$header = array(
			'応募ID',
			'応募日',
		);

		$ret = array();

		$event_id = $this->event_id;
		$event_entity = $this->T_info->find($this->event_id);
		
		
		/*
		 * メールフォーム情報
		 */

		$free_form = $this->T_free_form->find($event_entity->free_form_id);

		/*
		 * 基本項目の情報を取得し、ヘッダとソート順を保持
		 */

		$basic_detail_list = $this->T_free_form_item->find_list_by_form_id($free_form->id, Mail_form_type::BASIC);

		$basic_column_no_list = array();

		//基本項目部分のヘッダを取得
		foreach ($basic_detail_list as $detail_entity)
		{
			if ($detail_entity->valid_flg === Valid_flg::VALID)
			{
				$header[] = $detail_entity->title;
				$basic_column_no_list[] = $detail_entity->column_no;
			}
		}

		/*
		 * 追加項目の情報を取得し、ヘッダとソート順を保持
		 */

		$option_detail_list = $this->T_free_form_item->find_list_by_form_id($free_form->id, Mail_form_type::OPTION);

		$option_column_no_list = array();

		//追加項目部分のヘッダを取得
		foreach ($option_detail_list as $detail_entity)
		{
			if ($detail_entity->valid_flg === Valid_flg::VALID)
			{
				$header[] = $detail_entity->title;
				$option_column_no_list[] = $detail_entity->column_no;
			}
		}

		/*
		 * コンテンツ部分に独自項目を追加
		 */

		$content = array();

		//CSVの1行にあたる申し込み者でループ
		foreach ($list as $entity)
		{
			$content[] = $this->_create_line($entity, $basic_column_no_list, $option_column_no_list);
		}

		$ret = array();
		$ret['header'] = $header;
		$ret['content'] = $content;

		return $ret;
	}

	/**
	 * CSVの1行分の配列を作成する。
	 * 
	 * @param unknown_type $entity
	 * @param unknown_type $basic_column_no_list
	 * @param unknown_type $option_column_no_list
	 */
	private function _create_line($entity, $basic_column_no_list, $option_column_no_list)
	{
		$tmp = array(); 
		$tmp[] = $entity->id;
		$tmp[] = format_date_to_pattern($entity->post_date);

		//基本項目
		foreach ($basic_column_no_list as $column_no)
		{
			switch ($column_no)
			{
				case Mail_form_column::NAME:
					$tmp[] = $entity->name;
					break;
				case Mail_form_column::FURIGANA:
					$tmp[] = $entity->furigana;
					break;
				case Mail_form_column::COMPANY:
					$tmp[] = $entity->company_name;
					break;
				case Mail_form_column::MAIL:
					$tmp[] = $entity->email;
					break;
				case Mail_form_column::PHONE:
					$tmp[] = $entity->phone_number;
					break;
				case Mail_form_column::POSTAL_CODE:
					$tmp[] = create_postal_code_label($entity->postal_code1, $entity->postal_code2);
					break;
				case Mail_form_column::PLACE:
					$tmp[] = $entity->place;
					break;
				case Mail_form_column::POSITION:
					$tmp[] = $entity->position;
					break;
				case Mail_form_column::OTHER_INQUIRY:
					$tmp[] = $entity->other_inquiry;
					break;
				default:
					break;
			}
		}

		//追加項目
		foreach ($option_column_no_list as $column_no)
		{
			$db_column = "optional_form{$column_no}";
			$tmp[] = $entity->$db_column;
		}

		return $tmp;
	}
}