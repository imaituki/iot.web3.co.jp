<?php
//-------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田a
// 内  容: information 編集
//-------------------------------------------------------------------

//----------------------------------------
//  設定ファイル
//----------------------------------------
require "./config.ini";


//----------------------------------------
//  編集データ取得
//----------------------------------------
// 操作クラス
$objManage  = new DB_manage( _DNS );
$mainObject = new $class_name( $objManage );

// データ取得
$_POST = $mainObject->GetIdRow( $arr_get["id"] );

// クラス削除
unset( $objManage  );
unset( $mainObject );


//----------------------------------------
//  表示
//----------------------------------------
if( !empty($_POST[_CONTENTS_ID]) ) {

	// smarty設定
	$smarty = new MySmarty("admin");
	$smarty->compile_dir .= _CONTENTS_DIR. "/";

	// 表示
	$smarty->display( "edit.tpl" );

} else {

	// メッセージ保管
	$_SESSION["admin"][_CONTENTS_DIR]["message"]["ng"] = "データの取得に失敗しました。<br />";

	// 表示
	header( "Location: ./index.php" );

}
?>
