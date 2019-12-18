<?php
//----------------------------------------------------------------------------
// 作成日: 2016/11/01
// 作成者: 鈴木
// 内  容: 共通クラス
//----------------------------------------------------------------------------

//-------------------------------------------------------
//  クラス
//-------------------------------------------------------
class DB_manage extends DB_master {

	//-------------------------------------------------------
	// 関数名: __construct
	// 引  数: $_DSN    : 接続パラメータ
	// 戻り値: なし
	// 内  容: コンストラクタ
	//-------------------------------------------------------
	function __construct( $_DNS, $debug = NULL ) {

		// 親クラス
		parent::DB_master( $_DNS, $debug );

	}


	//-------------------------------------------------------
	// 関数名: insertLog
	// 引  数: $id  - 社員コード
	//       : $bid - 支店ID
	//       : $log - 操作ログ
	// 戻り値: なし
	// 内  容: ログデータの書き込み
	//-------------------------------------------------------
	function insertLog( $id, $bid, $log ) {

		// ログ操作クラス読み込み
		include_once( _DOCUMENT_ROOT . "/../cgi-data/class/DB_log.ctrl.php" );

		// 支店操作クラス
		$objLog = new DB_log( $this );

		// 登録
		$objLog->insert( array( "id_staff" => $id, "id_branches" => $bid, "date" => date( "Y/m/d H:i:s" ), "log" => $log ) );

		// クラス削除
		unset( $objLog );

	}


	//-------------------------------------------------------
	// 関数名: function getDataArray()
	// 引  数: creation_kit - SQL作成用配列
	//       : $cKey        - keyにするカラム名
	//       : $cVal        - valにするカラム名
	// 戻り値: 連想配列
	// 内  容: 連想配列の作成を行う。
	//-------------------------------------------------------
	function getDataArray( $creation_kit = NULL, $cKey, $cVal, $mbkn = NULL ) {

		// エラー防止
		if( empty( $creation_kit ) || empty( $cKey ) || empty( $cVal ) ) {
			return false;
		}

		// データ取得
		$temp = $this->selectCtrl( $creation_kit, array( "fetch" => _DB_FETCH_ALL ) );

		// key => value 形式に格納
		if( is_array( $temp ) ) {
			foreach( $temp as $key => $val ) {
				if( !empty( $mbkn ) ) {
					$res[(string)$val[$cKey]] = mb_convert_kana( $val[$cVal], $mbkn );
				} else {
					$res[(string)$val[$cKey]] = $val[$cVal];
				}
			}
		}

		return $res;

	}


	//-------------------------------------------------------
	// 関数名: freshCache()
	// 引  数: $list - 削除ファイルリスト
	//       : $dir  - ディレクトリ
	// 戻り値: なし
	// 内  容: キャッシュをリセット
	//-------------------------------------------------------
	function freshCache( $list, $dir ) {
		if( is_array( $dir ) ) {
			foreach( $dir as $key => $val ) {
				if( is_array( $list ) ) {
					foreach( $list as $key2 => $val2 ) {
						@unlink( $val . ""       . $val2 . _CACHE_EXTENSION );
						@unlink( $val . "admin_" . $val2 . _CACHE_EXTENSION );
						@unlink( $val . "front_" . $val2 . _CACHE_EXTENSION );
					}
				}
			}
		} else {
			if( is_array( $list ) ) {
				foreach( $list as $key => $val ) {
					@unlink( $dir . ""       . $val . _CACHE_EXTENSION );
					@unlink( $dir . "admin_" . $val . _CACHE_EXTENSION );
					@unlink( $dir . "front_" . $val . _CACHE_EXTENSION );
				}
			}
		}
	}


	//-------------------------------------------------------
	// 関数名: freshCacheAll()
	// 引  数: $dir  - ディレクトリ
	// 戻り値: なし
	// 内  容: キャッシュをすべてリセット
	//-------------------------------------------------------
	function freshCacheAll( $dir ) {

		// データチェック
		if( !empty( $dir ) ) {

			// ディレクトリオープン
			if( $handle = opendir( $dir ) ) {

				// ディレクトリ内を解析
				while( ( $strFile = readdir( $handle ) ) !== false ) {

					// 自分自信と上位階層を除外
					if( $strFile != "." && $strFile != ".." ) {
						if( !is_dir( $dir . $strFile ) && preg_match( "/\\" . _CACHE_EXTENSION . "$/", $strFile ) ) {
							unlink( $dir . "/" . $strFile );
						}
					}

				}
				closedir( $handle );
			}
		}
	}


	//-------------------------------------------------------
	// 関数名: function getCacheDataArray()
	// 引  数: creation_kit - SQL作成用配列
	//       : $cKey        - keyにするカラム名
	//       : $cVal        - valにするカラム名
	//       : $cacheName   - キャッシュ名（利用する場合のみ）
	// 戻り値: Smarty用連想配列
	// 内  容: Smarty用に連想配列の作成を行う。
	//-------------------------------------------------------
	function getCacheDataArray( $creation_kit = NULL, $cKey, $cVal, $cacheName, $mbkn = null ) {

		// エラー防止
		if( empty( $creation_kit ) || empty( $cKey ) || empty( $cVal ) || empty( $cacheName ) ) {
			return false;
		}

		// キャッシュファイルパス
		$cacheDir = $this->_CACHE_DIR . "/" . $cacheName . _CACHE_EXTENSION;

		// キャッシュの存在チェック
		if( !file_exists( $cacheDir ) ) {

			// データ取得
			$res = $this->getDataArray( $creation_kit, $cKey, $cVal, $mbkn );

			// シリアル化
			$data = serialize( $res );

			// ファイル書き込み用
			if ( !( $fp = fopen( $cacheDir, "w" ) ) ) {
				return false;
			} else {

				// ファイルロック
				if( flock( $fp, LOCK_EX ) ) {

					// 更新
					fwrite( $fp, $data );

					// ファイルロック解除
					flock( $fp, LOCK_UN );

				}

				// ファイルを閉じる
				fclose( $fp );

			}

		} else {

			// キャッシュを読み込み
			$res = unserialize( file_get_contents( $cacheDir ) );

		}

		return $res;

	}


}
?>
