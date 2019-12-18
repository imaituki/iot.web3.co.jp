<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 区分値の一覧表示を行うクラス
 * * @author ta-ando
 *
 */
class Kubun_search extends Search_Controller 
{
	/**
	 * コンストラクタ
	 * ・画面に固有の情報をセット
	 */
	public function __construct()
	{
		parent::__construct();
		// これ以降にコードを書いていく

		/*
		 * 画面に固有の情報をセット
		 */

		$this->package_name = 'kubun_annual';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}一覧";
		$this->page_type = Page_type::SEARCH;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_kubun;
		$this->sub_model = FALSE;
		$this->delete_model = $this->M_kubun;
		$this->_page_setting('kubun');

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//ソート可能なカラム
		$this->valid_sort_key = array(
			'id',
		);

		//独自のソート順
		$this->first_sort_key = 'order_number';
		$this->first_sort_order = 'ASC';
		$this->second_sort_key = 'kubun_code';
		$this->second_sort_order = 'ASC';

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
		$this->_do_delete($id, FALSE);
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
	 * SQLで使用する検索条件を作成して取得する。
	 * 共通に使用される項目は親クラスで設定している。
	 */
	protected function _get_condition_params()
	{
		$params = parent::_get_condition_params();

		$params['kubun_relation_data_type'] = Relation_data_type::COMMON;
		$params['kubun_type'] = Kubun_type::ANNUAL_CODE;

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

		$kubun_id_list = $this->M_kubun->get_for_dropdown_for_manage();

		foreach ($arraylist as $tmp)
		{
			$tmp['parent_kubun_id_label'] = ($tmp['parent_kubun_id'] != 0)
			                                ? $kubun_id_list[$tmp['parent_kubun_id']]
			                                : '--';
			$ret[] = $tmp;
		}

		return $ret;
	}
}