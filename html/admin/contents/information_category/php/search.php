<?php
//-------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容: information 検索
//-------------------------------------------------------------------

//----------------------------------------
//  設定ファイル
//----------------------------------------
require "./config.ini";


//----------------------------------------
//  SESSION設定
//----------------------------------------
$_SESSION["admin"][_CONTENTS_DIR]["search"]["POST"] = $arr_post;


//----------------------------------------
//  データ一覧取得
//----------------------------------------
// 操作クラス
$objManage  = new DB_manage( _DNS );
$mainObject = new $class_name( $objManage );

// データ取得
$t_information_category = $mainObject->GetSearchList( $arr_post );

// クラス削除
unset( $objManage );
unset( $mainObject );


//----------------------------------------
//  表示
//----------------------------------------
// smarty設定
$smarty = new MySmarty("admin");
$smarty->compile_dir .= _CONTENTS_DIR;

// テンプレートに設定
$smarty->assign( "page_navi"              , $t_information_category["page"] );
$smarty->assign( "t_information_category" , $t_information_category["data"] );


// 表示
$smarty->display("list.tpl");
?>
