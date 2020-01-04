<?php
//----------------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容: 実績紹介操作クラス
//----------------------------------------------------------------------------

//-------------------------------------------------------
//  クラス
//-------------------------------------------------------
class AD_case {

	//-------------------------------------------------------
	//  変数宣言
	//-------------------------------------------------------
	// DB接続
	var $_DBconn = null;

	// 主テーブル
	var $_CtrTable   = "t_case";
	var $_CtrTablePk = "id_case";

	// コントロール機能（ログ用）
	var $_CtrLogName = "実績紹介";

	// ファイル操作クラス
	var $_FN_file = null;

	// 画像設定
	var $_ARR_IMAGE = null;

	// ファイル設定
	var $_ARR_FILE = null;


	//-------------------------------------------------------
	// 関数名: __construct
	// 引  数: $dbconn: DB接続オブジェクト
	// 戻り値: なし
	// 内  容: コンストラクタ
	//-------------------------------------------------------
	function __construct( $dbconn, $arrImg = NULL, $arrFile = NULL ) {

		// クラス宣言
		if( !empty( $dbconn ) ) {
			$this->_DBconn  = $dbconn;
		} else {
			$this->_DBconn  = new DB_manage( _DNS );
		}
		$this->_FN_file = new FN_file();

		// 設定情報
		$this->_ARR_IMAGE = $arrImg;
		$this->_ARR_FILE  = $arrFile;

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
	// 関数名: setImageConfig
	// 引  数: $conf - 画像設定
	// 戻り値: なし
	// 内  容: 画像設定の設定を行う。
	//-------------------------------------------------------
	function setImageConfig( $conf ) {
		$this->_ARR_IMAGE = $conf;
	}


	//-------------------------------------------------------
	// 関数名: setFileConfig
	// 引  数: $conf - ファイル設定
	// 戻り値: なし
	// 内  容: ファイル設定の設定を行う。
	//-------------------------------------------------------
	function setFileConfig( $conf ) {
		$this->_ARR_FILE = $conf;
	}


	//-------------------------------------------------------
	// 関数名: convert
	// 引  数: $arrVal
	// 戻り値: データ変換
	// 内  容: データ変換を行う
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
	// 関数名: check
	// 引  数: $arrVal
	//       : $mode - チェックモード（ "insert", "update" ）
	// 戻り値: エラーメッセージ
	// 内  容: データチェック
	//-------------------------------------------------------
	function check( &$arrVal, $mode ) {

		// チェッククラス宣言
		$objInputCheck = new FN_input_check( "UTF-8" );

		// チェックエントリー
		$objInputCheck->entryData( "日付", "date" , $arrVal["date"] , array( "CHECK_EMPTY", "CHECK_DATE" ), null, null );
		$objInputCheck->entryData( "カテゴリー", "id_case_category", $arrVal["id_case_category"], array( "CHECK_EMPTY_ZERO", "CHECK_MIN_MAX_LEN" ), 0, 255 );
		$objInputCheck->entryData( "タイトル", "title", $arrVal["title"], array( "CHECK_EMPTY", "CHECK_MIN_MAX_LEN" ), 0, 255 );
		if( $arrVal["display_indefinite"] == 0 ) {
			$objInputCheck->entryData( "掲載開始", "display_start", $arrVal["display_start"], array( "CHECK_DATE" ), null, null );
			$objInputCheck->entryData( "掲載終了", "display_end", $arrVal["display_end"], array( "CHECK_DATE" ), null, null );
			$objInputCheck->entryData( "掲載終了", "display_end", $arrVal["display_end"], array( "CHECK_DATE_START_TERM" ), $arrVal["display_start"], null );
		}
		$objInputCheck->entryData( "表示／非表示", "display_flg", $arrVal["display_flg"], array( "CHECK_EMPTY", "CHECK_MIN_MAX_NUM" ), 0, 1 );

		if( (strcmp($mode, "insert") == 0) ) {
			// 画像チェック
			if( is_array($this->_ARR_IMAGE) ) {
				foreach( $this->_ARR_IMAGE as $key => $val ) {
					if( $val["notnull"] == 1 ) {
						$objInputCheck->entryData( $val["column"], $val["name"], $arrVal["_preview_image_" . $val["name"]], array( "CHECK_EMPTY" ), null, null );
					}
				}
			}
			// 添付チェック
			if( is_array($this->_ARR_FILE) ) {
				foreach( $this->_ARR_FILE as $key => $val ) {
					if( $val["notnull"] == 1 ) {
						$objInputCheck->entryFile( $val["column"], $val["name"], $_FILES[$val["name"]]["name"], array( "CHECK_EMPTY", "CHECK_EXT" ), null, array("pdf") );
					}
				}
			}
		}

		// チェックエントリー（UPDATE時）
		if( ( strcmp( $mode, "update" ) == 0 ) ) {
			$objInputCheck->entryData( "実績紹介ID", "all", $arrVal["id_case"], array( "CHECK_EMPTY", "CHECK_NUM" ), null, null );
		}

		// チェック実行
		$res["ng"] = $objInputCheck->execCheckAll();

		// データ加工
		if( $arrVal["display_indefinite"] == 0 ) {
			$arrVal["display_start"] = ( !empty( $arrVal["display_start"] ) ) ? date( "Y-m-d 00:00:00", strtotime( $arrVal["display_start"] ) ) : NULL;
			$arrVal["display_end"]   = ( !empty( $arrVal["display_end"]   ) ) ? date( "Y-m-d 23:59:59", strtotime( $arrVal["display_end"]   ) ) : NULL;
		} else {
			$arrVal["display_start"] = null;
			$arrVal["display_end"]   = null;
		}

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名: insert
	// 引  数: $arrVal - 登録データ（ 'カラム名' => '値' ）
	//       : $arrSql - 登録データ（ 'カラム名' => 'SQL' ）
	// 戻り値: なし
	// 内  容: 実績紹介データ登録
	//-------------------------------------------------------
	function insert( $arrVal, $arrSql = null ) {

		// アップ処理
		if( !empty($this->_ARR_IMAGE) && is_array($this->_ARR_IMAGE) ) {
			$ImageInfo = $this->_FN_file->copyImage( $_FILES, $this->_ARR_IMAGE, $arrVal );
		}
		if( !empty($this->_ARR_FILE) && is_array($this->_ARR_FILE) ) {
			$FileInfo  = $this->_FN_file->upFile( $_FILES, $this->_ARR_FILE, $arrVal );
		}

		// 登録データの作成
		$arrVal = $this->_DBconn->arrayKeyMatchFecth( $arrVal, "/^[^\_]/" );
	//	$arrSql["display_num"] = "( SELECT IFNULL( max_num + 1, 1 ) FROM ( SELECT MAX( display_num ) AS max_num FROM " . $this->_CtrTable . " ) AS maxnm ) ";
		$arrVal["entry_date"]  = date( "Y-m-d H:i:s" );
		$arrVal["update_date"] = date( "Y-m-d H:i:s" );
		if( !empty( $arrVal["id_case_category"] ) && is_array( $arrVal["id_case_category"] ) ){
			$arrVal["id_case_category"] = implode( ",", $arrVal["id_case_category"] );
		}

		// 登録
		$res = $this->_DBconn->insert( $this->_CtrTable, $arrVal, $arrSql );

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名: update
	// 引  数: $arrVal - 登録データ（ 'カラム名' => '値' ）
	//       : $arrSql - 登録データ（ 'カラム名' => 'SQL' ）
	// 戻り値: なし
	// 内  容: 実績紹介データ更新
	//-------------------------------------------------------
	function update( $arrVal, $arrSql = null ) {

		// 写真削除とアップ処理
		if( !empty($this->_ARR_IMAGE) && is_array($this->_ARR_IMAGE) ) {
			$this->_FN_file->delImage( $this->_ARR_IMAGE, $arrVal["_delete_image"], $arrVal );
			$ImageInfo = $this->_FN_file->copyImage( $_FILES, $this->_ARR_IMAGE, $arrVal );
		}
		// ファイル削除とアップ処理
		if( !empty($this->_ARR_FILE) && is_array($this->_ARR_FILE) ) {
			$this->_FN_file->delFile( $this->_ARR_FILE, $arrVal["_delete_file"], $arrVal );
			$FileInfo  = $this->_FN_file->upFile( $_FILES, $this->_ARR_FILE, $arrVal );
		}

		// 登録データの作成
		$arrVal = $this->_DBconn->arrayKeyMatchFecth( $arrVal, "/^[^\_]/" );
		$arrVal["update_date"] = date( "Y-m-d H:i:s" );
		if( !empty( $arrVal["id_case_category"] ) && is_array( $arrVal["id_case_category"] ) ){
			$arrVal["id_case_category"] = implode( ",", $arrVal["id_case_category"] );
		}

		// 更新条件
		$where = $this->_CtrTablePk . " = " . $arrVal["id_case"];

		// 更新
		$res = $this->_DBconn->update( $this->_CtrTable, $arrVal, $arrSql, $where );

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名: delete
	// 引  数: $id - 削除する実績紹介ID
	// 戻り値: true - 正常, false - 異常
	// 内  容: 実績紹介データ削除
	//-------------------------------------------------------
	function delete( $id ) {

		// 初期化
		$res = false;

		// 画像設定ループ
		if( !empty($this->_ARR_IMAGE) && is_array($this->_ARR_IMAGE) ){
			foreach( $this->_ARR_IMAGE as $key => $val ) {
				$select[] = $val["name"];
			}

			// SQL配列
			$creation_kit  = array( "select" => implode( ",", $select ),
									"from"   => $this->_CtrTable,
									"where"  => $this->_CtrTablePk . " = " . $id );

			// データ取得
			$tmp = $this->_DBconn->selectCtrl( $creation_kit, array( "fetch" => _DB_FETCH ) );

			// 画像削除
			$this->_FN_file->delImage( $this->_ARR_IMAGE, $tmp );

		}
		// ファイル設定ループ
		if( !empty($this->_ARR_FILE) && is_array($this->_ARR_FILE) ){

			foreach( $this->_ARR_FILE as $key => $val ) {
				$select[] = $val["name"];
			}

			// SQL配列
			$creation_kit  = array( "select" => implode( ",", $select ),
									"from"   => $this->_CtrTable,
									"where"  => $this->_CtrTablePk . " = " . $id );

			// データ取得
			$tmp = $this->_DBconn->selectCtrl( $creation_kit, array( "fetch" => _DB_FETCH ) );

			// 画像削除
			$this->_FN_file->delFile( $this->_ARR_FILE, $tmp );

		}

		// 更新
		$res = $this->_DBconn->delete( $this->_CtrTable, $this->_CtrTablePk . " = " . $id );

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名: changeDisplay
	// 引  数: $id  - ID
	//       : $flg - フラグ
	// 戻り値: true - 正常, false - 異常
	// 内  容: 表示切り替え
	//-------------------------------------------------------
	function changeDisplay( $id, $flg ) {

		// 初期化
		$res = false;

		// 切り替え処理
		$res = $this->_DBconn->update( $this->_CtrTable, array( "display_flg" => $flg ), null, $this->_CtrTablePk . " = " . $id );

		// 戻り値
		return $res;

	}

	//-------------------------------------------------------
	// 関数名：sort
	// 引  数：$sortIds - ソート順 ID
	//       ：$sortKey - 並び替えのフィールド名
	// 戻り値：true - 正常, false - 異常
	// 内  容：並び替え
	//-------------------------------------------------------
	function sort( $sortIds, $sortKey ) {

		// 初期化
		$res = false;

		// データチェック
		if( !empty( $sortIds ) ) {

			// 変数セット
			$this->_DBconn->_ADODB->query("set @a = 0;");

			// ソート
			$res = $this->_DBconn->update( $this->_CtrTable, null, array( "display_num" => "( @a := @a + 1 )" ), $this->_CtrTablePk . " IN( " . $sortIds . " ) ORDER BY FIELD( " . $sortKey . ", " . $sortIds . " ) " );

		}

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名: GetSearchList
	// 引  数: $search - 検索条件
	//       : $option - 取得条件
	// 戻り値: 実績紹介リスト
	// 内  容: 実績紹介検索を行いデータを取得
	//-------------------------------------------------------
	function GetSearchList( $search, $option = null ) {

		// SQL配列
		$creation_kit = array(  "select" => "*",
								"from"   => $this->_CtrTable,
								"where"  => "1 ",
								"order"  => "date DESC"
							);

		// 検索条件
		if( !empty( $search["search_keyword"] ) ) {
			$creation_kit["where"] .= "AND ( " . $this->_DBconn->createWhereSql( $search["search_keyword"], "title", "LIKE", "OR", "%string%" ) . " ) ";
		}

		if( !empty( $search["search_date_start"] ) ) {
			$creation_kit["where"] .= "AND " . $this->_DBconn->createWhereSql( "'" . $search["search_date_start"] . "'", $this->_CtrTable . ".date", " >= ", null, null ) . " ";
		}
		if( !empty( $search["search_date_end"] ) ) {
			$creation_kit["where"] .= "AND " . $this->_DBconn->createWhereSql( "'" . $search["search_date_end"] . "'", $this->_CtrTable . ".date", " <= ", null, null ) . " ";
		}

		if( !empty($search["search_category"]) ){
			$creation_kit["where"] .= " AND id_case_category = ". $search["search_category"]. " ";
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
	// 関数名: GetIdRow
	// 引  数: $id - 実績紹介ID
	// 戻り値: 実績紹介
	// 内  容: 実績紹介を1件取得する
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

		// データ取得
		$res = $this->_DBconn->selectCtrl( $creation_kit, array( "fetch" => _DB_FETCH ) );
		if( !empty( $res["id_case_category"] ) ){
					$res["id_case_category"] = explode( ",", $res["id_case_category"] );
				}

		// 戻り値
		return $res;

	}

/*
	//-------------------------------------------------------
	// 関数名: GetOption
	// 引  数: なし
	// 戻り値: 実績紹介カテゴリーオプション
	// 内  容: 実績紹介カテゴリーをオプション化して取得
	//-------------------------------------------------------
	function GetOption() {

		// SQL配列
		$creation_kit = array(  "select" => "id_case_category, title",
								"from"   => "t_id_case_category",
								"where"  => "delete_flg = 0 AND display_flg = 1",
								"order"  => "display_num ASC"
							);
		// データ取得
		$arr_option = $this->_DBconn->selectCtrl( $creation_kit, array("fetch" => _DB_FETCH_ALL) );

		// オプション用に成形
		if( !empty($arr_option) ){
			foreach( $arr_option as $val ){
				$res[$val["id_case_category"]] = $val["title"];
			}
		}

		// 戻り値
		return $res;

	}
*/
}
?>
