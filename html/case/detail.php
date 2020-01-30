<?php
//-------------------------------------------------------------------
// 作成日：2019/10/11
// 作成者：岡田
// 内  容：トップページ
//-------------------------------------------------------------------

//----------------------------------------
//  共通設定
//----------------------------------------
require "./config.ini";

//----------------------------------------
//  データ取得
//----------------------------------------
// 操作クラス
$objManage      = new DB_manage( _DNS );
$objCase = new FT_case( $objManage );

// データ取得
$t_case = $objCase->GetIdRow( $arr_get["id"] );

// クラス削除
unset( $objManage      );
unset( $objCase );


if( !empty( $t_case["id_case"] ) ){
	
	//----------------------------------------
	//  ヘッダー情報
	//----------------------------------------
	// タイトル
	$_HTML_HEADER["title"] = $t_case["title"];
	
	// キーワード
	$_HTML_HEADER["keyword"] = "";
	
	// ディスクリプション
	$_HTML_HEADER["description"] = "";
	
	//----------------------------------------
	//  smarty設定
	//----------------------------------------
	$smarty = new MySmarty("front");
	$smarty->compile_dir .= "case/";

	// テンプレートに設定
	$smarty->assign( "t_case"       , $t_case        );

    // オプション設定
    $smarty->assign( "OptionCaseCategory", $OptionCaseCategory );
    
	// 表示
	$smarty->display("detail.tpl");
}else{
	header( "Location: ./" );
	exit;
}
?>