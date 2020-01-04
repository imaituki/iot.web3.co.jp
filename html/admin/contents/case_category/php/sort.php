<?php
//-------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容: case ソート
//-------------------------------------------------------------------

//----------------------------------------
//  設定ファイル
//----------------------------------------
require "./config.ini";


//----------------------------------------
//  ソート処理
//----------------------------------------
// 操作クラス
$objManage  = new DB_manage( _DNS );
$mainObject = new $class_name( $objManage );

// トランザクション
$mainObject->_DBconn->StartTrans();

// ソート
$res = $mainObject->sort( $arr_post["sort"], _CONTENTS_ID );

// ロールバック
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
	echo json_encode( array( "result" => "false", "message" => "並び順の変更に失敗しました。（F5ボタンを押して一度ページを更新してください）<br />" ) );
} else {
	echo json_encode( array( "result" => "true", "message" => "並び順の変更が完了しました。<br />" ) );
}
?>
