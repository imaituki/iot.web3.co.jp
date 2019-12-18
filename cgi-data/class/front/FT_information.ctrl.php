<?php
//----------------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容: お知らせクラス
//----------------------------------------------------------------------------

//-------------------------------------------------------
//  クラス
//-------------------------------------------------------
class FT_information {

	//-------------------------------------------------------
	//  変数宣言
	//-------------------------------------------------------
	// DB接続
	var $_DBconn = null;

	// 主テーブル
	var $_CtrTable   = "t_information";
	var $_CtrTablePk = "id_information";

	// コントロール機能（ログ用）
	var $_CtrLogName = "お知らせ";


	//-------------------------------------------------------
	// 関数名: __construct
	// 引  数: $dbconn  :  DB接続オブジェクト
	// 戻り値: なし
	// 内  容: コンストラクタ
	//-------------------------------------------------------
	function __construct( $dbconn ) {

		// クラス宣言
		if( !empty( $dbconn ) ) {
			$this->_DBconn  = $dbconn;
		} else {
			$this->_DBconn  = new DB_manage( _DNS );
		}

	}


	//-------------------------------------------------------
	// 関数名: __destruct
	// 引  数: なし
	// 戻り値: なし
	// 内  容: デストラクタ
	//-------------------------------------------------------
	function __destruct() {

	}


	//-------------------------------------------------------
	// 関数名: GetSearchList
	// 引  数: $search - 検索条件
	//       : $option - 取得条件
	// 戻り値: リスト
	// 内  容: 検索を行いデータを取得
	//-------------------------------------------------------
	function GetSearchList( $search, $option = null, $limit = null ) {

		// SQL配列
		$creation_kit = array(  "select" => "*",
								"from"   => $this->_CtrTable,
								"where"  => "date <= NOW() AND
											 display_flg = 1 AND
											 ( display_indefinite = 1 OR ( display_indefinite = 0 AND display_start <= NOW() AND  NOW() <= display_end  ) ) ",
								"order"  => "date DESC"
							);

		if( !empty($search["cid"]) ){
			$creation_kit["where"] .= " AND id_category = ". $search["cid"]. " ";
		}
		//-------------------------------------------
		// 検索条件
		//-------------------------------------------
		// 掲載箇所
		if( !empty( $search["search_id_category"] ) ){
			$creation_kit["where"] .= "AND display_site REGEXP '^". $search["search_id_category"] ."$|^". $search["search_id_category"] .",|,". $search["search_id_category"] ."$|,". $search["search_id_category"] .",' ";
		}
		// 取得条件
		if( empty( $option ) ) {

			// ページ切り替え配列
			$_PAGE_INFO = array( "PageNumber"      => $search["page"],
								 "PageShowLimit"   => _PAGESHOWLIMIT,
								 "PageNaviLimit"   => _PAGENAVILIMIT,
								 "LinkSeparator"   => " ",
								 "LinkBackText"    => "&lt; 前へ",
								 "LinkNextText"    => "次へ &gt;",
								 "LinkBackClass"   => "next",
								 "LinkNextClass"   => "back",
								 "LinkSpanPref"    => "<li>",
								 "LinkSpanPost"    => "</li>",
								 "LinkSpanNowPref" => "<strong>",
								 "LinkSpanNowPost" => "</strong>" );

			// オプション
			$option = array( "fetch" => _DB_FETCH_ALL,
							 "page"  => $_PAGE_INFO );

		} else {

			// 取得件数制限
			if( !empty( $limit ) ) {
				$creation_kit["limit"] = $limit;
			}

		}

		// データ取得
		$res = $this->_DBconn->selectCtrl( $creation_kit, $option );

		// タグ許可
		if( !empty($res["data"]) && is_array($res["data"]) ) {
			foreach( $res["data"] as $key => $val ) {
				if( !empty( $res["data"][$key]["comment"] ) ) {
					$res["data"][$key]["comment"] = html_entity_decode( $res["data"][$key]["comment"] );
				}
			}
		} elseif( !empty($res) && is_array($res) ) {
			foreach( $res as $key => $val ) {
				if( !empty( $res[$key]["comment"] ) ) {
					$res[$key]["comment"] = html_entity_decode( $res[$key]["comment"] );
				}
			}
		}

		if( is_array( $res["data"] ) ) {
			foreach( $res["data"] as $key => $val ) {
				if( !empty( $res["data"][$key]["id_category"] ) ) {
					$res["data"][$key]["id_category"] = explode( ",", $res["data"][$key]["id_category"] );
				}
			}
		} elseif( is_array( $res ) ) {
			foreach( $res as $key => $val ) {
				if( !empty( $res[$key]["id_category"] ) ) {
					$res[$key]["id_category"] = explode( ",", $res[$key]["id_category"] );
				}
			}
		}

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名: GetIdRow
	// 引  数: $id   - ID
	// 戻り値: 1件分
	// 内  容: 1件取得する
	//-------------------------------------------------------
	function GetIdRow( $id ) {

		// データチェック
		if( !is_numeric( $id ) ) {
			return null;
		}

		// SQL配列
		$creation_kit = array( "select" => "*",
							   "from"   => $this->_CtrTable,
							   "where"  => "date <= NOW() AND
											 display_flg = 1 AND
											( display_indefinite = 1 OR ( display_indefinite = 0 AND display_start <= NOW() AND  NOW() <= display_end ) ) AND " .
											$this->_CtrTablePk . " = " . $id );

		// データ取得
		$res = $this->_DBconn->selectCtrl( $creation_kit, array( "fetch" => _DB_FETCH ) );

		// タグ許可
		if( !empty($res["comment"]) ){
			$res["comment"] = html_entity_decode( $res["comment"] );
		}

		if( !empty( $res["id_category"] ) ){
					$res["id_category"] = explode( ",", $res["id_category"] );
				}

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名: GetDetailPageNavi
	// 引  数: $id   - お知らせID
	// 戻り値: ページナビ
	// 内  容: 詳細ページ用のページナビを作成する
	//-------------------------------------------------------
	function GetDetailPageNavi( $id ) {

		// データチェック
		if( !is_numeric( $id ) ) {
			return null;
		}

		// SQL配列
		$creation_kit = array(  "select" => $this->_CtrTablePk,
								"from"   => $this->_CtrTable,
								"where"  => "display_flg = 1 AND
											 date <= NOW() AND
										   ( display_indefinite = 1 OR
										   ( NOW() BETWEEN display_start AND display_end ) ) ",
								"order"  => "date DESC"
							);

		// データ取得
		$aryId = $this->_DBconn->selectCtrl( $creation_kit, array( "fetch" => _DB_FETCH_COL ) );

		// データチェック
		if( is_array( $aryId ) ) {

			// 現在のKey
			$pageKey = array_search( $id, $aryId );

			// ページング
			$res["back"] = $aryId[$pageKey+1];
			$res["now"]  = $aryId[$pageKey];
			$res["next"] = $aryId[$pageKey-1];

		}

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名: GetOption
	// 引  数: なし
	// 戻り値: お知らせカテゴリーオプション
	// 内  容: お知らせカテゴリーをオプション化して取得
	//-------------------------------------------------------
	function GetOption() {

		// SQL配列
		$creation_kit = array(  "select" => "id_category, title",
								"from"   => "mst_info_category",
								"where"  => "delete_flg = 0 ",
								"order"  => "display_num ASC"
							);
		// データ取得
		$arr_option = $this->_DBconn->selectCtrl( $creation_kit, array("fetch" => _DB_FETCH_ALL) );

		// オプション用に成形
		if( !empty($arr_option) ){
			foreach( $arr_option as $val ){
				$res[$val["id_category"]] = $val["title"];
			}
		}

		// 戻り値
		return $res;

	}

}
?>
