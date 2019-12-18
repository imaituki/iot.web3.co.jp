<?php

//----------------------------------------------------------------------------
// 関数名：mb_convert_kana_array                                              
// 引  数：$arr_value - 変換対象配列                                          
//       ：$option    - オプション
// 戻り値：変換された配列                                                     
// 内  容：配列の各要素をDB用エスケープする。                                 
//----------------------------------------------------------------------------
function mb_convert_kana_array( $arr_value, $option, $encoding = "UTF-8" ) {
	
	// 配列が空(不正)の場合
	if ( $arr_value == FALSE ) {
		return $arr_value;
	}
	
	// 連想配列にも対応するため
	foreach ( $arr_value as $key => $val ) {
		// 配列の場合
		if ( is_array( $val ) ) {
			// 再起呼出
			$arr_value[$key] = mb_convert_kana_array( $val, $option, $encoding );
		} else {
			$arr_value[$key] = mb_convert_kana( $val, $option, $encoding );
		}
	}
	return $arr_value;
	
}

?>