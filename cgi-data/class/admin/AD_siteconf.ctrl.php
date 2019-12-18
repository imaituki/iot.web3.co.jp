<?php
//----------------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容: サイト設定操作クラス
//----------------------------------------------------------------------------

//-------------------------------------------------------
//  クラス
//-------------------------------------------------------
class AD_siteconf {

	//-------------------------------------------------------
	//  変数宣言
	//-------------------------------------------------------
	// DB接続
	var $_DBconn = null;

	// 主テーブル
	var $_CtrTable   = "mst_siteconf";

	// コントロール機能（ログ用）
	var $_CtrLogName = "サイト設定";

	// ファイル操作クラス
	var $_FN_file = null;

	// 画像設定
	var $_ARR_IMAGE = null;


	//-------------------------------------------------------
	// 関数名: __construct
	// 引  数: $dbconn  :  DB接続オブジェクト
	// 戻り値: なし
	// 内  容: コンストラクタ
	//-------------------------------------------------------
	function __construct( $dbconn, $arrImg = NULL ) {

		// クラス宣言
		if( !empty( $dbconn ) ) {
			$this->_DBconn  = $dbconn;
		} else {
			$this->_DBconn  = new DB_manage( _DNS );
		}
		$this->_FN_file = new FN_file();

		// 設定情報
		$this->_ARR_IMAGE = $arrImg;

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
		$objInputCheck->entryData( "デフォルトタイトル", "default_title", $arrVal["default_title"], array( "CHECK_EMPTY", "CHECK_MIN_MAX_LEN" ), 0, 255 );
		$objInputCheck->entryData( "デフォルトデスクリプション", "default_description", $arrVal["default_description"], array( "CHECK_EMPTY" ), null, null );
		$objInputCheck->entryData( "デフォルトキーワード", "default_keyword", $arrVal["default_keyword"], array( "CHECK_EMPTY", "CHECK_MIN_MAX_LEN" ), 0, 255 );

		if( (strcmp($mode, "insert") == 0) ) {
			// 画像チェック
			if( is_array($this->_ARR_IMAGE) ) {
				foreach( $this->_ARR_IMAGE as $key => $val ) {
					if( $val["notnull"] == 1 ) {
						$objInputCheck->entryData( $val["column"], $val["name"], $arrVal["_preview_image_" . $val["name"]], array( "CHECK_EMPTY" ), null, null );
					}
				}
			}
		}

		// チェック実行
		$res["ng"] = $objInputCheck->execCheckAll();

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名: update
	// 引  数: $arrVal - 登録データ（ 'カラム名' => '値' ）
	//       : $arrSql - 登録データ（ 'カラム名' => 'SQL' ）
	// 戻り値: なし
	// 内  容: サイト設定データ更新
	//-------------------------------------------------------
	function update( $arrVal, $arrSql = null ) {

		// 写真削除とアップ処理
		if( !empty($this->_ARR_IMAGE) && is_array($this->_ARR_IMAGE) ) {
			$this->_FN_file->delImage( $this->_ARR_IMAGE, $arrVal["_delete_image"], $arrVal );
			$ImageInfo = $this->_FN_file->copyImage( $_FILES, $this->_ARR_IMAGE, $arrVal );
		}

		// 登録データの作成
		$arrVal = $this->_DBconn->arrayKeyMatchFecth( $arrVal, "/^[^\_]/" );
		$arrVal["update_date"] = date( "Y-m-d H:i:s" );
		$arrVal["mail_base64"] = ( !empty( $arrVal["mail"] ) ) ? base64_encode( $arrVal["mail"] ) : NULL;

		// 更新条件
		$where = "id = 1";

		// 更新
		$res = $this->_DBconn->update( $this->_CtrTable, $arrVal, $arrSql, $where );

		// 戻り値
		return $res;

	}


	//-------------------------------------------------------
	// 関数名: GetIdRow
	// 引  数: $id - サイト設定ID
	// 戻り値: サイト設定
	// 内  容: サイト設定を1件取得する
	//-------------------------------------------------------
	function GetIdRow( $id = 1 ) {

		// データチェック
		if( !is_numeric( $id ) ) {
			return null;
		}

		// SQL配列
		$creation_kit = array( "select" => "*",
							   "from"   => $this->_CtrTable,
							   "where"  => "id = " . $id );

		// データ取得
		$res = $this->_DBconn->selectCtrl( $creation_kit, array( "fetch" => _DB_FETCH ) );

		// 戻り値
		return $res;

	}

}
?>
