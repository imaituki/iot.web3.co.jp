<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 
 * 固定ページの一括登録を行うクラス
 * @author ta-ando
 *
 */
class Freetext_bundle_register extends Post_register_Controller 
{
	/* パラメータの追加があればここに記述 */

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

		$this->target_data_type = Relation_data_type::FREETEXT;
		$this->package_name = 'freetext';
		$this->package_label = config_item("{$this->package_name}_package_name_label");
		$this->common_h3_tag = "{$this->package_label}";
		$this->page_type = Page_type::REGISTER;
		$this->current_main_menu = $this->package_name;
		$this->main_model = $this->T_freetext;
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

		$this->_do_db_logic();
		
		echo "Finished.";
		//$this->_load_tpl($this->_get_view_name(View_type::INPUT), $this->data);
	}

	/**
	 * DBへの更新処理を行うロジック
	 * 
	 */
	private function _do_db_logic()
	{
		$this->db->trans_start();

		foreach ($this->freetext_kubun_list as $kubun_code => $value)
		{
			$v_relation_entity = $this->V_relation_kubun->get_one_entity_by_kubun_code(
	                                                  Relation_data_type::FREETEXT,
	                                                  Kubun_type::CATEGORY,
	                                                  $kubun_code
	                                              );

			if ( $v_relation_entity)
			{
				continue;
			}

			$kubun_id = $this->M_kubun->convert_kubun_code_to_id(
			                                Relation_data_type::FREETEXT,
			                                Kubun_type::CATEGORY,
			                                $kubun_code);

			$entity = new T_freetext();
			$entity->relation_data_type = Relation_data_type::COMMON;
			$entity->relation_data_id = Relation_data_id::DEFAULT_ID;
			$entity->data_type = $this->target_data_type;
			$entity->post_date = create_db_datetme_str(date("Y/m/d"));
			$entity->draft_flg = Draft_flg::NOT_DRAFT;
			$entity->post_title = "";
			$entity->post_content = "";
			$entity->insert($this->login_user->user_code);

			$post_id = $this->db->insert_id();

			//基本カテゴリーをDELETE/INSERT
			$this->T_relation->delete_insert_list(
			                       $this->target_data_type,
			                       $post_id,
			                       Relation_data_type::KUBUN,
			                       Kubun_type::CATEGORY,
			                       create_array_param($kubun_id)
			                   );
		}

		$this->db->trans_complete();
	}
}