<?php
//-------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容: case 一括表示切替
//-------------------------------------------------------------------

//----------------------------------------
//  設定ファイル
//----------------------------------------
require "./config.ini";


//----------------------------------------
//  表示切替
//----------------------------------------
// 操作クラス
$objManage  = new DB_manage( _DNS );
$mainObject = new $class_name( $objManage );

// トランザクション
$mainObject->_DBconn->StartTrans();

// 表示切り替え処理
$res = $mainObject->changeDisplay( $arr_post["id"], $arr_post["display_flg"] );

// 失敗したらロールバック
if( $res == false ) {
	$mainObject->_DBconn->RollbackTrans();
}

// コミット
$mainObject->_DBconn->CompleteTrans();

// クラス削除
unset( $objManage  );
unset( $mainObject );

// 戻り値
if( $res == false ) {
	echo json_encode( array( "result" => "false", "message" => "表示切り替えに失敗しました。<br />" ) );
} else {
	echo json_encode( array( "result" => "true", "message" => "表示切り替え完了しました。<br />" ) );
}
?>
