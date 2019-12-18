<?php
//-------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容: case 一括削除
//-------------------------------------------------------------------

//----------------------------------------
//  設定ファイル
//----------------------------------------
require "./config.ini";


//----------------------------------------
//  削除処理
//----------------------------------------
// 操作クラス
$objManage  = new DB_manage( _DNS );
$mainObject = new $class_name( $objManage);

// トランザクション
$mainObject->_DBconn->StartTrans();

// 削除処理
$res = $mainObject->delete( $arr_post["id"] );

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
	echo json_encode( array( "result" => "false", "message" => "削除するデータを選択してください。<br />" ) );
} else {
	echo json_encode( array( "result" => "true", "message" => "削除完了しました。<br />" ) );
}
?>
