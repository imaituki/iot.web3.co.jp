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
$objInformation = new FT_information( $objManage );

// データ取得
$t_information = $objInformation->GetIdRow( $arr_get["id"] );

// クラス削除
unset( $objManage      );
unset( $objInformation );


if( !empty( $t_information["id_information"] ) ){
	
	//----------------------------------------
	//  ヘッダー情報
	//----------------------------------------
	// タイトル
	$_HTML_HEADER["title"] = $t_information["title"];
	
	// キーワード
	$_HTML_HEADER["keyword"] = "";
	
	// ディスクリプション
	$_HTML_HEADER["description"] = "";
	
	//----------------------------------------
	//  smarty設定
	//----------------------------------------
	$smarty = new MySmarty("front");
	$smarty->compile_dir .= "information/";

	// テンプレートに設定
	$smarty->assign( "t_information"       , $t_information        );

    // オプション設定
    $smarty->assign( "OptionInformationCategory", $OptionInformationCategory );
    
	// 表示
	$smarty->display("detail.tpl");
}else{
	header( "Location: ./" );
	exit;
}
?>