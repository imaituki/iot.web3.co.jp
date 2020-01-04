<?php
//----------------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容： お知らせカテゴリマスタ操作クラス
//----------------------------------------------------------------------------

//-------------------------------------------------------
//  クラス
//-------------------------------------------------------
class AD_information_category {

	//-------------------------------------------------------
	//  変数宣言
	//-------------------------------------------------------
	// DB接続
	var $_DBconn = null;

	// 主テーブル
	var $_CtrTable   = "t_information_category";
	var $_CtrTablePk = "id_information_category";

	// コントロール機能（ログ用）
	var $_CtrLogName = "お知らせカテゴリマスタ";

	// ファイル操作クラス
	var $_FN_file = null;

	// 画像設定
	var $_ARR_IMAGE = null;

	// キャッシュディレクトリー
	var $_CacheDir = _CACHE_DIR;

	//-------------------------------------------------------
	// 関数名：__construct
	// 引  数：$dbconn  ： DB接続オブジェクト
	// 戻り値：なし
	// 内  容：コンストラクタ
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
	// 関数名：__destruct
	// 引  数：なし
	// 戻り値：なし
	// 内  容：デストラクタ
	//-------------------------------------------------------
	function __destruct() {

	}

	//-------------------------------------------------------
	// 関数名：convert
	// 引  数：$arrVal
	// 戻り値：データ変換
	// 内  容：データ変換を行う
	//-------------------------------------------------------
	function convert( $arrVal ) {

		// データ変換クラス宣言
		$objInputConvert = new FN_input_convert( $arrVal, "UTF-8" );

		// 変換エントリー
		//$objInputConvert->entryConvert( "url", array( "ENC_KANA" ), "a" );

		// 変換実行
		$objInputConvert->execConvertAll();

		// 戻り値
		return $objInputConvert->GetData();

	}


	//-------------------------------------------------------
	// 関数名：check
	// 引  数：$arrVal
	//       ：$mode - チェックモード（ "insert", "update" ）
	// 戻り値：エラーメッセージ
	// 内  容：データチェック
	//-------------------------------------------------------
	function check( &$arrVal, $mode ) {

		// チェッククラス宣言
		$objInputCheck = new FN_input_check( "UTF-8" );

		// チェックエントリー

		$objInputCheck->entryData( "カテゴリ名", "name" , $arrVal["name"] , array( "CHECK_EMPTY" ), null, null );
		$objInputCheck->entryData( "表示／非表示", "display_flg", $arrVal["display_flg"], array( "CHECK_EMPTY", "CHECK_MIN_MAX_NUM" ), 0, 1 );

		// チェックエントリー（UPDATE時）
		if( ( strcmp( $mode, "update" ) == 0 ) ) {
			$objInputCheck->entryData( "カテゴリID", "all", $arrVal["id_information_category"], array( "CHECK_EMPTY", "CHECK_NUM" ), null, null );
		}

		// チェック実行
		$res["ng"] = $objInputCheck->execCheckAll();

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名：insert
	// 引  数：$arrVal - 登録データ（ 'カラム名' => '値' ）
	//       ：$arrSql - 登録データ（ 'カラム名' => 'SQL' ）
	// 戻り値：なし
	// 内  容：お知らせカテゴリマスタデータ登録
	//-------------------------------------------------------
	function insert( $arrVal, $arrSql = null ) {

		// 登録データの作成
		$arrVal = $this->_DBconn->arrayKeyMatchFecth( $arrVal, "/^[^\_]/" );
		$arrVal["entry_date"]  = date( "Y-m-d H:i:s" );
		$arrVal["update_date"] = date( "Y-m-d H:i:s" );

		// 登録
		$res = $this->_DBconn->insert( $this->_CtrTable, $arrVal, $arrSql );

		// キャッシュクリア
		$this->_DBconn->freshCacheAll( $this->_CacheDir );

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名：update
	// 引  数：$arrVal - 登録データ（ 'カラム名' => '値' ）
	//       ：$arrSql - 登録データ（ 'カラム名' => 'SQL' ）
	// 戻り値：なし
	// 内  容：お知らせカテゴリマスタデータ更新
	//-------------------------------------------------------
	function update( $arrVal, $arrSql = null ) {

		// 登録データの作成
		$arrVal = $this->_DBconn->arrayKeyMatchFecth( $arrVal, "/^[^\_]/" );
		$arrVal["update_date"] = date( "Y-m-d H:i:s" );

		// 更新条件
		$where = $this->_CtrTablePk . " = " . $arrVal["id_information_category"];

		// 更新
		$res = $this->_DBconn->update( $this->_CtrTable, $arrVal, $arrSql, $where );

		// キャッシュクリア
		$this->_DBconn->freshCacheAll( $this->_CacheDir );

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名：delete
	// 引  数：$id - 削除するお知らせカテゴリマスタID
	// 戻り値：true - 正常, false - 異常
	// 内  容：お知らせカテゴリマスタデータ削除
	//-------------------------------------------------------
	function delete( $id ) {

		// 初期化
		$res = false;

		// 更新
		$res = $this->_DBconn->update( $this->_CtrTable, array( "delete_flg" => 1 ), null, $this->_CtrTablePk . " = " . $id );

		// キャッシュクリア
		$this->_DBconn->freshCacheAll( $this->_CacheDir );

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名：changeDisplay
	// 引  数：$id  - ID
	//       ：$flg - フラグ
	// 戻り値：true - 正常, false - 異常
	// 内  容：表示切り替え
	//-------------------------------------------------------
	function changeDisplay( $id, $flg ) {

		// 初期化
		$res = false;

		// 切り替え処理
		$res = $this->_DBconn->update( $this->_CtrTable, array( "display_flg" => $flg ), null, $this->_CtrTablePk . " = " . $id );

		// キャッシュクリア
		$this->_DBconn->freshCacheAll( $this->_CacheDir );

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名：GetSearchList
	// 引  数：$search - 検索条件
	//       ：$option - 取得条件
	// 戻り値：お知らせカテゴリマスタリスト
	// 内  容：お知らせカテゴリマスタ検索を行いデータを取得
	//-------------------------------------------------------
	function GetSearchList( $search, $option = null ) {

		// SQL配列
		$creation_kit = array(  "select" => "*",
								"from"   => $this->_CtrTable,
								"where"  => "delete_flg = 0 ",
								"order"  => $this->_CtrTablePk . " asc"
							);

		// 検索条件
		if( !empty( $search["search_keyword"] ) ) {
			$creation_kit["where"] .= "AND ( " . $this->_DBconn->createWhereSql( $search["search_keyword"], "name", "LIKE", "OR", "%string%" ) . " ) ";
		}


		// 取得条件
		if( empty( $option ) ) {

			// ページ切り替え配列
			$_PAGE_INFO = array( "PageNumber"      => ( !empty( $search["page"] ) ) ? $search["page"] : 1,
								 "PageShowLimit"   => _PAGESHOWLIMIT,
								 "PageNaviLimit"   => _PAGENAVILIMIT,
								 "LinkSeparator"   => " | ",
								 "PageUrlFreeMode" => 1,
								 "PageFileName"    => "javascript:changePage(%d);" );

			// オプション
			$option = array( "fetch" => _DB_FETCH_ALL,
							 "page"  => $_PAGE_INFO );

		}

		// データ取得
		$res = $this->_DBconn->selectCtrl( $creation_kit, $option );

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名：GetIdRow
	// 引  数：$id - お知らせカテゴリマスタID
	// 戻り値：お知らせカテゴリマスタ
	// 内  容：お知らせカテゴリマスタを1件取得する
	//-------------------------------------------------------
	function GetIdRow( $id ) {

		// データチェック
		if( !is_numeric( $id ) ) {
			return null;
		}

		// SQL配列
		$creation_kit = array( "select" => "*",
							   "from"   => $this->_CtrTable,
							   "where"  => $this->_CtrTablePk . " = " . $id );

		// データ取得
		$res = $this->_DBconn->selectCtrl( $creation_kit, array( "fetch" => _DB_FETCH ) );

		// 戻り値
		return $res;

	}

}

?>
