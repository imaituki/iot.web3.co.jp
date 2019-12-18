<?php
//----------------------------------------------------------------------------
// 作成日: 2016/11/01
// 作成者: 鈴木
// 内  容: 共通クラス
//----------------------------------------------------------------------------

//-------------------------------------------------------
//  定数
//-------------------------------------------------------
// 取得方法
define( "_DB_FETCH"    , 1 );
define( "_DB_FETCH_ALL", 2 );
define( "_DB_FETCH_ONE", 3 );
define( "_DB_FETCH_COL", 4 );


//-------------------------------------------------------
//  クラス
//-------------------------------------------------------
class DB_master {
	
	//-------------------------------------------------------
	//  変数宣言
	//-------------------------------------------------------
	// ADODBオブジェクト
	var $_ADODB;
	
	// キャッシュディレクトリ
	var $_CACHE_DIR = _CACHE_DIR;
	
	
	//-------------------------------------------------------
	// 関数名: function DBmanage()
	// 引  数: なし
	// 戻り値: なし
	// 内  容: DB接続を行なう。
	//-------------------------------------------------------
	function DB_master( $dsn, $debug = NULL ) {
		
		// キャッシュディレクトリ
		global $ADODB_CACHE_DIR;
		$ADODB_CACHE_DIR = _ADODB_CACHE_DIR;
		
		// DB接続
		$this->_ADODB = ADONewConnection( $dsn );
		
		// 接続確認
		if( !$this->_ADODB ) die( "接続に失敗しました。" );
		
		// デバッグ
		$this->_ADODB->debug = $debug;
		
		// 文字コード指定
		$this->_ADODB->query("SET NAMES utf8");
		
		// FETCHモード
		$this->_ADODB->SetFetchMode( ADODB_FETCH_ASSOC );
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: function StartTrans()
	// 引  数: なし
	// 戻り値: なし
	// 内  容: トランザクション
	//-------------------------------------------------------
	function StartTrans() {
		$this->_ADODB->execute('START TRANSACTION');
	}
	
	
	//-------------------------------------------------------
	// 関数名: function RollbackTrans()
	// 引  数: なし
	// 戻り値: なし
	// 内  容: ロールバック
	//-------------------------------------------------------
	function RollbackTrans() {
		$this->_ADODB->execute('ROLLBACK');
	}
	
	
	//-------------------------------------------------------
	// 関数名: function CompleteTrans()
	// 引  数: なし
	// 戻り値: なし
	// 内  容: コミットとロールバック
	//-------------------------------------------------------
	function CompleteTrans() {
		$this->_ADODB->execute('COMMIT');
	}
	
	
	//-------------------------------------------------------
	// 関数名: function Insert_ID()
	// 引  数: なし
	// 戻り値: 直前にインサートしたID
	// 内  容: 直前にインサートしたIDを取得
	//-------------------------------------------------------
	function Insert_ID() {
		return $this->_ADODB->Insert_ID();
	}
	
	
	//-------------------------------------------------------
	// 関数名: function insert()
	// 引  数: table  - テーブル
	//       : arrVal - 登録データ（ 'カラム名' => '値' ）
	//       : arrSql - 登録データ（ 'カラム名' => 'SQL' ）
	// 戻り値: SQL発行結果
	// 内  容: INSERT文作成と発行
	//-------------------------------------------------------
	function insert( $table, $arrVal, $arrSql = NULL ) {
		
		// データチェック
		if( empty( $table ) || ( !is_array( $arrVal ) && !is_array( $arrSql ) ) ) {
			return null;
		}
		
		// 初期化
		$res     = null;
		$sql     = null;
		$stmt    = null;
		$sqlcol  = null;
		$sqlval  = null;
		$bindVal = null;
		
		// SQL作成
		if( is_array( $arrVal ) ) {
			foreach( $arrVal as $key => $val ) {
				
				// カラム名
				$sqlcol[] = "`" . $key . "`";
				
				// 登録値
				if( strcmp( 'NOW()', $val ) == 0 ) {
					$sqlval[] = 'NOW()';
				} else {
					$sqlval[]  = '?';
					$bindVal[] = ( !empty( $val ) ) ? stripslashes( $val ) : $val;
				}
			}
		}
		if( is_array( $arrSql ) ) {
			foreach( $arrSql as $key => $val ) {
				$sqlcol[] = "`" . $key . "`";
				$sqlval[] = $val;
			}
			if( empty( $bindVal ) ) {
				$bindVal = array();
			}
		}
		
		// SQL発行
		if( is_array( $sqlcol ) && is_array( $sqlval ) && is_array( $bindVal ) ) {
			
			// SQL文
			$sql = "INSERT INTO " . $table . " ( " . implode( ', ', $sqlcol ) . " ) VALUES ( " . implode( ', ', $sqlval ) . " ) ";

			// ステートメント作成
			$stmt = $this->_ADODB->prepare( $sql );
			// 実行
			$res = $this->_ADODB->Execute( $stmt, $bindVal );
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: function update()
	// 引  数: table  - テーブル
	//       : arrVal - 登録データ（ 'カラム名' => '値' ）
	//       : arrSql - 登録データ（ 'カラム名' => 'SQL' ）
	//       : where  - 更新条件
	// 戻り値: SQL発行結果
	// 内  容: INSERT文作成と発行
	//-------------------------------------------------------
	function update( $table, $arrVal, $arrSql, $where, $whereVal = null ) {
		
		// データチェック
		if( empty( $table ) || ( !is_array( $arrVal ) && !is_array( $arrSql ) ) || empty( $where ) ) {
			return null;
		}
		
		// 初期化
		$res     = null;
		$sql     = null;
		$stmt    = null;
		$sqlcol  = null;
		$bindVal = array();
		
		// SQL作成
		if( is_array( $arrVal ) ) {
			foreach( $arrVal as $key => $val ) {
				
				// 登録値
				if( strcmp( 'NOW()', $val ) == 0 ) {
					$sqlcol[]  = "`" . $key . "`" . " = NOW()";
				} else {
					$sqlcol[]  = "`" . $key . "`" . " = ?";
					$bindVal[] = ( !empty( $val ) ) ? stripslashes( $val ) : $val;
				}
			}
		}
		if( is_array( $arrSql ) ) {
			foreach( $arrSql as $key => $val ) {
				$sqlcol[] = "`" . $key . "`" . "=" . $val;
			}
		}
		
		// SQL発行
		if( is_array( $sqlcol ) ) {
			
			// SQL文
			$sql = "UPDATE " . $table . " SET " . implode( ', ', $sqlcol ) . " ";
			
			
			// 条件追加
			if( !empty( $where ) ) {
				$sql .= "WHERE " . $where;
				if( is_array( $whereVal ) ) {
					foreach( $whereVal as $key => $val ) {
						$bindVal[] = $val;
					}
				}
			}
			
			// ステートメント作成
			$stmt = $this->_ADODB->prepare( $sql );
			
			// 実行
			$res = $this->_ADODB->Execute( $stmt, $bindVal );
			
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: function replace()
	// 引  数: table  - テーブル
	//       : arrVal - 登録データ（ 'カラム名' => '値' ）
	//       : arrSql - 登録データ（ 'カラム名' => 'SQL' ）
	// 戻り値: SQL発行結果
	// 内  容: INSERT文作成と発行
	//-------------------------------------------------------
	function replace( $table, $arrVal, $arrSql = NULL ) {
		
		// データチェック
		if( empty( $table ) || ( !is_array( $arrVal ) && !is_array( $arrSql ) ) ) {
			return null;
		}
		
		// 初期化
		$res     = null;
		$sql     = null;
		$stmt    = null;
		$sqlcol  = null;
		$sqlval  = null;
		$bindVal = null;
		
		// SQL作成
		if( is_array( $arrVal ) ) {
			foreach( $arrVal as $key => $val ) {
				
				// カラム名
				$sqlcol[] = "`" . $key . "`";
				
				// 登録値
				if( strcmp( 'NOW()', $val ) == 0 ) {
					$sqlval[] = 'NOW()';
				} else {
					$sqlval[]  = '?';
					$bindVal[] = ( !empty( $val ) ) ? stripslashes( $val ) : $val;
				}
			}
		}
		if( is_array( $arrSql ) ) {
			foreach( $arrSql as $key => $val ) {
				$sqlcol[] = "`" . $key . "`";
				$sqlval[] = $val;
			}
		}
		
		// SQL発行
		if( is_array( $sqlcol ) && is_array( $sqlval ) && is_array( $bindVal ) ) {
			
			// SQL文
			$sql = "REPLACE INTO " . $table . " ( " . implode( ', ', $sqlcol ) . " ) VALUES ( " . implode( ', ', $sqlval ) . " ) ";
			
			// ステートメント作成
			$stmt = $this->_ADODB->prepare( $sql );
			
			// 実行
			$res = $this->_ADODB->Execute( $stmt, $bindVal );
			
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: function insert_dup_update()
	// 引  数: table  - テーブル
	//       : arrVal - 登録データ（ 'カラム名' => '値' ）
	//       : arrSql - 登録データ（ 'カラム名' => 'SQL' ）
	// 戻り値: SQL発行結果
	// 内  容: INSERT ON DUPLICATE KEY UPDATE文作成と発行
	//-------------------------------------------------------
	function insert_dup_update( $table, $arrVal, $arrSql = NULL ) {
		
		// データチェック
		if( empty( $table ) || ( !is_array( $arrVal ) && !is_array( $arrSql ) ) ) {
			return null;
		}
		
		// 初期化
		$res        = null;
		$stmt       = null;
		$sqlInsCol  = null;
		$sqlInsVal  = null;
		$bindInsVal = null;
		$sqlUpCol   = null;
		
		// SQL作成
		if( is_array( $arrVal ) ) {
			foreach( $arrVal as $key => $val ) {
				
				// カラム名
				$sqlInsCol[] = $key;
				$sqlUpCol[]  = $key . " = VALUES( " . $key . " )";
				
				// 登録値
				if( strcmp( 'NOW()', $val ) == 0 ) {
					$sqlInsVal[] = 'NOW()';
				} else {
					$sqlInsVal[]  = '?';
					$bindInsVal[] = ( !empty( $val ) ) ? stripslashes( $val ) : $val;
				}
			}
		}
		if( is_array( $arrSql ) ) {
			foreach( $arrSql as $key => $val ) {
				$sqlInsCol[] = $key;
				$sqlInsVal[] = $val;
				$sqlUpCol[]  = $key . " = VALUES( " . $key . " )";
			}
			$bindInsVal = array();
		}
		// SQL発行
		if( is_array( $sqlInsCol ) && is_array( $sqlInsVal ) && is_array( $bindInsVal ) && is_array( $sqlUpCol ) ) {
			
			// SQL文（ INSERT ... UPDATE ） [ UNIQUE id date ]
			$sql = "INSERT INTO " . $table . " ( " . implode( ', ', $sqlInsCol ) . " ) VALUES ( " . implode( ', ', $sqlInsVal ) . " ) ON DUPLICATE KEY UPDATE " . implode( ', ', $sqlUpCol ) . " ";
			
			// ステートメント作成
			$stmt = $this->_ADODB->prepare( $sql );
			
			// 実行
			$res = $this->_ADODB->Execute( $stmt, $bindInsVal );
			
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: function delete()
	// 引  数: table  - テーブル
	//       : where  - 更新条件
	// 戻り値: SQL発行結果
	// 内  容: DELETE文作成と発行
	//-------------------------------------------------------
	function delete( $table, $where ) {
		
		// データチェック（怖いので条件は必須にしてます。）
		if( empty( $table ) || empty( $where ) ) {
			return null;
		}
		
		// SQL文
		$sql = "DELETE FROM " . $table . " WHERE " . $where . " ";
		
		// 実行
		$res = $this->_ADODB->query( $sql );
		
		// 戻り値
		return $res;
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: function selectCtrl()
	// 引  数: creation_kit - SQL作成用配列
	//       :             [select]
	//       :             [from]
	//       :             [join]
	//       :             [where]
	//       :             [order]
	//       :             [group]
	//       :             [limit]
	//       : option - オプション
	//       :     [fetch]  - 取得方法
	//       :     [cache]  - キャッシュオプション
	//       :       [mode]
	//       :       [cache_time]
	//       :     [page]   - ページング情報
	//       :       [page_number]
	//       :       [page_show_limit]
	//       :       [page_navi_limit]
	//       :     [smarty] - smarty配列作成オプション
	//       :       [key]
	//       :       [val]
	// 戻り値: SQL発行結果
	// 内  容: 
	//-------------------------------------------------------
	function selectCtrl( $creation_kit = NULL, $option = array( "fetch" => _DB_FETCH_ALL, "cache" => NULL, "page" => NULL, "smarty" => NULL ) ) {
		
		// 初期化
		$fetch  = NULL;
		$cache  = NULL;
		$page   = NULL;
		$smarty = NULL;
		$select = NULL;
		$form   = NULL;
		$join   = NULL;
		$order  = NULL;
		$group  = NULL;
		$limit  = NULL;
		
		// オプション分割
		extract( $option );
		
		// データチェック
		if( empty( $creation_kit["from"] ) ) {
			return NULL;
		}
		
		// SELECT
		if( empty( $creation_kit["select"] ) ) {
			$select = " * ";
		} else {
			$select = $creation_kit["select"] . " ";
		}
		
		// FROM
		$from = $creation_kit["from"] . " ";
		
		// JOIN
		if( !empty( $creation_kit["join"] ) ) {
			$join = $creation_kit["join"] . " ";
		}
		
		// WHERE
		if( !empty( $creation_kit["where"] ) ) {
			$where = "WHERE " . $creation_kit["where"] . " ";
		}
		
		// ORDER BY
		if( !empty( $creation_kit["order"] ) ) {
			$order = "ORDER BY " . $creation_kit["order"] . " ";
		}
		
		// GROUP BY
		if( !empty( $creation_kit["group"] ) ) {
			$group = "GROUP BY " . $creation_kit["group"] . " ";
		}
		
		// LIMIT
		if( !empty( $creation_kit["limit"] ) ) {
			$limit = "LIMIT " . $creation_kit["limit"] . " ";
		}
		
		// ページ切り替え
		if( !empty( $page ) ) {
			
			// グループ設定を行う場合
			if( $group != NULL ) {
				$page["PageItemTotal"] = $this->_ADODB->GetOne("SELECT COUNT( DISTINCT " . $creation_kit["group"] . " ) FROM $from $join $where");
			} else {
				$page["PageItemTotal"] = $this->_ADODB->GetOne("SELECT COUNT( * ) FROM $from $join $where");
			}
			
			// ページ切替
			$res["page"] = $this->createPageNavi( $page );
			
			// SQL作成
			$sql = "SELECT " . $select  . " FROM " . $from . $join . $where . $group .$order . " LIMIT "  . $res["page"]["PageOffset"] . "," . $res["page"]["PageShowLimit"];
			
		} else {
			
			// SQL作成
			$sql = "SELECT " . $select  . " FROM " . $from . $join . $where . $group .$order . $limit;
			
		}
		
		// データ取得
		switch( $fetch ) {
			
			case _DB_FETCH:
				if( $cache["mode"] == true ) {
					$res["data"] = $this->_ADODB->CacheGetRow( $cache["cache_time"], $sql );
				} else {
					$res["data"] = $this->_ADODB->GetRow( $sql );
				}
			break;
			
			case _DB_FETCH_ALL:
				if( $cache["mode"] == true ) {
					$res["data"] = $this->_ADODB->CacheGetAll( $cache["cache_time"], $sql );
				} else {
					$res["data"] = $this->_ADODB->GetAll( $sql );
				}
			break;
			
			case _DB_FETCH_ONE:
				if( $cache["mode"] == true ) {
					$res["data"] = $this->_ADODB->CacheGetOne( $cache["cache_time"], $sql );
				} else {
					$res["data"] = $this->_ADODB->GetOne( $sql );
				}
			break;
			
			case _DB_FETCH_COL:
				if( $cache["mode"] == true ) {
					$res["data"] = $this->_ADODB->CacheGetCol( $cache["cache_time"], $sql );
				} else {
					$res["data"] = $this->_ADODB->GetCol( $sql );
				}
			break;
			
			default:
				$res["data"] = false;
			break;
		}
		if( $res["data"] == false ) {
			$res["data"] = NULL;
		}
		
		// 戻り値
		if( !empty( $page ) ) {
			return $res;             // ページ切り替え付き
		} else {
			return $res["data"];     // データのみ
		}
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: function createWhereSql()
	// 引  数: str         - 検索文字列
	//       : col         - 検索カラム
	//       : cmpoperator - 比較演算子
	//       : separator   - AND or OR
	//       : type        - 変数の型
	// 戻り値: SQL発行結果
	// 内  容: DELETE文作成と発行
	//-------------------------------------------------------
	function createWhereSql( $str, $col, $cmpoperator = "=", $separator = "OR", $type = "string" ) {
		
		// 初期化
		$res = null;
		
		// 検索条件（スペース区切り）
		$arrStr = explode( " ", trim( str_replace( "　", " ", $str ) ) );
		
		// 条件作成
		if( is_array( $arrStr ) ) {
			foreach( $arrStr as $key => $val ) {
				
				// エスケープ
				switch( strtolower( trim( $cmpoperator ) ) ) {
					case "like":
						$val = str_replace( array( '\\', '%', '_' ), array( '\\\\', '\%', '\_' ), $val );
					break;
				}
				
				// 変数型に合わせて変更
				switch( strtolower( trim( $type ) ) ) {
					case "string":
						$val = "'" . $val . "'";
					break;
					case "string%":
						$val = "'" . $val . "%'";
					break;
					case "%string":
						$val = "'%" . $val . "'";
					break;
					case "%string%":
						$val = "'%" . $val . "%'";
					break;
				}
				
				// 条件作成
				$res[] = $col . " " . trim( $cmpoperator ) . " " . $val;
				
			}
		}
		
		// 戻り値
		if( is_array( $res ) ) {
			return implode( " " . $separator . " ", $res );
		} else {
			return $res;
		}
		
	}
	
	//----------------------------------------------------------------------------
	// 関数名: createPageNavi
	// 引  数: $Option[]           - ページ切替用情報配列
	//       :   PageItemTotal     - 取得総数
	//       :   PageNumber        - 表示ページ数
	//       :   PageShowLimit     - １ページの最大表示件数
	//       :   PageNaviLimit     - ページナビの最大表示件数
	//       :   PageQueryName     - ページIDのクエリ名
	//       :   PageInnerAnchor   - ページ内アンカー名
	//       :   PageUrlFreeMode   - URL指定フリーモード
	//       :   PagePath          - 実行パス
	//       :   PageFileName      - 実行ファイル名
	//       :   PageIndexClear    - ファイル名がindex.phpだった場合削除する
	//       :   LinkBackText      - Backテキスト
	//       :   LinkNextText      - Nextテキスト
	//       :   LinkBackClass     - Backリンクの<a>タグに設定するClass
	//       :   LinkNextClass     - Nextリンクの<a>タグに設定するClass
	//       :   LinkPageClass     - Pageリンクの<a>タグに設定するClass
	//       :   LinkSeparator     - リンク間の区切り文字
	//       :   LinkSpanPref      - リンクを囲む前タグ
	//       :   LinkSpanPost      - リンクを囲む後タグ
	//       :   LinkSpanNowPref   - 現在ページを囲む前タグ
	//       :   LinkSpanNowPost   - 現在ページを囲む後タグ
	// 戻り値: $Option[]           - ページ切替用情報配列
	//       :   PageItemTotal     - 取得総数
	//       :   PageTotal         - 総ページ数
	//       :   PageNumber        - 表示ページ数
	//       :   PageShowLimit     - １ページの最大表示件数
	//       :   PageNaviLimit     - ページナビの最大表示件数
	//       :   PageQueryName     - ページIDのクエリ名
	//       :   PageUrlFreeMode   - URL指定フリーモード
	//       :   PageUrl           - 実行ファイル名
	//       :   PagePath          - 実行パス
	//       :   PageFileName      - 実行ファイル名
	//       :   PageOffset        - オフセット
	//       :   LinkBack          - Backリンク
	//       :   LinkBackText      - Backテキスト
	//       :   LinkBackClass     - Backリンクの<a>タグに設定するClass
	//       :   LinkNext          - Nextリンク
	//       :   LinkNextText      - Nextテキスト
	//       :   LinkNextClass     - Nextリンクの<a>タグに設定するClass
	//       :   LinkPage          - ページリンク
	//       :   LinkPageClass     - ページリンクの<a>タグに設定するClass
	//       :   LinkSeparator     - リンク間の区切り文字
	//       :   LinkSpanPref      - リンクを囲む前タグ
	//       :   LinkSpanPost      - リンクを囲む後タグ
	//       :   LinkSpanNowPref   - 現在ページを囲む前タグ
	//       :   LinkSpanNowPost   - 現在ページを囲む後タグ
	// 内  容: ページ切替用表示データの作成。
	//----------------------------------------------------------------------------
	function createPageNavi( $option ) {
		
		// URLの解析（パス、実行ファイル名、クエリーの取得）
		$this->setOptions( $option );
		
		// 総ページ数、表示ページの取得
		$this->getPageData( $option );
		
		// Backリンクの取得
		$this->getLinkBack( $option );
		
		// Nextリンクの取得
		$this->getLinkNext( $option );
		
		// ページリンクの取得
		$this->getLinkPage( $option );
		
		// OFFSETの計算
		if( $option["PageNumber"] > 0 ) {
			$option["PageOffset"] = ( $option["PageNumber"] - 1 ) * $option["PageShowLimit"];
		} else {
			$option["PageOffset"] = 0;
		}
		
		// 戻り値
		return $option;
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: setOptions
	// 引  数: オプション配列
	// 戻り値: なし
	// 内  容: 初期設定を行う
	//----------------------------------------------------------------------------
	function setOptions( &$option ) {
		
		//---------------------------------------
		//  初期値の設定
		//---------------------------------------
		// ページクエリ名
		if( $option["PageNumber"] < 1 ) {
			$option["PageNumber"] = 1;
		}
		
		// ページクエリ名
		if( empty( $option["PageQueryName"] ) ) {
			$option["PageQueryName"] = "page";
		}
		
		// Backリンクのテキスト
		if( empty( $option["LinkBackText"] ) ) {
			$option["LinkBackText"] = "&lt;&lt;";
		}
		
		// Nextリンクのテキスト
		if( empty( $option["LinkNextText"] ) ) {
			$option["LinkNextText"] = "&gt;&gt;";
		}
		
		
		//---------------------------------------
		//  クエリーの取得
		//---------------------------------------
		// 初期化
		$qs = array();
		
		// GET値の取得
		$qs = $_GET;
		
		// ゲット値の任意追加
		if( isset( $option["ExtraQuery"] ) && is_array( $option["ExtraQuery"] ) ){
			$qs = array_merge( $qs, $option["ExtraQuery"] );
		}
		
		// 文字列に変換
		$option["QueryData"] = $qs;
		
		
		//---------------------------------------
		//  URLの取得
		//---------------------------------------
		if( !empty( $option["PageUrlFreeMode"] ) && $option["PageUrlFreeMode"] == 1 ) {
			
			// URLの生成
//			if( !strstr( $option["PageFileName"], '%d' ) ) {
//				echo "ファイル名の指定が間違っています。（%d）";
//				exit;
//			}
			
			// URLの指定先がJavascriptかチェック
			if( strncasecmp( $option["PageFileName"], 'javascript', 10 ) != 0 ) {
				$option["PageUrl"] = urlencode($option["PagePath"] . "/" . $option["PageFileName"] );
			} else {
				$option["PageUrl"] = $option["PageFileName"];
			}
			
		} else {
			
			// パス・ファイル名の取得
			if ( substr( $_SERVER['PHP_SELF'], -1 ) == '/' ) {
				$option["PageFileName"] = "";
				$option["PagePath"] = str_replace( '\\', '/', $_SERVER['PHP_SELF'] );
			} else {
				$option["PageFileName"] = preg_replace( '/(.*)\?.*/', '\\1', basename( $_SERVER['PHP_SELF'] ) );
				$option["PagePath"] = str_replace( '\\', '/', dirname( $_SERVER['PHP_SELF'] ) );
			}
			
			// ファイル名がindex.phpの場合
			if( $option["PageFileName"] == "index.php" && $option["PageIndexClear"] == 1 ){
				$option["PageFileName"] = "";
			}
			
			// URLの生成
			$option["PageUrl"] = str_replace( "%2F", "/", urlencode( $option["PagePath"] ) )  . "/" . urlencode( $option["PageFileName"] );
			//$option["PageUrl"] = $option["PagePath"] . $option["PageFileName"];
			
		}
		
		//---------------------------------------
		//  ページ内リンクの生成
		//---------------------------------------
		if( empty( $option["PageInnerAnchor"] ) ){
			$option["PageInnerAnchor"] = "";
			
		} else{
			
			// 先頭が#でない場合は追加する
			if( substr( $option["PageInnerAnchor"], 0, 1 ) != '#' ){
				$option["PageInnerAnchor"] = "#" . $option["PageInnerAnchor"];
			}
		}
	}
	
	//----------------------------------------------------------------------------
	// 関数名: getPageData
	// 引  数: オプション配列
	// 戻り値: なし
	// 内  容: 総ページ数などのページに関する情報を計算
	//----------------------------------------------------------------------------
	function getPageData( &$option ) {
		
		// 総ページ数の計算
		if( $option["PageShowLimit"] > 0 ) {
			$option["PageTotal"] = ceil( ( float )$option["PageItemTotal"] / ( float )$option["PageShowLimit"] );
		}
		
		// 表示ページの取得
		$option["PageNumber"] = min( $option["PageTotal"], $option["PageNumber"] );
		
		// 表示件数 ○件 ～ PageShowEnd件
		if( $option["PageItemTotal"] < ( $option["PageNumber"] * $option["PageShowLimit"] ) ) {
			$option["PageShowEnd"] = $option["PageItemTotal"];
		} else {
			$option["PageShowEnd"] = $option["PageNumber"] * $option["PageShowLimit"];
		}
		// 表示件数 PageShowStart件 ～ ○件
		if ( $option["PageShowEnd"] > 0 ) {
			$option["PageShowStart"] = ( ( $option["PageNumber"] - 1 ) * $option["PageShowLimit"] ) + 1;
		} else {
			$option["PageShowStart"] = $option["PageShowEnd"];
		}
		
	}
	
	//----------------------------------------------------------------------------
	// 関数名: getLinkPage
	// 引  数: オプション配列
	// 戻り値: なし
	// 内  容: ページリンクの作成
	//----------------------------------------------------------------------------
	function getLinkPage( &$option ) {
		
		// 初期化
		if( !isset( $option["LinkSpanPref"] ) )    $option["LinkSpanPref"]    = NULL;
		if( !isset( $option["LinkSpanPost"] ) )    $option["LinkSpanPost"]    = NULL;
		if( !isset( $option["LinkSpanNowPref"] ) ) $option["LinkSpanNowPref"] = NULL;
		if( !isset( $option["LinkSpanNowPost"] ) ) $option["LinkSpanNowPost"] = NULL;
		
		// 開始、終了の計算
		$lower = $option["PageNumber"] - ceil( $option["PageNaviLimit"] / 2 );
		$upper = $option["PageNumber"] + ceil( $option["PageNaviLimit"] / 2 );
		
		// ナビの開始を計算
		if( ( $lower >  0 ) && ( $upper <= $option["PageTotal"] ) ) {
			$start = $lower;
		} elseif( ( $upper > $option["PageTotal"] ) && ( ( $lower - ( $upper - $option["PageTotal"] ) + 1 ) > 0 ) ) {
			$start = $lower - ( $upper - $option["PageTotal"] ) + 1;
		} else {
			$start = 1;
		}
		
		// ナビの作成
		for( $i = $start; $i <= $option["PageTotal"]; $i++ ) {
			
			// 最大ページナビ数チェック
			if( $i >= $option["PageNaviLimit"] + $start ) {
				
				// ループを抜ける
				break;
				
			} else {
				
				// 表示ページか？
				if ( $i == $option["PageNumber"] ) {
					
					// リンクの作成
					$links[] = $option["LinkSpanPref"] . $option["LinkSpanNowPref"] . $i . $option["LinkSpanNowPost"] . $option["LinkSpanPost"];
					
				} else {
					
					if( !empty( $option["PageUrlFreeMode"] ) && $option["PageUrlFreeMode"] == 1 ) {
						
						// URLの作成
						$links[] = $option["LinkSpanPref"] . sprintf( '<a href="%s" class="page%s"%s>%s</a>', sprintf( $option["PageUrl"], $i ), $i, empty( $option["LinkPageClass"] )? "": ( " " . $option["LinkPageClass"] ), $i ) . $option["LinkSpanPost"];
						
					} else {
						
						// ページ数の設定
						$option["QueryData"][$option["PageQueryName"]] = $i;
						
						// URLの作成
						$href = $option["PageUrl"] . "?" . $this->createQueryString( $option["QueryData"] ) . $option["PageInnerAnchor"];
						
						// リンクの作成
						$links[] = $option["LinkSpanPref"] . sprintf( '<a href="%s" class="page'.$i.'"%s>%s</a>', $href, empty( $option["LinkPageClass"] )? "": ( " " . $option["LinkPageClass"] ), $i ) . $option["LinkSpanPost"];
						
					}
				}
			}
		}
		
		// 区切りの設定
		if( isset( $links ) && is_array( $links ) ) {
			$option["LinkPage"] = implode( $option["LinkSeparator"], $links );
		}
		
	}
	
	//----------------------------------------------------------------------------
	// 関数名: getLinkBack
	// 引  数: オプション配列
	// 戻り値: なし
	// 内  容: Backリンクの作成
	//----------------------------------------------------------------------------
	function getLinkBack( &$option ) {
		
		// 表示ページが1ページ目以降か
		if( $option["PageNumber"] > 1 ) {
			
			if( !empty( $option["PageUrlFreeMode"] ) && $option["PageUrlFreeMode"] == 1 ) {
				
				// URLの作成
				$href = sprintf( $option["PageUrl"], ( $option["PageNumber"] - 1 ) );
				
			} else {
				
				// ページ数の設定
				$option["QueryData"][$option["PageQueryName"]] = $option["PageNumber"] - 1;
				
				// URLの作成
				$href = $option["PageUrl"] . "?" . $this->createQueryString( $option["QueryData"] ) . $option["PageInnerAnchor"];
				
			}
			
			// Back作成
			$option["LinkBack"] = sprintf( '<a href="%s" class="page'.( $option["PageNumber"] - 1 ).'"%s>%s</a>', $href, empty( $option["LinkBackClass"] )? "": ( " " . $option["LinkBackClass"] ), $option["LinkBackText"] );
			
		}
		
	}
	
	//----------------------------------------------------------------------------
	// 関数名: getLinkNext
	// 引  数: オプション配列
	// 戻り値: なし
	// 内  容: Nextリンクの作成
	//----------------------------------------------------------------------------
	function getLinkNext( &$option ) {
		
		// 表示ページが最終ページより前か
		if( $option["PageNumber"] < $option["PageTotal"] ) {
			
			if( !empty( $option["PageUrlFreeMode"] ) && $option["PageUrlFreeMode"] == 1 ) {
				
				// URLの作成
				$href = sprintf( $option["PageUrl"], ( $option["PageNumber"] + 1 ) );
				
			} else {
				
				// ページ数の設定
				$option["QueryData"][$option["PageQueryName"]] = $option["PageNumber"] + 1;
				
				// URLの作成
				$href = $option["PageUrl"] . "?" . $this->createQueryString( $option["QueryData"] ) . $option["PageInnerAnchor"];
				
			}
			
			// Next作成
			$option["LinkNext"] = sprintf( '<a href="%s" class="page'.( $option["PageNumber"] + 1 ).'"%s>%s</a>', $href, empty( $option["LinkNextClass"] )? "": ( " " . $option["LinkNextClass"] ), $option["LinkNextText"] );
			
		}
		
	}
	
	//----------------------------------------------------------------------------
	// 関数名: createQueryString
	// 引  数: $option["QueryData"]
	// 戻り値: クエリの文字列
	// 内  容: URLのクエリ部分の生成
	//----------------------------------------------------------------------------
	function createQueryString( $qs ) {
		
		// 初期化
		$res = NULL;
		
		// URLの作成
		if( is_array( $qs ) ) {
			
			// エスケープ
			$this->arrayStripslashes( $qs );
			
			// クエリ文字列の作成
			foreach( $qs as $key => $val ) {
				
				if( !empty( $val ) ) {
					$qs[urlencode( $key )] = urlencode( $key ) . "=" . urlencode( $val );
				} else {
					unset( $qs[urlencode( $key )] );
				}
				
			}
			
			if( is_array( $qs ) ) {
				$res = implode( "&", $qs );
			}
			
		}
		
		// 戻り値
		return $res;
		
	}
	
	//----------------------------------------------------------------------------
	// 関数名: arrayStripslashes
	// 引  数: 文字列もしくは配列
	// 戻り値: エスケープした文字
	// 内  容: 文字列をエスケープする
	//----------------------------------------------------------------------------
	function arrayStripslashes( $array ) {
		
		// 配列が空(不正)の場合
		if ( $array == FALSE ) {
			return $array;
		}
		
		// 連想配列にも対応するため
		foreach ( $array as $key => $val ) {
			
			// 配列の場合
			if ( is_array( $val ) ) {
				// 再起呼出
				$array[$key] = stripslashes_array( $val );
			} else {
				$array[$key] = stripslashes( $val );
			}
			
		}
		
		// 戻り値
		return $val;
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: function arrayKeyMatchFecth()
	// 引  数: $array   - 対象配列
	//       : $pattern - 正規表現
	// 戻り値: $res - 条件に一致したデータ
	// 内  容: 対象の配列データから条件に合うデータを取得する
	//-------------------------------------------------------
	function arrayKeyMatchFecth( $array, $pattern = "/^[^\_]/" ) {
		
		// データ検索
		if( is_array( $array ) ) {
			foreach( $array as $key => $val ) {
				if( preg_match( $pattern, $key ) ) {
					$res[$key] = $val;
				}
			}
		}
		
		// 戻り値
		return $res;
	}
	
	
	//-------------------------------------------------------
	// 関数名: function arrayKeyNotMatchFecth()
	// 引  数: $array   - 対象配列
	//       : $pattern - 正規表現
	// 戻り値: $res - 条件に一致したデータ
	// 内  容: 対象の配列データから条件に合うデータを取得する
	//-------------------------------------------------------
	function arrayKeyNotMatchFecth( $array, $pattern = "/^[^\_]/" ) {
		
		// データ検索
		if( is_array( $array ) ) {
			foreach( $array as $key => $val ) {
				if( !preg_match( $pattern, $key ) ) {
					$res[$key] = $val;
				}
			}
		}
		
		// 戻り値
		return $res;
	}
	
	
}
?>