<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* base_Model.php
* t_postとその派生Viewに特化したモデルの共通親クラス
*/
class Base_post_Model extends Base_Model
{
	var $relation_data_type;  // 関連データタイプ
	var $relation_data_id;  // 関連データID

	/** データ種別。他テーブルのrelation_data_typeと結合するために使用する。 */
	var $data_type;	//データタイプ

	var $post_title;  // 記事タイトル
	var $post_sub_title;   //記事サブタイトル
	var $post_content;  // 記事本文
	var $post_link;  // リンク
	var $post_link_text;  // リンクテキスト
	var $post_date;  // 登録日
	var $post_status;  // 記事ステータス
	var $order_number;  // ソート順
	var $new_icon_end_date;  // NEWアイコン表示終了日
	var $publish_end_date;  // 掲載終了日時
	var $draft_flg;  // 下書きフラグ

	/**
	 * 管理画面用の検索の共通メソッド。
	 * 戻り値：SQL文字列とパラメータを配列にセットしたもの
	 * 
	 * @param unknown_type $params
	 * @param unknown_type $add_keyword_condition	キーワード検索の対象とする条件を追加する配列
	 * @param unknown_type $add_select_column SELECT句を追加する場合の文字列。カンマ始まりの文字列とすること。
	 */
	protected function create_query_for_manage($params, $add_keyword_condition = array(), $add_select_column = '')
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.*
				,(	SELECT
						kubun_code 
					FROM
						v_relation_kubun AS SUB
					WHERE 
						SUB.parent_relation_data_type = MAIN.data_type
						AND SUB.parent_relation_data_id = MAIN.id
						AND SUB.child_kubun_type = ?
						ORDER BY id ASC
						LIMIT 1 OFFSET 0
	        	) AS main_category_kubun_code /* カテゴリーを1件のみ取得する */
	        	{$add_select_column}
			FROM
				{$this->_table} AS MAIN
			WHERE
				MAIN.del_flg = ?
		";

		$value_array[] = Kubun_type::CATEGORY;
		$value_array[] = Del_flg::NOT_DELETE;

		//関連データタイプとID
		if (isset($params['relation_data_type']) && is_not_blank($params['relation_data_type'])
		&& isset($params['relation_data_id']) && is_not_blank($params['relation_data_id']))
		{
			$sql .= '
				AND MAIN.relation_data_type = ?
				AND MAIN.relation_data_id = ?
			';

			$value_array[] = $params['relation_data_type'];
			$value_array[] = $params['relation_data_id'];
		}

		//id
		if (isset($params['id']) && is_not_blank($params['id']))
		{
			$sql .= '
				AND MAIN.id = ?
			';

			$value_array[] = $params['id'];
		}

		//公開/非公開
		if (isset($params['draft_flg']) && is_not_blank($params['draft_flg']))
		{
			$sql .= '
				AND MAIN.draft_flg = ?
			';

			$value_array[] = $params['draft_flg'];
		}

		//基本カテゴリーを区分IDで検索
		if (isset($params['category_ids']) 
		&& is_array_has_content($params['category_ids']))
		{
			$questions = get_question_str($params['category_ids']);
			
			$sql .= "
				AND EXISTS(
					SELECT
						SUB.*
					FROM
						v_relation_kubun SUB
					WHERE
						SUB.del_flg = ?
						AND SUB.parent_relation_data_type = MAIN.data_type
						AND SUB.parent_relation_data_id = MAIN.id
						AND SUB.child_relation_data_type = ?
						AND SUB.child_kubun_type = ?
						AND SUB.child_relation_data_id IN ({$questions})
				)
			";

			$value_array[] = Del_flg::NOT_DELETE;
			$value_array[] = Relation_data_type::KUBUN;
			$value_array[] = Kubun_type::CATEGORY;
			$value_array = array_merge($value_array, $params['category_ids']);
		}

		/*
		 * 区分IDを条件にセットする。
		 * 複数の条件をセット可能。
		 */

		if (isset($params['column_kubun_id_condition_list']) 
		&& ! empty($params['column_kubun_id_condition_list']))
		{
			foreach ($params['column_kubun_id_condition_list'] as $column_kubun_code_info)
			{
				if (isset($column_kubun_code_info['kubun_ids']) 
				&& is_array_has_content($column_kubun_code_info['kubun_ids']))
				{
					$questions = get_question_str($column_kubun_code_info['kubun_ids']);

					$sql .= "
						AND EXISTS(
							SELECT
								SUB.*
							FROM
								v_relation_kubun SUB
							WHERE
								SUB.del_flg = ?
								AND SUB.parent_relation_data_type = MAIN.data_type
								AND SUB.parent_relation_data_id = MAIN.id
								AND SUB.child_relation_data_type = ?
								AND SUB.child_kubun_type = ?
								AND SUB.child_relation_data_id IN ({$questions})
						)
					";
		
					$value_array[] = Del_flg::NOT_DELETE;
					$value_array[] = Relation_data_type::KUBUN;
					$value_array[] = $column_kubun_code_info['kubun_type'];
					$value_array = array_merge($value_array, $column_kubun_code_info['kubun_ids']);
				}
			}
		}

		/*
		 * キーワードのLIKE検索。
		 * 巨大なAND句を作成し、その中に複数のLIKE句をORでつなげる。
		 */

		if (isset($params['keyword']) && is_not_blank($params['keyword']))
		{
			$keyword_array = explode_for_like($params['keyword']);

			//検索対象のカラムを追加する場合は$add_keyword_conditionを使用して追加する
			$like_array = array_merge(
			                  $add_keyword_condition,
			                  array(
			                      ' MAIN.post_title LIKE ? ',
			                      ' MAIN.post_content LIKE ? '
			                  )
			              );

			$merged_like = array();

			//SQLを生成するため単語数×カラム数だけOR句を生成
			for ($i = 0; $i < count($keyword_array); $i++)
			{
				$merged_like = array_merge($merged_like, $like_array);
			}

			//全てのLIKE句をORで繋げた文字列を作成
			$merged_like_str = implode(' OR ', $merged_like);

			$sql .= " 
				AND (
					{$merged_like_str}
				)
			";

			//検索ワードの数 * カラム数だけ?と置き換える列をセットする
			foreach ($keyword_array as $like_tmp)
			{
				$lise_str = $this->db->escape_like_str($like_tmp);

				for ($i = 0; $i < count($like_array); $i++)
				{
					$value_array[] = "%{$lise_str}%";
				}
			}
		}

		return array(
		           'sql' => $sql,
		           'value_array' => $value_array
		       );
	}

	/**
	 * 公開画面用の検索の共通メソッド。
	 * 戻り値：SQL文字列とパラメータを配列にセットしたもの
	 * 
	 * @param unknown_type $params
	 * @param unknown_type $add_keyword_condition	キーワード検索の対象とする条件を追加する配列
	 * @param unknown_type $add_select_column SELECT句を追加する場合の文字列。カンマ始まりの文字列とすること。
	 */
	protected function create_query_for_front($params, $add_keyword_condition = array(), $add_select_column = '')
	{
		/** 定数を展開して使用するため変数に一時的にセット */
		$new_icon_show = New_icon_show_flg::SHOW;
		$new_icon_not_show = New_icon_show_flg::NOT_SHOW;

		$value_array = array();

		$sql = "
			SELECT
				MAIN.*
				,(	SELECT
						kubun_code 
					FROM
						v_relation_kubun AS SUB
					WHERE 
						SUB.parent_relation_data_type = MAIN.data_type
						AND SUB.parent_relation_data_id = MAIN.id
						AND SUB.child_kubun_type = ?
						ORDER BY id ASC
						LIMIT 1 OFFSET 0
	        	) AS main_category_kubun_code /* カテゴリーを1件のみ取得する */
				,CASE 
					WHEN
						MAIN.new_icon_end_date IS NOT NULL 
						AND DATE(MAIN.new_icon_end_date) >= CURRENT_DATE() 
						THEN {$new_icon_show}
					ELSE {$new_icon_not_show}
					END AS new_icon_show_flg /* NEWアイコン表示可否フラグ。 */
	        	{$add_select_column}
				FROM
				{$this->_table} AS MAIN
			WHERE
				MAIN.del_flg = ?
				AND MAIN.draft_flg = ?
				AND DATE(MAIN.post_date) <= CURRENT_DATE() 
				AND ( (DATE(MAIN.publish_end_date) >= CURRENT_DATE()) 
					OR (MAIN.publish_end_date IS NULL) )
		";

		$value_array[] = Kubun_type::CATEGORY;
		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = Draft_flg::NOT_DRAFT;

		//関連データタイプとID
		if (isset($params['relation_data_type']) && is_not_blank($params['relation_data_type'])
		&& isset($params['relation_data_id']) && is_not_blank($params['relation_data_id']))
		{
			$sql .= '
				AND MAIN.relation_data_type = ?
				AND MAIN.relation_data_id = ?
			';

			$value_array[] = $params['relation_data_type'];
			$value_array[] = $params['relation_data_id'];
		}

		//id
		if (isset($params['id']) && is_not_blank($params['id']))
		{
			$sql .= '
				AND MAIN.id = ?
			';

			$value_array[] = $params['id'];
		}

		/*
		 * キーワードのLIKE検索。
		 * 巨大なAND句を作成し、その中に複数のLIKE句をORでつなげる。
		 */

		if (isset($params['keyword']) && is_not_blank($params['keyword']))
		{
			$keyword_array = explode_for_like($params['keyword']);

			//検索対象のカラムを追加する場合は$add_keyword_conditionを使用して追加する
			$like_array = array_merge(
			                  $add_keyword_condition,
			                  array(
			                      ' MAIN.post_title LIKE ? ',
			                      ' MAIN.post_content LIKE ? '
			                  )
			              );

			$merged_like = array();

			//SQLを生成するため単語数×カラム数だけOR句を生成
			for ($i = 0; $i < count($keyword_array); $i++)
			{
				$merged_like = array_merge($merged_like, $like_array);
			}

			//全てのLIKE句をORで繋げた文字列を作成
			$merged_like_str = implode(' OR ', $merged_like);

			$sql .= " 
				AND (
					{$merged_like_str}
				)
			";

			//検索ワードの数 * カラム数だけ?と置き換える列をセットする
			foreach ($keyword_array as $like_tmp)
			{
				$lise_str = $this->db->escape_like_str($like_tmp);

				for ($i = 0; $i < count($like_array); $i++)
				{
					$value_array[] = "%{$lise_str}%";
				}
			}
		}

		/*
		 * テーブル独自の条件があればセット
		 */
		if (isset($params['column_kubun_code_condition_list']) 
		&& ! empty($params['column_kubun_code_condition_list']))
		{
			foreach ($params['column_kubun_code_condition_list'] as $column_kubun_code_info)
			{
				if (isset($column_kubun_code_info['kubun_codes']) 
				&& is_array_has_content($column_kubun_code_info['kubun_codes']))
				{
					$questions = get_question_str($column_kubun_code_info['kubun_codes']);
		
					$sql .= "
						AND EXISTS (
							SELECT 
								* 
							FROM 
								m_kubun AS KUBUN
							WHERE
								KUBUN.relation_data_type = MAIN.data_type 
								AND KUBUN.id = MAIN.{$column_kubun_code_info['column_name']} 
								AND kubun_type = ? 
								AND kubun_code IN ({$questions}) 
						)
					";
		
					$value_array[] = $column_kubun_code_info['kubun_type'];
					$value_array = array_merge($value_array, $column_kubun_code_info['kubun_codes']);
				}
			}
		}

		//relationテーブルの区分コードで検索する
		if (isset($params['kubun_code_condition_list']) 
		&& ! empty($params['kubun_code_condition_list']))
		{
			foreach ($params['kubun_code_condition_list'] as $kubun_type => $kubun_codes)
			{
				if (is_array_has_content($kubun_codes))
				{
					$questions = get_question_str($kubun_codes);
		
					$sql .= "
						AND EXISTS(
							SELECT
								SUB.*
							FROM
								v_relation_kubun SUB
							WHERE
								SUB.del_flg = ?
								AND SUB.parent_relation_data_type = MAIN.data_type
								AND SUB.parent_relation_data_id = MAIN.id
								AND SUB.child_relation_data_type = ?
								AND SUB.child_kubun_type = ?
								AND SUB.kubun_code IN ({$questions})
						)
					";
		
					$value_array[] = Del_flg::NOT_DELETE;
					$value_array[] = Relation_data_type::KUBUN;
					$value_array[] = $kubun_type;
					$value_array = array_merge($value_array, $kubun_codes);
				}
			}
		}

		return array(
		           'sql' => $sql,
		           'value_array' => $value_array
		       );
	}

	/**
	 * 公開可能なエンティティを1件取得する。
	 * 公開側検索用SELECTを1エンティティに限定できる条件で呼び出している。
	 * 同名メソッドをオーバーライドしている。
	 * @see Base_Model::find_released()
	 */
	function find_released($id)
	{
		/*
		 * IDを指定するだけのシンプルなSQLを生成する
		 */

		$nds_pagination = new Nds_pagination(); 
		$params = array('id' => $id);

		$basic_query_ret = $this->create_query_for_front($params);

		$list = $this->_do_paging_select(
		                   $nds_pagination,
		                   $basic_query_ret['sql'],
		                   $basic_query_ret['value_array']
		               );

		return ($list)
		       ? $list[0]
		       : FALSE;
	}

	/**
	 * 指定した条件に合うレコードのうち、更新日時が一番最新のエンティティを1つ取得します。
	 * 
	 * @param unknown_type $params
	 */
	function get_latest_entity($params)
	{
		/*
		 * シンプルなSQLを生成する
		 */

		$nds_pagination = new Nds_pagination();
		$nds_pagination->add_order('MAIN.update_datetime', 'DESC');

		$basic_query_ret = $this->create_query_for_front($params);

		$list = $this->_do_paging_select(
		                   $nds_pagination,
		                   $basic_query_ret['sql'],
		                   $basic_query_ret['value_array']
		               );

		return ($list)
		       ? $list[0]
		       : FALSE;
	}

	/**
	 * 関係情報が一致するデータを一括で物理削除する。
	 * 
	 * @param unknown_type $relation_data_type
	 * @param unknown_type $relation_data_id
	 */
	function delete_by_relation($relation_data_type, $relation_data_id)
	{
		parent::delete_by_params(array(
		                             'relation_data_type' => $relation_data_type,
		                             'relation_data_id' => $relation_data_id
		                         ));
	}

	/**
	 * 
	 * 
	 * @param unknown_type $params
	 * @param unknown_type $nds_pagination
	 */
	function simple_select_for_manage($params, Nds_pagination $nds_pagination = NULL)
	{
		//基本的なSQLとパラメータを生成する。
		$basic_query_ret = $this->create_query_for_manage($params);

		$sql = $basic_query_ret['sql'];
		$value_array = $basic_query_ret['value_array'];

		if ( ! $nds_pagination)
		{
			$nds_pagination = new Nds_pagination(FALSE);
			$nds_pagination->add_order('order_number', 'ASC');
			$nds_pagination->add_order('id', 'DESC');
		}

		return $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}

	/**
	 * 
	 * 
	 * @param unknown_type $params
	 * @param unknown_type $nds_pagination
	 */
	function simple_select_for_front($params, Nds_pagination $nds_pagination = NULL)
	{
		//基本的なSQLとパラメータを生成する。
		$basic_query_ret = $this->create_query_for_front($params);

		$sql = $basic_query_ret['sql'];
		$value_array = $basic_query_ret['value_array'];

		if ( ! $nds_pagination)
		{
			$nds_pagination = new Nds_pagination(FALSE);
			$nds_pagination->add_order('order_number', 'ASC');
			$nds_pagination->add_order('id', 'DESC');
		}

		return $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}
}