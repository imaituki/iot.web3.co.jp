<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 *  応募の確認を行うクラス
 * * @author ta-ando
 *
 */
class Apply_detail extends Post_register_Controller 
{
	const EVENT_ID = 'event_id';
	const APPLY_ID = 'apply_id';

	/** フォームで使用するパラメータ名 */
	const F_NAME = 'name';
	const F_FURIGANA = 'furigana';
	const F_COMPANY_NAME = 'company_name';
	const F_EMAIL = 'email';
	const F_EMAIL_CHECK = 'email_check';
	const F_PHONE_NUMBER = 'phone_number';
	const F_POSTAL_CODE1 = 'postal_code1';
	const F_POSTAL_CODE2 = 'postal_code2';
	const F_PLACE = 'place';
	const F_OTHER_INQUIRY = 'other_inquiry';
	const F_POSITION = 'position';

	/* パラメータの追加があればここに記述 */
	
	/** 画面に受け渡す変数 */ 
	const F_BASIC_FORM = 'basic_form'; //メールフォームの基本項目用接頭辞
	const F_OPTIONAL_FORM = 'optional_form'; //メールフォームの追加項目用接頭辞
	const F_OPTION_FORM_USE_FLG = 'option_form_use_flg';	//メールフォームの追加項目の使用可否

	/** 申し込みフォームの基本項目のソート順を保持する文字列 */
	const F_BASIC_COLUMN_ORDER_NUM_STR = 'basic_column_order_num_str';
	/** 申し込みフォームの追加項目のソート順を保持する文字列 */
	const F_OPTIONAL_COLUMN_ORDER_NUM_STR = 'optional_column_order_num_str';

	var $max_basic_form;
	var $max_optional_form;

	/** 複数項目のサブキー */
	static $sub_keys = array(
		'form_type',
		'require_flg',
		'title',
		'choices',
		'input',
		'choices_list',
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

		$this->target_data_type = Relation_data_type::APPLY;
		$this->package_name = 'apply';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}詳細";
		$this->page_type = Page_type::DETAIL;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->T_apply;
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
		 * handle_relationメソッドへのアクセスがある場合はチェック不要
		 */

		if ( ! $this->application_session_data->can_access_package($this->package_name)
		&& ! $this->_is_method_match('handle_relation'))
		{
			show_error('不正な画面遷移が行われています。再度メニューから操作を行ってください。');
		}

		/*
		 * 編集対象のデータを取得して画面表示用に保持する。
		 */

		if ( ! $this->_is_method_match()
		&& ! $this->_is_method_match('handle_relation'))
		{
			$this->_load_entity_from_session();
		}

		$this->max_basic_form = Mail_form_type::get_max(Mail_form_type::BASIC);
		$this->max_optional_form = Mail_form_type::get_max(Mail_form_type::OPTION);

		//HTTPのGET,POST情報を$this->dataに移送。メンバ以外にも上記の初期化を行ったキーもHTTPリクエストが送信されていれば取得する。
		$this->_httpinput_to_data($this->optional_keys);
	}

	/**
	 * 初期表示を行う。
	 * 
	 * @param unknown_type $event_id
	 * @param unknown_type $apply_id
	 */
	public function index($event_id, $apply_id)
	{
		/*
		 * 初期処理
		 */

		$this->_unset_page_session();
		$this->_save_page_session(self::EVENT_ID, $event_id);
		$this->_save_page_session(self::APPLY_ID, $apply_id);

		/*
		 * フォーム項目を読み込み
		 */

		$event_entity = $this->T_info->find($event_id);

		$this->_load_form_item($event_entity->free_form_id, Mail_form_type::BASIC);
		$this->_load_form_item($event_entity->free_form_id, Mail_form_type::OPTION);

		/*
		 * DBデータを読み込み、表示用にローカル変数にセットする。
		 */

		$this->_load_main_table($apply_id);

		$this->_load_tpl($this->_get_view_name(View_type::CONF), $this->data);
	}

	/**
	 * (non-PHPdoc)
	 * @see Register_Controller::_create_optional_form_key()
	 */
	protected function _create_optional_form_key()
	{
		parent::_create_optional_form_key();

		//フォーム部品を追加
		$this->optional_keys = array_merge(
			$this->optional_keys,
			$this->_init_mailform_detail(Mail_form_type::BASIC),
			$this->_init_mailform_detail(Mail_form_type::OPTION)
		);
	}

	/**
	 * 
	 * 
	 * @param unknown_type $post_id
	 * @param unknown_type $mail_form_type
	 */
	protected function _load_form_item($post_id, $mail_form_type)
	{
		if ($mail_form_type === Mail_form_type::BASIC)
		{
			$max = Mail_form_type::get_max(Mail_form_type::BASIC);
			$mail_form_type_prefix = self::F_BASIC_FORM;
		}
		else
		{
			$max = Mail_form_type::get_max(Mail_form_type::OPTION);
			$mail_form_type_prefix = self::F_OPTIONAL_FORM;
		}

		$params = array();
		$params["relation_data_type"] = Relation_data_type::FREE_FORM;
		$params["relation_data_id"] = $post_id;
		$params["column_type"] = $mail_form_type;

		$detail_list = $this->T_free_form_item->select_by_params($params, FALSE, "order_number ASC, id ASC");

		$form_column_no_list = array();

		foreach ($detail_list as $detail_entity)
		{
			//column_noは1始まりの項目の順番と同じ
			$column_no = $detail_entity->column_no;

			$this->data[$mail_form_type_prefix."{$column_no}_title"] = $detail_entity->title;
			$this->data[$mail_form_type_prefix."{$column_no}_form_type"] = $detail_entity->form_type;
			$this->data[$mail_form_type_prefix."{$column_no}_require_flg"] = $detail_entity->require_flg;
			$this->data[$mail_form_type_prefix."{$column_no}_choices"] = $detail_entity->choices;

			//column_noを順に保持する(order順となる)
			$form_column_no_list[] = $column_no;
		}

		//メールフォーム項目の並び順としてcolumn_noをカンマつなぎにした文字列を画面に渡す
		if ($mail_form_type === Mail_form_type::BASIC)
		{
			$this->data[self::F_BASIC_COLUMN_ORDER_NUM_STR] = implode(',', $form_column_no_list);
		}
		else
		{
			$this->data[self::F_OPTIONAL_COLUMN_ORDER_NUM_STR] = implode(',', $form_column_no_list);
		}
	}

	/**
	 * メールフォームの複数項目のアップロードフォームのキーをthis->dataにセットして初期値をセットする処理
	 * 戻り値で作成したキーの配列を返します。
	 * 
	 * @param unknown_type $mail_form_type
	 */
	private function _init_mailform_detail($mail_form_type)
	{
		if ($mail_form_type === Mail_form_type::BASIC)
		{
			$max = Mail_form_type::get_max(Mail_form_type::BASIC);
			$mail_form_type_prefix = self::F_BASIC_FORM;
		}
		else
		{
			$max = Mail_form_type::get_max(Mail_form_type::OPTION);
			$mail_form_type_prefix = self::F_OPTIONAL_FORM;
		}

		$oitional_keys = array();

		// メールフォーム用に複数項目あるフォーム用の初期化処理
		for ($i = 1; $i <= $max; $i++)
		{
			$column_no = $i;

			foreach (self::$sub_keys as $value)
			{
				$nest_key = "{$mail_form_type_prefix}{$column_no}_{$value}";

				$this->data[$nest_key] = '';
				$this->error_list[$nest_key] = '';

				//キーを保持
				$oitional_keys[] = $nest_key;
			}
		}

		return $oitional_keys;
	}

	/**
	 * 画面でメインに使用するテーブルを読み込み保持する。
	 * 
	 * @param unknown_type $id
	 */
	private function _load_main_table($id)
	{
		$entity = $this->T_apply->find($id);

		if ( ! $entity) 
		{
			//エラーページを表示して処理終了
			show_error('応募者が選択されていません');
			return;	//実際にはこのRETURNには到達しない 
		}

		$this->data = array_merge($this->data, (array)$entity);

		/*
		 * 追加項目用カラムを画面用にセット
		 */

		for ($i = 1; $i <= Mail_form_type::get_max(Mail_form_type::OPTION); $i++)
		{
			$column_no = $i;

			//連番のキーを作成
			$form_type_key = self::F_OPTIONAL_FORM."{$column_no}_form_type";
			$input_key = self::F_OPTIONAL_FORM."{$column_no}_input";
			$column_name = "optional_form{$column_no}";

			if ($this->data[$form_type_key] === Form_type::MULTI_CHECKBOX)
			{
				$this->data[$input_key] = explode("|", $entity->$column_name);
			}
			else
			{
				$this->data[$input_key] = $entity->$column_name;
			}
		}
	}
}