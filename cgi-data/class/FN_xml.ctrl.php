<?php
class FN_xml {
	
	//-------------------------------------------------------
	//  変数宣言
	//-------------------------------------------------------
	// 対象XMLデータ
	var $_xmlPath = NULL;
	var $_xmlStr  = NULL;
	
	// XML作成オプション
	var $_defCreateOption = array(
		"version"         => "1.0", 
		"encoding"        => "UTF-8", 
		"rootCode"        => "root", 
		"contentName"     => "_contents", 
		"attributesArray" => "_attributes" 
	);
	
	
	//-------------------------------------------------------
	// 関数名: __construct
	// 引  数: $xmlPath
	// 戻り値: なし
	// 内  容: コンストラクタ
	//-------------------------------------------------------
	function __construct( $xmlPath = null ) {
		
		// XMLパス
		$this->_xmlPath = $xmlPath;
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: setXmlPath
	// 引  数: $xmlPath - XMLパス
	// 戻り値: なし
	// 内  容: XMLパスの変更
	//-------------------------------------------------------
	function SetXmlPath( $xmlPath ) {
		
		// XMLパス
		$this->_xmlPath = $xmlPath;
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: SaveXml
	// 引  数: $strXml - XML
	// 戻り値: なし
	// 内  容: XMLの保存
	//-------------------------------------------------------
	function SaveXml( $strXml = null ) {
		
		// データの読み込み
		if( !empty( $strXml ) ) {
			$xml = simplexml_load_string( $strXml );
		} else {
			$xml = simplexml_load_string( $this->_xmlStr );
		}
		
		// 保存
		$xml->asXml( $this->_xmlPath );
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: GetDataXml
	// 引  数: $xmlAry - XML配列
	//       : $option - XML作成オプション
	// 戻り値: XMLデータ配列
	// 内  容: XMLデータ配列取得
	//-------------------------------------------------------
	function GetDataXml( $xmlAry = null, $option = null ) {
		
		// 初期化
		$res = null;
		
		// 作成オプション
		$option = ( !empty( $option ) ) ? $option : $this->_defCreateOption;
		
		// 配列データ取得
		if( is_array( $xmlAry ) ) {
			foreach( $xmlAry as $key => $val ) {
				
				// データ取得
				if( isset( $val[$option["contentName"]] ) ) { 
					$res[$key] = $val[$option["contentName"]];
				} else {
					$res[$key] = null;
				}
				
				// 不要データ削除
				unset( $val[$option["attributesArray"]] );
				unset( $val[$option["contentName"]] );
				
				// 配列下層があれば
				if( is_array( $val ) && !empty( $val ) ) {
					$res[$key] = $this->GetDataXml( $val, $option );
				}
				
			}
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//-------------------------------------------------------
	// 関数名: GetAttrXml
	// 引  数: $xmlAry - XML配列
	//       : $option - XML作成オプション
	// 戻り値: XML属性データ配列
	// 内  容: XML属性データ配列取得
	//-------------------------------------------------------
	function GetAttrXml( $xmlAry = null, $option = null ) {
		
		// 初期化
		$res = null;
		
		// 作成オプション
		$option = ( !empty( $option ) ) ? $option : $this->_defCreateOption;
		
		// 配列データ取得
		if( is_array( $xmlAry ) ) {
			foreach( $xmlAry as $key => $val ) {
				
				// データ取得
				if( isset( $val[$option["attributesArray"]] ) ) { 
					$attr = $val[$option["attributesArray"]];
				} else {
					$attr = null;
				}
				
				// 不要データ削除
				unset( $val[$option["attributesArray"]] );
				unset( $val[$option["contentName"]] );
				
				// 配列下層があれば
				if( is_array( $val ) && !empty( $val ) ) {
					$res[$key] = $this->GetAttrXml( $val, $option );
				}
				
				// データ設定
				if( isset( $res[$key] ) && is_array( $res[$key] ) ) {
					$res[$key][$option["attributesArray"]] = $attr;
				} else {
					$res[$key] = $attr;
				}
				
			}
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//----------------------------------------------------------------------------
	// 関数名: GetArrayXml
	// 引  数: $strXml  - XML文字列（無い場合はxmlPathに指定したファイルを読み込む）
	//       : $getAttr - 属性取得（true or false）
	//       : $option  - XML作成オプション
	// 戻り値: 取得値
	// 内  容: XMLデータ配列の作成を行う
	//----------------------------------------------------------------------------
	function GetArrayXml( $strXml = null, $getAttr = true, $option = null ) {
		
		// 初期化
		$res = NULL;
		
		// 最新読み込み
		if( !empty( $strXml ) ) {
			$xmlObj = simplexml_load_string( $strXml );
		} else {
			$xmlObj = simplexml_load_file( $this->_xmlPath );
		}
		
		// 作成オプション
		$option = ( !empty( $option ) ) ? $option : $this->_defCreateOption;
		
		// データ読み込み
		if( is_object( $xmlObj ) ) {
			foreach( $xmlObj as $key => $val ) {
				
				// データ取得
				$nkey = $val->getName();
				
				// データ取得
				if( !empty( $val ) ) {
					
					// テキスト
					$tmp = trim( (string)$xmlObj->$nkey );
					if( !empty( $tmp ) ) {
						$res[$nkey][$option["contentName"]] = (string)$xmlObj->$nkey;
					}
					
					// 下層取得
					$tmp = $this->GetArrayXml( $val->asXML(), $getAttr, $option );
					
					// 配列に設定
					if( is_array( $res[$nkey] ) && array_keys( $res[$nkey], $nkey ) !== false && is_array( $tmp ) ) {
						if( isset( $res[$nkey][0] ) ) {
							$res[$nkey][] = $tmp;
						} elseif( !empty( $res[$nkey] ) ) {
							$res[$nkey] = array( $res[$nkey], $tmp );
						} else {
							$res[$nkey] = $tmp;
						}
					} elseif( is_array( $res[$nkey] ) && is_array( $tmp ) ) {
						$res[$nkey] = $res[$nkey] + $tmp;
					} elseif( !is_array( $res[$nkey] ) && is_array( $tmp ) ) {
						$res[$nkey] = $tmp;
					}
					
				} else {
					$res[$nkey][$option["contentName"]] = (string)$xmlObj->$nkey;
				}
				
				// 属性取得
				if( $getAttr == true ) {
					if( count( $xmlObj->$nkey->attributes() ) > 0 ) {
						foreach( $xmlObj->$nkey->attributes() as $attrKey => $attr ) {
							$res[$nkey][$option["attributesArray"]][$attrKey] = (string)$attr;
						}
					}
				}
				
			}
		}
		
		// 戻り値
		return $res;
		
	}
	
	
	//-------------------------------------------------------------------
	// 関数名: CreateArrayToXml
	// 引  数: $array  - 連想配列
	//       : $option - XML作成オプション
	// 戻り値: XML
	// 内  容: 連想配列からXMLを作成する
	//-------------------------------------------------------------------
	function CreateArrayToXml( $array, $savePath = null, $option = null ) {
		
		// データチェック
		if( !is_array( $array ) ) {
			return null;
		}
		
		// 作成オプション
		$option = ( !empty( $option ) ) ? $option : $this->_defCreateOption;
		
		// 保存先
		$savePath = ( !empty( $savePath ) ) ? $savePath : $this->_xmlPath;
		
		// XML作成開始
		$xml = new SimpleXMLElement('<?xml version="' . $option["version"] . '" encoding="' . $option["encoding"] . '" ?><' . $option["rootCode"] . '></' . $option["rootCode"] . '>');
		
		// 作成
		$this->AddNode( $xml, $array, $option );
		
		// 改行処理を行うため
		$dom = new DOMDocument( '1.0' );
		$dom->loadXML( $xml->asXML() );
		$dom->formatOutput = true;
		$this->_xmlStr = $dom->saveXML();
		
		// 戻り値
		return $this->_xmlStr;
		
	}
	
	
	//-------------------------------------------------------------------
	// 関数名: AddNode
	// 引  数: $xml    - SimpleXMLElementクラス
	//       : $array  - 連想配列
	//       : $option - XML作成オプション
	// 戻り値: XML
	// 内  容: XMLへ属性・ノードの追加を行う
	//-------------------------------------------------------------------
	function AddNode( &$xml, $array, $option ) {
		
		// XML作成
		foreach( $array as $key => $val ) {
			
			// タグ追加
			if( isset( $val[$option["contentName"]] ) ) {
				$node = $xml->addChild( $key, $this->escapeXmlData( $val[$option["contentName"]] ) );
			} else {
				$node = $xml->addChild( $key );
			}
			
			// 属性追加
			if( isset( $val[$option["attributesArray"]] ) && is_array( $val[$option["attributesArray"]] ) ) {
				foreach( $val[$option["attributesArray"]] as $key2 => $val2 ) {
					$node->addAttribute( $key2, $this->escapeXmlData( $val2 ) );
				}
			}
			
			// 不要データ削除
			unset( $val[$option["attributesArray"]] );
			unset( $val[$option["contentName"]] );
			
			// 下層
			if( is_array( $val ) ) {
				$this->AddNode( $node, $val, $option );
			}
		}
		
	}
	
	
	//-------------------------------------------------------------------
	// 関数名: escapeXmlData
	// 引  数: $val - エスケープ対象データ
	// 戻り値: エスケープ後のデータ
	// 内  容: エスケープを行う
	//-------------------------------------------------------------------
	function escapeXmlData( $val ) {
		return htmlspecialchars( $val, ENT_QUOTES );
	}
	
}
