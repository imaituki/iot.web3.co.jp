<?php

// 暗号化モジュールモード
define("_MCRYPT_TYPE", "rijndael-256");

//----------------------------------------------------------------------------
// 関数名：fn_encrypt
// 引  数：$str        - 暗号化する文字列
//       ：$mcrypt_key - 暗号キー
// 戻り値：暗号化した文字列
// 内  容：文字列を暗号化する。
//----------------------------------------------------------------------------
function fn_encrypt( $str, $mcrypt_key ) {
	
	// 暗号化モジュールオープン
	$td  = mcrypt_module_open( _MCRYPT_TYPE, "", "ecb", "" );
	$iv  = mcrypt_create_iv( mcrypt_enc_get_iv_size( $td ), MCRYPT_RAND );
	$key = substr( $mcrypt_key, 0, mcrypt_enc_get_key_size( $td ) );
	
	// 暗号化モジュール初期化
	mcrypt_generic_init( $td, $mcrypt_key, $iv );
	
	// データを暗号化
	$str = base64_encode( mcrypt_generic( $td, $str ) );
	
	// 暗号化モジュール終了
	mcrypt_generic_deinit( $td );
	mcrypt_module_close( $td );
	
	// 戻り値
	return $str;
	
}

//----------------------------------------------------------------------------
// 関数名：fn_decrypt
// 引  数：$str - 復号化する文字列
//       ：$mcrypt_key - 暗号キー
// 戻り値：復号化した文字列
// 内  容：文字列を復号化する。
//----------------------------------------------------------------------------
function fn_decrypt( $str, $mcrypt_key ) {
	
	// データチェック
	if( $str == "" || $mcrypt_key == "" ) {
		return null;
	}
	
	// 暗号化モジュールオープン
	$td  = mcrypt_module_open( _MCRYPT_TYPE, "", "ecb", "" );
	$iv  = mcrypt_create_iv( mcrypt_enc_get_iv_size( $td ), MCRYPT_RAND );
	$key = substr( $mcrypt_key, 0, mcrypt_enc_get_key_size( $td ) );
	
	// 暗号化モジュール初期化
	mcrypt_generic_init( $td, $mcrypt_key, $iv );
	
	// 復号化
	if( !empty( $str ) ) {
		$str = mdecrypt_generic( $td, base64_decode( $str ) );
	}
	
	// 空白削除
	$str = rtrim( $str );
	
	// 暗号化モジュール終了
	mcrypt_generic_deinit( $td );
	mcrypt_module_close( $td );
	
	// 戻り値
	return $str;
	
}
?>