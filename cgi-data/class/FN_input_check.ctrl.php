<?php
class FN_input_check {
	
	//-------------------------------------------------------
	//  変数宣言
	//-------------------------------------------------------
	// DB接続
	var $_DBconn = null;
	
	// 一括チェックデータ
	var $_entryData = array();
	var $_entryFile = array();
	
	// デフォルト文字コード
	var $_defEnc    = "UTF-8";
	
	// エラー先頭文字
	var $_errHead = _ERRHEAD;
	
	// 配列チェック用メッセージ行
	var $_msgNum;
	
	//-------------------------------------------------------
	// 関数名: __construct
	// 引  数: $enc    - 文字コード
	//       : $DBconn - DB接続オブジェクト
	// 戻り値: なし
	// 内  容: コンストラクタ
	//-------------------------------------------------------
	function __construct( $enc, $DBconn = NULL ) {
		
		// 初期化
		$this->_entryData = array();
		
		// クラス宣言
		if( isset( $DBconn ) ) {
			$this->_DBconn = $DBconn;
		}
		
		// 初期文字コード設定
		if( !empty( $enc ) ) {
			$this->_defEnc = $enc;
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: entryData
	// 引  数: $itemName   - 項目名
	//       : $keyName    - キー
	//       : $checkData  - チェック対象データ
	//       : $arrCheck   - チェック項目
	//       : $min        - 最小文字数 or 数字 or 開始日
	//       : $max        - 最大文字数 or 数字 or 終了日
	//       : $emp        - 補助（上記以外の変数）
	// 戻り値: なし
	// 内  容: チェックデータのエントリー
	//----------------------------------------------------------------------------
	function entryData( $itemName, $keyName, $checkData, $arrCheck, $min, $max, $emp = null ) {
		$this->_entryData[] = array( $itemName, $keyName, $checkData, $arrCheck, $min, $max, $emp );
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: entryFile
	// 引  数: $itemName  - 項目名
	//       : $keyName   - キー
	//       : $checkData - チェック対象データ
	//       : $arrCheck  - チェック項目
	//       : $dir       - 保存先
	//       : $extension - 拡張子
	// 戻り値: なし
	// 内  容: チェックファイルのエントリー
	//----------------------------------------------------------------------------
	function entryFile( $itemName, $keyName, $checkData, $arrCheck, $dir, $extension ) {
		$this->_entryFile[] = array( $itemName, $keyName, $checkData, $arrCheck, $dir, $extension );
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: freshEntryData
	// 引  数: なし
	// 戻り値: なし
	// 内  容: チェックデータのエントリー解除
	//----------------------------------------------------------------------------
	function freshEntryData() {
		$this->_entryData = array();
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: freshEntryFile
	// 引  数: なし
	// 戻り値: なし
	// 内  容: チェックファイルのエントリー解除
	//----------------------------------------------------------------------------
	function freshEntryFile() {
		$this->_entryFile = array();
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: freshEntryAll
	// 引  数: なし
	// 戻り値: なし
	// 内  容: すべてのエントリー解除
	//----------------------------------------------------------------------------
	function freshEntryAll() {
		$this->_entryData = array();
		$this->_entryFile = array();
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: execCheckAll
	// 引  数: なし
	// 戻り値: なし
	// 内  容: エントリー中の一括チェック処理
	//----------------------------------------------------------------------------
	function execCheckAll() {
		
		// 初期化
		$res = array();
		
		// エントリー中のデータ一括処理
		if( is_array( $this->_entryData ) ) {
			foreach( $this->_entryData as $key => $val ) {
				
				// クリア
				unset( $errMsg );
				
				// エラー番号初期化
				$this->_msgNum = 0;
				
				// チェック
				$errMsg = call_user_func_array( array( $this, "execCheck" ), $val );
				
				// 戻り値に反映
				if( is_array( $errMsg ) ) {
					$key = key( $errMsg );
					if( isset( $errMsg[$key] ) ) {
						$res[$key] = ( isset( $res[$key] ) ) ? $res[$key] . "\n" . $errMsg[$key] : $errMsg[$key];
					}
				}
				
			}
		}
		
		// エントリー中のファイル一括処理
		if( is_array( $this->_entryFile ) ) {
			foreach( $this->_entryFile as $key => $val ) {
				
				// クリア
				unset( $errMsg );
				
				// チェック
				$errMsg = call_user_func_array( array( $this, "execCheckFile" ), $val );
				
				// 戻り値に反映
				if( is_array( $errMsg ) ) {
					$res = array_merge( $res, $errMsg );
				}
				
			}
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: execCheck
	// 引  数: $itemName   - 項目名
	//       : $keyName    - キー
	//       : $checkData  - チェック対象データ
	//       : $arrCheck   - チェック項目
	//       : $min        - 最小文字数 or 数字
	//       : $max        - 最大文字数 or 数字
	//       : $emp        - 補助（上記以外の変数）
	// 戻り値: エラー内容
	// 内  容: 入力チェック
	//----------------------------------------------------------------------------
	function execCheck( $itemName, $keyName, $checkData, $arrCheck, $min, $max, $emp = null ) {
		
		// 初期化
		$msg = null;
		$res = null;
		
		// 配列の場合再起チェック
		if( is_array( $checkData ) ) {
			
			foreach( $checkData as $key => $val ) {
				
				// 番号アップ
				$this->_msgNum++;
				
				// チェック
				$msg = $this->execCheck( $itemName, $keyName, $val, $arrCheck, $min, $max, $emp );
				
				// メッセージ振り分け
				if( !empty( $res[$keyName] ) && is_array( $msg ) ) {
					$res[$keyName] = ( is_array( $msg ) ) ? $res[$keyName] . implode( "\n", array_filter( $msg, "strlen" ) ) : $res[$keyName];
				} else {
					$res[$keyName] = ( is_array( $msg ) ) ? implode( "\n", array_filter( $msg, "strlen" ) ) : null;
				}
				
				// 空の場合は削除
				if( empty( $res[$keyName] ) ) {
					unset( $res[$keyName] );
				}
				
			}
		} else {
			
			// 配列の場合の対応
			if( $this->_msgNum > 0 ) {
				$itemName .= $this->_msgNum;
			}
			
			// データチェック
			if( is_array( $arrCheck ) ) {
				foreach( $arrCheck as $key => $val ) {
					
					// 処理分岐
					switch( $val ) {
						case "CHECK_EMPTY":              // NULLチェック
						case "CHECK_EMPTY_ZERO":         // NULLチェック
						case "CHECK_NUM":                // 数値チェック
						case "CHECK_POINT_NUM":          // 数値チェック（小数あり）
						case "CHECK_MAIL":               // メールアドレスチェック
						case "CHECK_TEL":                // 電話番号チェック
						case "CHECK_ZIP":                // 郵便番号チェック
						case "ALPHA_CHECK":              // 英字チェック
						case "CHECK_KANA":               // カタカナのみチェック
						case "CHECK_ALNUM":              // 英数字のみチェック
						case "CHECK_ALNUM_TYPE2":        // 英数字のみチェック(半角スペース許可)
						case "CHECK_EM":                 // 全角のみチェック
						case "CHECK_DATE":               // 日付チェック
						case "CHECK_DATETIME":           // 日時チェック YYYY/mm/dd HH:ii:ss
						case "CHECK_DATETIME2":          // 日時チェック YYYY/mm/dd HH:ii
							$msg[] = $this->$val( $itemName, $checkData );
						break;
						case "CHECK_MIN_NUM":            // 数値 MIN値チェック
							$msg[] = $this->$val( $itemName, $checkData, $min );
						break;
						case "CHECK_MAX_NUM":            // 数値 MAX値チェック
							$msg[] = $this->$val( $itemName, $checkData, $max );
						break;
						case "CHECK_MIN_MAX_NUM":        // 数値 MIN-MAXチェック
							$msg[] = $this->$val( $itemName, $checkData, $min, $max );
						break;
						case "CHECK_MIN_LEN":            // 文字列 MIN値チェック
							$msg[] = $this->$val( $itemName, $checkData, $min, $this->_defEnc );
						break;
						case "CHECK_MAX_LEN":            // 文字列 MAX値チェック
							$msg[] = $this->$val( $itemName, $checkData, $max, $this->_defEnc );
						break;
						case "CHECK_MIN_MAX_LEN":        // 文字列 MIN-MAX値チェック
							$msg[] = $this->$val( $itemName, $checkData, $min, $max, $this->_defEnc );
						break;
						case "CHECK_DATE_TERM":          // 日付 期間チェック(開始 <= 終了)
							$msg[] = $this->$val( $itemName, $checkData, $min, $max );
						break;
						case "CHECK_DATE_START_TERM":    // 日付 期間チェック($min < 開始)
						case "CHECK_DATEYM_START_TERM":  // 日付 期間チェック($min < 開始)
						case "CHECK_DATETIME_START_TERM":
						case "CHECK_TIME_START_TERM":
							$msg[] = $this->$val( $itemName, $checkData, $min, $emp );
						break;
					}
					
				}
				
				// 戻り値に設定
				if( !empty( $res[$keyName] ) && is_array( $msg ) ) {
					$res[$keyName] = ( is_array( $msg ) ) ? $res[$keyName] . implode( "\n", array_filter( $msg, "strlen" ) ) : $res[$keyName];
				} else {
					$res[$keyName] = ( is_array( $msg ) ) ? implode( "\n", array_filter( $msg, "strlen" ) ) : null;
				}
				
				// 空の場合は削除
				if( empty( $res[$keyName] ) ) {
					unset( $res[$keyName] );
				}
				
			}
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: execCheckFile
	// 引  数: $itemName   - 項目名
	//       : $keyName    - キー
	//       : $checkData  - チェック対象データ
	//       : $arrCheck   - チェック項目
	//       : $dir        - 保存先
	//       : $extension  - 拡張子
	// 戻り値: エラー内容
	// 内  容: 入力チェック
	//----------------------------------------------------------------------------
	function execCheckFile( $itemName, $keyName, $checkData, $arrCheck, $dir, $extension ) {
		
		// 初期化
		$msg = null;
		$res = null;
		
		// 配列の場合再起チェック
		if( is_array( $checkData ) ) {
			foreach( $checkData as $key => $val ) {
				$this->execCheckFile( $itemName, $keyName, $checkData, $arrCheck, $dir, $extension );
			}
		} else {
			
			// データチェック
			if( is_array( $arrCheck ) ) {
				foreach( $arrCheck as $key => $val ) {
					
					// 処理分岐
					switch( $val ) {
						case "CHECK_EMPTY":              // NULLチェック
							$msg[] = $this->$val( $itemName, $checkData );
						break;
						case "CHECK_EXT":                // 拡張子チェック
							$msg[] = $this->$val( $itemName, $checkData, $extension );
						break;
						case "CHECK_FILE_EXISTS":        // 存在チェック
							$msg[] = $this->$val( $itemName, $checkData, $dir );
						break;
					}
					
				}
				
				// 戻り値に設定
				if( !empty( $res[$keyName] ) && is_array( $msg ) ) {
					$res[$keyName] = ( is_array( $msg ) ) ? $res[$keyName] . implode( "\n", array_filter( $msg, "strlen" ) ) : $res[$keyName];
				} else {
					$res[$keyName] = ( is_array( $msg ) ) ? implode( "\n", array_filter( $msg, "strlen" ) ) : null;
				}
				
				// 空の場合は削除
				if( empty( $res[$keyName] ) ) {
					unset( $res[$keyName] );
				}
				
			}
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_EMPTY
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 必須チェックを行う。
	//----------------------------------------------------------------------------
	function CHECK_EMPTY( $item, $data ) {
		
		// NULLチェック
		if( (string)$data == "" ) {
			return $this->_errHead . $item . "は必ず入力してください。<br />";
		} else {
			return null;
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_EMPTY_ZERO
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 必須チェックを行う。
	//----------------------------------------------------------------------------
	function CHECK_EMPTY_ZERO( $item, $data ) {
		
		// NULLチェック
		if( empty( $data ) ) {
			return $this->_errHead . $item . "は必ず入力してください。<br />";
		} else {
			return null;
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_NUM
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 数値チェックを行う。
	//----------------------------------------------------------------------------
	function CHECK_NUM( $item, $data ) {
		
		// 数値チェック（文字列が数字のみ true）
		if( mb_strlen( $data ) > 0 && !ctype_digit( (string)$data ) ) {
			return $this->_errHead . $item . "は数字で入力してください。<br />";
		} else {
			return null;
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_NUM
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 小数点付き数値チェックを行う。
	//----------------------------------------------------------------------------
	function CHECK_POINT_NUM( $item, $data ) {
		
		// 数値チェック
		if( !is_numeric( $data ) ) {
			return $this->_errHead . $item . "は数字で入力してください。<br />";
		} else {
			return null;
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_MIN_NUM
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	//       : $min  - 最小数
	// 戻り値: エラー内容
	// 内  容: 数値の最小数チェック
	//----------------------------------------------------------------------------
	function CHECK_MIN_NUM( $item, $data, $min ) {
		
		// 最大数のチェック
		if( is_numeric( $data )  ) {
			if( $data < $min ) {
				return $this->_errHead . $item . "は" . $min . "以上の数値で入力してください。<br />";
			}
		}
		
		// 戻り値
		return null;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_MAX_NUM
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	//       : $max  - 最大数
	// 戻り値: エラー内容
	// 内  容: 数値の最大数チェック
	//----------------------------------------------------------------------------
	function CHECK_MAX_NUM( $item, $data, $max ) {
		
		// 最大数のチェック
		if( is_numeric( $data )  ) {
			if( $data > $max ) {
				return $this->_errHead . $item . "は" . $max . "以下の数値で入力してください。<br />";
			}
		}
		
		// 戻り値
		return null;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_MIN_MAX_NUM
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	//       : $min  - 最小数
	//       : $max  - 最大数
	// 戻り値: エラー内容
	// 内  容: 数値の最大・最小数チェック
	//----------------------------------------------------------------------------
	function CHECK_MIN_MAX_NUM( $item, $data, $min, $max ) {
		
		// 最大・最小数のチェック
		if( is_numeric( $data )  ) {
			if( ( $data > $max ) || ( $data < $min ) ) {
				return $this->_errHead . $item . "は" . $min . "以上" . $max . "以下の数値で入力してください。<br />";
			}
		} else {
			return $this->_errHead . $item . "は半角数字で入力してください。<br />";
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_MIN_LEN
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	//       : $min  - 最小文字数
	//       : $enc  - 文字コード
	// 戻り値: エラー内容
	// 内  容: 最小文字数のチェック
	//----------------------------------------------------------------------------
	function CHECK_MIN_LEN( $item, $data, $min, $enc ) {
		
		// 文字数チェック
		if( mb_strlen( $data, $enc ) < $min ) {
			return $this->_errHead . $item . "は" . $min . "文字以上の文字数で入力してください。<br />";
		}
		
		// 戻り値
		return null;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_MAX_LEN
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	//       : $max  - 最大文字数
	//       : $enc  - 文字コード
	// 戻り値: エラー内容
	// 内  容: 最大文字数チェック
	//----------------------------------------------------------------------------
	function CHECK_MAX_LEN( $item, $data, $max, $enc ) {
		
		// 文字数チェック
		if( mb_strlen( $data, $enc ) > $max ) {
			return $this->_errHead . $item . "は" . $max . "文字以下の文字数で入力してください。<br />";
		}
		
		// 戻り値
		return null;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_MIN_MAX_LEN
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	//       : $min  - 最小文字数
	//       : $max  - 最大文字数
	//       : $enc  - 文字コード
	// 戻り値: エラー内容
	// 内  容: 入力チェック
	//----------------------------------------------------------------------------
	function CHECK_MIN_MAX_LEN( $item, $data, $min, $max, $enc ) {
		
		// 文字数チェック
		if( mb_strlen( $data, $enc ) < $min || mb_strlen( $data, $enc ) > $max ) {
			return $this->_errHead . $item . "は" . $min . "文字以上" . $max . "文字以下の文字数で入力してください。<br />";
		}
		
		// 戻り値
		return null;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_MAIL
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 入力チェック
	//----------------------------------------------------------------------------
	function CHECK_MAIL( $item, $data ) {
		
		// 入力チェック
		if( !empty( $data ) ) {
			
			// 正規表現
			$regex = "/^[a-zA-Z0-9_\.\-]+?@[A-Za-z0-9_\.\-]+$/";
			
			// メールアドレスチェック
			if( !preg_match( $regex, $data ) ) {
				return $this->_errHead . $item . "を正しく入力してください。<br />";
			}
			
		}
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_TEL
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 入力チェック
	//----------------------------------------------------------------------------
	function CHECK_TEL( $item, $data ) {
		
		// 入力チェック
		if( !empty( $data ) ) {
			
			// 数字とハイフンチェック
			if ( !preg_match( "/^[0-9][0-9\-]+[0-9]$/", $data ) ) {
				return $this->_errHead . $item . "を正しく入力してください。<br />";
			}
			
			// ハイフンを取り除く
			$tmp = str_replace( "-", "", $data );
			
			// 桁数チェック（最小 10桁 最大 12桁）
			if( mb_strlen( $tmp ) < 10 || mb_strlen( $tmp ) > 12 ) {
				return $this->_errHead . $item . "を正しく入力してください。<br />";
			}
			
		}
		
		// 戻り値
		return null;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_ZIP
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 入力チェック
	//----------------------------------------------------------------------------
	function CHECK_ZIP( $item, $data ) {
		
		// 入力チェック
		if( !empty( $data ) ) {
			
			// ハイフンを取り除く
			$tmp = str_replace( "-", "", $data );
			
			// 数字7桁もしくは数字＋ハイフンチェック
			if ( preg_match( "/^[0-9]{7}$/", $tmp ) || preg_match( "/^[0-9]{3}\-[0-9]{4}$/", $data ) ) {
				return null;
			} else {
				return $this->_errHead . $item . "を正しく入力してください。<br />";
			}
			
		}
		
		// 戻り値
		return null;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_DATE
	// 引  数: $item - 項目名
	//       : $data - YYYY/mm/dd
	// 戻り値: エラー内容
	// 内  容: 入力チェック
	//----------------------------------------------------------------------------
	function CHECK_DATE( $item, $data ) {
		
		// 日付分解
		list( $year, $month, $day ) = explode( "/", str_replace( "-", "/", $data ) );
		
		// 少なくともどれか一つが入力されている。
		if( $year > 0 || $month > 0 || $day > 0 ) {
			
			// 年月日のどれかが入力されていない。
			if( !( strlen( $year ) > 0 && strlen( $month ) > 0 && strlen( $day ) > 0 ) ) {
				return $this->_errHead . $item . "は全ての項目を入力して下さい。<br />";
			} elseif( !checkdate( $month, $day, $year ) ) {
				return $this->_errHead . $item . "を正しく入力してください。<br />";
			}
			
		}
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_DATETIME
	// 引  数: $item - 項目名
	//       : $data - YYYY/mm/dd HH:ii:ss
	// 戻り値: エラー内容
	// 内  容: 入力チェック
	//----------------------------------------------------------------------------
	function CHECK_DATETIME( $item, $data ) {
		
		// 日時分解
		list( $date, $time ) = explode( " ", str_replace( "　", " ", $data ) );
		list( $year, $month, $day ) = explode( "/", str_replace( "-", "/", $date ) );
		list( $hour, $minut, $sec ) = explode( ":", $time );
		
		// 少なくともどれか一つが入力されている。
		if( $year > 0 || $month > 0 || $day > 0 || $hour >= 0 || $minut >= 0 || $sec >= 0 ) {
			
			// 年月日のどれかが入力されていない。
			if( !( strlen( $year ) > 0 && strlen( $month ) > 0 && strlen( $day ) > 0 && strlen( $hour ) >= 0 && strlen( $minut ) >= 0 && strlen( $sec ) >= 0 ) ) {
				return $this->_errHead . $item . "は全ての項目を入力して下さい。<br />";
			} elseif( !checkdate( $month, $day, $year ) ) {
				return $this->_errHead . $item . "を正しく入力してください。<br />";
			} elseif( ( $hour < 0 && $hour > 24 ) || ( $minut < 0 && $minut > 59 ) || ( $sec < 0 && $sec > 59 ) ) {
				return $this->_errHead . $item . "を正しく入力してください。<br />";
			}
			
		}
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_DATETIME2
	// 引  数: $item - 項目名
	//       : $data - YYYY/mm/dd HH:ii
	// 戻り値: エラー内容
	// 内  容: 入力チェック
	//----------------------------------------------------------------------------
	function CHECK_DATETIME2( $item, $data ) {
		
		// 日時分解
		list( $date, $time ) = explode( " ", str_replace( "　", " ", $data ) );
		list( $year, $month, $day ) = explode( "/", str_replace( "-", "/", $date ) );
		list( $hour, $minut       ) = explode( ":", $time );
		
		// 少なくともどれか一つが入力されている。
		if( strlen( $year ) > 0 || strlen( $month ) > 0 || strlen( $day ) > 0 || strlen( $hour ) > 0 || strlen( $minut ) > 0 ) {
			
			// 年月日のどれかが入力されていない。
			if( !( strlen( $year ) > 0 && strlen( $month ) > 0 && strlen( $day ) > 0 && strlen( $hour ) >= 0 && strlen( $minut ) >= 0 ) ) {
				return $this->_errHead . $item . "は全ての項目を入力して下さい。<br />";
			} elseif( !checkdate( $month, $day, $year ) ) {
				return $this->_errHead . $item . "を正しく入力してください。<br />";
			} elseif( ( $hour < 0 && $hour > 24 ) || ( $minut < 0 && $minut > 59 ) ) {
				return $this->_errHead . $item . "を正しく入力してください。<br />";
			}
			
		}
	}
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_DATE_TERM
	// 引  数: $item  - 項目名
	//       : $data  - 指定日(タイムスタンプ)
	//       : $start - 開始日(array)
	//       : $end   - 終了日(array)
	//       : $mode  - モード
	// 戻り値: エラー内容
	// 内  容: 期間チェック(日付)
	//----------------------------------------------------------------------------
	function CHECK_DATE_TERM( $item, $data, $start, $end, $mode = "<=" ) {
		
		// 年月日の補完
		if( empty( $start ) || is_array( $start ) ) {
			if( !isset( $start["Year"] ) || empty( $start["Year"] ) ) {
				$start["Year"] = date( 'Y' );
			}
			if( !isset( $start["Month"] ) || empty( $start["Month"] ) ) {
				$start["Month"] = 1;
			}
			if( !isset( $start["Day"] ) || empty( $start["Day"] ) ) {
				$start["Day"] = 1;
			}
		}
		if( empty( $end ) || is_array( $end ) ) {
			if( !isset( $end["Year"] ) || empty( $end["Year"] ) ) {
				$end["Year"] = date( 'Y' );
			}
			if( !isset( $end["Month"] ) || empty( $end["Month"] ) ) {
				$end["Month"] = 1;
			}
			if( !isset( $end["Day"] ) || empty( $end["Day"] ) ) {
				$end["Day"] = 1;
			}
		}
		
		// 日付をタイムスタンプに変換
		$data  = ( is_array( $data ) ) ? strtotime( implode( "/", $data ) ) : strtotime( $data );
		$start = ( is_array( $start ) ) ? mktime( 0, 0, 0, $start["Month"], $start["Day"], $start["Year"] ) : strtotime( $start );
		$end   = ( is_array( $end ) ) ? mktime( 0, 0, 0, $end["Month"], $end["Day"], $end["Year"] ) : strtotime( $end );
		
		// 指定日チェック
		if( !empty( $data ) ) {
			
			// 期間チェック(指定日あり)
			switch( $mode ) {
				case "<":
					if( $data < $start || $data > $end ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日", $start ) .  "～". date( "Y年m月d日", $end ) . "内の日を指定してください。<br />";
					}
				break;
				case "<=":
					if( $data <= $start || $data >= $end ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日", $start ) .  "～". date( "Y年m月d日", $end ) . "以内の日を指定してください。<br />";
					}
				break;
				default:
					if( $data <= $start || $data >= $end ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日", $start ) .  "～". date( "Y年m月d日", $end ) . "以内の日を指定してください。<br />";
					}
				break;
			}
			
		} else {
			
			// 期間チェック(指定日なし)
			if( $start > $end ) {
				return $this->_errHead . $item . "の期間指定が正しくありません。<br />";
			}
			
		}
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_DATE_START_TERM
	// 引  数: $item  - 項目名
	//       : $data  - 指定日(タイムスタンプ)
	//       : $start - 開始日(array)
	//       : $mode  - モード
	// 戻り値: エラー内容
	// 内  容: 期間チェック(日付)
	//----------------------------------------------------------------------------
	function CHECK_DATE_START_TERM( $item, $data, $start, $mode = "<" ) {
		
		// 年月日の補完
		if( empty( $start ) || is_array( $start ) ) {
			if( !isset( $start["Year"] ) || empty( $start["Year"] ) ) {
				$start["Year"] = date( 'Y' );
			}
			if( !isset( $start["Month"] ) || empty( $start["Month"] ) ) {
				$start["Month"] = date( 'm' );
			}
			if( !isset( $start["Day"] ) || empty( $start["Day"] ) ) {
				$start["Day"] = date( 'd' );
			}
		}
		
		// 日付をタイムスタンプに変換
		$data  = ( is_array( $data ) ) ? strtotime( implode( "/", $data ) ) : strtotime( $data );
		$start = ( is_array( $start ) ) ? mktime( 0, 0, 0, $start["Month"], $start["Day"], $start["Year"] ) : strtotime( $start );
		
		// 指定日チェック
		if( !empty( $data ) ) {
			
			// 期間チェック(指定日あり)
			switch( $mode ) {
				case "<":
					// 期間チェック(指定日あり)
					if( $data < $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日", $start ) . "より後の日を指定してください。<br />";
					}
				break;
				case ">":
					// 期間チェック(指定日あり)
					if( $data > $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日", $start ) . "より前の日を指定してください。<br />";
					}
				break;
				case "<=":
					// 期間チェック(指定日あり)
					if( $data <= $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日", $start ) . "以降を指定してください。<br />";
					}
				break;
				case ">=":
					// 期間チェック(指定日あり)
					if( $data >= $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日", $start ) . "以前を指定してください。<br />";
					}
				break;
				default:
					// 期間チェック(指定日あり)
					if( $data < $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日", $start ) . "以降を指定してください。<br />";
					}
				break;
			}
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_DATEYM_START_TERM
	// 引  数: $item  - 項目名
	//       : $data  - 指定日(タイムスタンプ)
	//       : $start - 開始日(array)
	// 戻り値: エラー内容
	// 内  容: 期間チェック(日付)
	//----------------------------------------------------------------------------
	function CHECK_DATEYM_START_TERM( $item, $data, $start ) {
		
		// 年月の補完
		if( empty( $start ) || is_array( $start ) ) {
			if( !isset( $start["Year"] ) || empty( $start["Year"] ) ) {
				$start["Year"] = date( 'Y' );
			}
			if( !isset( $start["Month"] ) || empty( $start["Month"] ) ) {
				$start["Month"] = date( 'm' );
			}
		}
		
		// 日付をタイムスタンプに変換
		$data  = ( is_array( $data ) ) ? strtotime( implode( "/", $data ) . "/01" ) : strtotime( $data );
		$start = ( is_array( $start ) ) ? mktime( 0, 0, 0, $start["Month"], 01, $start["Year"] ) : strtotime( $start );
		
		// 指定日チェック
		if( !empty( $data ) ) {
			
			// 期間チェック(指定日あり)
			switch( $mode ) {
				case "<":
					// 期間チェック(指定日あり)
					if( $data < $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月", $start ) . "より後の日を指定してください。<br />";
					}
				break;
				case ">":
					// 期間チェック(指定日あり)
					if( $data > $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月", $start ) . "より前の日を指定してください。<br />";
					}
				break;
				case "<=":
					// 期間チェック(指定日あり)
					if( $data <= $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月", $start ) . "以降を指定してください。<br />";
					}
				break;
				case ">=":
					// 期間チェック(指定日あり)
					if( $data >= $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月", $start ) . "以前を指定してください。<br />";
					}
				break;
				default:
					// 期間チェック(指定日あり)
					if( $data < $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月", $start ) . "以降を指定してください。<br />";
					}
				break;
			}
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_DATETIME_START_TERM
	// 引  数: $item  - 項目名
	//       : $data  - 指定日(タイムスタンプ)
	//       : $start - 開始日(array)
	//       : $mode  - モード
	// 戻り値: エラー内容
	// 内  容: 期間チェック(日付)
	//----------------------------------------------------------------------------
	function CHECK_DATETIME_START_TERM( $item, $data, $start, $mode = "<" ) {
		
		// 年月日の補完
		if( empty( $start ) || is_array( $start ) ) {
			if( !isset( $start["Year"] ) || empty( $start["Year"] ) ) {
				$start["Year"] = date( 'Y' );
			}
			if( !isset( $start["Month"] ) || empty( $start["Month"] ) ) {
				$start["Month"] = date( 'm' );
			}
			if( !isset( $start["Day"] ) || empty( $start["Day"] ) ) {
				$start["Day"] = date( 'd' );
			}
			if( !isset( $start["Hour"] ) || empty( $start["Hour"] ) ) {
				$start["Hour"] = date( 'H' );
			}
			if( !isset( $start["Minute"] ) || empty( $start["Minute"] ) ) {
				$start["Minute"] = date( 'i' );
			}
			if( !isset( $start["Second"] ) || empty( $start["Second"] ) ) {
				$start["Second"] = date( 's' );
			}
		}
		
		// 日付をタイムスタンプに変換
		$data  = ( is_array( $data ) ) ? mktime( $data["Hour"], $data["Minute"], $data["Second"], $data["Month"], $data["Day"], $data["Year"] ) : strtotime( $data );
		$start = ( is_array( $start ) ) ? mktime( $start["Hour"], $start["Minute"], $start["Second"], $start["Month"], $start["Day"], $start["Year"] ) : strtotime( $start );
		
		// 指定日チェック
		if( !empty( $data ) ) {
			
			// 期間チェック(指定日あり)
			switch( $mode ) {
				case "<":
					if( $data < $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日 H時i分", $start ) . "より後の日を指定してください。<br />";
					}
				break;
				case ">":
					if( $data > $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日 H時i分", $start ) . "より前の日を指定してください。<br />";
					}
				break;
				default:
					if( $data <= $start ) {
						return $this->_errHead . $item . "は" . date( "Y年m月d日 H時i分", $start ) . "以降を指定してください。<br />";
					}
				break;
			}
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_TIME_START_TERM
	// 引  数: $item  - 項目名
	//       : $data  - 指定日(タイムスタンプ)
	//       : $start - 開始日(array)
	//       : $mode  - モード
	// 戻り値: エラー内容
	// 内  容: 期間チェック(日付)
	//----------------------------------------------------------------------------
	function CHECK_TIME_START_TERM( $item, $data, $start, $mode = "<" ) {
		
		// 年月日の補完
		if( empty( $start ) || is_array( $start ) ) {
			if( !isset( $start["Year"] ) || empty( $start["Year"] ) ) {
				$start["Year"] = date( 'Y' );
			}
			if( !isset( $start["Month"] ) || empty( $start["Month"] ) ) {
				$start["Month"] = date( 'm' );
			}
			if( !isset( $start["Day"] ) || empty( $start["Day"] ) ) {
				$start["Day"] = date( 'd' );
			}
			if( !isset( $start["Hour"] ) || empty( $start["Hour"] ) ) {
				$start["Hour"] = date( 'H' );
			}
			if( !isset( $start["Minute"] ) || empty( $start["Minute"] ) ) {
				$start["Minute"] = date( 'i' );
			}
			if( !isset( $start["Second"] ) || empty( $start["Second"] ) ) {
				$start["Second"] = date( 's' );
			}
		}
		
		// 日付をタイムスタンプに変換
		$data  = ( is_array( $data ) ) ? mktime( $data["Hour"], $data["Minute"], $data["Second"], $data["Month"], $data["Day"], $data["Year"] ) : strtotime( $data );
		$start = ( is_array( $start ) ) ? mktime( $start["Hour"], $start["Minute"], $start["Second"], $start["Month"], $start["Day"], $start["Year"] ) : strtotime( $start );
		
		// 指定日チェック
		if( !empty( $data ) ) {
			
			// 期間チェック(指定日あり)
			switch( $mode ) {
				case "<":
					if( $data < $start ) {
						return $this->_errHead . $item . "は" . date( "H時i分", $start ) . "より後の時間を指定してください。<br />";
					}
				break;
				case ">":
					if( $data > $start ) {
						return $this->_errHead . $item . "は" . date( "H時i分", $start ) . "より前の時間を指定してください。<br />";
					}
				break;
				default:
					if( $data <= $start ) {
						return $this->_errHead . $item . "は" . date( "H時i分", $start ) . "以降を指定してください。<br />";
					}
				break;
			}
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: ALPHA_CHECK
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 英字チェック
	//----------------------------------------------------------------------------
	function ALPHA_CHECK( $item, $data ) {
		
		// 英数チェック
		if( mb_strlen( $data ) > 0 && !ctype_alpha( $data ) ) {
			return $this->_errHead . $item . "は半角英字で入力してください。<br />";
		} else {
			return null;
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_KANA
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: カタカナチェック
	//----------------------------------------------------------------------------
	function CHECK_KANA( $item, $data ) {
		
		// カタカナチェック
		if( mb_strlen( $data ) > 0 && !preg_match("/^[ 　ァ-ヶｦ-ﾟー]+$/u", $data ) ) {
			return $this->_errHead . $item . "はカタカナで入力してください。<br />";
		} else {
			return null;
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_ALNUM
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 英数字チェック
	//----------------------------------------------------------------------------
	function CHECK_ALNUM( $item, $data ) {
		
		// 英数チェック
		if( mb_strlen( $data ) > 0 && !ctype_alnum( $data ) ) {
			return $this->_errHead . $item . "は英数字で入力してください。（※ スペースは入りません。）<br />";
		} else {
			return null;
		}
		
	}
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_ALNUM_TYPE2
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 英数字チェック(半角スペース許可)
	//----------------------------------------------------------------------------
	function CHECK_ALNUM_TYPE2( $item, $data ) {

		// 半角スペースを取り除く
		$data = str_replace( array( " ", "?", ".", "!" ), "", $data );

		// 英数チェック
		if( mb_strlen( $data ) > 0 && !ctype_alnum( $data ) ) {
			return $this->_errHead . $item . "は英数字で入力してください。（※ 全角スペースは入りません。）<br />";
		} else {
			return null;
		}

	}
    
    //----------------------------------------------------------------------------
	// 関数名: CHECK_EM
	// 引  数: $item - 項目名
	//       : $data - チェックデータ
	// 戻り値: エラー内容
	// 内  容: 全角チェック
	//----------------------------------------------------------------------------
	function CHECK_EM( $item, $data ) {

		// 入力チェック
		if( !empty( $data ) ) {

			//記号をリプレイス
			$data = preg_replace( '/[!\?\-\/:-@\[-`\{-\~]/', '', $data );

			// 全角チェック
			if( ( ( mb_strlen( $data ) > 0 ) && ( ctype_alnum( $data )  ) ) || empty( $data ) ) {
				return $this->_errHead . $item . "は全角を含んで入力してください。<br />";
			} else {
				return null;
			}

		}

	}
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_EXT
	// 引  数: $item - ファイル名
	//       : $data - チェックデータ 
	//       : $ext  - 拡張子許可
	// 戻り値: エラー内容
	// 内  容: ファイルの拡張子チェック。
	//----------------------------------------------------------------------------
	function CHECK_EXT( $item, $data, $ext ) {
		
		// データチェック
		if( empty( $data ) ) {
			return null;
		}
		
		// 拡張子を取得
		$parts = pathinfo( $data );
		
		// 拡張子チェック
		if( array_search( strtolower( $parts["extension"] ), $ext ) === false ) {
			return $this->_errHead . $item . "の拡張子は" . implode( "、", $ext ) . "が指定可能です。<br />";
		} else {
			return null;
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: CHECK_FILE_EXISTS
	// 引  数: $item - ファイル名
	//       : $data - チェックデータ 
	//       : $dir  - 保存先
	// 戻り値: エラー内容
	// 内  容: ファイルの存在チェック。
	//----------------------------------------------------------------------------
	function CHECK_FILE_EXISTS( $item, $data, $dir ) {
		
		// パス
		$path = $dir . $data;
		
		// データチェック
		if( empty( $path ) ) {
			return null;
		}
		
		// 存在チェック
		if( !file_exists( $path ) ) {
			return $this->_errHead . $item . "は存在しません。<br />";
		} else {
			return null;
		}
		
	}
	
}
?>