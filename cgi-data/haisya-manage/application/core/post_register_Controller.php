<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * t_post関連のテーブルの登録、編集画面固有の親Controller
 * ※このクラスがロードされるのはcore/MY_Controller.phpのファイル一番下のrequire_once
 * @author ta-ando
 *
 */
class Post_register_Controller extends Register_Controller
{
	/** コントローラ内でのみ使用する定数 */
	const POST_ID = 'post_id';

	/** フォームで使用するパラメータ名 */
	const F_POST_TITLE = 'post_title';  // 記事タイトル
	const F_POST_SUB_TITLE = 'post_sub_title';  // 記事サブタイトル
	const F_POST_CONTENT = 'post_content';  // 記事本文
	const F_POST_LINK = 'post_link';  // リンク
	const F_POST_LINK_TEXT = 'post_link_text';  // リンクタイトル
	const F_POST_DATE = 'post_date';  // 登録日
	const F_NEW_ICON_END_DATE = 'new_icon_end_date';  // NEWアイコン表示終了日
	const F_PUBLISH_END_DATE = 'publish_end_date';  // 掲載終了日時
	const F_DRAFT_FLG = 'draft_flg';  // 下書きフラグ
	const F_ORDER_NUMBER = 'order_number';  // ソート順

	/** 共通項目 */
	var $columns = array(
		               self::F_POST_TITLE,
		               self::F_POST_SUB_TITLE,
		               self::F_POST_CONTENT,
		               self::F_POST_LINK,
		               self::F_POST_LINK_TEXT,
		               self::F_POST_DATE,
		               self::F_NEW_ICON_END_DATE,
		               self::F_PUBLISH_END_DATE,
		               self::F_DRAFT_FLG,
		               self::F_ORDER_NUMBER,
		           );

	/** t_postテーブルのカラムを画面で使用するかどうかのフラグ */
	var $column_post_date_use = TRUE;
	var $column_new_icon_end_date_use = TRUE;
	var $column_publish_end_date_use = TRUE;
	var $column_post_title_use = TRUE;
	var $column_post_sub_title_use = TRUE;
	var $column_post_link_use = TRUE;
	var $column_order_number_use = TRUE;

	/** t_postテーブルのカラムのラベル(変更する場合は子クラスのコンストラクタで上書きする) */
	var $label_post_date;
	var $label_new_icon_end_date;
	var $label_publish_end_date;
	var $label_post_title;
	var $label_post_content;
	var $label_post_sub_title;
	var $label_post_link;
	var $label_post_link_text;
	var $label_order_number;

	/** t_postテーブルのカラムの入力チェック内容 */
	var $validate_rule_post_date;
	var $validate_rule_new_icon_end_date;
	var $validate_rule_publish_end_date;
	var $validate_rule_post_title;
	var $validate_rule_post_content;
	var $validate_rule_post_sub_title;
	var $validate_rule_post_link;
	var $validate_rule_post_link_text;
	var $validate_rule_order_number;

	var $free_table_select_max = 10;

	/*
	 * コンストラクタ
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_config_setting()
	 */
	protected function _config_setting()
	{
		parent::_config_setting();

		// 項目毎の設定を読み込む
		foreach ($this->columns as $column_name)
		{
			$column_use_val = "column_{$column_name}_use";	//変数名を作成
			$this->$column_use_val = config_item("{$this->package_name}_column_{$column_name}_use");

			$label_val = "label_{$column_name}";	//変数名を作成
			$this->$label_val = config_item("{$this->package_name}_label_{$column_name}");

			$validate_rule_val = "validate_rule_{$column_name}";	//変数名を作成
			$this->$validate_rule_val = config_item("{$this->package_name}_validate_rule_{$column_name}");
		}	
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_set_default_form_value()
	 */
	protected function _set_default_form_value()
	{
		parent::_set_default_form_value();

		//画像の並び順を初期化
		$this->data[self::F_IMAGE_ORDER_STR] = get_cardinal_joined_str(1,  $this->max_image_file);

		//当日
		$this->data[self::F_POST_DATE] = date('Y/m/d');
		//14日後
		$this->data[self::F_NEW_ICON_END_DATE] = date('Y/m/d', strtotime ('+14 day'));
	}

	/**
	 * 基本項目の入力チェックを行う。
	 * ※戻り値を返さないメソッドのため、下位クラスの_input_check()とは役割が異なる。
	 */
	protected function _basic_input_check()
	{
		//公開非公開（※入力チェックが0件だと検証結果がFALSEになってしまうので設定している）
		$this->form_validation->set_rules(self::F_DRAFT_FLG, '公開/非公開', 'integer');

		//基本カテゴリー
		if ($this->basic_category_use)
		{
			$this->form_validation->set_rules(self::F_BASIC_CATEGORY_IDS, $this->label_basic_category, $this->validate_rule_basic_category);
		}

		//共通項目入力チェック
		foreach ($this->columns as $column_name)
		{
			$column_use_val = "column_{$column_name}_use";	//変数名を作成
			$label_val = "label_{$column_name}";	//変数名を作成
			$validate_rule_val = "validate_rule_{$column_name}";	//変数名を作成

			if ($this->$column_use_val)
			{
				$this->form_validation->set_rules($column_name, $this->$label_val, $this->$validate_rule_val);
			}
		}

		//画像のキャプション、章タイトル
		if ($this->use_image_upload)
		{
			for ($i = 1; $i <= $this->max_image_file; $i++)
			{
				$this->form_validation->set_rules("image{$i}_caption", "画像{$i}キャプション", 'max_length[500]');
				$this->form_validation->set_rules("image{$i}_paragraph_title", "画像{$i}の章タイトル", 'max_length[150]');
			}
		}

		//ダウンロード用ファイルのキャプション、表示用ファイル名
		if ($this->use_doc_upload)
		{
			for ($i = 1; $i <= $this->max_doc_file; $i++)
			{
				$this->form_validation->set_rules("doc{$i}_caption", "ファイル{$i}キャプション", 'max_length[150]');
				$this->form_validation->set_rules("doc{$i}_title", "ファイル{$i}の表示用ファイル名", 'max_length[150]');
			}
		}
	}

	/**
	 * 共通項目の相関チェックを行う。
	 */
	protected function _relation_check()
	{
		$ret = TRUE;

		$post_date_timestamp =  strtotime($this->data[self::F_POST_DATE]);

		//NEWアイコン掲載終了日の相関チェック
		if (is_not_blank($this->data[self::F_NEW_ICON_END_DATE]))
		{
			$new_icon_date_timestamp =  strtotime($this->data[self::F_NEW_ICON_END_DATE]);

			if ($new_icon_date_timestamp < $post_date_timestamp)
			{
				$ret = FALSE;
				$this->error_list['new_icon_date_reverse_date_error'] = "{$this->label_new_icon_end_date}と{$this->label_post_date}の日付が逆転しています。";
			}
		}

		//掲載終了日の相関チェック
		if (is_not_blank($this->data[self::F_PUBLISH_END_DATE]))
		{
			$publish_end_date_timestamp =  strtotime($this->data[self::F_PUBLISH_END_DATE]);

			if ($publish_end_date_timestamp < $post_date_timestamp)
			{
				$ret = FALSE;
				$this->error_list['publish_end_date_reverse_date_error'] = "{$this->label_publish_end_date}と{$this->label_post_date}の日付が逆転しています。";
			}
		}

		//基本カテゴリーの選択は１つまでとする場合のチェック
		if ( ! $this->basic_category_multi_select)
		{
			if (is_array($this->input->post(self::F_BASIC_CATEGORY_IDS))
			&& count($this->input->post(self::F_BASIC_CATEGORY_IDS)) > 1)
			{
				$ret = FALSE;
				$this->error_list['basic_category_ids_relation_error'] ="{$this->label_basic_category}は複数選択できません";
			}
		}

		return $ret;
	}

	/**
	 * 画面で扱うメインテーブルの共通カラムに値のセットを行う。
	 * 戻り値でエンティティを返す。
	 * 画面上に存在しないデータをカラムにセットしたい場合は事前に引数の$session_varにセットすること
	 * 
	 * @param unknown_type $session_var
	 */
	protected function _set_main_table_column_for_insert($session_var)
	{
		$entity = $this->main_model->create_model_instance();

		//現在保持している親データを取得する
		$entity->relation_data_type = $this->application_session_data->get_relation_data_type($this->package_name);
		$entity->relation_data_id = $this->application_session_data->get_relation_data_id($this->package_name);

		$entity->data_type = $this->target_data_type;

		//登録日は画面入力をしない場合でもNULLにしないようにするためユーザーの入力値を使用するかを指定する。
		if ($this->column_post_date_use)
		{
			$entity->post_date = create_db_datetme_str($session_var[self::F_POST_DATE]);
		}
		else
		{
			$entity->post_date = create_db_datetme_str(date('Y/m/d'));
		}

		$entity->post_title = $session_var[self::F_POST_TITLE];
		$entity->post_sub_title = $session_var[self::F_POST_SUB_TITLE];
		$entity->post_content = $session_var[self::F_POST_CONTENT];
		$entity->post_link = $session_var[self::F_POST_LINK];
		$entity->post_link_text = $session_var[self::F_POST_LINK_TEXT];
		$entity->new_icon_end_date = create_db_datetme_str($session_var[self::F_NEW_ICON_END_DATE]);
		$entity->publish_end_date = create_db_datetme_str($session_var[self::F_PUBLISH_END_DATE]);
		$entity->order_number = get_default_str($session_var[self::F_ORDER_NUMBER], NULL);
		$entity->draft_flg = ($session_var[self::F_DRAFT_FLG] === Draft_flg::DRAFT)
		                     ? Draft_flg::DRAFT
		                     : Draft_flg::NOT_DRAFT;

		return $entity;
	}

	/**
	 * 編集画面に共通の初期処理
	 * 
	 * @param unknown_type $post_id
	 */
	protected function _init_edit_logic($post_id)
	{
		if ( ! is_num($post_id))
		{
			//WYSIWYGエディタでのパス間違いなどで/show/img/EEEE.jpgなどのパスがリクエストされた場合に、IDが上書きされる不具合が発生するのを防ぐ。
			show_404();
		}

		/*
		 * 初期処理
		 */

		$this->_unset_page_session();
		$this->_save_page_session(self::POST_ID, $post_id);

		//画像の並び順を初期化
		$this->data[self::F_IMAGE_ORDER_STR] = get_cardinal_joined_str(1,  $this->max_image_file);
	}

	/**
	 * データのうち整形が必要なものをここでセットする。
	 */
	protected function _convert_load_data()
	{
		$this->data = array_merge($this->data, (array)$this->target_entity);

		//調整
		$this->data[self::F_POST_DATE] = format_date_to_pattern($this->target_entity->post_date, "Y/m/d");
		$this->data[self::F_NEW_ICON_END_DATE] = format_date_to_pattern($this->target_entity->new_icon_end_date, "Y/m/d");
		$this->data[self::F_PUBLISH_END_DATE] = format_date_to_pattern($this->target_entity->publish_end_date, "Y/m/d");
	}

	/**
	 * セッションに保持しているIDを元にこの画面で操作するデータのエンティティを取得する。
	 */
	protected function _load_entity_from_session()
	{
		$post_id = $this->_get_page_session(self::POST_ID);

		// 記事を取得
		$entity = $this->main_model->find_with_relation_id(
		                             $post_id,
		                             $this->application_session_data->get_relation_data_type($this->package_name),
		                             $this->application_session_data->get_relation_data_id($this->package_name)
		                         );

		if ( ! $entity) 
		{
			//エラーページを表示して処理終了
			show_error('データが存在しません');
			return;	//実際にはこのRETURNには到達しない 
		}

		$this->target_entity = $entity;
	}

	/**
	 * この画面で扱うメインテーブルに更新用にデータをセットする。
	 * 戻り値はエンティティ。
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $post_id
	 */
	protected function _set_main_table_column_for_update($session_var, $post_id)
	{
		$entity = $this->main_model->find_with_relation_id(
		                                 $post_id,
		                                 $this->application_session_data->get_relation_data_type($this->package_name),
		                                 $this->application_session_data->get_relation_data_id($this->package_name)
		                             );

		if ( ! $entity)
		{
			show_error('データが存在しないため、更新処理を中止しました。');
			return;	//実際にはこのRETURNには到達しない 
		}

		//登録日は画面入力をしない場合でもNULLにしないようにするためユーザーの入力値を使用するかを指定する。
		if ($this->column_post_date_use)
		{
			$entity->post_date = create_db_datetme_str($session_var[self::F_POST_DATE]);
		}

		$entity->post_title = $session_var[self::F_POST_TITLE];
		$entity->post_sub_title = $session_var[self::F_POST_SUB_TITLE];
		$entity->post_content = $session_var[self::F_POST_CONTENT];
		$entity->post_link = $session_var[self::F_POST_LINK];
		$entity->post_link_text = $session_var[self::F_POST_LINK_TEXT];
		$entity->new_icon_end_date = create_db_datetme_str($session_var[self::F_NEW_ICON_END_DATE]);
		$entity->publish_end_date = create_db_datetme_str($session_var[self::F_PUBLISH_END_DATE]);
		$entity->order_number = get_default_str($session_var[self::F_ORDER_NUMBER], NULL);
		$entity->draft_flg = ($session_var[self::F_DRAFT_FLG] === Draft_flg::DRAFT)
		                     ? Draft_flg::DRAFT
		                     : Draft_flg::NOT_DRAFT;

		return $entity;
	}

	/**
	 * 商品のダウンロードファイル用のフォルダのパスを取得する。
	 * フォルダが存在しない場合はフォルダを作成する。
	 * 
	 * @param unknown_type $item_id
	 * @param unknown_type $dir_name
	 */
	protected function _get_item_file_dir($item_id, $dir_name)
	{
		$dir_path  = config_item('item_download_dir_path')."item_download/{$item_id}/{$dir_name}/";

		if (! file_exists($dir_path))
		{
			mkdir($dir_path, 0777, TRUE);
		}

		return $dir_path;
	}

	/**
	 * サブ画面での検索結果を保持するフォーム部品のキーを作成する。
	 * 
	 * @param unknown_type $max
	 */
	protected function _create_modal_result_form_key($max)
	{
		$ret = array();

		for ($i = 1; $i <= $max; $i++)
		{
			$ret[] = "related_item_id_{$i}";
			$ret[] = "related_item_label_{$i}";
		}

		return $ret;
	}
}
