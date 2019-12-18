<?php

//----------------------------------------------------------------------------
// 関数名：disp_arr                                                           
// 引  数：$to_encoding   - 変換後エンコード                                  
//       ：$from_encoding - 変換元エンコード                                  
// 戻り値：                                                                   
// 内  容：配列要素を表示する(デバッグ用)                                     
//----------------------------------------------------------------------------
function disp_arr( $arr, $to_encoding = NULL, $from_encoding = NULL ) {
	
	// 両エンコードが設定されている場合
	if ($to_encoding != NULL && $from_encoding != NULL) {
		$arr = convert_encoding_array($arr,$to_encoding,$from_encoding);
	}
	
	// データ表示
	echo "<pre style=\"
		text-align:left;
		font-size:12px;
		background:#F6F6F6;
		color:#111;
		padding:10px;
		border-top:8px solid #6286B8;
		border-bottom:8px solid #6286B8;
		margin-bottom:10px;
		position:relative;
		top:0;
		left:0;
		z-index:6;
		line-height:130%;
	\">";
	print_r($arr);
	echo "</pre>";
	
}


//----------------------------------------------------------------------------
// 関数名：dispnone_arr                                                           
// 引  数：$to_encoding   - 変換後エンコード                                  
//       ：$from_encoding - 変換元エンコード                                  
// 戻り値：                                                                   
// 内  容：配列要素を表示する(デバッグ用)                                     
//----------------------------------------------------------------------------
function dispnone_arr( $arr, $to_encoding = NULL, $from_encoding = NULL ) {
	
	// 両エンコードが設定されている場合
	if ($to_encoding != NULL && $from_encoding != NULL) {
		$arr = convert_encoding_array($arr,$to_encoding,$from_encoding);
	}
	
	// データ表示
	echo "<!--";
	print_r($arr);
	echo "-->";
	
}

?>