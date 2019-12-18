<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 製品のモデル
 * 
 * @author ta-ando
 *
 */
class M_item extends Base_post_Model
{
	/* カラムの追加があればここに記述 */

	/**
	 * このクラスのモデルのインスタンスを生成して返す
	 */
	public function create_model_instance()
	{
		return new self();
	}

	/**
	 * 管理画面用にSELECTを行うメソッド。
	 * $count_onlyフラグがTRUEの場合はSELECT COUNT(*)の結果を返す。
	 * 
	 * @param unknown_type $nds_pagination
	 * @param unknown_type $params
	 * @param unknown_type $count_only
	 */
	function select_for_manage(Nds_pagination $nds_pagination, $params, $count_only = FALSE)
	{
		//基本的なSQLとパラメータを生成する。
		$basic_query_ret = parent::create_query_for_manage($params);

		$sql = $basic_query_ret['sql'];
		$value_array = $basic_query_ret['value_array'];

		/*
		 * テーブル独自の条件があればセット
		 */

		// SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}

	/**
	 * 公開画面用にSELECTを行うメソッド。
	 * $count_onlyフラグがTRUEの場合はSELECT COUNT(*)の結果を返す。
	 * 
	 * @param unknown_type $nds_pagination
	 * @param unknown_type $params
	 * @param unknown_type $count_only
	 */
	function select_for_front(Nds_pagination $nds_pagination, $params, $count_only = FALSE)
	{
		//基本的なSQLとパラメータを生成する。
		$basic_query_ret = parent::create_query_for_front($params);

		$sql = $basic_query_ret['sql'];
		$value_array = $basic_query_ret['value_array'];
	
		/*
		 * 製品のキーワードのLIKE検索。
		 * 巨大なAND句を作成し、その中に複数のLIKE句をORでつなげる。
		 */

		if (isset($params['item_keyword']) && is_not_blank($params['item_keyword']))
		{
			$keyword_array = explode_for_like($params['item_keyword']);

			//検索対象のカラムを追加する場合は$add_keyword_conditionを使用して追加する
			$like_array = array(
			                      ' MAIN.post_title LIKE ? ',
			                      ' MAIN.post_sub_title LIKE ? ',
			                      ' MAIN.post_content LIKE ? ',
			                      ' EXISTS (
										SELECT
											*
										FROM
											t_item_keyword AS ITEM_KEYWORD
										WHERE
											ITEM_KEYWORD.relation_data_type = '.Relation_data_type::ITEM. '
											AND ITEM_KEYWORD.relation_data_id = MAIN.id
											AND post_title LIKE ? 
									)'
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
	
		//技術情報を区分コードで検索する
		if (isset($params['technology_kubun_codes']) 
		&& is_array_has_content($params['technology_kubun_codes']))
		{
			$questions = get_question_str($params['technology_kubun_codes']);

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
			$value_array[] = Kubun_type::TECHNOLOGY;
			$value_array = array_merge($value_array, $params['technology_kubun_codes']);
		}

		//その他の属性（おすすめ）を区分コードで検索する
		if (isset($params['other_attribute_kubun_codes']) 
		&& is_array_has_content($params['other_attribute_kubun_codes']))
		{
			$questions = get_question_str($params['other_attribute_kubun_codes']);

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
			$value_array[] = Kubun_type::OTHER_ATTRIBUTE;
			$value_array = array_merge($value_array, $params['other_attribute_kubun_codes']);
		}

		//ダウンロードファイルの有無
		if (isset($params['download_exists']) 
		&& $params['download_exists'])
		{
			$sql .= "
				AND 
				(
					EXISTS(
						SELECT
							DOWNLOAD.*
						FROM
							t_item_download DOWNLOAD
						WHERE
							DOWNLOAD.del_flg = ?
							AND DOWNLOAD.draft_flg = ?
							AND DOWNLOAD.relation_data_type = ?
							AND DOWNLOAD.relation_data_id = MAIN.id
					)
					OR
					EXISTS(
						SELECT
							CUTAWAY.*
						FROM
							t_item_cutaway CUTAWAY
						WHERE
							CUTAWAY.del_flg = ?
							AND CUTAWAY.draft_flg = ?
							AND CUTAWAY.relation_data_type = ?
							AND CUTAWAY.relation_data_id = MAIN.id
					)
					OR
					EXISTS(
						SELECT
							SEKOU.*
						FROM
							t_item_sekou_results SEKOU
						WHERE
							SEKOU.del_flg = ?
							AND SEKOU.draft_flg = ?
							AND SEKOU.relation_data_type = ?
							AND SEKOU.relation_data_id = MAIN.id
					)
				)
			";
	
			$value_array[] = Del_flg::NOT_DELETE;
			$value_array[] = Draft_flg::NOT_DRAFT;
			$value_array[] = Relation_data_type::ITEM;
			$value_array[] = Del_flg::NOT_DELETE;
			$value_array[] = Draft_flg::NOT_DRAFT;
			$value_array[] = Relation_data_type::ITEM;
			$value_array[] = Del_flg::NOT_DELETE;
			$value_array[] = Draft_flg::NOT_DRAFT;
			$value_array[] = Relation_data_type::ITEM;
		}

		//ランキング上位何位までに入っているか？
		if (isset($params['ranking_top_exists']) 
		&& $params['ranking_top_exists'])
		{
			$sql .= "
				AND EXISTS(
					SELECT
						DOWNLOAD.*
					FROM
						(
							SELECT
								*
							FROM
								v_item_current_access_counter AS V_COUNTER
							ORDER BY
								V_COUNTER.access_count DESC
							 LIMIT ? OFFSET 0
						) AS TOP_RANKING
					WHERE
						TOP_RANKING.item_id = MAIN.id
				)
			";

			$value_array[] = 30;
		}

		// SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}

	/**
	 * 製品名を条件にエンティティを取得する。
	 * 
	 * @param unknown_type $post_title
	 */
	function find_by_post_title($post_title)
	{
		return $this->select_entity_by_params(array('post_title' => $post_title));
	} 

	/**
	 * 製品名を取得する。
	 * 
	 * @param unknown_type $post_id
	 */
	function get_item_name($post_id)
	{
		return $this->select_column($post_id, 'post_title');
	}

	/**
	 * ランキングを検索する
	 * 
	 * @param unknown_type $nds_pagination
	 * @param unknown_type $params
	 * @param unknown_type $count_only
	 */
	function select_for_ranking(Nds_pagination $nds_pagination, $params, $count_only = FALSE)
	{
		$value_array = array();

		$sql = "
			SELECT
				MAIN.*,
				ACCESS_COUNT.access_count
			FROM
				{$this->_table} AS MAIN
				INNER JOIN v_item_current_access_counter AS ACCESS_COUNT
					ON ACCESS_COUNT.item_id = MAIN.id
			WHERE
				MAIN.del_flg = ?
				AND ( 
					(DATE(MAIN.publish_end_date) >= CURRENT_DATE()) 
					OR (MAIN.publish_end_date IS NULL) 
				)
				AND MAIN.draft_flg = ? 
		";

		$value_array[] = Del_flg::NOT_DELETE;
		$value_array[] = Draft_flg::NOT_DRAFT;

		//おすすめに選ばれている製品のみ
		if (isset($params['recommend_only']) && $params['recommend_only'])
		{
			$sql .= "
				AND EXISTS (
					SELECT
						OTHER_ATTRIBUTE.*
					FROM
						v_relation_kubun AS OTHER_ATTRIBUTE
					WHERE
						OTHER_ATTRIBUTE.parent_relation_data_type = ?
						AND OTHER_ATTRIBUTE.parent_relation_data_id = MAIN.id
						AND OTHER_ATTRIBUTE.child_relation_data_type = ?
						AND OTHER_ATTRIBUTE.child_kubun_type = ?
						AND OTHER_ATTRIBUTE.kubun_code = ?
				)
			";

			$value_array[] = Relation_data_type::ITEM;
			$value_array[] = Relation_data_type::KUBUN;
			$value_array[] = Kubun_type::OTHER_ATTRIBUTE;
			$value_array[] = Item_kubun_code::OTHER_RECOMMEND;
		}

		// SELECT COUNT(*)かLIMIT/OFFSETを使ったSELECTかを分岐して処理。
		return ($count_only)
		       ? $this->db->query($sql, $value_array)->num_rows()
		       : $this->_do_paging_select($nds_pagination, $sql, $value_array);
	}
}