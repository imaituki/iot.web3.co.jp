<?php
//-------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容: case プレビュー
//-------------------------------------------------------------------

//----------------------------------------
//  共通設定
//----------------------------------------
require "./config.ini";
require $_SERVER["DOCUMENT_ROOT"] . "/..". _CGI_PATH. "/config/front.ini";


//----------------------------------------
//  データ整理
//----------------------------------------
// 保存済みの画像
if( is_array( $_ARR_IMAGE ) ) {
	foreach( $_ARR_IMAGE as $key => $val ) {
		if( !empty($arr_post["_image". $key. "_now"]) ){
			$arr_post["image". $key] = $arr_post["_image". $key. "_now"];
		}
	}
}

// 保存済みのファイル
if( is_array( $_ARR_FILE ) ) {
	foreach( $_ARR_FILE as $key => $val ) {
		if( !empty($arr_post["_file". $key. "_now"]) ){
			$arr_post["file". $key] = $arr_post["_file". $key. "_now"];
		}
	}
}

// タグ許可
if( !empty($arr_post["comment"]) ){
	$arr_post["comment"] = html_entity_decode( $arr_post["comment"] );
}


//----------------------------------------
//  表示
//----------------------------------------
$smarty = new MySmarty("front");
$smarty->compile_dir .= _CONTENTS_DIR. "/";

// テンプレート設定
$smarty->assign( "data", $arr_post );

// 表示
$html = $smarty->fetch( _PREVIEW_TPL, "", _CONTENTS_DIR . "_preview" );

echo $html;
?>
