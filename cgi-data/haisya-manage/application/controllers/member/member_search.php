<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 会員の検索を行うクラス
 * @author ta-ando
 *
 */
class Member_search extends Post_search_Controller 
{
	const F_COND_MEMBER_TYPE = 'cond_member_type';

	/*
	 * コンストラクタ
	 */
	public function __construct()
	{
		parent::__construct();

		/*
		 * 画面に固有の情報をセット
		 */

		$this->target_data_type = Relation_data_type::MEMBER;
		$this->package_name = 'member';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}検索";
		$this->page_type = Page_type::SEARCH;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_member;
		$this->sub_model = FALSE;
		$this->delete_model = $this->M_member;
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

		//関係テーブルのデータをDBからの呼び出す
		$this->_init_relation_data();

		//HTTPのGET,POST情報を$this->dataに移送
		$this->_httpinput_to_data();
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

		$ret = $this->_do_search($page, $this->max_list);
		$this->list = $this->_convert_list($ret);

		$this->_load_tpl($this->_get_view_name(View_type::SEARCH), $this->data);
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
		$params['member_type'] = $this->data[self::F_COND_MEMBER_TYPE];

		return $params;
	}

	/**
	 * (non-PHPdoc)
	 * @see Post_search_Controller::_convert_for_csv()
	 */
	protected function _convert_for_csv($list)
	{
		$ret_array = parent::_convert_for_csv($list);

		/*
		 * ヘッダーに独自項目を追加
		 */

		$header = $ret_array['header'];

		$header[] = '会員種別';
		$header[] = 'メールアドレス';
		$header[] = '氏名';
		$header[] = 'フリガナ';
		$header[] = '電話番号';
		$header[] = 'FAX番号';
		$header[] = '企業・団体';
		$header[] = '役職等';
		$header[] = '住所';

		/*
		 * コンテンツ部分に独自項目を追加
		 */

		$parent_content_list = $ret_array['content'];

		$content = array();

		//リスト数と親メソッドから取得したコンテンツ数は一致する仕様なので取得した項目に追加する。
		for ($i = 0; $i < count($list); $i++)
		{
			if ( ! isset($parent_content_list[$i]))
			{
				continue;
			}

			$entity = $list[$i];
			$tmp = $parent_content_list[$i];

			$tmp[] = Member_type::get_label($entity->member_type);
			$tmp[] = $entity->email;
			$tmp[] = $entity->name;
			$tmp[] = $entity->furigana;
			$tmp[] = $entity->phone_number;
			$tmp[] = $entity->fax_number;
			$tmp[] = $entity->company_name;
			$tmp[] = $entity->position;
			$tmp[] = $entity->place;
			$content[] = $tmp;
		}

		$ret = array();
		$ret['header'] = $header;
		$ret['content'] = $content;

		return $ret;
	}
}