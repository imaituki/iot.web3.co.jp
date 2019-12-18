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
if( !empty($arr_post["search_date_start"]) ) {
	$arr_post["search_date_start"] = date( "Y/m/d", strtotime($arr_post["search_date_start"]) );
} else {
	$arr_post["search_date_start"] = null;
}
if( !empty($arr_post["search_date_end"]) ) {
	$arr_post["search_date_end"] = date( "Y/m/d", strtotime($arr_post["search_date_end"]) );
} else {
	$arr_post["search_date_end"] = null;
}
$_SESSION["admin"][_CONTENTS_DIR]["search"]["POST"] = $arr_post;

//----------------------------------------
//  データ一覧取得
//----------------------------------------
// 操作クラス
$objManage  = new DB_manage( _DNS );
$mainObject = new $class_name( $objManage );

// データ取得
$t_information = $mainObject->GetSearchList( $arr_post );

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
$smarty->assign( "page_navi"     , $t_information["page"] );
$smarty->assign( "t_information" , $t_information["data"] );
if( !empty($_ARR_IMAGE) ){
	$smarty->assign( '_ARR_IMAGE', $_ARR_IMAGE );
}
if( !empty($_ARR_FILE) ){
	$smarty->assign( '_ARR_FILE', $_ARR_FILE );
}

// オプション設定
$smarty->assign( 'OptionInformationCategory' , $OptionInformationCategory  );


// 表示
$smarty->display("list.tpl");
?>
