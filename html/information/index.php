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
//  ヘッダー情報
//----------------------------------------
// タイトル
$_HTML_HEADER["title"] = "お知らせ";

// キーワード
$_HTML_HEADER["keyword"] = "";

// ディスクリプション
$_HTML_HEADER["description"] = "";


//----------------------------------------
//  データ取得
//----------------------------------------
// 操作クラス
$objManage      = new DB_manage( _DNS );
$objInformation = new FT_information( $objManage );

// 検索条件
$search["page"] = ( empty( $arr_get["page"] ) ) ? 1 : $arr_get["page"];

// データ取得
$t_information = $objInformation->GetSearchList( $search );


// クラス削除
unset( $objInformation );
unset( $objManage      );


//----------------------------------------
//  smarty設定
//----------------------------------------
$smarty = new MySmarty("front");
$smarty->compile_dir .= "information/";

//テンプレートに設定
$smarty->assign( "page_navi"    , $t_information["page"] );
$smarty->assign( "t_information", $t_information["data"] );
$smarty->assign( "message"      , $message               );

// オプション設定
$smarty->assign( "OptionInformationCategory", $OptionInformationCategory );

// 表示
$smarty->display("index.tpl");
?>
