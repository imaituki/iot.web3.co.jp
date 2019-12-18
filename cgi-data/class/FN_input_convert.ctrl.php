<?php
class FN_input_convert {
	
	//-------------------------------------------------------
	//  変数宣言
	//-------------------------------------------------------
	// 変換対象データ
	var $_data = array();
	
	// 変換モードリスト
	var $_entryConvert = array();
	
	// デフォルト文字コード
	var $_defEnc    = "UTF-8";
	
	
	//-------------------------------------------------------
	// 関数名: __construct
	// 引  数: $data - 変換データ
	//       : $enc  - 文字コード
	// 戻り値: なし
	// 内  容: コンストラクタ
	//-------------------------------------------------------
	function __construct( $data, $enc ) {
		
		// 初期化
		$this->_data = $data;
		
		// 初期文字コード設定
		if( !empty( $enc ) ) {
			$this->_defEnc = $enc;
		}
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: getData
	// 引  数: なし
	// 戻り値: 対象データ
	// 内  容: 対象データを取得
	//----------------------------------------------------------------------------
	function getData() {
		return $this->_data;
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: entryConvert
	// 引  数: $keyName    - キー
	//       : $arrConvert - データ変換項目
	//       : $convert    - 変換モード（mb_convert_kana）
	//       : $changeEnc  - 変換文字コード
	// 戻り値: なし
	// 内  容: 変換モードのエントリー
	//----------------------------------------------------------------------------
	function entryConvert( $keyName, $arrConvert, $convert, $changeEnc = null ) {
		$this->_entryConvert[] = array( $keyName, $arrConvert, $convert, $changeEnc );
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: freshEntryData
	// 引  数: なし
	// 戻り値: なし
	// 内  容: データのエントリー解除
	//----------------------------------------------------------------------------
	function freshEntryData() {
		$this->_entryConvert = array();
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: execConvertAll
	// 引  数: なし
	// 戻り値: なし
	// 内  容: エントリー中の一括変換処理
	//----------------------------------------------------------------------------
	function execConvertAll() {
		
		// 初期化
		$res = array();
		
		// エントリー中のデータ一括処理
		if( is_array( $this->_entryConvert ) ) {
			foreach( $this->_entryConvert as $key => $val ) {
				call_user_func_array( array( $this, "execConvert" ), $val );
			}
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: execConvert
	// 引  数: $keyName    - キー
	//       : $arrConvert - データ変換項目
	//       : $convert    - 変換モード（mb_convert_kana）
	//       : $changeEnc  - 変換エンコード
	// 戻り値: なし
	// 内  容: データ変換
	//----------------------------------------------------------------------------
	function execConvert( $keyName, $arrConvert, $convert = null, $changeEnc = null ) {
		
		// 初期化
		$data = null;
		
		// 対象データの取得
		if( strcmp( substr( $keyName, 0, 1 ), "[" ) == 0 && strcmp( substr( $keyName, -1 ), "]" ) == 0 ) {
			eval( '$data = $this->_data' . $keyName . ';' );
		} else {
			$data = $this->_data[$keyName];
		}
		
		// データチェック
		if( isset( $data ) ) {
			
			// データ変換
			$data = $this->convert( $data, $arrConvert, $convert, $changeEnc );
			
			// 対象データの設定
			if( strcmp( substr( $keyName, 0, 1 ), "[" ) == 0 && strcmp( substr( $keyName, -1 ), "]" ) == 0 ) {
				eval( '$this->_data' . $keyName . ' = $data;' );
			} else {
				$this->_data[$keyName] = $data;
			}
			
		}
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: convert
	// 引  数: $data       - 変換データ
	//       : $arrConvert - データ変換項目
	//       : $convert    - 変換モード（mb_convert_kana）
	//       : $changeEnc  - 変換エンコード
	// 戻り値: 英字大文字
	// 内  容: 英字大文字に変換
	//----------------------------------------------------------------------------
	function convert( $data = null, $arrConvert, $convert = null, $changeEnc = null ) {
		
		// データ変換
		if( is_array( $data ) ) {
			foreach( $data as $key => $val ) {
				$data[$key] = $this->convert( $val, $arrConvert, $convert, $changeEnc );
			}
		} elseif( !empty( $data ) ) {
			if( is_array( $arrConvert ) ) {
				foreach( $arrConvert as $key => $val ) {
					
					// 処理分岐
					switch ( $val ) {
						case "STR_UP":
						case "STR_LOW":
							$data = $this->$val( $data );
						break;
						case "ENC_KANA":
							$data = $this->$val( $data, $convert );
						break;
						case "ENC_ENCODING":
							$data = $this->$val( $data, $changeEnc );
						break;
					}
				}
			}
		}
		
		// 戻り値
		return $data;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: STR_UP
	// 引  数: $data - 変換データ
	// 戻り値: 英字大文字
	// 内  容: 英字大文字に変換
	//----------------------------------------------------------------------------
	function STR_UP( $data ) {
		return strtoupper( $data );
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: STR_LOW
	// 引  数: $data - 変換データ
	// 戻り値: 英字小文字
	// 内  容: 英字小文字に変換
	//----------------------------------------------------------------------------
	function STR_LOW( $data ) {
		return strtolower( $data );
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: ENC_KANA
	// 引  数: $data - 変換データ
	//       : $cnv  - 変換モード
	// 戻り値: 文字変換後のデータ
	// 内  容: 指定のモードで文字変換を行う。
	//----------------------------------------------------------------------------
	function ENC_KANA( $data, $cnv ) {
		return mb_convert_kana( $data, $cnv, $this->_defEnc );
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: ENC_ENCODING
	// 引  数: $data - 変換データ
	//       : $enc  - 変換文字コード
	// 戻り値: エンコード後のデータ
	// 内  容: 指定の文字コードにエンコードを行う。
	//----------------------------------------------------------------------------
	function ENC_ENCODING( $data, $enc ) {
		return mb_convert_encoding( $data, $enc, $this->_defEnc );
	}
	
	
}
?>