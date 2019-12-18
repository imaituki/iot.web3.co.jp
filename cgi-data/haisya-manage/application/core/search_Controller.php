<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 検索画面固有の親Controller
 * ※このクラスがロードされるのはcore/MY_Controller.phpのファイル一番下のrequire_once
 * @author ta-ando
 *
 */
class Search_Controller extends Common_Controller
{
	/** フォームで使用するパラメータ名 */
	const F_COND_ID = 'cond_id';
	const F_COND_KEYWORD = 'cond_keyword';
	const F_COND_DRAFT_FLG = 'cond_draft_flg';

	/** フォームから取得するパラメータ(ソート用) */
	const F_COND_SORT_KEY='cond_sort_key';
	const F_COND_SORT_ORDER='cond_sort_order';

	/** フォームで使用するパラメータ名 */
	const F_COND_BASIC_CATEGORY_IDS = 'cond_basic_category_ids';

	/** 検索結果を保持する変数 */
	var $list;

	var $valid_sort_key = array();

	/** 検索画面で削除に使用するモデル。検索にViewを使用する画面などmain_modelと削除対象が異なる場合を想定して分けている。 */
	var $delete_model;

	/** ソート条件 */
	var $first_sort_key = 'id';
	var $first_sort_order = 'DESC';
	var $second_sort_key = 'id';
	var $second_sort_order = 'DESC';
	var $third_sort_key = 'update_datetime';
	var $third_sort_order = 'DESC';
	var $fourth_sort_key = 'update_datetime';
	var $fourth_sort_order = 'DESC';

	/*
	 * コンストラクタ
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * nds_system_manage_config.phpに記述されているページ用の設定を読み込みます。
	 */
	protected function _config_setting()
	{
		//検索結果の最大件数
		$this->max_list = config_item("{$this->package_name}_max_list");

		//基本カテゴリーの使用有無
		$this->basic_category_use = config_item("{$this->package_name}_basic_category_use");
		$this->label_basic_category = config_item("{$this->package_name}_label_basic_category");
		$this->label_keyword_search_condition = config_item("{$this->package_name}_label_keyword_search_condition");
	}

	/**
	 * 関係テーブルのデータをDBから読み取り画面のメンバに保持する。
	 */
	protected function _init_relation_data()
	{
		// カテゴリーを取得（ドロップダウン用）
		$this->basic_category_list = $this->M_kubun->get_for_dropdown(
		                                           $this->target_data_type, 
		                                           Kubun_type::CATEGORY
		                                       );
	}

	/**
	 * ソートキーを取得する
	 * 
	 * @param unknown_type $default_key
	 */
	protected function _get_sort_key($default_key)
	{
		return in_array($this->data[self::F_COND_SORT_KEY], $this->valid_sort_key) 
		       ? $this->data[self::F_COND_SORT_KEY]
		       : $default_key;
	}

	/**
	 * ソート順を取得する
	 * 
	 * @param unknown_type $default_key
	 */
	protected function _get_sort_order($default_order)
	{
		$order = strtoupper($this->data[self::F_COND_SORT_ORDER]);

		return ($order === 'ASC' or $order === 'DESC') 
		       ? $order 
		       : $default_order;
	}


	/**
	 * ・検索条件をページングのURL生成用に作成する。
	 * ・別画面から戻る場合のためにセッションに保持する。この場合はページ数も保持が必要
	 *
	 * @param unknown_type $page
	 */
	protected function _create_and_save_condition($page)
	{
		//GETリクエストで全ての検索条件をリンクに追加するための文字列を作成する。
		$condition_list = $this->_create_condition_list();
		$this->get_query = http_build_query($condition_list);

		//再検索で使用するために検索条件をセッションに保持する。
		$condition_list['page'] = $page;
		$this->_save_page_session(parent::SESSION_KEY_SERCH_COND_DATA, $condition_list);
	}

	/**
	 * SELECT時に使用するページング情報を生成する。
	 * 画面で1つのSELECTを行う場合を想定している。
	 * 
	 * @param unknown_type $max
	 * @param unknown_type $page
	 */
	protected function _create_pagination($max, $page)
	{
		/*
		 * ページング情報を生成
		 */

		$nds_pagination = new Nds_pagination($max, $page);
		$nds_pagination->add_order($this->_get_sort_key($this->first_sort_key), $this->_get_sort_order($this->first_sort_order))
		               ->add_order($this->second_sort_key, $this->second_sort_order)
		               ->add_order($this->third_sort_key, $this->third_sort_order)
		               ->add_order($this->fourth_sort_key, $this->first_sort_order);

		return $nds_pagination;
	}

	/**
	 * SQLで使用する検索条件を保持した配列を作成して取得する。
	 */
	protected function _get_condition_params()
	{
		$params = array();
		$params['id'] = $this->data[self::F_COND_ID];
		$params['keyword'] =  $this->data[self::F_COND_KEYWORD];
		$params['draft_flg'] =  $this->data[self::F_COND_DRAFT_FLG];
		$params['category_ids'] = create_array_param($this->data[self::F_COND_BASIC_CATEGORY_IDS]);

		//現在セッションで保持しているデータIDをセット
		$params['relation_data_type'] = $this->application_session_data->get_relation_data_type($this->package_name);
		$params['relation_data_id'] = $this->application_session_data->get_relation_data_id($this->package_name);

		return $params;
	}

	/**
	 * 一意となるエンティティの論理削除を行う処理。
	 * 関連データを持つかどうかでデータの存在チェックの厳密さを変更している。
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $relation_use_flg
	 */
	protected function _do_delete($id, $relation_check_flg = TRUE)
	{
		$this->db->trans_start();

		$this->_logical_delete_by_id($id, $relation_check_flg);
		$this->_logical_delete_relation_by_id($id);

		$this->db->trans_complete();
	}

	/**
	 * 指定したデータに紐付いている関連テーブルをすべて論理削除する。
	 * 
	 * 
	 * @param unknown_type $id
	 */
	private function _logical_delete_relation_by_id($id)
	{
		//関連テーブルを削除する。
		$this->T_relation->logical_delete_all_child_relation($this->target_data_type, $id);
		$this->T_file->logical_delete_by_relation_data($this->target_data_type, $id);
	}

	/**
	 * idを元にエンティティを論理削除する
	 * 
	 * @param unknown_type $id
	 * @param unknown_type $relation_check_flg
	 */
	private function _logical_delete_by_id($id, $relation_check_flg = TRUE)
	{
		//必須情報が不足している場合は完了画面Viewにエラーを表示
		if (is_blank($id))
		{
			$this->error_list['delete'] = '削除するデータが指定されていません';
			$this->_load_tpl($this->_get_view_name(View_type::COMPLETE), $this->data);
			return;
		}

		$entity = FALSE;

		if ($relation_check_flg)
		{
			// 記事を取得
			$entity = $this->delete_model->find_with_relation_id(
			                                   $id,
			                                   $this->application_session_data->get_relation_data_type($this->package_name),
			                                   $this->application_session_data->get_relation_data_id($this->package_name)
			                               );
		}
		else
		{
			$entity = $this->delete_model->find($id);
		}

		if ( ! $entity) 
		{
			//エラーページを表示して処理終了
			show_error('削除対象のデータが存在しないか、削除する権限がありません');
			return;	//実際にはこのRETURNには到達しない 
		}

		$this->delete_model->logical_delete($id);
	}

	/**
	 * 再検索の条件をセッションから取得して画面で使用するために$this->dataにセットします。
	 * ページ数だけは別で使用するので
	 */
	protected function _set_search_again_condition()
	{
		$condition_list = $this->_get_page_session(parent::SESSION_KEY_SERCH_COND_DATA);

		$page = 1;

		if ($condition_list !== FALSE)
		{
			//セッションから取得した検索条件を$dataに詰め替え
			parent::_set_to_data($condition_list);

			$page = isset($condition_list['page']) 
			        ? $condition_list['page'] 
			        : 1;
		}

		return $page;
	}

	/**
	 * select_for_manage()メソッドを持つモデルを検索し、エンティティのリストを取得する。
	 * ※$this->nds_paginationに値をセットするため、複数のページングが必要な場合は注意すること。
	 * 
	 * @param Base_Model $model
	 * @param Nds_pagination $nds_pagination
	 * @param unknown_type $params
	 */
	protected function _do_search_for_manage(Base_Model $model, Nds_pagination $nds_pagination, $params = array())
	{
		$nds_pagination->total = $model->select_for_manage($nds_pagination, $params, TRUE);
		$this->nds_pagination = $nds_pagination;

		return ($nds_pagination->total !== 0) 
		       ? $model->select_for_manage($nds_pagination, $params)
		       : array();
	}

	/**
	 * select_for_front()メソッドを持つモデルを検索し、エンティティのリストを取得する。
	 * ※$this->nds_paginationに値をセットするため、複数のページングが必要な場合は注意すること。
	 * 
	 * @param Base_Model $model
	 * @param Nds_pagination $nds_pagination
	 * @param unknown_type $params
	 */
	protected function _do_search_for_front(Base_Model $model, Nds_pagination $nds_pagination, $params = array())
	{
		$nds_pagination->total = $model->select_for_front($nds_pagination, $params, TRUE);
		$this->nds_pagination = $nds_pagination;

		return ($nds_pagination->total !== 0) 
		       ? $model->select_for_front($nds_pagination, $params)
		       : array();
	}

	/**
	 * 基本カテゴリーのラベルを取得する。
	 * 
	 * @param unknown_type $id
	 */
	protected function _get_basic_category_label($id)
	{
		$category_ids = $this->T_relation->get_attribute_value_array(
                                       $this->target_data_type,
                                       $id,
                                       Relation_data_type::KUBUN,
                                       Kubun_type::CATEGORY
                                   );

		return $this->M_kubun->get_joined_label(
		                           $this->target_data_type,
		                           Kubun_type::CATEGORY,
		                           $category_ids
		                       );
	}

	/**
	 * CSVのダウンロードを実行する。
	 * 
	 * @param unknown_type $csv_file_name
	 * @param unknown_type $header_list
	 * @param unknown_type $content_list
	 * @param unknown_type $character_encode
	 */
	protected function _do_download_csv($csv_file_name, $header_list, $content_list, $character_encode = 'SJIS-WIN')
	{
		$all_list = array();
		$all_list[] = $header_list;
		$all_list = array_merge($all_list, $content_list);

		$fileName =  mb_convert_encoding($csv_file_name, $character_encode);

		header('Content-Type: application/x-csv');
		header("Content-Disposition: attachment; filename=$fileName");

		$fp = fopen('php://output', 'w');

		foreach ($all_list as $fields)
	 	{
			mb_convert_variables('SJIS-WIN', mb_internal_encoding(), $fields);
    		fputcsv($fp, $fields);
		}

		fclose($fp);
	}
}
