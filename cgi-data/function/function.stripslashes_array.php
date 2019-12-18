<?php

//----------------------------------------------------------------------------
// 関数名：stripslashes_array
// 引  数：$arr_value - 変換対象配列
// 戻り値：変換された配列
// 内  容：配列の各要素をエスケープを元に戻す。
//----------------------------------------------------------------------------
function stripslashes_array( $arr_value ) {
	
	// 配列が空(不正)の場合
	if ( $arr_value == FALSE ) {
		return $arr_value;
	}
	
	// 連想配列にも対応するため
	foreach ( $arr_value as $key => $val ) {
		// 配列の場合
		if ( is_array( $val ) ) {
			// 再起呼出
			$arr_value[$key] = stripslashes_array( $val );
		} else {
			$arr_value[$key] = stripslashes( $val );
		}
	}
	return $arr_value;
}

?>