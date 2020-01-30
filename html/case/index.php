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
$_HTML_HEADER["title"] = "実績紹介";

// キーワード
$_HTML_HEADER["keyword"] = "";

// ディスクリプション
$_HTML_HEADER["description"] = "";


//----------------------------------------
//  データ取得
//----------------------------------------
// 操作クラス
$objManage      = new DB_manage( _DNS );
$objCase = new FT_case( $objManage );

// 検索条件
$search["page"] = ( empty( $arr_get["page"] ) ) ? 1 : $arr_get["page"];

// データ取得
$t_case = $objCase->GetSearchList( $search );


// クラス削除
unset( $objCase );
unset( $objManage      );


//----------------------------------------
//  smarty設定
//----------------------------------------
$smarty = new MySmarty("front");
$smarty->compile_dir .= "case/";

//テンプレートに設定
$smarty->assign( "page_navi"    , $t_case["page"] );
$smarty->assign( "t_case", $t_case["data"] );
$smarty->assign( "message"      , $message               );

// オプション設定
$smarty->assign( "OptionCaseCategory", $OptionCaseCategory );

// 表示
$smarty->display("index.tpl");
?>
