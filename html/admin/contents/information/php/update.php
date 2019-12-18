<?php
//-------------------------------------------------------------------
// 作成日: 2019/12/28
// 作成者: 岡田
// 内  容: information 編集
//-------------------------------------------------------------------

//----------------------------------------
//  設定ファイル
//----------------------------------------
require "./config.ini";


//----------------------------------------
//  更新処理
//----------------------------------------
// 操作クラス
$objManage  = new DB_manage( _DNS );
$mainObject = new $class_name( $objManage, $_ARR_IMAGE, $_ARR_FILE );

// データ変換
$arr_post = $mainObject->convert( $arr_post );

// データチェック
$message = $mainObject->check( $arr_post, 'update' );

// エラーチェック
if( empty( $message["ng"] ) ) {

	// トランザクション
	$mainObject->_DBconn->StartTrans();

	// 登録処理
	$res = $mainObject->update( $arr_post );

	// 失敗したらロールバック
	if( $res == false ) {
		$mainObject->_DBconn->RollbackTrans();
		$message["ng"]["all"] = _ERRHEAD . "登録処理に失敗しました。（ブラウザの再起動を行って改善されない場合は、システム管理者へご連絡ください。）<br />";
	}

	// コミット
	$mainObject->_DBconn->CompleteTrans();

}

// クラス削除
unset( $objManage  );
unset( $mainObject );


//----------------------------------------
//  表示
//----------------------------------------
if( empty( $message["ng"] ) ) {

	// メッセージ保管
	$_SESSION["admin"][_CONTENTS_DIR]["message"]["ok"] = "更新が完了しました。<br />";

	// 表示
	header( "Location: ./index.php" );

} else {

	// データ加工
	if( !empty($arr_post["display_start"]) ){
		$arr_post["display_start"] = date( "Y/m/d", strtotime($arr_post["display_start"]) );
	}
	if( !empty($arr_post["display_end"]) ){
		$arr_post["display_end"] = date( "Y/m/d", strtotime($arr_post["display_end"]) );
	}

	// 写真
	if( !empty($_ARR_IMAGE) && is_array($_ARR_IMAGE) ){
		foreach( $_ARR_IMAGE as $key => $val ) {
			$arr_post[$val["name"]] = $arr_post["_" . $val["name"]."_now"];
		}
	}
	if( !empty($_ARR_FILE) && is_array($_ARR_FILE) ){
		foreach( $_ARR_FILE as $key => $val ) {
			$arr_post[$val["name"]] = $arr_post["_" . $val["name"]."_now"];
		}
	}

	// smarty設定
	$smarty = new MySmarty("admin");
	$smarty->compile_dir .= _CONTENTS_DIR;

	// テンプレートに設定
	$smarty->assign( "message" , $message  );
	$smarty->assign( "arr_post", $arr_post );
	if( !empty($_ARR_IMAGE) ){
		$smarty->assign( '_ARR_IMAGE', $_ARR_IMAGE );
	}
	if( !empty($_ARR_FILE) ){
		$smarty->assign( '_ARR_FILE', $_ARR_FILE );
	}

	// オプション設定
	$smarty->assign( 'OptionInformationCategory' , $OptionInformationCategory  );

	// 表示
	$smarty->display( "edit.tpl" );

}
?>
