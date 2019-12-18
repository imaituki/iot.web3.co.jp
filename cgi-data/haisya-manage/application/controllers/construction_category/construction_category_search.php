<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * クラスの検索を行うクラス
 * * @author ta-ando
 *
 */
class Construction_category_search extends Search_Controller 
{
	/** フォームで使用するパラメータ名 */
	const F_COND_CONSTRUCTION_CATEGORY_CODE = 'cond_construction_category_code';
	const F_COND_CONSTRUCTION_CATEGORY_NAME = 'cond_construction_category_name';

	/*
	 * コンストラクタ
	 */
	public function __construct()
	{
		parent::__construct();

		/*
		 * 画面に固有の情報をセット
		 */

		//$this->target_data_type = Relation_data_type::INFO;
		//$this->target_post_type = Post_type::INFO;
		$this->package_name = 'construction_category';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}検索";
		$this->page_type = Page_type::SEARCH;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->M_construction_category;
		$this->sub_model = FALSE;
		$this->delete_model = $this->M_construction_category;
		$this->_page_setting();

		//設定ファイルから画面の設定を読み込む処理。
		$this->_config_setting();

		//ソート可能なカラム
		$this->valid_sort_key = array(
			'construction_category_code',
			'construction_category_name',
		);

		//独自のソート順
		$this->first_sort_key = 'id';
		$this->first_sort_order = 'ASC';

		/*
		 * この機能に必要な情報がセッションに保持されているか確認する
		 */

		if ( ! $this->application_session_data->can_access_package($this->package_name))
		{
			show_error('不正な画面遷移が行われています。再度メニューから操作を行ってください。');
		}

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
	 * データの物理削除を行う。
	 * ※DB更新を行うため、完了画面へリダイレクトする。
	 */
	function delete($id = '')
	{
		//必須情報が不足している場合は完了画面Viewにエラーを表示
		if (is_blank($id))
		{
			$this->error_list['delete'] = 'IDを指定してください';
			$this->_load_tpl($this->_get_view_name(View_type::COMPLETE), $this->data);
			return;
		}

		/*
		 * 論理削除処理
		 */

        $entity->id = $id;
        $entity->del_flg = Del_flg::DELETE;

		$this->db->trans_start();
		//$this->M_construction_category->delete($id);
		$this->main_model->update($this->login_user->user_code, $entity);

		$this->db->trans_complete();

		//完了画面表示用メソッドへリダイレクト
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
	public function csv()
	{
		//検索に必要な情報を作成
		$params = $this->_get_construction_category_condition_params();

        $page = 1; $max = FALSE;
		$nds_pagination = $this->_create_pagination($max, $page);
		$search_list = $this->_do_search_for_manage($this->main_model, $nds_pagination, $params);
		$ret_array = $this->Csv_logic->convert_for_csv($search_list, $this->package_name);

		$this->_do_download_csv(
		           "{$this->package_name}_".date('YmdHis').".csv",
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
		$params = $this->_get_construction_category_condition_params();
		$nds_pagination = $this->_create_pagination($max, $page);

		return $this->_do_search_for_manage($this->main_model, $nds_pagination, $params);
	}

	/**
	 * SQLで使用する検索条件を作成して取得する。
	 * 他の機能との互換性がないので親クラスの_get_condition_params()は使用しない
	 */
	private function _get_construction_category_condition_params()
	{
		$params = array();
		$params['construction_category_code'] =  $this->data[self::F_COND_CONSTRUCTION_CATEGORY_CODE];
		$params['construction_category_name'] =  $this->data[self::F_COND_CONSTRUCTION_CATEGORY_NAME];

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

		foreach ($arraylist as $tmp)
		{
			$ret[] = $tmp;
		}

		return $ret;
	}
}
