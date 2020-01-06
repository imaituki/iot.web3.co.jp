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
$objCase        = new FT_case( $objManage );

// お知らせ
$t_information  = $objInformation->GetSearchList( null, array("fetch" => _DB_FETCH_ALL), 3 );
// 実績紹介
$t_case  = $objCase->GetSearchList( null, array("fetch" => _DB_FETCH_ALL), 3 );

// クラス削除
unset( $objInformation   );
unset( $objCase          );
unset( $objManage        );


//----------------------------------------
//  ヘッダー情報
//----------------------------------------
// タイトル
$_HTML_HEADER["title"] = "";

// キーワード
$_HTML_HEADER["keyword"] = "";

// ディスクリプション
$_HTML_HEADER["description"] = "";


//----------------------------------------
//  smarty設定
//----------------------------------------
$smarty = new MySmarty("front");
$smarty->compile_dir .= "/";

// テンプレートに設定
$smarty->assign( "t_information" , $t_information );
$smarty->assign( "t_case"        , $t_case        );

// オプション設定
$smarty->assign( "OptionInformationCategory", $OptionInformationCategory );
$smarty->assign( "OptionCaseCategory"       , $OptionCaseCategory        );

// 表示
$smarty->display("index.tpl");

?>
