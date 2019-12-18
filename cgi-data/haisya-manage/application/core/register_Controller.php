<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 登録、編集画面固有の親Controller
 * ※このクラスがロードされるのはcore/MY_Controller.phpのファイル一番下のrequire_once
 * @author ta-ando
 *
 */
class Register_Controller extends Common_Controller
{
	const F_BASIC_CATEGORY_IDS = 'basic_category_ids'; //基本カテゴリー(複数指定可)

	/** 画像のソート順を保持する文字列 */
	const F_IMAGE_ORDER_STR = 'image_order_str';

	/** 一覧の件数、画像と添付ファイルのファイル数の最大値 */
	var $max_list = 10;
	var $max_image_file = 0;
	var $max_doc_file = 0;
	var $use_image_caption = TRUE;
	var $use_image_paragraph_title = TRUE;

	var $main_image_width = 640;
	var $main_image_height = 480;
	var $thumbnail_width = 200;
	var $thumbnail_height = 150;
	var $thumbnail_m_width = FALSE;
	var $thumbnail_m_height = FALSE;
	var $thumbnail_ss_width = FALSE;
	var $thumbnail_ss_height = FALSE;

	/** ファイルのアップロードを使用するかどうかを保持 */
	var $use_image_upload = FALSE;
	var $use_doc_upload = FALSE;

	/** this->dataにセットする追加情報用の配列 */
	var $optional_keys = array();

	/** 編集画面で操作対象のテーブルのエンティティを保持する変数 */
	var $target_entity;

	var $file_form_keys = array(
		                      'caption',
		                      'paragraph_title',
		                      'title',
	                          'caption_position',
	                          'image_size'
		                  );
	
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
		//基本カテゴリーの使用有無
		$this->basic_category_use = config_item("{$this->package_name}_"."basic_category_use");
		$this->basic_category_multi_select = config_item("{$this->package_name}_"."basic_category_multi_select");
		$this->label_basic_category = config_item("{$this->package_name}_"."label_basic_category");
		$this->validate_rule_basic_category = config_item("{$this->package_name}_"."validate_rule_basic_category");

		//ファイルアップロード関連の設定をnds_system_manage_config.phpから取得。
		$this->use_image_upload = config_item("{$this->package_name}_"."use_image_upload");
		$this->use_image_caption = config_item("{$this->package_name}_"."use_image_caption");
		$this->use_image_paragraph_title = config_item("{$this->package_name}_"."use_image_paragraph_title");
		$this->use_doc_upload = config_item("{$this->package_name}_"."use_doc_upload");
		$this->max_image_file = config_item("{$this->package_name}_"."max_image_file");
		$this->max_doc_file = config_item("{$this->package_name}_"."max_doc_file");

		//画像サイズ関連の設定。設定ファイルに無ければデフォルト値を使用する。
		$this->main_image_width = config_item("{$this->package_name}_"."main_image_width")
		                          ? config_item("{$this->package_name}_"."main_image_width")
		                          : $this->main_image_width;
		$this->main_image_height = config_item("{$this->package_name}_"."main_image_height")
		                           ? config_item("{$this->package_name}_"."main_image_height")
		                           : $this->main_image_height;
		$this->thumbnail_width = config_item("{$this->package_name}_"."thumbnail_width")
		                         ? config_item("{$this->package_name}_"."thumbnail_width")
		                         : $this->thumbnail_width;
		$this->thumbnail_height = config_item("{$this->package_name}_"."thumbnail_height")
		                          ? config_item("{$this->package_name}_"."thumbnail_height")
		                          : $this->thumbnail_height;
		$this->thumbnail_m_width = config_item("{$this->package_name}_"."thumbnail_m_width")
		                         ? config_item("{$this->package_name}_"."thumbnail_m_width")
		                         : $this->thumbnail_m_width;
		$this->thumbnail_m_height = config_item("{$this->package_name}_"."thumbnail_m_height")
		                          ? config_item("{$this->package_name}_"."thumbnail_m_height")
		                          : $this->thumbnail_m_height;
		$this->thumbnail_ss_width = config_item("{$this->package_name}_"."thumbnail_ss_width")
		                         ? config_item("{$this->package_name}_"."thumbnail_ss_width")
		                         : $this->thumbnail_ss_width;
		$this->thumbnail_ss_height = config_item("{$this->package_name}_"."thumbnail_ss_height")
		                          ? config_item("{$this->package_name}_"."thumbnail_ss_height")
		                          : $this->thumbnail_ss_height;
	}

	/**
	 * フォームの初期値をセットする。
	 */
	protected function _set_default_form_value()
	{
		
	}

	/**
	 * 関係テーブルのデータをDBから読み取り画面のメンバに保持する。
	 */
	protected function _init_relation_data()
	{
		// 基本カテゴリーを取得（チェックボックス用）
		$this->basic_category_list = $this->M_kubun->get_key_value_list(
		                                           $this->target_data_type,
		                                           Kubun_type::CATEGORY
		                                       );
	}

	/**
	 * フォーム内でネストする項目用にフォームのキーを作成する。
	 * 動的にファイルアップロード項目の初期化。
	 * ファイルアップロード時のsubmitで送信されるPOSTのキーは他のフォーム部品とは異なり。
	 * コントローラー側でF_AAAのように定数を持っていない。これは設定ファイルでフォーム部品の数を増減できるようにするためである。
	 * このメソッドで動的にキーを作成している。
	 */
	protected function _create_optional_form_key()
	{
		//配列を作成してマージ
		$this->optional_keys = array_merge(
		                           $this->_create_fileupload_form_key(
		                                      $this->max_image_file,
		                                      file_type::IMAGE),
		                           $this->_create_fileupload_form_key(
		                                      $this->max_doc_file,
		                                      file_type::DOCUMENT)
		                       );
	}

	/**
	 * ネストする複数項目の初期化
	 */
	protected function _init_optional_form_key()
	{
		foreach ($this->optional_keys as $optional_key)
		{
			$this->data[$optional_key] = '';
			$this->error_list[$optional_key] = '';
			$this->label_list[$optional_key] = '';
		}
	}

	/**
	 * 画面表示用にラベルに変換する処理
	 */
	protected function _convert_label()
	{
		if ($this->basic_category_use)
		{
			//カテゴリー
			$this->label_list[self::F_BASIC_CATEGORY_IDS] = $this->M_kubun->get_joined_label(
			                                                                    $this->target_data_type,
			                                                                    Kubun_type::CATEGORY,
			                                                                    $this->data[self::F_BASIC_CATEGORY_IDS]
			                                                                );
		}
	}

	/**
	 * 戻る処理。
	 * 画面に入力内容をセットするため、セッションに保持されている情報を取得し、
	 * $this->dataに展開する。
	 */
	protected function _do_back()
	{
		//セッションから情報を取得
		$session_var = $this->_get_page_session(parent::SESSION_KEY_INPUT_DATA);

		if ( ! $session_var)
		{
			show_error(parent::ERROR_MSG_SESSION_ERRROR);
		}

		//セッション保持データを$dataに詰め替え
		$this->_set_to_data($session_var);
	}

	/**
	 * アップロードされたファイルをINSERTする処理。
	 * 画像と通常ファイルで別の処理を行う。
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $post_id
	 */
	protected function _insert_file($session_var, $post_id)
	{
		//画像ファイル(並び順有り)をDBにINSERT
		$this->_do_insert_file(
		           $session_var, 
		           $this->target_data_type, 
		           $post_id,
		           $session_var[self::F_IMAGE_ORDER_STR],
		           $this->max_image_file, 
		           File_type::IMAGE
		       );

		$this->_move_file_to_destination(
		           $session_var,
		           File_type::IMAGE,
		           $this->max_image_file
		       );

		//ダウンロード用ファイルをDBにINSERT
		$this->_do_insert_file(
		           $session_var, 
		           $this->target_data_type, 
		           $post_id, 
		           '', 
		           $this->max_doc_file, 
		           File_type::DOCUMENT
		       );

		$this->_move_file_to_destination(
		           $session_var,
		           File_type::DOCUMENT,
		           $this->max_doc_file
		       );
	}

	/**
	 * 関連テーブルをDELETE/INSERTによって更新する処理。
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $post_id
	 */
	protected function _delete_insert_relation($session_var, $post_id)
	{
		if ($this->basic_category_use)
		{
			//基本カテゴリーをDELETE/INSERT
			$this->T_relation->delete_insert_list(
			                       $this->target_data_type,
			                       $post_id,
			                       Relation_data_type::KUBUN,
			                       Kubun_type::CATEGORY,
			                       create_array_param($session_var[self::F_BASIC_CATEGORY_IDS])
			                   );
		}
	}


	/**
	 * アップロードされたファイル情報を読み込み$this->dataに保持する。
	 * 編集なのでファイルを一時フォルダにコピーを同時に行う。
	 * 
	 * @param unknown_type $id
	 */
	protected function _load_file($post_id)
	{
		$this->_load_file_data($this->target_data_type, $post_id, File_type::IMAGE, TRUE);
		$this->_load_file_data($this->target_data_type, $post_id, File_type::DOCUMENT, TRUE);
	}

	/**
	 * 関連テーブルを読み込む
	 * 
	 * @param unknown_type $post_id
	 */
	protected function _load_relation($post_id)
	{
		//カテゴリー
		$this->data[self::F_BASIC_CATEGORY_IDS] = $this->T_relation->get_attribute_value_array(
			                                                       $this->target_data_type,
			                                                       $post_id,
			                                                       Relation_data_type::KUBUN,
			                                                       Kubun_type::CATEGORY
			                                                   );
	}

	/**
	 * 画像のアップロードファイルの処理。
	 * 不要ファイルの削除、DBのDELETE/INSERTを行う。
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $post_id
	 */
	protected function _delete_file_and_record($session_var, $post_id)
	{
		/*
		 * 画像
		 */

		//調整と削除処理
		$this->_delete_not_uploaded_file(
		           $session_var,
		           $this->target_data_type,
		           $post_id,
		           File_type::IMAGE,
		           $this->max_image_file,
		           $this->destination_upload_dir
		       );

		//DBのデータを物理削除する。
		$this->T_file->delete_by_related_data(
		                   $this->target_data_type, 
		                   $post_id, 
		                   File_type::IMAGE
		               );

		/*
		 * 通常ファイル
		 */

		//調整と削除処理
		$this->_delete_not_uploaded_file(
		           $session_var,
		           $this->target_data_type,
		           $post_id,
		           File_type::DOCUMENT,
		           $this->max_doc_file,
		           $this->destination_upload_dir
		       );

		//DBのデータを物理削除する。
		$this->T_file->delete_by_related_data(
		                   $this->target_data_type,
		                   $post_id,
		                   File_type::DOCUMENT
		               );
	}

	/**
	 * 操作用フォルダから本番用フォルダへのファイルのコピーを行う。
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $file_type
	 * @param unknown_type $max
	 */
	protected function _move_file_to_destination($session_var, $file_type, $max)
	{
		//作業フォルダと本番用フォルダが同じ場合は処理をスキップ
		if ($this->departure_upload_dir === $this->destination_upload_dir)
		{
			return;
		}

		//ファイルの種類によってキー名の接頭辞を変更
		$key_prefix = File_type::get_prefix($file_type);

		for ($i = 1; $i <= $max; $i++)
		{
			$upload_file_name = $session_var["after_upload_{$key_prefix}{$i}"];

			if (is_blank($upload_file_name))
			{
				continue;
			}

			// 操作用フォルダに存在するファイルを本番用フォルダに移動
			$this->_do_move_file($upload_file_name, '');

			// 画像の場合はサムネイル画像も移動
			if ($file_type !== File_type::DOCUMENT)
			{
				$this->_do_move_file($upload_file_name, $this->thumbnail_prefix);
				$this->_do_move_file($upload_file_name, $this->thumbnail_m_prefix);
				$this->_do_move_file($upload_file_name, $this->thumbnail_ss_prefix);
			}
		}
	}

	/**
	 * ファイルを指定フォルダから対象フォルダに実際に移動させる。
	 * 
	 * @param unknown_type $upload_file_name
	 * @param unknown_type $file_prefix
	 */
	private function _do_move_file($upload_file_name, $file_prefix = '')
	{
		if (file_exists($this->departure_upload_dir.$file_prefix.$upload_file_name))
		{
			rename(
			    $this->departure_upload_dir.$file_prefix.$upload_file_name, 
			    $this->destination_upload_dir.$file_prefix.$upload_file_name
			);
		}
	}

	/**
	 * ファイルのアップロードフォームのキーをthis->dataにセットして初期値をセットする処理。
	 * 戻り値で作成したキーの配列を返します。
	 * 
	 */
	protected function _create_fileupload_form_key($max, $file_type)
	{
		//ファイルの種類によってキー名の接頭辞を変更
		$key_prefix = File_type::get_prefix($file_type);

		$ret = array();

		//ファイル用フォーム部品名をセット
		for ($i = 1; $i <= $max; $i++)
		{
			//ファイル名を保持するキーをセット
			$key = "after_upload_{$key_prefix}{$i}";
			$ret[] = $key;
			$ret[] = "{$key}_exists_flg";

			//個別項目のキーを保持
			foreach ($this->file_form_keys as $file_form_key)
			{
				$ret[] = "{$key_prefix}{$i}_{$file_form_key}";
			}
		}

		return $ret;
	}

	/**
	 * 画像,ダウンロード用ファイルのDBのINSERT処理。
	 * 画像は並び順を並び順がセットされた配列からインデックスを取得してセットする。
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 * @param unknown_type $order_array_str
	 * @param unknown_type $max
	 * @param unknown_type $file_type
	 */
	protected function _do_insert_file($session_var, $relation_data_type, $relation_data_id, $order_array_str, $max, $file_type)
	{
		$order_array = explode(',', $order_array_str);

		//ファイルの種類によってキー名の接頭辞を変更
		$key_prefix = File_type::get_prefix($file_type);

		for ($i = 1; $i <= $max; $i++)
		{
			$key = "after_upload_{$key_prefix}{$i}";

			if (is_blank($session_var[$key]))
			{
				continue;
			}

			//並び順を取得
			if ($file_type === File_type::IMAGE)
			{
				$order_num = array_search($i, $order_array);
				//存在していることを確認し、無ければ0にする
				$order_num = ($order_num !== FALSE) 
			                 ? $order_num 
			                 : 0;
			}
			else
			{
				$order_num = 0;
			}

			$tmp_entity = new T_file();
			$tmp_entity->relation_data_type = $relation_data_type;
			$tmp_entity->relation_data_id = $relation_data_id;
			$tmp_entity->seq_no = $i;
			$tmp_entity->order_num = $order_num;
			$tmp_entity->file_type = $file_type;
			$tmp_entity->file_name = $session_var[$key];

			foreach ($this->file_form_keys as $file_form_key)
			{
				$tmp_entity->$file_form_key = $session_var["{$key_prefix}{$i}_{$file_form_key}"];
			}

			$tmp_entity->insert($this->login_user->user_code);
		}
	}

	/**
	 * 画像をファイルテーブルから読み込みます。
	 * 編集画面の場合はリネームしたファイルを一時フォルダーにコピーします。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 * @param unknown_type $file_type
	 * @param unknown_type $edit_flg
	 */
	protected function _load_file_data($relation_data_type, $relation_data_id, $file_type, $edit_flg = FALSE)
	{
		//エンティティのリストを取得
		$image_entity_list = $this->T_file->find_by_related_data(
		                                        $relation_data_type, 
		                                        $relation_data_id, 
		                                        $file_type
		                                    );

		if (empty($image_entity_list))
		{
			return;
		}

		//ファイルの種類によってキー名の接頭辞を変更
		$key_prefix = File_type::get_prefix($file_type);

		for ($i = 1; $i <= count($image_entity_list); $i++)
		{
			$tmp_entity = $image_entity_list[($i - 1)];

			$key = "after_upload_{$key_prefix}{$i}";
			$this->data[$key] = $tmp_entity->file_name;
			$this->data["{$key}_exists_flg"] = TRUE;

			//項目のキーを作成して画面表示用にセットする
			foreach ($this->file_form_keys as $file_form_key)
			{
				$this->data["{$key_prefix}{$i}_{$file_form_key}"] = $tmp_entity->$file_form_key;
			}
		}
	}

	/**
	 * ファイルテーブルに存在するレコードのうち、
	 * 配列(セッション情報）の指定キーに存在しないファイル名のファイルをファイルシステムから削除する。
	 * 
	 * @param unknown_type $session_var
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 * @param unknown_type $file_type
	 * @param unknown_type $max
	 * @param unknown_type $arg_upload_dir
	 */
	protected function _delete_not_uploaded_file($session_var, $relation_data_type, $relation_data_id, $file_type, $max, $arg_upload_dir)
	{
		$not_changed_file_list = array();

		//ファイルの種類によってキー名の接頭辞を変更
		$key_prefix = File_type::get_prefix($file_type);

		//アップロードされたものを配列で保持
		for ($i = 1; $i <= $max; $i++)
		{
			$key = "after_upload_{$key_prefix}{$i}";

			if (is_not_blank($session_var[$key]))
			{
				$not_changed_file_list[] = $session_var[$key];
			}
		}

		//DBから変更前の画像のリストを取得
		$image_entity_list = $this->T_file->find_by_related_data(
		                                               $relation_data_type, 
		                                               $relation_data_id,
		                                               $file_type
		                                           );

		//データが無ければ以降の処理は不要
		if (empty($image_entity_list))
		{
			return;
		}

		//画面からのサブミットに含まれていないない画像をファイルシステムから削除する。
		foreach ($image_entity_list as $tmp_entity)
		{
			if ( ! in_array($tmp_entity->file_name, $not_changed_file_list))
			{
				//ファイルを削除する。
				$this->_do_delete_file($arg_upload_dir, $tmp_entity->file_name);

				// サムネイルが存在すれば削除する。
				$this->_do_delete_file($arg_upload_dir, $tmp_entity->file_name, $this->thumbnail_prefix);
				$this->_do_delete_file($arg_upload_dir, $tmp_entity->file_name, $this->thumbnail_m_prefix);
				$this->_do_delete_file($arg_upload_dir, $tmp_entity->file_name, $this->thumbnail_ss_prefix);
			}
		}
	}

	/**
	 * ファイルシステム上のファイルを削除する。
	 * 
	 * @param unknown_type $arg_upload_dir
	 * @param unknown_type $upload_file_name
	 * @param unknown_type $file_prefix
	 */
	private function _do_delete_file($arg_upload_dir, $upload_file_name, $file_prefix = '')
	{
		if(file_exists($arg_upload_dir.$file_prefix.$upload_file_name))
		{
			unlink($arg_upload_dir.$file_prefix.$upload_file_name);
		}
	}

	/**
	 * ファイルのアップロードを行う。
	 * ・アップロードした画像のチェック
	 * ・指定したフォルダにリネームしたファイルを配置する。
	 * ・リネーム後のファイル名を対象の画像のhidden用変数に保持する。
	 * 画像の場合はリサイズし、サムネイルも作成する。
	 * 
	 * @param unknown_type $file_prefix
	 * @param unknown_type $arg_config
	 */
	protected function _upload_image($file_prefix = 'system', $arg_config = FALSE)
	{
		//hiddenから対象のファイルのIDを取得する
		$target_file_key =  $this->data[self::F_TARGET_IMAGE_ID];

		//フォームのname属性からimgかdocか判断して拡張子チェックを切り替え
		$doc_ext = config_item('upload_form_prefix_doc');

		$file_type = preg_match("/$doc_ext/", $target_file_key) 
		             ? File_type::DOCUMENT
		             : File_type::IMAGE;

		$upload_check_config = $this->_get_upload_check_config($file_type, $arg_config); 

		$this->load->library('upload', $upload_check_config);

		//codeigniterのアップロードを実行
		if ( ! $this->upload->do_upload($target_file_key))
		{
			$this->error_list[$target_file_key] = $this->upload->display_errors();
			$this->file_data = FALSE;

			return FALSE;
		}

		//アップロードされたファイルの詳細を取得
		$file_date = $this->upload->data();
		$this->file_data = $file_date;

		//システムで保持する新しいファイル名を作成
		$new_file_pame = create_tmpfile_name(uniqid($file_prefix . '_') . $file_date['file_ext']);

		//画像と通常ファイルでファイルの生成方法を変更
		if ($file_type === File_type::DOCUMENT)
		{
			//通常ファイルであればリネーム
			rename($file_date['full_path'], $file_date['file_path'] . $new_file_pame);
		}
		else
		{
			// 画像のリサイズ
			$this->_resize_image($file_date, $new_file_pame, $this->main_image_width, $this->main_image_height, '');
			$this->_resize_image($file_date, $new_file_pame, $this->thumbnail_width, $this->thumbnail_height, $this->thumbnail_prefix);

			//設定がある場合のみ中サイズのサムネイルを作成
			if ($this->thumbnail_m_width && $this->thumbnail_m_height)
			{
				$this->_resize_image($file_date, $new_file_pame, $this->thumbnail_m_width, $this->thumbnail_m_height, $this->thumbnail_m_prefix);
			}

			//設定がある場合のみ極小サイズのサムネイルを作成
			if ($this->thumbnail_ss_width && $this->thumbnail_ss_height)
			{
				$this->_resize_image($file_date, $new_file_pame, $this->thumbnail_ss_width, $this->thumbnail_ss_height, $this->thumbnail_ss_prefix);
			}

			//元ファイルを削除
			unlink($file_date['full_path']);
		}

		/*
		 * フォーム用に情報をセットする。
		 */

		$this->data["after_{$target_file_key}_exists_flg"] = FALSE;
		$this->data["after_{$target_file_key}"] = $new_file_pame;
	}

	/**
	 * 画像を縮小する
	 * 
	 * @param unknown_type $file_date
	 * @param unknown_type $new_file_pame
	 * @param unknown_type $image_width
	 * @param unknown_type $image_height
	 * @param unknown_type $file_prefix
	 */
	private function _resize_image($file_date, $new_file_pame, $image_width, $image_height, $file_prefix = '')
	{
		$main_image_config = $this->_get_resize_config(
		                                $file_date,
		                                $new_file_pame,
		                                $image_width,
		                                $image_height,
		                                $file_prefix
		                            );

		$this->load->library('image_lib'); 
		$this->image_lib->initialize($main_image_config);
		$this->image_lib->resize();
		$this->image_lib->clear();
	}

	/**
	 * ファイルアップロード用のチェック内容を取得する。
	 * 
	 * @param unknown_type $file_type
	 * @param unknown_type $arg_config
	 */
	private function _get_upload_check_config($file_type, $arg_config = FALSE)
	{
		$config = array();

		//ファイルアップロードを行うライブラリを読み込み
		$config = ( ! $arg_config) 
		          ? $this->_get_upload_config_image() 
		          : $arg_config;

		$config['upload_path'] = $this->departure_upload_dir;

		//fileタグのname属性(upload_imageXX or upload_docXX)によって分岐
		if ($file_type === File_type::DOCUMENT) 
		{
			//ダウンロード用ファイルの場合はファイルサイズの指定なし
			$config['allowed_types'] = config_item('upload_ext_doc');
			$config['max_width'] = FALSE;
			$config['max_height'] = FALSE;
		}
		else
		{
			//画像の場合
			$config['allowed_types'] = config_item('upload_ext_img');
		}

		return $config;
	}

	/**
	 * リサイズ用の設定を取得する
	 * 
	 * @param unknown_type $file_date
	 * @param unknown_type $new_file_pame
	 * @param unknown_type $resize_width
	 * @param unknown_type $resize_height
	 * @param unknown_type $resize_file_prefix
	 */
	private function _get_resize_config($file_date, $new_file_pame, $resize_width, $resize_height, $resize_file_prefix = '')
	{
		$config = array();
		$config['image_library'] = 'gd2';

		$s_width= $file_date['image_width'];
		$s_height = $file_date['image_height'];	

		// リサイズの必要がない場合
		if ($s_width <= $resize_width && $s_height <= $resize_height)
		{
			//そのまま
			$config['width']= $s_width;
			$config['height'] = $s_height;
		}
		else
		{
			// 出力サイズ変更
			$o_width= $s_width;
			$o_height = $s_height;

			if ($resize_width < $s_width)
			{
				$o_width= $resize_width;
				$o_height = $s_height * $resize_width / $s_width;

				if ( $o_height < 1 )
				{
					$o_height = 1;
				}
			}

			if ($resize_height < $o_height && $resize_height < $s_height)
			{
				$o_width= $s_width * $resize_height / $s_height;
				$o_height = $resize_height;

				if ( $o_width < 1 )
				{
					$o_width = 1;
				}
			}

			$config['width']= $o_width;
			$config['height'] = $o_height;
		}

		$config['source_image']	= $file_date['full_path'];
		$config['new_image'] = $resize_file_prefix . $new_file_pame;
		$config['quality'] = '100%';

		return $config;
	}

	/**
	 * アップロードしたファイルの削除を行う
	 * ・hiddenからファイル名を取得する。
	 * ・取得したファイル名を元に一時フォルダから一時ファイルを削除
	 * ・対象の画像のhidden用変数の値を空にする。
	 */
	protected function _delete_image()
	{
		$target_file_key =  $this->data[self::F_TARGET_IMAGE_ID];

		$file = $this->data["after_{$target_file_key}"];

		//ファイルの削除
		if(file_exists($this->departure_upload_dir . $file)){
		    unlink($this->departure_upload_dir . $file);
		}

		//小サイズサムネイルの削除
		if(file_exists($this->departure_upload_dir .$this->thumbnail_prefix . $file)){
		    unlink($this->departure_upload_dir . $this->thumbnail_prefix. $file);
		}

		//中サイズサムネイルの削除
		if(file_exists($this->departure_upload_dir .$this->thumbnail_m_prefix . $file)){
		    unlink($this->departure_upload_dir . $this->thumbnail_m_prefix. $file);
		}

		//極小サイズサムネイルの削除
		if(file_exists($this->departure_upload_dir .$this->thumbnail_ss_prefix . $file)){
		    unlink($this->departure_upload_dir . $this->thumbnail_ss_prefix. $file);
		}

		$this->data["after_{$target_file_key}_exists_flg"] = FALSE;
		$this->data["after_{$target_file_key}"] = '';
	}

	/**
	 * テーブルのINSERT処理
	 * 
	 * @param unknown_type $main_entity
	 * @param unknown_type $session_var
	 */
	protected function _insert_main_table($main_entity, $session_var)
	{
		$main_entity->insert($this->login_user->user_code);

		//DBが採番したIDを取得
		return $this->db->insert_id();
	}

	/**
	 * テーブルのUPDATE処理
	 * 
	 * @param unknown_type $main_entity
	 * @param unknown_type $session_var
	 */
	protected function _update_main_table($main_entity, $session_var)
	{
		$this->main_model->update($this->login_user->user_code, $main_entity);
	}
}
