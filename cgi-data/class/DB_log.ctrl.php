<?php
//----------------------------------------------------------------------------
// 作成日: 2016/11/01
// 作成者: 鈴木
// 内  容: ログ操作クラス
//----------------------------------------------------------------------------

//-------------------------------------------------------
//  クラス
//-------------------------------------------------------
class DB_log {
	
	//-------------------------------------------------------
	//  変数宣言
	//-------------------------------------------------------
	// DB接続
	var $_DBconn = null;
	
	// 主テーブル
	var $_CtrTable   = "t_log";
	var $_CtrTablePk = "id_log";
	
	// 主テーブル2
	var $_CtrTable2   = "t_log2";
	var $_CtrTablePk2 = "id_log";
	
	// コントロール機能（ログ用）
	var $_CtrLogName = "ログ情報";
	
	
	//-------------------------------------------------------
	// 関数名: __construct
	// 引  数: $DBconn : DB接続オブジェクト
	// 戻り値: なし
	// 内  容: コンストラクタ
	//-------------------------------------------------------
	function __construct( $DBconn = null ) {
		
		// クラス宣言
		if( isset( $DBconn ) ) {
			$this->_DBconn = $DBconn;
		} else {
			$this->_DBconn = new DB_manage( _DNS );
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
	// 関数名: __destruct
	// 引  数: なし
	// 戻り値: なし
	// 内  容: デストラクタ
	//-------------------------------------------------------
	function fnrun() {
		$args = func_get_args();
		$function = array_shift( $args );
		return call_user_func_array( array( $function ), $args );
	}
	
	
	//-------------------------------------------------------
	// 関数名: __destruct
	// 引  数: なし
	// 戻り値: なし
	// 内  容: デストラクタ
	//-------------------------------------------------------
	function dbrun() {
		$args = func_get_args();
		$function = array_shift( $args );
		return call_user_func_array( array( $this->_DBconn, $function ), $args );
	}
	
	
	//-------------------------------------------------------
	// 関数名: convert
	// 引  数: $arrVal
	// 戻り値: データ変換
	// 内  容: データ変換を行う
	//-------------------------------------------------------
	function convert( $arrVal ) {
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: check
	// 引  数: $arrVal
	//       : $mode - チェックモード（ "insert", "update" ）
	// 戻り値: エラーメッセージ
	// 内  容: データチェック
	//-------------------------------------------------------
	function check( $arrVal, $mode ) {
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: insert
	// 引  数: $arrVal - 登録データ（ 'カラム名' => '値' ）
	// 戻り値: なし
	// 内  容: ログ情報データ登録
	//-------------------------------------------------------
	function insert( $arrVal ) {
		$this->_DBconn->insert( $this->_CtrTable, $arrVal );
	}
	
	
	//-------------------------------------------------------
	// 関数名: insert2
	// 引  数: $arrVal - 登録データ（ 'カラム名' => '値' ）
	// 戻り値: なし
	// 内  容: 電話代行スタッフログ情報データ登録
	//-------------------------------------------------------
	function insert2( $arrVal ) {
		$this->_DBconn->insert( $this->_CtrTable2, $arrVal );
	}
	
	
	//-------------------------------------------------------
	// 関数名: update
	// 引  数: $arrVal - 登録データ（ 'カラム名' => '値' ）
	// 戻り値: なし
	// 内  容: ログ情報データ更新
	//-------------------------------------------------------
	function update( $table, $arrVal, $where ) {
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: GetSearchList
	// 引  数: 検索条件
	// 戻り値: ログ情報リスト
	// 内  容: ログ情報検索を行いデータを取得
	//-------------------------------------------------------
	function GetSearchList( $search ) {
		
		// SQL配列
		$creation_kit = array(  "select" => "*",
								"from"   => $this->_CtrTable, 
								"where"  => "1 ", 
								"order"  => "date DESC" 
							);
		
		// 権限設定
		if( is_array( $_COOKIE["ad_auth"][_AUTH_FN_LOG] ) && $_COOKIE["ad_master_flg"] != 1 ) {
			$creation_kit["where"] .= "AND " . $this->_CtrTable . ".id_branches IN( " . implode( ",", $_COOKIE["ad_auth"][_AUTH_FN_LOG]  ) . " ) ";
		}
		
		// ページ切り替え配列
		$_PAGE_INFO = array( "PageNumber"      => $search["page"], 
							 "PageShowLimit"   => _PAGESHOWLIMIT,
							 "PageNaviLimit"   => _PAGENAVILIMIT, 
							 "LinkSeparator"   => " | ", 
							 "PageUrlFreeMode" => 1, 
							 "PageFileName"    => "javascript:changePage(%d);" );
		
		// オプション
		$option = array( "fetch" => _DB_FETCH_ALL,
						 "page"  => $_PAGE_INFO );
		
		// データ取得
		$res = $this->_DBconn->selectCtrl( $creation_kit, $option );
		
		// 戻り値
		return $res;
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: GetIdRow
	// 引  数: $id - ログ情報ID
	// 戻り値: ログ情報
	// 内  容: ログ情報を1件取得する
	//-------------------------------------------------------
	function GetIdRow( $id ) {
		
		// データチェック
		if( !is_numeric( $id ) ) {
			return null;
		}
		
		// SQL配列
		$creation_kit = array( "select" => "*",
							   "from"   => $this->_CtrTable, 
							   "where"  => $this->_CtrTablePk . " = " . $id . " " );
		
		// 権限設定
		if( is_array( $_COOKIE["ad_auth"][_AUTH_FN_LOG] ) && $_COOKIE["ad_master_flg"] != 1 ) {
			$creation_kit["where"] .= "AND " . $this->_CtrTable . ".id_branches IN( " . implode( ",", $_COOKIE["ad_auth"][_AUTH_FN_LOG]  ) . " ) ";
		}
		
		// データ取得
		$res = $this->_DBconn->selectCtrl( $creation_kit, array( "fetch" => _DB_FETCH ) );
		
		// 戻り値
		return $res;
		
	}
	
}
?>