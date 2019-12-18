<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * t_post関連のテーブルの検索画面固有の親Controller
 * ※このクラスがロードされるのはcore/MY_Controller.phpのファイル一番下のrequire_once
 * @author ta-ando
 *
 */
class Post_search_Controller extends Search_Controller
{
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

	/*
	 * コンストラクタ
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * (non-PHPdoc)
	 * @see Search_Controller::_config_setting()
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
		}
	}


	/**
	 * SELECT結果をCSV用に整形する。
	 * 戻り値はヘッダ用とコンテンツ用配列を持った連想配列。
	 * 追加項目をセットする場合はこのメソッドの戻り値のヘッダとコンテンツにそれぞれ追加してください。
	 * 
	 * @param unknown_type $list
	 */
	protected function _convert_for_csv($list)
	{
		/*
		 * ヘッダーを作成する
		 */

		$header = array();
		$header[] = 'データID';

		//共通項目
		foreach ($this->columns as $column_name)
		{
			$column_use_val = "column_{$column_name}_use";	//変数名を作成
			$label_val = "label_{$column_name}";	//変数名を作成

			if ($this->$column_use_val)
			{
				$header[] = $this->$label_val;
			}
		}

		//カテゴリー
		if ($this->basic_category_use)
		{
			$header[] = $this->label_basic_category;
		}

		/*
		 * 一覧部分を作成する
		 */

		$content = array();

		foreach ($list as $entity)
		{
			$tmp = array();
			$tmp[] = $entity->id;

			//共通項目
			foreach ($this->columns as $column_name)
			{
				$column_use_val = "column_{$column_name}_use";	//変数名を作成

				if ($this->$column_use_val)
				{
					$tmp[] = $entity->$column_name;
				}
			}

			//カテゴリー
			if ($this->basic_category_use)
			{
				$tmp[] = $this->V_relation_kubun->get_joined_labels(
				                                      $this->target_data_type,
				                                      $entity->id,
				                                      Kubun_type::CATEGORY
				                                  );
			}

			$content[] = $tmp;
		}

		$ret = array();
		$ret['header'] = $header;
		$ret['content'] = $content;

		return $ret;
	}
}
