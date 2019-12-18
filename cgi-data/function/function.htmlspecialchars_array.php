<?php

//----------------------------------------------------------------------------
// 関数名：htmlspecialchars_array                                             
// 引  数：$arr_value   - 変換前配列                                          
//       ：$quote_style - クォート種別                                        
// 戻り値：変換された文字列                                                   
// 内  容：配列の各要素を特殊文字をHTMLエンティティに変換する。               
//----------------------------------------------------------------------------
function htmlspecialchars_array( $arr_value, $quote_style = ENT_COMPAT ) {
	
	// 配列が空(不正)の場合
	if ( $arr_value == FALSE ) {
		return $arr_value;
	}
	
	// 連想配列にも対応するため
	foreach ( $arr_value as $key => $val ) {
		// 配列の場合
		if ( is_array( $val ) ) {
			// 再起呼出
			$arr_value[$key] = htmlspecialchars_array( $val, $quote_style );
		} else {
			$arr_value[$key] = htmlspecialchars( addslashes($val), $quote_style );
		}
	}
	return $arr_value;
	
}

?>