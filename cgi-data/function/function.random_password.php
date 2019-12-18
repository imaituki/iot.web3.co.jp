<?php

//----------------------------------------------------------------------------
// 関数名：random_password
// 引  数：なし
// 戻り値：$password - パスワード
// 内  容：ランダムでパスワードを生成する。
//----------------------------------------------------------------------------
function random_password( $length, $use_string = NULL ) {
	
	// 初期化
	$password = "";
	
	// パスワードの長さ指定
	if( !empty( $length ) ) {
		$pw_length = $length;
	} else {
		$pw_length = 8;
	}
	
	// パスワードで使う文字列を設定
	if( empty( $use_string ) ) {
		$use_string = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	}
	
	// パスワード生成
	for( $i = 0; $i < $pw_length; $i++ ) {
		
		// ランダム値取得
		$rand_num  = rand( 0, ( strlen( $use_string ) - 1 ) );
		
		// パスワード結合
		$password .= substr( $use_string, $rand_num, 1 );
		
	}
	
	return $password;
}
?>